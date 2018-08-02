<?php

namespace Zelfi\DB;

require_once 'DBConfig.php';

class PDO
{
    private static $_instance;
    public $pdo;
    private function __construct() {
        $config = getDBConfig();
        $this->pdo = new \PDO('mysql:host='.$config['server'].';dbname='.$config['database_name'], $config['username'], $config['password']);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }
    protected function __clone() {}

    public static function get(){
        if (self::$_instance === null) {
            self::$_instance = new PDO();
        }
        return self::$_instance->pdo;
    }
}