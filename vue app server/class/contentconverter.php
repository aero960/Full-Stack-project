<?php

namespace converter {

    class contentConverter
    {

        private $content;

        public function __construct($webContent)
        {
            $this->content = ["data" => $webContent];
        }

        public function getContent()
        {
            return json_encode($this->content, JSON_FORCE_OBJECT);
        }
    }


}

