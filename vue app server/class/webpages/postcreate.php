<?php


namespace WebpageMNG;


use authentication\Authentication;
use BuilderComposite;
use language\Serverlanguage;
use PostCreateEXT;
use PostCreator;
use PostModificator;

use PostParameters;
use RoutesMNG\Parameters;
use TagsShowEXT;

class PostCreate extends Page
{
    private PostCreateEXT $postManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new PostParameters($parameters);
    }
    protected function Initialize(): void
    {
        $this->postManagment = new PostCreateEXT();
        $this->postManagment->PostCreate(Authentication::getInstance()->getCurrentyUser()->getId(),
            $this->parameters->getParameter(PostParameters::TITLE),
            $this->parameters->getParameter(PostParameters::CONTENT),
            $this->parameters->getParameter(PostParameters::TAGS)
        );

        $this->outputController->setDataSuccess(true);
        $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage("p.c"));
        $this->outputController->setContent([
            'postdata' => $this->postManagment->getData()->toIterate(),
            'tags' => array_column((new TagsShowEXT($this->postManagment->getData()->getPostId()))->getTags(), "tag_title")
        ]);



    }
}