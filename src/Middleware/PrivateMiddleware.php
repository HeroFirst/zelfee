<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 07.11.2016
 * Time: 1:43
 */

namespace Zelfi\Middleware;


use Zelfi\DB\ZFMedoo;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Model\ZFCities;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Modules\SocialSites\SocialSites;

class PrivateMiddleware
{
    function __invoke(\Slim\Http\Request $request, \Psr\Http\Message\ResponseInterface $response, $next) {
        $get_filter_city = $request->getQueryParam('filter-city');

        if ($get_filter_city != null){
            $cookiePrivateCityId = \Zelfi\Utils\Cookies::set($response, \Zelfi\Utils\Cookies::COOKIE_APP_PRIVATE_CITY, $get_filter_city);
        } else {
            $cookiePrivateCityId = \Zelfi\Utils\Cookies::getWithDefault($request, $response, \Zelfi\Utils\Cookies::COOKIE_APP_PRIVATE_CITY, 0);
        }

        $privateData = [];

        $privateData['filter_city'] = $cookiePrivateCityId;

        $request = $request->withAttribute(\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA, $privateData);

        $response = $next($request, $response);

        return $response;
    }

}