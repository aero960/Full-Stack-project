<?php


use authentication\Authentication;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;

class PostIterator implements Iterator
{

    private array $iterate;
    private $position = 0;
    private bool $commentShow;

    public function __construct(array $iterate,bool $commentShow = true,bool $tagsShow = true,bool $categoryShow = true,bool $userShow = true)
    {
        $this->iterate = $iterate;
        $this->commentShow = $commentShow;

    }

    public function current()
    {
        $currenty = $this->iterate[$this->position];
        return ["postdata" => $currenty->toIterate(),
            "tags" => (new TagsShowEXT($currenty->getPostId()))->getFastActionResponse()->getData(),
            "category" => (new ShowCategoryToSpecificPostEXT($currenty->getPostId()))->getFastActionResponse()->getData(),
            "comment" =>($this->commentShow) ? (new ShowCommetoRealtedToPostEXT($currenty->getPostId()))->getFastActionResponse()->getData() : 'ukryte',
            "user"=> (new GetUserById($currenty->getUserId()))->getFastActionResponse()->getData()
         ];
    }


    public function next()
    {
        ++$this->position;
    }


    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->iterate[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

}


class PostView extends Page
{
    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new PostViewerParameters($parameters);
    }

    private function showPostCategory(string $category)
    {
        //do zmiany
        $pageNumber = $this->parameters->getParameter("page");
        $page = (isset($pageNumber)) ? $this->parameters->getParameter("page") : 0;

        $pager = new PageLimiter(new AuthenticationPrivateFilter(new CategoryShowEXT($category)), $page);

        $posts = $pager->getView();
        if (!empty($posts)) {
            $this->outputController->setDataSuccess(true);
            $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage("c.p.s"), $category));
            $this->outputController->setContent($pager->getInfo());
            $this->outputController->setMulticontent(new PostIterator($posts,false));
            return true;
        }
        return false;
    }

    private function showUserCategory(string $userId)
    {

        $pageNumber = $this->parameters->getParameter("page");
        $page = (isset($pageNumber)) ? $this->parameters->getParameter("page") : 0;
        $pager = new PageLimiter(new AuthenticationPrivateFilter(new ShowUserPost($userId)), $page);
        $posts = $pager->getView();

        if (!empty($posts)) {
            $this->outputController->setDataSuccess(true);
            $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage("u.p"), $userId));
            $this->outputController->setContent($pager->getInfo());
            $this->outputController->setMulticontent(new PostIterator($posts,false));
            return true;
        }
        return false;


    }

    private function showAllPosts()
    {

        $pageNumber = $this->parameters->getParameter("page");

        $page = (isset($pageNumber)) ? $this->parameters->getParameter("page") : 0;


        $pager = new PageLimiter(new AuthenticationPrivateFilter(new ShowAllPost()), $page);
        $posts = $pager->getView();


        if (!empty($posts)) {

            $this->outputController->setDataSuccess(true);
            $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage("p.a.s")));
            $this->outputController->setContent($pager->getInfo());

            $this->outputController->setMulticontent(new PostIterator($posts,false));
            return true;
        } else {
            $this->outputController->setContent($pager->getInfo());
        }
        return false;
    }


    protected function Initialize(): void
    {
        $category = $this->parameters->getParameter("category");

        $user = $this->parameters->getParameter("user");
        if (isset($category)) {
            $successAction = $this->showPostCategory($category);
        } elseif (isset($user)) {
            if((new UserExist($user))->action())
            $successAction = $this->showUserCategory($user);
            else
                $successAction = false;
        } else{

            $successAction = $this->showAllPosts();
        }


        if (!$successAction) {
            $this->outputController->setDataSuccess(false);
            $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage("p.n.f"));
        }


    }
}