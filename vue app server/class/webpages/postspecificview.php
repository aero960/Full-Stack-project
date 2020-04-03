<?php

use authentication\Authentication;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;




class PostSpecificView extends Page
{

    private ShowSpecificPost $showPosts;


    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new NoParameters($parameters);
    }

    protected function pageContent()
    {
        $this->Initialize();
        return ["title" => $this->showPosts->getView()->getTitle(),
            "content" => $this->showPosts->getView()->getContent(),
            "published" => $this->showPosts->getView()->getPublished(),
            "publishedAt" => $this->showPosts->getView()->getPostPublishedAt(),
            "postId" => $this->showPosts->getView()->getPostId(),
            (new TagsShowEXT($this->showPosts->getView()->getPostId()))->action()];
    }
    public function ExtensionData()
    {
        $this->addActualItem(new PostItem("postid", $this->parameters->getParameter(0)));
    }
    protected function Initialize(): void
    {
        $this->showPosts = new ShowSpecificPost($this->getActualItem("postid")->getValue());
    }
}