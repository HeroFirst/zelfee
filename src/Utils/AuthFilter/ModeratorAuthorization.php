<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 04.11.2016
 * Time: 0:37
 */

namespace Zelfi\Utils\AuthFilter;

class ModeratorAuthorization extends AdminAuthorization
{
    protected function isAuthorized($user){
        return ($user->getRole() == 3) || parent::isAuthorized($user);
    }
}