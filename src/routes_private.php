<?php
// Routes

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zelfi\DB\ZFMedoo;
use Zelfi\Utils\AuthFilter\AdminAuthorization;
use Zelfi\Utils\AuthFilter\GuestAuthorization;
use Zelfi\Utils\AuthFilter\ModeratorAuthorization;
use Zelfi\Utils\AuthFilter\WriterAuthorization;
use Zelfi\Utils\RendererHelper;

$app->group('/private', function() use ($app){

    $this->get('/', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        RendererHelper::get()
            ->addCurrentId(0)
            ->with($request, $args);
        $this->logger->info("Slim-Skeleton '/private/' route");

        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_balls_users_video_not_approved = [
            'AND' => [
                'balls_users_video.active' => true,
                'balls_users_video.approved' => false
            ]
        ];

        $where_orders = [
            'AND' => [
                'store_orders.accepted' => false,
                'store_orders.finished' => false,
                'store_orders.active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_balls_users_video_not_approved['AND']['users.residence'] = $privateData['filter_city'];
            $where_orders['AND']['users.residence'] = $privateData['filter_city'];
        }

        $balls_users_video_not_approved_count = ZFMedoo::get()->count(
            'balls_users_video',[
                '[>]users' => [
                    'user_id' => 'id'
                ]
        ],
            'balls_users_video.id' , $where_balls_users_video_not_approved);

        $store_orders_count = ZFMedoo::get()->count('store_orders', [
            '[>]users' => [
                'user_id' => 'id'
            ]
        ],
            'store_orders.id', $where_orders);

        $args['balls_users_video_not_approved_count'] = $balls_users_video_not_approved_count;
        $args['store_orders_count'] = $store_orders_count;

        return $this->renderer->render($response, '/private/index.php', $args);
    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/places', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivatePlacesController($app);

        $app->get('/all', $controller('get_all'));
        $app->get('/new', $controller('get_new'));
        $app->get('/edit/{id}', $controller('get_edit'));

        $app->post('/new', $controller('post_new'));
        $app->post('/edit', $controller('post_edit'));
        $app->post('/delete', $controller('post_delete'));

    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/events', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivateEventsController($app);

        $app->get('/all', $controller('get_all'));
        $app->get('/trash', $controller('get_trash'));
        $app->get('/new', $controller('get_new'));
        $app->get('/edit/{id}', $controller('get_edit'));
        $app->get('/members/{id}/new', $controller('get_members_new'));
        $app->get('/members/{id}/export/excel', $controller('get_members_export_excel'));
        $app->get('/members/{id}/{type}', $controller('get_members'));

        $app->post('/new', $controller('post_new'));
        $app->post('/edit', $controller('post_edit'));
        $app->post('/delete', $controller('post_delete'));
        $app->post('/restore', $controller('post_restore'));
        $app->post('/members/new', $controller('post_members_new'));
        $app->post('/members/remove', $controller('post_members_remove'));

    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/users', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivateUsersController($app);



        //++
        $app->get('/teams/all', $controller('get_all_team'));
        $app->get('/teams', $controller('get_all_team'));
        $app->get('/team/{id}/edit', $controller('edit_team'));
        $app->get('/teams/create', $controller('create_team'));
        $app->post('/teams/create', $controller('create_db_team'));
        $app->post('/team/update', $controller('add_member_team'));
        $app->post('/team/ball', $controller('ball_edit_team'));
        $app->post('/team/changecity', $controller('changecity'));
        //++
        
        $app->get('/all', $controller('get_all'));
        $app->get('/disabled', $controller('get_disabled'));
        $app->get('/new', $controller('get_new'));
        $app->get('/edit/{id}', $controller('get_edit'));
        $app->get('/events/{id}', $controller('get_events'));

        $app->post('/new', $controller('post_new'));
        $app->post('/edit', $controller('post_edit'));
        $app->post('/disable', $controller('post_disable'));
        $app->post('/enable', $controller('post_enable'));
        $app->post('/reset', $controller('post_reset'));

    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/paper', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivatePaperController($app);

        $app->get('/all', $controller('get_all'));
        $app->get('/draft', $controller('get_draft'));
        $app->get('/trash', $controller('get_trash'));
        $app->get('/new', $controller('get_new'));
        $app->get('/edit/{id}', $controller('get_edit'));

        $app->post('/new', $controller('post_new'));
        $app->post('/edit', $controller('post_edit'));
        $app->post('/delete', $controller('post_delete'));
        $app->post('/restore', $controller('post_restore'));
    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/news', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivateNewsController($app);

        $app->get('/all', $controller('get_all'));
        $app->get('/draft', $controller('get_draft'));
        $app->get('/trash', $controller('get_trash'));
        $app->get('/new', $controller('get_new'));
        $app->get('/edit/{id}', $controller('get_edit'));

        $app->post('/new', $controller('post_new'));
        $app->post('/edit', $controller('post_edit'));
        $app->post('/delete', $controller('post_delete'));
        $app->post('/restore', $controller('post_restore'));
    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/balls-system', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivateBallsSystemController($app);

        $app->get('/users/all', $controller('get_users_all'));
        $app->get('/users/edit/{id}', $controller('get_users_edit'));
        $app->get('/bonuses/attending-events', $controller('get_bonuses_attending_events'));
        $app->get('/bonuses/attending-events/add', $controller('get_bonuses_attending_events_add'));
        $app->get('/bonuses/attending-events/edit/{id}', $controller('get_bonuses_attending_events_edit'));
        $app->get('/bonuses/users-video/new', $controller('get_users_video_new'));
        $app->get('/bonuses/users-video/approved', $controller('get_users_video_approved'));

        $app->post('/users/edit', $controller('post_users_edit'));
        $app->post('/bonuses/attending-events/add', $controller('post_bonuses_attending_events_add'));
        $app->post('/bonuses/attending-events/edit', $controller('post_bonuses_attending_events_edit'));
        $app->post('/bonuses/attending-events/remove', $controller('post_bonuses_attending_events_remove'));
        $app->post('/bonuses/users-video/approve', $controller('post_users_video_approve'));
        $app->post('/bonuses/users-video/remove', $controller('post_users_video_remove'));

    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/galleries', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivateGalleriesController($app);

        $app->get('/all', $controller('get_all'));
        $app->get('/new', $controller('get_new'));
        $app->get('/edit/{id}', $controller('get_edit'));

        $app->post('/new', $controller('post_new'));
        $app->post('/edit', $controller('post_edit'));
        $app->post('/delete', $controller('post_delete'));
    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/partners', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivatePartnersController($app);

        $app->get('/all', $controller('get_all'));
        $app->get('/new', $controller('get_new'));
        $app->get('/edit/{id}', $controller('get_edit'));

        $app->post('/new', $controller('post_new'));
        $app->post('/edit', $controller('post_edit'));
        $app->post('/delete', $controller('post_delete'));

    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

    $app->group('/store', function () use ($app) {
        $controller = new \Zelfi\Controllers\PrivateStoreController($app);

        $app->get('/all', $controller('get_all'));
        $app->get('/orders/new', $controller('get_orders_new'));
        $app->get('/orders/accepted', $controller('get_orders_accepted'));
        $app->get('/orders/finished', $controller('get_orders_finished'));
        $app->get('/new', $controller('get_new'));
        $app->get('/edit/{id}', $controller('get_edit'));

        $app->post('/new', $controller('post_new'));
        $app->post('/edit', $controller('post_edit'));
        $app->post('/delete', $controller('post_delete'));
        $app->post('/orders/accept', $controller('post_orders_accept'));
        $app->post('/orders/finish', $controller('post_orders_finish'));
        $app->post('/orders/remove', $controller('post_orders_remove'));

    })->add(
        new \Zelfi\Utils\AuthFilter\AdminAuthorization()
    );

});
