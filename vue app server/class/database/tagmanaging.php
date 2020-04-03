<?php




interface tagHandler
{
    function Initialize();
    function TagAction();
}


class TagsRemoveEXT extends BuilderComposite implements FastAction
{
    private string $postId;
    public function __construct(string $postId)
    {
        parent::__construct();
        $this->postId = $postId;
    }
    private function getRealtedTags()
    {
        $sql = "SELECT pt_tag_id FROM post_tag WHERE pt_post_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->postId]);

        return $statement->fetchAll();

    }
    private function getTagsToDelete()
    {
        $tagList = $this->getRealtedTags();
        $tagsToDelete = [];
        foreach($tagList as $index){
            $sql = "SELECT * FROM post_tag WHERE pt_tag_id=:id";
           $statement = $this->getDb()->prepare($sql);
           $statement->execute(["id"=>$index->pt_tag_id]);
           if( $statement->rowCount() <= 1)
               $tagsToDelete[] = $index;
        }
     return $tagsToDelete;
    }
    private function removeAllConnections(){
            $sql = 'DELETE FROM post_tag WHERE pt_post_id=:id';
            $statement = $this->getDb()->prepare($sql);
            $statement->execute(["id" => $this->postId]);
    }
    public function removeTag()
    {

        foreach ($this->getTagsToDelete() as $index){
            $sql = 'DELETE FROM tags WHERE id_tag=:id';
            $statement = $this->getDb()->prepare($sql);
            $statement->execute(["id" => $index->pt_tag_id]);
        }
        $this->removeAllConnections();
        return true;
    }

    public function getFastActionResponse()
    {
        return true;
    }
}
class TagsShowEXT extends BuilderComposite implements FastAction
{
    private string $postId;

    public function __construct(string $postId)
    {
        parent::__construct();
        $this->postId = $postId;
    }

    public function getTags()
    {
        $sql = 'SELECT tag_title FROM tags INNER JOIN post_tag pt
             ON pt_tag_id = tags.id_tag WHERE pt.pt_post_id=:postId ';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["postId" => $this->postId]);
        return $statement->fetchAll();
    }

    public function getFastActionResponse()
    {
        return $this->getTags();
    }
}


class TagsAddEXT extends BuilderComposite implements FastAction
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
            if (!$this->checkExistTag($index)) {
                $id = $this->createTag($index);
                $this->createdTagList[] = ["tag_title" => $index, "id" => $id];
            } else {

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
    public function getFastActionResponse()
    {
        $this->addTag();
        return  $this->createdTagList;
    }
}

