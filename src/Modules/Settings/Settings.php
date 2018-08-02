<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 14.11.2016
 * Time: 4:33
 */

namespace Zelfi\Modules\Settings;

use Zelfi\DB\ZFMedoo;

class Settings
{

    public static function get($name, $defValue = ''){

        $value = ZFMedoo::get()->get('settings', '*', ['name' => $name]);

        if (!$value){
            ZFMedoo::get()->insert('settings', ['name' => $name, 'value' => $defValue]);
        }

        return ($value) ? $value['value'] : $defValue;
    }

    public static function set($name, $value){
        if (ZFMedoo::get()->get('settings', '*', ['name' => $name])){
            ZFMedoo::get()->update('settings', ['value' => $value], ['name' => $name]);
        } else {
            ZFMedoo::get()->insert('settings', ['name' => $name,'value' => $value]);
        }
    }

}