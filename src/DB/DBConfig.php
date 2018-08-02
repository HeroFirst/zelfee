<?php

function getDBConfig(){
    switch (\Zelfi\Utils\ProductionHelper::getServerType()){
        case 0:
            return DB_CONFIG_PRODUCTION;
        case 1:
            return DB_CONFIG_DEV;
        case 2:
            return DB_CONFIG_LOCAL;
    }
}

const DB_CONFIG_PRODUCTION = array(
    'database_type' => 'mysql',
    'database_name' => 'zelfi_ru',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'c8u2Lg8w84kt'
);

const DB_CONFIG_DEV = array(
    'database_type' => 'mysql',
    'database_name' => 'beta_zelfi_ru',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'c8u2Lg8w84kt'
);

const DB_CONFIG_LOCAL = array(
    'database_type' => 'mysql',
    'database_name' => 'zelfi',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
);