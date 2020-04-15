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

    public const ADD_LIKE_POSTID = "postid";
    public const ADD_LIKE_USERID = "userid";

    public const GET_DATA_USERID = 'userid';

    public const GET_USER = 'userid';

    public const REPORT_TYPE = 'type';
    public const REPORT_MESSAGE = 'message';


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

        $context =$this->action->getContext();
        $this->outputController->setDataSuccess($context->isSuccess());
        $this->outputController->setContent($context->getData());
        //BARDZO DO ZMIANY NIE RUSZAC TEGO BO ZA CHWILE...
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
    private array $mapAction;


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
                $this->mapAction[] = "createcategory";
                break;
            }
            case "addlikepost":
            {
                $this->obj = new CheckAuthFa(
                    new PostAddLikeEXT(Authentication::getInstance()->getCurrentyUser()->getId(),
                        $this->fabricCreator->getValues(FastActionEXT::ADD_LIKE_POSTID)));
                $this->mapAction[] = "addlikepost";
                break;
            }
            case "connectcategory":
            {
                $this->obj = new CheckAuthFa(new AddToCategoryEXT(
                    $this->fabricCreator->getValues(FastActionEXT::CATEGORY_CONNECT_NAME_CATEGORY),
                    $this->fabricCreator->getValues(FastActionEXT::CATEGORY_CONNECT_POSTID)));
                $this->mapAction[] = "connectcategory";
                break;
            }
            case "getuserbytoken":
            {
                $this->obj = new CheckAuthFa(new GetUserById(Authentication::getInstance()->getCurrentyUser()->getId()));
                $this->mapAction[] = "getuserbytoken";
                break;
            }
            case "getfulluserdata":
            {
                $this->obj = new GetFullUserData($this->fabricCreator->getValues(FastActionEXT::GET_DATA_USERID));
                $this->mapAction[] = "getfulluserdata";
                break;
            }
            case "getuserbyid":
            {
                $this->obj = new GetUserById($this->fabricCreator->getValues(FastActionEXT::GET_USER));
                $this->mapAction[] = "getuserbyid";
                break;
            }
            case "createcomment":
            {
                //do zmiany

                    if (!Authentication::getInstance()->isAuthenticated()) {
                        $guest = new CreateGuest($this->fabricCreator->getValues(AuthenticationSchema::USERNAME));
                        $guest->action();
                        Authentication::getInstance()->getCurrentyUser()->setId($guest->getCreatedID());
                    }
                    $this->obj = new ItemExistFA(new AddCommentToPostEXT($this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_TITLE),
                        $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_CONTENT),
                        $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_POSTID),
                        Authentication::getInstance()->getCurrentyUser()->getId()),
                        $this->fabricCreator->getValues(FastActionEXT::COMMENT_ADD_POSTID));

                $this->mapAction[] = "createcomment";
                break;
            }
            case "reportpost":{
                $this->obj =  new CheckAuthFa(new ReportAddEXT(
                    $this->fabricCreator->getValues(FastActionEXT::REPORT_TYPE),
                    $this->fabricCreator->getValues(FastActionEXT::REPORT_MESSAGE)));

                $this->mapAction[] = "reportpost";
                break;
            }
            case "showcategories":
            {
                $this->obj = new FetchListCategoriesEXT();

                $this->mapAction[] = "showcategories";
                break;
            }
            case "deletecomment":
            {
                $this->obj = new AuthenticateAdminOrOwnerFA(
                    new RemoveCommentFromPostEXT($this->fabricCreator->getValues(FastActionEXT::COMMENT_REMOVE_ID),
                        $this->fabricCreator->getValues(FastActionEXT::COMMENT_REMOVE_SPAM)),
                    $this->fabricCreator->getValues(FastActionEXT::COMMENT_REMOVE_ID));


                $this->mapAction[] = "deletecomment";
                break;
            }

        }
    }


    public function getContext()
    {
        $this->createAction();
        return $this->obj->getFastActionResponse();
           try {

        } catch (Error $e) {

              $this->obj = new DefaultAction($this->mapAction);
              return $this->obj->getFastActionResponse();
          }


    }
}

