<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new \Zelfi\Middleware\MenuCounterMiddleware());
$app->add(new \Zelfi\Middleware\PrivateMiddleware());
$app->add(new \Zelfi\Middleware\UserInfoMiddleware());
$app->add(function ($request, $response, $next) use ($c) {
    $response = $next($request, $response);

    if (404 === $response->getStatusCode() && 0 === $response->getBody()->getSize()) {
        $handler = $c['notFoundHandler'];

        return $handler($request, $response);
    }

    return $response;
});