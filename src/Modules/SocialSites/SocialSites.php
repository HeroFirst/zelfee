<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 17.11.2016
 * Time: 3:25
 */

namespace Zelfi\Modules\SocialSites;


class SocialSites
{
    const links = [
        [
            'vk' => '//vk.com/zf_kzn',
            'fb' => '//facebook.com/zfmillion',
            'instagram' => '//instagram.com/zf_kzn',
            'ok' => '//ok.ru/zfmillion',
            'twitter' => '//twitter.com/ZF_russia',
            'youtube' => '//www.youtube.com/channel/UCFTlvt5mQ67BZIpIREeHB9g',
        ],
        [
            'vk' => '//vk.com/zf_almet',
            'fb' => '//facebook.com/zfmillion',
            'instagram' => '//instagram.com/zf_almet',
            'ok' => '//ok.ru/zfmillion',
            'twitter' => '//twitter.com/ZF_russia',
            'youtube' => '//www.youtube.com/channel/UCFTlvt5mQ67BZIpIREeHB9g',
        ]
    ];

    public static function getLinks($city){
        if ($city-1 < count(self::links)) return self::links[$city-1];
        else return null;
    }
}