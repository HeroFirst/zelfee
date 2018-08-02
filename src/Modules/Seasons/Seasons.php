<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 14.11.2016
 * Time: 4:47
 */

namespace Zelfi\Modules\Seasons;


use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\SettingsDefValues;
use Zelfi\Enum\SettingsNames;
use Zelfi\Modules\Settings\Settings;

class Seasons
{

    public static function getSeason($id){
        return ZFMedoo::get()->get('seasons', [
            'id',
            'name',
            'active'
        ], [
            'id' => $id
        ]);
    }

    public static function getCurrentSeason(){
        return ZFMedoo::get()->get('seasons', [
            'id',
            'name',
            'active'
        ], [
            'id' => Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF)
        ]);
    }

    public static function getAll()
    {
        return ZFMedoo::get()->select('seasons', '*');
    }
}