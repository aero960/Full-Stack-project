<?php


use authentication\AuthenticationSchema;
use authentication\SchemaBuilder;

class PostSchema extends SchemaBuilder
{

    public const POSTID = 'post_id';
    public const USERID = 'user_id';
    public const TITLE = 'post_title';
    public const PUBLISHED = 'post_published';
    public const POSTCREATEAT = 'post_create_at';
    public const POSTPUBLISHEDAT = 'post_published_at';
    public const POSTUPDATEDAT = 'post_updated_at';
    public const CONTENT = 'post_content';

    private string $postId;
    private string $userId;
    private string $title;
    private bool $published;
    private DateTime $postCreateAt;
    private DateTime $postUpdatedAt;
    private DateTime $postPublishedAt;
    private string $content;

    private AuthenticationSchema $user;
    public function __construct($data)
    {
        SchemaBuilder::__construct($data);
        $this->postId = $this->assignValue(self::POSTID);
        $this->userId = $this->assignValue(self::USERID);
        $this->title = $this->assignValue(self::TITLE);
        $this->published = $this->assignValue(self::PUBLISHED);
        $this->postCreateAt = $this->assignDataValue(self::POSTCREATEAT);
        $this->postUpdatedAt = $this->assignDataValue(self::POSTUPDATEDAT);
        $this->content = $this->assignValue(self::CONTENT);
        $this->postPublishedAt = $this->assignDataValue(self::POSTPUBLISHEDAT);
    }

    public function assignUser(AuthenticationSchema $user){
        $this->user = $user;
    }

    public  function assignUserById(string $userId){
        $this->user = (new GetUserById($userId))->action();
    }

    public function getUser(){
        return $this->user;
    }





    public function getContent()
    {
        return $this->content;
    }

    public function getPostPublishedAt()
    {
        return $this->postPublishedAt;
    }

    public function getPostCreateAt()
    {
        return $this->postCreateAt;
    }


    public function getPostId()
    {
        return $this->postId;
    }


    public function getPostUpdatedAt()
    {
        return $this->postUpdatedAt;
    }


    public function getPublished()
    {
        return $this->published;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function getUserId()
    {
        return $this->userId;
    }

    public function toIterate(): array
    {
        return [self::POSTID => $this->getPostId(),
        self::USERID => $this->getUserId(),
        self::TITLE => $this->getTitle(),
        self::PUBLISHED => $this->getPublished(),
        self::POSTCREATEAT => $this->getPostCreateAt()->format(BuilderComposite::DATEFORMAT),
        self::POSTPUBLISHEDAT => $this->getPostPublishedAt()->format(BuilderComposite::DATEFORMAT),
        self::POSTUPDATEDAT => $this->getPostUpdatedAt()->format(BuilderComposite::DATEFORMAT),
        self::CONTENT => $this->getContent()];
    }
}