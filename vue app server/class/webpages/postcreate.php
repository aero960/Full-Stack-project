<?php


namespace WebpageMNG;


use authentication\Authentication;
use PostCreateEXT;
use PostCreator;
use PostModificator;

use PostParameters;
use RoutesMNG\Parameters;

class PostCreate extends Page
{
    private PostCreateEXT $postManagment;
    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new PostParameters($parameters);
    }

    protected function pageContent()
    {
        $this->Initialize();
        return ['info'=>[
            $this->postManagment->getData()->toIterate(),
            'tags'=> array_column((new \TagsShowEXT($this->postManagment->getData()->getPostId()))->getTags(),"tag_title")
        ]];
    }

    protected function Initialize(): void
    {
        $this->postManagment = new PostCreateEXT();
        $this->postManagment->PostCreate(Authentication::getInstance()->getCurrentyUser()->getId(),
            $this->parameters->getParameter(PostParameters::TITLE),
            $this->parameters->getParameter(PostParameters::CONTENT),
            $this->parameters->getParameter(PostParameters::TAGS)
            );
    }
}