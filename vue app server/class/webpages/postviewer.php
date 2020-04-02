<?php


use authentication\Authentication;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;

class PostView extends Page
{

    private ViewQuery $showPosts;
    private PostModificator $postManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new NoParameters();
    }
    protected function pageContent()
    {
        $this->Initialize();
        $arrayOfPost = array_filter($this->showPosts->getView(), fn($index) => $index[1]->getPublished());
        return empty($arrayOfPost) ? ["info" => Serverlanguage::getInstance()->GetMessage("doesent.published.posts")] : $arrayOfPost;
    }
    protected function Initialize(): void
    {
        if (Authentication::getInstance()->isAuthenticated())
            $this->showPosts = new ShowUserPost(Authentication::getInstance()->getCurrentyUser()->getId());
        else
            $this->showPosts = new ShowAllPost();

    }
}