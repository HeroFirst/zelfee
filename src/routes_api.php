<?php
// Routes

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zelfi\Utils\AuthFilter\AdminAuthorization;
use Zelfi\Utils\AuthFilter\GuestAuthorization;
use Zelfi\Utils\AuthFilter\ModeratorAuthorization;
use Zelfi\Utils\AuthFilter\WriterAuthorization;
use Zelfi\Utils\ExportDataExcel;
use Zelfi\Utils\RendererHelper;


$app->group('/api/1', function() use ($app){

    $controller = new \Zelfi\Controllers\APIController($app);

    $app->get('/events', $controller('events'));
    $app->get('/authorizeMember', $controller('authorizeMember'));

});
