<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 05.11.2016
 * Time: 0:45
 */

namespace Zelfi\DB;

use medoo;

require_once 'DBConfig.php';

class ZFMedoo
{
    public static $medoo;

    private function __construct() {}
    protected function __clone() {}

    /**
     * @return Medoo
     */
    public static function get(){
        if (is_null(self::$medoo)){
            self::$medoo = new Medoo(getDBConfig());
        }

        return self::$medoo;
    }
}