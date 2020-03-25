<?php

use authentication\Authentication;
use language\Serverlanguage;

class PermissionChecker {

    public static function checkNormalUserAuth(){
           $permission =   Authentication::getInstance()->getCurrentyUser()->getPermission();
           if($permission < 1){
               return ["info"=> Serverlanguage::getInstance()->GetMessage("noactivepage")];
           }


    }



}
