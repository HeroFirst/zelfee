<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 04.10.2016
 * Time: 18:57
 */

namespace Zelfi\Utils\AuthFilter;

use Zelfi\Enum\HelperAttributes;
use Zelfi\Model\ZFUser;

class Authorization
{
    /**
     * Authorization middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        /* @var ZFUser $zfUser */
        $zfUser = $request->getAttribute(HelperAttributes::APPUSER);

        if(!$this->isAuthorized($zfUser)){
            throw new \Slim\Exception\NotFoundException($request, $response);
        }

        return $next($request, $response);
    }

    /**
     * Check if the given user is authorized.
     *
     * @param  ZFUser $user The user to check.
     *
     * @return boolean True if the user is authorized, false otherwise.
     */
    protected function isAuthorized($user){
        return false;
    }
}


