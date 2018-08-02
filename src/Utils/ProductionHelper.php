<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 12.11.2016
 * Time: 6:47
 */

namespace Zelfi\Utils;


class ProductionHelper
{
    /**
     * @return int [0 - production, 1 - dev, 2 - local]
     */
    static function getServerType(){
        if ($_SERVER["HTTP_HOST"] == 'zelfi.ru' || $_SERVER["HTTP_HOST"] == 'www.zelfi.ru') return 0;
        else if ( $_SERVER["HTTP_HOST"] == 'beta.zelfi.ru') return 1;
        else return 2;
    }
}