<?php


use authentication\AuthenticationSchema;

interface ViewQuery
{
    public function getView();
}

abstract class ShowPosts extends BuilderComposite
{
    protected function convertToArraySchema(array $data){
        return array_map(fn($index)=>new PostSchema($index) ,$data);
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
        $sql = "SELECT p.* FROM
             post p JOIN users u on p.user_id = u.id WHERE u.id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id"=>$this->userId]);
        return $statement->fetchAll();
    }
    public function getView()
    {
      return $this->showSpecificUserPosts();
    }
}
class ShowSpecificPost extends ShowPosts implements  ViewQuery {
    private string $postId;
    public function __construct(string $postId = '')
    {
        parent::__construct();
        $this->postId = $postId;
    }

    private function showSpecificPost()
    {
        $sql = "SELECT p.* FROM post p  WHERE p.post_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id"=>$this->postId]);
        return $statement->fetch();
    }

    public function getView() : PostSchema
    {
        return new PostSchema($this->showSpecificPost());
    }
}

class Pager {
  private int $FROM;
  private int $HowManyOnPage;


    public function __construct(int $FROM, int $HowManyOnPage)
    {
        $this->FROM = $FROM;
        $this->HowManyOnPage = $HowManyOnPage;
    }
    public function changePosition($position): int
    {
            $this->FROM = $position;
    }
    public function changeLimit($LimitRecords): int
    {
       $this->HowManyOnPage = $LimitRecords;
    }
    public function getLimit(){
        return "LIMIT {$this->HowManyOnPage} OFFSET {$this->FROM}";
    }
}
class ShowAllPost extends ShowPosts implements  ViewQuery {

    private function showAllPosts()
    {
        $sql = "SELECT p.*,u.* FROM post p INNER JOIN users u ON p.user_id = u.id ";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }



    public function getView()
    {
        return $this->convertToArraySchema($this->showAllPosts());
    }
}





