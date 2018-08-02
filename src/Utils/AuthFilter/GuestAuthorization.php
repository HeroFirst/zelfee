<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 04.11.2016
 * Time: 0:36
 */

namespace Zelfi\Utils\AuthFilter;

class GuestAuthorization extends WriterAuthorization
{
    protected function isAuthorized($user){
        return true;
    }
}
