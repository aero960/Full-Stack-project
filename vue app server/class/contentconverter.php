<?php

namespace converter{

    class contentConverter {

        private $content;

        public function __construct($webContent)
        {
                $this->content = ["data" => $webContent];
         }

        public function getContent(){
            echo "<pre>";
          print_r($this->content);
          echo "</pre>";
        }
    }


}

