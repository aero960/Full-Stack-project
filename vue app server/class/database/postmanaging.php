<?php




abstract class PostModificator extends QueryComposer
{
    public function __construct()
    {
        QueryComposer::__construct();
    }
    public function getData(): PostSchema
    {
        return parent::getData();
    }
}


class PostCreateEXT extends PostModificator implements tagHandler
{
    protected Composer $tagManaging;
    protected $tagData;

    public function __construct()
    {
        parent::__construct();
    }
    public function PostCreate(string $userid, string $title, string $content, $tagData)
    {
        $this->fetcherComposite = new PostQueryDecorator(new PostCreator( $userid, $title, $content));
        $this->execute();

        $this->tagData = $tagData;
        $this->TagAction();
    }


    function getCreatedTag(){
           return $this->tagManaging->getData();
    }
    function Initialize()
    {
        $this->tagManaging = new TagsAddEXT($this->tagData,$this->getData()->getPostId());
    }

    function TagAction()
    {
        $this->Initialize();
        $this->tagManaging->action();
    }
}

class PostPublishEXT extends PostModificator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function PublishPost(string $postId, $publish = 0)
    {
        $this->fetcherComposite = new PostQueryDecorator(new PostPublisher( $postId,$publish));
        $this->execute();
    }
    public function getData(): PostSchema
    {
        return parent::getData();
    }
}

class PostUpdateEXT extends PostModificator
{
    public function __construct()
    {
        parent::__construct();
    }

    private DateTime $lastUpdate;

    public function getLastLogin()
    {
        try {
            return $this->lastUpdate;
        } catch (Exception $e) {
            throw new Exception("Object must contains updating fetcher composit");
        }
    }
    public function PostUpdate(string $userid, string $title, string $content, string $postId)
    {
        $updater = new PostUpdater( $userid, $title, $content, $postId);
        $this->lastUpdate = $updater->lastLogin;
        $this->fetcherComposite = new PostQueryDecorator($updater);

        $this->execute();
    }



}


class PostRemoveEXT extends PostModificator
{
    public function __construct()
    {
        parent::__construct();
    }

    private PostSchema $postBeforeDelete;

    public function getPostBeforeDelete()
    {
        return $this->postBeforeDelete;
    }


    public function PostRemove(string $id)
    {
        $this->fetcherComposite = new PostQueryDecorator(new PostDeleter( $id));
        $this->postBeforeDelete = $this->fetcherComposite->fetchData();

        $this->execute();
    }
}
