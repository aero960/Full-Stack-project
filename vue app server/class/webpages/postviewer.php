<?php


use authentication\Authentication;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;

class PostView extends Page
{
    private ViewQuery $showPosts;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new PostViewerParameters($parameters);
    }

    protected function pageContent()
    {
        $this->Initialize();
        $category = $this->parameters->getParameter("category");
        if (isset($category)) {
            $posts = (new CategoryShowEXT($this->parameters->getParameter("category")))->getFastActionResponse();

            if (!empty($posts)) {
                $data = [];
                foreach ($posts as $index) {
                    $post = new PostSchema($index);

                    $data[] = ["info" => "posty z kategori {$category}",
                        "content" => $post->toIterate(),
                        "comments" => (new ShowCommetoRealtedToPostEXT($post->getPostId()))->getFastActionResponse()];
                }
                return $data;
            }

            return ["info" => "Kategoria : " . $this->parameters->getParameter("category") . " nie posiada wpisow"];
        }
    }

    protected function Initialize(): void
    {

        /*
        if (Authentication::getInstance()->isAuthenticated())
            $this->showPosts = new ShowUserPost(Authentication::getInstance()->getCurrentyUser()->getId());
            $this->showPosts = new ShowAllPost();
        */
    }
}