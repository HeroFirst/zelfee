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

class UserInfoMiddleware
{
    function __invoke(\Slim\Http\Request $request, \Psr\Http\Message\ResponseInterface $response, $next) {
        $mainCityAlias = $request->getAttribute('routeInfo')[2]['main_city_alias'];
        $cookieHash = \Zelfi\Utils\Cookies::get($request, \Zelfi\Utils\Cookies::COOKIE_APP_AUTH_SESSION);
        $cookieCityId = \Zelfi\Utils\Cookies::get($request, \Zelfi\Utils\Cookies::COOKIE_APP_AUTH_CITY);
        
        $user = array();
        $simpleAuth = new SimpleAuth();

        if ($cookieHash !== ''){
            $user = $simpleAuth->getUserByHash($cookieHash);
        }

        if ($mainCityAlias){
            $mainCity = ZFMedoo::get()->get('cities', '*', [
                'alias' => $mainCityAlias
            ]);

            if ($mainCity){
                $mainCityId = $mainCity['id'];
                $user['city'] = $mainCity['id'];

                $simpleAuth->setCity($response, $mainCityId, $cookieHash);
            } else throw new \Slim\Exception\NotFoundException($request, $response);
        } else {
            $user['city'] = ($cookieCityId) ? $cookieCityId : 1;
        }

        $cities = \Zelfi\DB\ZFMedoo::get()->select('cities','*');
        $user_city = \Zelfi\DB\ZFMedoo::get()->get('cities','*', ['id'=>$user['city']]);
        $user['city_name'] = $user_city['name'];
        $user['city_alias'] = $user_city['alias'];
        $user['residence_name'] = \Zelfi\DB\ZFMedoo::get()->get('cities','*', ['id'=>$user['residence']])['name'];
        $user['balls']  = Rating::getBallsSeason($user['id']);
        $user['zelfi']  = Rating::getAllBalls($user['id'])['zelfi'];

        $zfUser = new \Zelfi\Model\ZFUser($user);
        $zfCities = new ZFCities($cities);
        $zfSocialLinks = SocialSites::getLinks($zfUser->getCity());
        $request = $request->withAttribute(\Zelfi\Enum\HelperAttributes::APPUSER, $zfUser);
        $request = $request->withAttribute(\Zelfi\Enum\HelperAttributes::APPCITIES, $zfCities);
        $request = $request->withAttribute(\Zelfi\Enum\HelperAttributes::APPSOCIALLINKS, $zfSocialLinks);

        $response = $next($request, $response);

        return $response;
    }

}