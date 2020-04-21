<?php


use authentication\Authentication;

interface ViewQuery
{
    public function getView();
}


interface PagerLimiterInterface extends ViewQuery
{
    public function getSql(): string;

    public function setSql(string $sql): void;

    public function getNumbersOfRow(): int;
}


abstract class ViewerElement extends BuilderComposite implements PagerLimiterInterface
{
    protected string $sql;

    public function getSql(): string
    {
        return $this->sql;
    }

    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

    abstract public function getView();

}


abstract class ShowPosts extends ViewerElement
{
    protected function convertToArraySchema(array $data)
    {
        return array_map(fn($index) => new PostSchema($index), $data);
    }
}


class ShowUserPost extends ShowPosts
{
    private string $userId;

    public function __construct(string $userId)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->sql = "SELECT p.* FROM
             post p JOIN users u on p.user_id = u.id WHERE u.id=:id ";
    }

    private function showSpecificUserPosts()
    {
        $statement = $this->getDb()->prepare($this->sql);
        $statement->execute(["id" => $this->userId]);
        return $statement;
    }

    public function getView()
    {
        return $this->convertToArraySchema($this->showSpecificUserPosts()->fetchAll());
    }

    public function getNumbersOfRow(): int
    {
        return $this->showSpecificUserPosts()->rowCount();
    }
}

class ShowSpecificPost extends ShowPosts
{
    private string $postId;

    public function __construct(string $postId = '')
    {
        parent::__construct();
        $this->postId = $postId;
        $this->sql = "SELECT p.* FROM post p  WHERE p.post_id=:id";
    }

    private function showSpecificPost()
    {

        $statement = $this->getDb()->prepare($this->sql);
        $statement->execute(["id" => $this->postId]);
        return $statement->fetch();
    }

    public function getView(): PostSchema
    {
        return new PostSchema($this->showSpecificPost());
    }

    public function getNumbersOfRow(): int
    {
        return 0;
    }
}

class AuthenticationPrivateFilter implements PagerLimiterInterface
{
    private PagerLimiterInterface $element;


    public function __construct(PagerLimiterInterface $element)
    {
        $this->element = $element;
    }


    private function filterData(array $data)
    {
        $public = [];
        foreach ($data as $index) {
            if ($index->getPublished())
                $public[] = $index;
        }
        return $public;
    }

    private function OwnerFilter(array $data)
    {
        $owner = [];
        foreach ($data as $index) {
            $item = new PostItem('currenty', $index->getPostId());
            if ($item->CheckValidOwner() || PermissionChecker::checkAdminUserAuthBOOL())
                $owner[] = $index;
        }
        return $owner;
    }

    public function getView()
    {
        if (Authentication::getInstance()->isAuthenticated()) {
            return $this->OwnerFilter($this->element->getView());
        }

        return $this->filterData($this->element->getView());
    }

    public function getSql(): string
    {
        return $this->element->getSql();
    }

    public function setSql(string $sql): void
    {
        $this->element->setSql($sql);
    }

    public function getNumbersOfRow(): int
    {
        return count($this->filterData($this->element->getView()));
    }
}

class PageLimiter extends ShowPosts
{
    private int $FROM;
    private int $HowManyOnPage;
    private int $pageNumber = 0;
    private ViewQuery $element;

    private int $numbersOfPage;

    public function __construct(PagerLimiterInterface $element, int $pageNumber = 0, int $HowManyOnPage = 7)
    {
        parent::__construct();

        $this->HowManyOnPage = $HowManyOnPage;
        $this->element = $element;
        $this->numbersOfPage = $this->getNumbersOfRow();

        $this->pageNumber = $this->checkPageLimit($pageNumber);
    }

    public function getInfo()
    {
        return ["pagenumber" => $this->pageNumber, "maxpage" => $this->numbersOfPage, "itemsperpage" => $this->HowManyOnPage];
    }

    private function checkPageLimit($value)
    {

        if ($value <= 0)
            return 0;
        if ($value > $this->numbersOfPage)
            return $this->numbersOfPage;
        return $value;
    }

    public function getLimit()
    {

        $offset = $this->pageNumber * $this->HowManyOnPage;
        return " LIMIT {$this->HowManyOnPage} OFFSET {$offset}";
    }

    public function getView()
    {
        $sql = $this->element->getSql();
        $this->element->setSql($sql . $this->getLimit());
        return $this->element->getView();
    }

    public function getNumbersOfRow(): int
    {

        $withOutFloor = $this->element->getNumbersOfRow() / $this->HowManyOnPage;
        $withFollor = floor($this->element->getNumbersOfRow() / $this->HowManyOnPage);


        return ($withOutFloor == $withFollor) ? $withFollor - 1 : $withFollor;
    }
}

class ShowAllPost extends ShowPosts
{
    public function __construct()
    {
        parent::__construct();
        $this->sql = "SELECT p.*,u.* FROM post p INNER JOIN users u ON p.user_id = u.id ";
    }


    private function showAllPosts()
    {
        $statement = $this->getDb()->prepare($this->sql);
        $statement->execute();
        return $statement;
    }

    public function getView()
    {
        return $this->convertToArraySchema($this->showAllPosts()->fetchAll());
    }

    public function getNumbersOfRow(): int
    {
        return $this->showAllPosts()->rowCount();
    }
}





