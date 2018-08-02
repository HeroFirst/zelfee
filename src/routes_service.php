<?php
// Routes

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zelfi\Utils\AuthFilter\AdminAuthorization;
use Zelfi\Utils\AuthFilter\GuestAuthorization;
use Zelfi\Utils\AuthFilter\ModeratorAuthorization;
use Zelfi\Utils\AuthFilter\WriterAuthorization;
use Zelfi\Utils\RendererHelper;


$app->group('/service', function() use ($app){
    $controller_service = new \Zelfi\Controllers\ServicesController($app);

    $app->get('/test', $controller_service('get_test'));
    $app->get('/mailchimp/webhook', $controller_service('mailchimpWebhook'));
    $app->get('/mailchimp/sync', $controller_service('mailChimpSync'));
    $app->get('/git/pull', $controller_service('gitPull'));

    $app->post('/mailchimp/webhook', $controller_service('mailchimpWebhook'));
    $app->post('/git/pull', $controller_service('gitPull'));
});
