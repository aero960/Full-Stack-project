<?php

use authentication\Authentication;
use authentication\AuthenticationSchema;
use RoutesMNG\Parameters;
use WebpageMNG\Element;
use WebpageMNG\Fabric;
use WebpageMNG\FabricActioner;
use WebpageMNG\Page;


class FastActionEXT extends Page implements FabricActioner
{
    public const CATEGORY_ADD_TITLE = "title_category";
    public const CATEGORY_ADD_CONTENT = "content_category";

    public const CATEGORY_CONNECT_POSTID = "postid";
    public const CATEGORY_CONNECT_NAME_CATEGORY = "category_name";

    public const COMMENT_ADD_TITLE = "title";
    public const COMMENT_ADD_CONTENT = "content_comment";
    public const COMMENT_ADD_POSTID = "postid";

    public const COMMENT_REMOVE_ID = "comment_id";
    public const COMMENT_REMOVE_SPAM = "spam";

    private Fabric $action;


    public function __construct(Parameters $parameters)
    {
        parent::__construct();
        $this->parameters = new NoParameters($parameters);
    }

    public function ExtensionData()
    {
        $this->addActualItem(new PostItem("action", $this->parameters->getParameter(0)));
    }

    protected function Initialize(): void
    {
        $this->action = new ChooseAction($this);
    //do zmiany
        $dataSuccess = @$this->action->getContext()['success'];
            if (isset($dataSuccess) && $dataSuccess == false) {
                $this->outputController->setDataSuccess(false);
                $this->outputController->setContent($this->action->getContext()['info']);
                return;
            }
        $this->outputController->setDataSuccess(true);
        $this->outputController->setContent($this->action->getContext());
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
            case "getuserbytoken":
            {
                $this->obj = new CheckAuthFa(new GetUserById(Authentication::getInstance()->getCurrentyUser()->getId()));
                break;
            }
            case "createcomment":
            {
                //do zmiany
                if (!Authentication::getInstance()->isAuthenticated())
                    (new CreateGuest($this->fabricCreator->getValues(AuthenticationSchema::USERNAME)))->action();
                $this->obj = new ItemExistFA(new AddCommentToPostEXT($this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_TITLE),
                    $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_CONTENT),
                    $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_POSTID),
                    Authentication::getInstance()->getCurrentyUser()->getId()),
                    $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_POSTID));
                break;
            }
            case "deletecomment":
            {
                $this->obj = new AuthenticateAdminOrOwnerFA(
                    new RemoveCommentFromPostEXT($this->fabricCreator->getValues(FastActionEXT::COMMENT_REMOVE_ID),
                        $this->fabricCreator->getValues(FastActionEXT::COMMENT_REMOVE_SPAM)),
                    $this->fabricCreator->getValues(FastActionEXT::COMMENT_REMOVE_ID));
                break;
            }
        }
    }

    public static function getMapActions()
    {
        return ["createcategory", "connectcategory", "createcomment", "deletecomment", "getUserByToken"];
    }

    public function getContext()
    {
        try {
            $this->createAction();

        } catch (TypeError $e) {
            $this->obj = new DefaultAction();
        }
        return $this->obj->getFastActionResponse();
    }
}

