<?php

use authentication\Authentication;
use RoutesMNG\Parameters;
use WebpageMNG\Element;
use WebpageMNG\Fabric;
use WebpageMNG\FabricActioner;
use WebpageMNG\Page;


class FastActionEXT extends Page implements FabricActioner
{
    public const CATEGORY_ADD_TITLE = "title";
    public const CATEGORY_ADD_CONTENT = "content_category";

    public const CATEGORY_CONNECT_POSTID = "postid";
    public const CATEGORY_CONNECT_NAME_CATEGORY = "categoryname";

    public const COMMENT_ADD_TITLE = "title";
    public const COMMENT_ADD_CONTENT = "content_comment";
    public const COMMENT_ADD_POSTID = "postid";

    private Fabric $action;

    public function __construct(Parameters $parameters)
    {
        parent::__construct();
        $this->parameters = new NoParameters($parameters);
    }

    protected function pageContent()
    {
        $this->Initialize();
        return $this->action->getContext();
    }

    public function ExtensionData()
    {
        $this->addActualItem(new PostItem("action", $this->parameters->getParameter(0)));
    }

    protected function Initialize(): void
    {
        $this->action = new ChooseAction($this);
    }

    public function getValues(string $name)
    {
        return $this->parameters->getParameter($name);
    }

    public function getAction()
    {
        return $this->getActualItem("action")->getValue();
    }


}

class ChooseAction implements Fabric
{
    private ?FastAction $obj;
    private FabricActioner $fabricCreator;

    public function __construct(FabricActioner $fabricCreator)
    {
        $this->fabricCreator = $fabricCreator;
    }

    private function createAction(): void
    {
        switch ($this->fabricCreator->getAction()) {
            case "createcategory":
            {
                $this->obj = new AuthenticateAdminUserFA(new AddCategoryEXT(
                    $this->fabricCreator->getValues(FastActionEXT::CATEGORY_ADD_TITLE),
                    $this->fabricCreator->getValues(FastActionEXT::CATEGORY_ADD_CONTENT)));
                break;
            }
            case "connectcategory":
            {
                $this->obj = new AuthenticateAdminUserFA(new AddToCategoryEXT(
                    $this->fabricCreator->getValues(FastActionEXT::CATEGORY_CONNECT_NAME_CATEGORY),
                    $this->fabricCreator->getValues(FastActionEXT::CATEGORY_CONNECT_POSTID)));
                break;
            }
            case "addcomment":
            {
                $this->obj = new ItemExistFA(new AddCommentToPostEXT($this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_TITLE),
                    $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_CONTENT),
                    $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_POSTID),
                    Authentication::getInstance()->getCurrentyUser()->getId()),

                    $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_POSTID));
                break;
            }
        }
    }

    public static function getMapActions()
    {
        return ["createcategory", "connectcategory"];
    }

    public function getContext()
    {
        $this->createAction();

        if (isset($this->obj)) {

            return $this->obj->getFastActionResponse();
        }
        return ["info" => "to nie jest prawidlowa akcja",
            "tip" => self::getMapActions()];
    }
}

