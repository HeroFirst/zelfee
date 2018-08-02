<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 18.11.2016
 * Time: 4:26
 */

namespace Zelfi\Utils;


class AppUtils
{
    public static function fileExt($contentType)
    {
        $map = array(
            'application/pdf'   => '.pdf',
            'application/zip'   => '.zip',
            'image/gif'         => '.gif',
            'image/jpeg'        => '.jpg',
            'image/png'         => '.png',
            'text/css'          => '.css',
            'text/html'         => '.html',
            'text/javascript'   => '.js',
            'text/plain'        => '.txt',
            'text/xml'          => '.xml',
        );
        if (isset($map[$contentType]))
        {
            return $map[$contentType];
        }

        // HACKISH CATCH ALL (WHICH IN MY CASE IS
        // PREFERRED OVER THROWING AN EXCEPTION)
        $pieces = explode('/', $contentType);
        return '.' . array_pop($pieces);
    }


    /*
    echo plural_form(42, array('арбуз', 'арбуза', 'арбузов'));
    */
    static function plural_form($n, $forms) {
        return $n.' '.($n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]));
    }
}