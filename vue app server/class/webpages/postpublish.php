<?php


namespace WebpageMNG;

use authentication\Authentication;
use BuilderComposite;
use DateTime;


use PostItem;
use PostModificator;
use PostParameters;
use PostPublishEXT;
use PostPublishParameters;
use PostUpdateEXT;
use RoutesMNG\Parameters;


class PostPublish extends Page
{
    private PostPublishEXT $postManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new PostPublishParameters($parameters);
    }

    protected function pageContent()
    {
        $this->Initialize();
        $data = $this->postManagment->getData();
        $data->assignUserById($data->getUserId());
        $infoMsg = ($data->getPublished()) ? "Opublikowano post " : "Zmieniono Status na prywatny, postu o nazwie ";
        return ["info" => "{$infoMsg}  postu o nazwie {$this->postManagment->getData()->getTitle()}",
            "data" => [$data->getUser()->getUsername(),
                $data->getContent(),
                $data->getPublished()]
        ];
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
    }
}