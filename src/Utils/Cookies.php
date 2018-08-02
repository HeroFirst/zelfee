<?php

namespace Zelfi\Utils;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Cookies{

    const COOKIE_OAUTH2STATE = "oauth2state";
    const COOKIE_OAUTH2REDIRECT = "oauth2redirect";
    const COOKIE_APP_AUTH_SESSION = "app_auth_session";
    const COOKIE_APP_AUTH_CITY = "app_auth_city";

    const COOKIE_APP_PRIVATE_CITY = "app_private_city";

    public static function get(RequestInterface $request, $name)
    {
        return FigRequestCookies::get($request, $name)->getValue();
    }

    public static function getWithDefault(RequestInterface $request, ResponseInterface &$response, $name, $default)
    {
        if (FigRequestCookies::get($request, $name)->getValue() == null){
            self::set($response, $name, $default);
        }

        return FigRequestCookies::get($request, $name)->getValue();
    }

    public static function set(ResponseInterface &$response, $name, $value = null, $expire = 0)
    {
        $response = FigResponseCookies::set($response, SetCookie::create($name)
            ->withValue($value)
            ->withExpires($expire)
            ->withPath('/')
        );

        return $value;
    }

}