<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 04.11.2016
 * Time: 0:37
 */

namespace Zelfi\Utils\AuthFilter;

class WriterAuthorization extends ModeratorAuthorization
{
    protected function isAuthorized($user){
        return ($user->getRole() == 4) || parent::isAuthorized($user);
    }
}