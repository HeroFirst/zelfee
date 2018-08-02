<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 15.11.2016
 * Time: 14:08
 */

namespace Zelfi\Utils;


class DateHelper
{
    public static function getDateFromRU($date, $time = '00:00'){
        return date("Y-m-d H:i:s", strtotime($date.''.$time));
    }

    public static function getDateFromDateTIme($date, $format = "d.m.Y"){
        return date($format, strtotime($date));
    }

    public static function getTimeFromDateTime($date, $format = "H:i"){
        return date($format, strtotime($date));
    }

    public static function getRussianDate($date)
    {
        return date("d M Y", strtotime($date));
    }

    public static function getEnDate()
    {
        return date("Y-m-d");
    }
}