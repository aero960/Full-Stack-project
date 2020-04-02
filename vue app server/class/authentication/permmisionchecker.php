<?php

use authentication\Authentication;
use authentication\Permmision;
use language\Serverlanguage;

class PermissionChecker {

    const CHECKER = 'PermissionChecker';
    const NORMALAUTH ='checkNormalUserAuth';
    const ADMINAUTH = 'checkAdminUserAuth';
    const POSTOWNERAUTH = 'checkPostOwner';

    public static function checkNormalUserAuth(){
           $permission =   Authentication::getInstance()->getCurrentyUser()->getPermission();
           if($permission < Permmision::NORMAL){
               return ["info"=> Serverlanguage::getInstance()->GetMessage("noactivepage")];
           }
           return null;
    }

    public static function checkAdminUserAuth(){

        $permission =   Authentication::getInstance()->getCurrentyUser()->getPermission();
        if($permission < Permmision::ADMIN){
            return ["info"=> Serverlanguage::getInstance()->GetMessage("noactiveadmin")];
        }
        return null;
    }



}
