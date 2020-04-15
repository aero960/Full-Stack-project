<?php

use authentication\CategorySchema;
use language\Serverlanguage;

class FastActionDelivery
{

    public const INFO = 'info';
    private bool $isSuccess;
    private $data;
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function getData()
    {
        return $this->data;
    }

    public function __construct(bool $isSuccess, $data)
    {
        $this->isSuccess = $isSuccess;
        $this->data = $data;
    }


}


interface FastAction
{
    public function getFastActionResponse() : FastActionDelivery;
}


class AddToCategoryEXT extends BuilderComposite implements FastAction
{
    private string $categoryName;
    private string $postId;

    public function __construct(string $categoryName, string $postId)
    {
        parent::__construct();
        $this->categoryName = $categoryName;
        $this->postId = $postId;
    }

    private function getCategoryId()
    {
        $sql = "SELECT category_id FROM category WHERE category_title=:title";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["title" => $this->categoryName]);
        return $statement->fetch()->category_id;
    }

    private function checkPostHasCurrentyCategory()
    {
        $sql = "Select * FROM post_category WHERE pc_category_id=:idCategory AND pc_post_id=:postId";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["idCategory" => $this->getCategoryId(), "postId" => $this->postId]);
        return $statement->rowCount();
    }

    private function connectWithCategory()
    {

        if (!$this->checkPostHasCurrentyCategory()) {
            $sql = "INSERT INTO post_category SET pc_category_id=:categoryId, pc_post_id=:postId";
            $statement = $this->getDb()->prepare($sql);
            $statement->execute(["categoryId" => $this->getCategoryId(), "postId" => $this->postId]);
        }
    }

    public function getFastActionResponse() : FastActionDelivery
    {
        $this->connectWithCategory();

        return  new FastActionDelivery(true,[FastActionDelivery::INFO  => "połączenie postu:  {$this->postId} z kategorią {$this->categoryName}"]);
    }
}


class CategoryShowEXT extends ShowPosts
{

    private string $category;


    public function __construct(string $category)
    {
        parent::__construct();
        $this->category = $category;
        $this->sql = "SELECT p.*,category.category_content FROM post_category
             JOIN post p ON pc_post_id=post_id
             JOIN category ON category_id=pc_category_id
            WHERE category_title=:name";
    }

    private function getPostToCategory()
    {
        $statement = $this->getDb()->prepare($this->sql);
        $statement->execute(["name" => $this->category]);
        return $statement;
    }

    private function getPostsSchemas()
    {
        return $this->getPostToCategory()->fetchAll();
    }

    public function getView()
    {
        return $this->convertToArraySchema($this->getPostsSchemas());

    }

    public function getSql(): string
    {
        return $this->sql;
    }

    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

    public function getNumbersOfRow(): int
    {
        return $this->getPostToCategory()->rowCount();
    }
}


class DefaultAction implements FastAction
{

    private array $mapActions;
        public function __construct(array $mapActions)
        {
            $this->mapActions = $mapActions;
        }


    public function getFastActionResponse() : FastActionDelivery
    {

        return new FastActionDelivery(false,["Action need all parameters",
            "tip" => $this->mapActions]);

    }
}

class ShowCategoryToSpecificPostEXT extends BuilderComposite implements FastAction
{


    private string $postId;

    public function __construct(string $postId)
    {
        parent::__construct();
        $this->postId = $postId;
    }


    private function showCategoryToPost()
    {
        $sql = "SELECT category_title FROM post_category JOIN category ON pc_category_id=category_id
                        WHERE   pc_post_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->postId]);
        return $statement->fetchAll();
    }


    public function getFastActionResponse() : FastActionDelivery
    {
        return new FastActionDelivery(true,$this->showCategoryToPost());
    }
}


class AddCategoryEXT extends BuilderComposite implements FastAction
{
    private string  $id;
    private string $title;
    private string $content;

    public function __construct(string $title, string $content)
    {

        parent::__construct();
        $this->title = $title;
        $this->content = $content;

    }

    private function getId(): string
    {
        return $this->id;
    }

    private function addCategory()
    {
        $id = $this->getRandomId("category", "category_id");
        $this->id = $id;
        $sql = "INSERT INTO category SET category_title=:title,category_content=:content,category_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["title" => $this->title, "content" => $this->content, "id" => $this->id]);
    }

    private function getCreatedCategory() : CategorySchema
    {
        $sql = "SELECT * FROM category WHERE category_title=:title";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["title" => $this->title]);
        return  new CategorySchema($statement->fetch());
    }

    public function getFastActionResponse() : FastActionDelivery
    {

        if (!$this->checkValueExist("category", "category_title", $this->title))
            $this->addCategory();

        return new FastActionDelivery(true,$this->getCreatedCategory()->toIterate());


    }
}

