<?php

use WebpageMNG\Page;

class page_error extends Page{

    protected function pageContent()
    {
       return "This page probably doesnt exist";
    }
}