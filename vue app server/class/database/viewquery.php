<?php


use authentication\AuthenticationSchema;

interface ViewQuery
{
    public function getView();
}

abstract class ShowPosts extends ShortcutBuilder
{
    protected function convertToArraySchema(array $data){
        return array_map(fn($index)=>[new AuthenticationSchema($index),new PostSchema($index)] ,$data);
    }
}

class ShowUserPost extends ShowPosts implements  ViewQuery {
    private string $userId;
    public function __construct(string $userId = '')
    {
        parent::__construct();
        $this->userId = $userId;
    }

    private function showSpecificUserPosts()
    {
        $sql = "SELECT p.*,u.* FROM
             post p JOIN users u on p.user_id = u.id WHERE u.id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id"=>$this->userId]);

        return $statement->fetchAll();
    }
    public function getView()
    {
      return $this->convertToArraySchema($this->showSpecificUserPosts());
    }
}

class ShowAllPost extends ShowPosts implements  ViewQuery {
    private function showAllPosts()
    {
        $sql = "SELECT p.*,u.* FROM post p INNER JOIN users u ON p.user_id = u.id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
    public function getView()
    {
        return $this->convertToArraySchema($this->showAllPosts());
    }
}





