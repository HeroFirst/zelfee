<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 22.11.2016
 * Time: 15:46
 */

namespace Zelfi\Middleware;


use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Utils\RendererHelper;

class MenuCounterMiddleware
{
    function __invoke(\Slim\Http\Request $request, \Psr\Http\Message\ResponseInterface $response, $next) {
        /* @var \Zelfi\Model\ZFUser $zfUser */

        $args = RendererHelper::get()
            ->with($request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $zfMenuCounter = [];

        $events = ZFMedoo::get()->select(
            'events',
            [
                '[>]events_places' => [
                    'id' => 'event_id'
                ]
            ],
            '*',
            [
                'GROUP' => 'events.id',
                'AND' => [
                    'events.date_start[>=]' => date('Y-m-d H:i:s'),
                    'events_places.place_id' => ZFMedoo::get()->select('places', 'id', ['city' => $zfUser->getCity()]),
                    'events.active' => true
                ]
            ]
        );

        $zfMenuCounter['2'] = $events ? count($events) : 0;

        $request = $request->withAttribute(\Zelfi\Enum\HelperAttributes::APPMENUCOUNTER, $zfMenuCounter);

        $response = $next($request, $response);

        return $response;
    }
}