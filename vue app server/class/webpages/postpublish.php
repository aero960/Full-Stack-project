<?php


namespace WebpageMNG;

use authentication\Authentication;
use BuilderComposite;
use DateTime;


use language\Serverlanguage;
use PostItem;
use PostModificator;
use PostParameters;
use PostPublishEXT;
use PostPublishParameters;
use PostUpdateEXT;
use RoutesMNG\Parameters;
use TagsShowEXT;


class PostPublish extends Page
{
    private PostPublishEXT $postManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new PostPublishParameters($parameters);
    }

    public function ExtensionData()
    {
        $this->addActualItem(new PostItem("postid", $this->parameters->getParameter(0)));
    }

    protected function Initialize(): void
    {

        $this->postManagment = new PostPublishEXT();
        $this->postManagment->PublishPost($this->getActualItem("postid")->getValue(),
            $this->parameters->getParameter(PostPublishParameters::PUBLISH));
        $this->outputController->setDataSuccess(true);

        $infoMsg = ($this->postManagment->getData()->getPublished()) ? "Opublikowano post" : "Zmieniono Status na prywatny,";

        $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage("p.pub"),
            $infoMsg,
            $this->postManagment->getData()->getTitle()));
        $this->outputController->setContent(["postdata" => $this->postManagment->getData()->toIterate(),
            "published" => $this->postManagment->getData()->getPublished()]);


    }
}