<?php

interface tagHandler
{

    function Initialize();

    function TagAction();

}
class TagsRemoveEXT extends ShortcutBuilder implements Shortcut
{
    private string $postId;

    public function __construct(string $postId)
    {
        parent::__construct();
        $this->postId = $postId;
    }

    public function removeTag(string $name)
    {
        if (!$this->checkExistTag($name))
            return false;
        $sql = 'DELETE FROM  tags WHERE tag_title=:name';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["name" => $name]);
        return true;
    }

    private function checkExistTag(string $name)
    {
        $sql = 'SELECT tag_title FROM tags WHERE tag_title=:title';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["title" => $name]);
        return ($statement->rowCount() > 0) ? true : false;
    }

    public function action()
    {
        return true;
    }
}

class TagsShowEXT extends ShortcutBuilder implements Shortcut
{
    private string $postId;

    public function __construct(string $postId)
    {
        parent::__construct();

    }

    public function getTags()
    {
        $sql = 'SELECT tag_title FROM tags INNER JOIN post_tag pt
             ON pt_tag_id = tags.id_tag WHERE pt.pt_post_id=:postId ';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["postId" => $this->postId]);
        return $statement->fetchAll();
    }

    public function action()
    {
       return $this->getTags();
    }

}

class TagsAddEXT extends BuilderComposite implements Composer
{
    private array $data;
    private string $tagId;
    private string $postId;
    private array $createdTagList = [];

    public function __construct($data, string $postId)
    {
        parent::__construct();
        $this->postId = $postId;
        if (is_array($data))
            $this->data = array_unique($data);
        else
            $this->data = array_unique(preg_split("/,|\./", $data));
    }

    private function addConnection($id)
    {
        $sql = 'INSERT INTO post_tag SET pt_post_id=:postId, pt_tag_id=:idTag';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["postId" => $this->postId, "idTag" => $id]);
    }

    private function createTag(string $title)
    {
        $id = $this->getRandomId("tags", "id_tag");
        $sql = 'INSERT INTO tags SET tags.tag_title=:title,tags.id_tag=:id';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $id, "title" => $title]);
        return $id;
    }

    private function getTagByTitle($title)
    {
        $sql = 'SELECT id_tag FROM tags WHERE tag_title=:title ';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["title" => $title]);
        return $statement->fetch();
    }

    private function addTag()
    {
        foreach ($this->data as $index) {
            if (!$this->checkExistTag($index)){
                $id = $this->createTag($index);
                $this->createdTagList[] = ["tag_title" => $index, "id" => $id];
            }else{

                $this->createdTagList[] = ["tag_title" => $index, "id" => $this->getTagByTitle($index)->id_tag];
            }
        }
        foreach ($this->createdTagList as $index)
            $this->addConnection($index["id"]);
    }

    private function checkExistTag(string $name)
    {
        $sql = 'SELECT tag_title FROM tags WHERE tag_title=:title';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["title" => $name]);
        return ($statement->rowCount() > 0) ? true : false;
    }

    public function action()
    {
        $this->addTag();
    }

    public function getData()
    {
        return $this->createdTagList;
    }
}

