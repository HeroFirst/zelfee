<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 17.11.2016
 * Time: 16:05
 */

namespace Zelfi\Enum;


use Zelfi\Utils\Enum;

class BallsTypes extends Enum
{
    // За посещение мероприятия
    const EVENT = 1;
    // За регистрацию
    const REGISTRATION = 2;
    //Коррекция баллов
    const CORRECTION = 3;
    //За загрузку видео
    const VIDEO_UPLOAD = 4;
    //За заказ в магазине
    const STORE_ORDER = 5;
    //Возврат средств
    const STORE_ORDER_RETURN = 6;
}