<?php
// Routes
use Dflydev\FigCookies\Cookie;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Psr\Http\Message\ResponseInterface;
use Zelfi\DB\PDO;
use Psr\Http\Message\ServerRequestInterface;
use JeremyKendall\Password\PasswordValidator;
use JeremyKendall\Slim\Auth\Adapter\Db\PdoAdapter;
use JeremyKendall\Slim\Auth\Bootstrap;
use Zelfi\Controllers\AppController;
use Zelfi\Controllers\RegistrationController;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\Strings;
use Zelfi\Modules\Auth\SocialAuth;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Modules\Settings\Settings;
use Zelfi\Utils\RendererHelper;

$app->get('/register', function ($request, $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */
    RendererHelper::get()
        ->addCurrentId(9)
        ->addFooterScripts(['register'])
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    if ($zfUser->getRole() < 6 || $zfUser->getActive()) throw new \Slim\Exception\NotFoundException($request, $response);

    return $this->renderer->render($response, 'register/step_1.php', $args);
});

$app->get('/recover', function ($request, $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */
    RendererHelper::get()
        ->addCurrentId(9)
        ->addFooterScripts(['recover'])
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    if ($zfUser->getRole() < 6 || $zfUser->getActive()) throw new \Slim\Exception\NotFoundException($request, $response);

    return $this->renderer->render($response, 'register/recover.php', $args);
});

$app->get('/register/step/2', function ($request, $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */

    RendererHelper::get()
        ->addFooterScripts(['register'])
        ->addFooterData(['register_step_2'])
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    $cities = \Zelfi\DB\ZFMedoo::get()->select('cities','*',['active'=>true]);

    $args['cities'] = $cities;

    if ($zfUser->getRole() > 5 || $zfUser->getActive()) throw new \Slim\Exception\NotFoundException($request, $response);

    return $this->renderer->render($response, 'register/step_2.php', $args);
});

$app->post('/events/subscribe', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */

    RendererHelper::get()
        ->addFooterScripts(['event'])
        ->addBodyClasses(['event-single'])
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    $mainCity = ZFMedoo::get()->get('cities', '*', [
        'id' => $zfUser->getCity()
    ]);

    $event_id = $request->getParsedBodyParam('event_id');
    $place_id = $request->getParsedBodyParam('place_id');

    if ($event_id && $place_id){
        if (ZFMedoo::get()->has('events', [
            'id' => $event_id
        ])){
            if (!ZFMedoo::get()->has('events_members', [
                'AND' => [
                    'user_id' => $zfUser->getInfoItem('id'),
                    'event_id' => $event_id,
                    'place_id' => $place_id
                ]
            ])){
				$team_id = ZFMedoo::get()->select('teams_users', 'team_id', [

						'AND' => [
							'user_id' => $zfUser->getInfoItem('id'),
							'team_alert' => 0
						]
					]);			

					
					$team_id['team_id'] = $team_id[0];
                $row_id = ZFMedoo::get()->insert('events_members', [
                    'user_id' => $zfUser->getInfoItem('id'),
                    'event_id' => $event_id,
					'team_id' => $team_id['team_id'],
                    'finished' => false,
                    'place_id' => $place_id,
                    'is_subscribe_online' => true,
                    'active' => true
                ]);

                if ($row_id){
                    return $response->withRedirect('/'.$mainCity['alias'].'/events/'.$event_id.'?status=success');
                } else {
                    return $response->withRedirect('/'.$mainCity['alias'].'/events/'.$event_id.'?status=fail');
                }
            } else {
                return $response->withRedirect('/'.$mainCity['alias'].'/events/'.$event_id.'?status=fail');
            }
        }
    }

    return $response->withRedirect('/'.$mainCity['alias'].'/events/'.$event_id);
});

$app->post('/events/unsubscribe', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */

    RendererHelper::get()
        ->addFooterScripts(['event'])
        ->addBodyClasses(['event-single'])
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    $mainCity = ZFMedoo::get()->get('cities', '*', [
        'id' => $zfUser->getCity()
    ]);

    $event_id = $request->getParsedBodyParam('event_id');

    if ($event_id){
        if (ZFMedoo::get()->has('events', [
            'id' => $event_id
        ])){
            ZFMedoo::get()->delete('events_members', [
                'AND' => [
                    'user_id' => $zfUser->getInfoItem('id'),
                    'event_id' => $event_id
                ]
            ]);
        }
    }

    return $response->withRedirect('/'.$mainCity['alias'].'/events/'.$event_id);

});

$app->get('/terms', function ($request, $response, $args) {
    RendererHelper::get()
        ->with($request, $args);

    return $this->renderer->render($response, 'terms.php', $args);
});

$app->group('/auth', function () use ($app) {

    $controller = new \Zelfi\Controllers\AuthSocialController($app);

    $app->get('/vk', $controller('authVk'));

    $app->post('/email', $controller('authEmail'));

    $app->get('/fb', $controller('authFb'));

    $app->get('/gplus', $controller('authGPlus'));

    $app->get('/logout', $controller('logout'));

    $app->group('/callback', function () use ($app, $controller){

        $this->get('/vk', $controller('callbackVk'));

        $this->get('/digits', $controller('callbackDigits'));

        $this->get('/fb', $controller('callbackFb'));

        $this->get('/gplus', $controller('callbackGPlus'));

    });

});

//POST

$app->post('/recover', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */

    RendererHelper::get()
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    $email = $request->getParsedBodyParam('email');

    if ($email){
        $user = ZFMedoo::get()->get('users', '*',[
            'email' => $email
        ]);

        if ($user){
            $simpleAuth = new \Zelfi\Modules\Auth\SimpleAuth();
            $simpleAuth->reset($user['id']);

            return $response->withRedirect('/?modal-message=Новые данные для входа отправлены на ваш email');

        }
    }

    return $response->withRedirect('/recover?modal-message=Пользователь с данным email не найден');
});

$app->group('/users', function () use ($app){
    $controller = new \Zelfi\Controllers\UsersController($app);

    $app->get('/me', $controller('get_me'));
    $app->get('/me/settings', $controller('get_me_settings'));
    $app->get('/me/{id}/changelider', $controller('change_capitan_team')); // смена капитана
    $app->get('/me/team/{id}/out', $controller('out_from_team')); // смена капитана
    $app->get('/me/team/{id}/accede', $controller('accede_to_team')); // смена капитана
    $app->get('/me/team/{id}/teamdelete', $controller('delete_team')); // удаление команды

    $app->post('/me/search', $controller('search_item_rating')); // смена капитана
    $app->post('/me/addmember', $controller('add_member_toteam')); // смена капитана
    $app->post('/settings/info', $controller('post_settings_info'));
    $app->post('/settings/password', $controller('post_settings_password'));
    $app->post('/settings/subscribe', $controller('post_settings_subscribe'));
});

$app->group('/app', function () use ($app){
    $controller = new AppController($app);

    $app->post('/feedback', $controller('feedback'));

});

$app->group('/users', function () use ($app){
    $controller = new \Zelfi\Controllers\UsersController($app);

    $app->post('/update/cover', $controller('post_update_cover'));
    $app->post('/balls/videos/new', $controller('post_balls_videos_new'));
    $app->post('/balls/videos/remove', $controller('post_balls_videos_remove'));

});

$app->group('/registration', function () use ($app) {
    $controller = new RegistrationController($app);

    $app->post('/step/1', $controller('registrationStepOne'));
    $app->post('/step/2', $controller('registrationStepTwo'));
});

$app->get('/', function (\Slim\Http\Request $request, ResponseInterface $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */

    RendererHelper::get()
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    $mainCity = ZFMedoo::get()->get('cities', '*', [
        'id' => $zfUser->getCity()
    ]);

    return $response->withRedirect('/'.$mainCity['alias']);
});

$app->get('/events/{id}', function (\Slim\Http\Request $request, ResponseInterface $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */

    RendererHelper::get()
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    $id = $args['id'];

    $mainCity = ZFMedoo::get()->get('cities', '*', [
        'id' => $zfUser->getCity()
    ]);

    return $response->withRedirect('/'.$mainCity['alias'].'/events/'.$id);
});

$app->get('/news/{id}', function (\Slim\Http\Request $request, ResponseInterface $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */

    RendererHelper::get()
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    $id = $args['id'];

    $mainCity = ZFMedoo::get()->get('cities', '*', [
        'id' => $zfUser->getCity()
    ]);

    return $response->withRedirect('/'.$mainCity['alias'].'/news/'.$id);
});

$app->get('/paper/{id}', function (\Slim\Http\Request $request, ResponseInterface $response, $args) {
    /* @var \Zelfi\Model\ZFUser $zfUser */

    RendererHelper::get()
        ->with($request, $args);

    $zfUser = $args[HelperAttributes::APPUSER];

    $id = $args['id'];

    $mainCity = ZFMedoo::get()->get('cities', '*', [
        'id' => $zfUser->getCity()
    ]);

    return $response->withRedirect('/'.$mainCity['alias'].'/paper/'.$id);
});

$app->group('/store', function () use ($app) {
    $controller = new \Zelfi\Controllers\StoreController($app);

    $app->post('/order/new', $controller('post_order_new'));
    $app->post('/order/remove', $controller('post_order_remove'));
});

$app->group('/{main_city_alias}', function () use ($app) {
    $app->get('', function (\Slim\Http\Request $request, ResponseInterface $response, $args) {
        /* @var \Zelfi\Model\ZFUser $zfUser */
        $this->logger->info("Slim-Skeleton '/' route");

        RendererHelper::get()
            ->addCurrentId(0)
            ->addFooterData([
                'home'
            ])
            ->with($request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $paper_types = \Zelfi\DB\ZFMedoo::get()->select('papers_types', '*');
        $news_types = \Zelfi\DB\ZFMedoo::get()->select('news_types', '*');

        $slider = [];
        $slider['paper'] = ZFMedoo::get()->select(
            'papers',
            [
                '[>]papers_cities' => [
                    'id' => 'paper_id'
                ],
                '[>]users' => [
                    'user_created' => 'id'
                ]
            ],
            [
                'papers.id',
                'papers.title',
                'papers.description_short',
                'papers.description',
                'papers.cover',
                'papers.cover_big',
                'papers.cover_social',
                'papers.alias',
                'papers.type',
                'papers.user_created',
                'papers.date_publish',
                'papers.date_created',
                'papers.is_hot',
                'papers.is_draft',
                'user' => [
                    'users.first_name',
                    'users.last_name',
                    'users.photo',
                    'users.photo_small'
                ]
            ],
            [
                'ORDER' => [
                    'papers.date_publish' => 'DESC'
                ],
                'AND' => [
                    'papers.is_top' => true,
                    'papers_cities.city' => $zfUser->getCity(),
                    'papers.active' => true,
                    'papers.is_draft' => false
                ]
            ]
        );

        $slider['news'] = ZFMedoo::get()->select(
            'news',
            [
                '[>]news_cities' => [
                    'id' => 'news_id'
                ],
                '[>]users' => [
                    'user_created' => 'id'
                ]
            ],
            [
                'news.id',
                'news.title',
                'news.description_short',
                'news.description',
                'news.cover',
                'news.cover_big',
                'news.cover_social',
                'news.alias',
                'news.type',
                'news.user_created',
                'news.date_publish',
                'news.date_created',
                'news.is_hot',
                'news.is_draft',
                'user' => [
                    'users.first_name',
                    'users.last_name',
                    'users.photo',
                    'users.photo_small'
                ]
            ],
            [
                'ORDER' => [
                    'news.date_publish' => 'DESC'
                ],
                'AND' => [
                    'news_cities.city' => $zfUser->getCity(),
                    'news.is_top' => true,
                    'news.active' => true,
                    'news.is_draft' => false
                ]
            ]
        );

        $paper = ZFMedoo::get()->select(
            'papers',
            [
                '[>]papers_cities' => [
                    'id' => 'paper_id'
                ],
                '[>]users' => [
                    'user_created' => 'id'
                ]
            ],
            [
                'papers.id',
                'papers.title',
                'papers.description_short',
                'papers.description',
                'papers.cover',
                'papers.cover_big',
                'papers.cover_social',
                'papers.alias',
                'papers.type',
                'papers.user_created',
                'papers.date_publish',
                'papers.date_created',
                'papers.is_hot',
                'papers.is_draft',
                'user' => [
                    'users.first_name',
                    'users.last_name',
                    'users.photo',
                    'users.photo_small'
                ]
            ],
            [
                'LIMIT' => 9,
                'ORDER' => [
                    'papers.date_publish' => 'DESC'
                ],
                'AND' => [
                    'papers_cities.city' => $zfUser->getCity(),
                    'papers.active' => true,
                    'papers.is_draft' => false,
                    'papers.is_top' => false
                ]
            ]
        );

        $news = ZFMedoo::get()->select(
            'news',
            [
                '[>]news_cities' => [
                    'id' => 'news_id'
                ],
                '[>]users' => [
                    'user_created' => 'id'
                ]
            ],
            [
                'news.id',
                'news.title',
                'news.description_short',
                'news.description',
                'news.cover',
                'news.cover_big',
                'news.cover_social',
                'news.alias',
                'news.type',
                'news.user_created',
                'news.date_publish',
                'news.date_created',
                'news.is_hot',
                'news.is_draft',
                'user' => [
                    'users.first_name',
                    'users.last_name',
                    'users.photo',
                    'users.photo_small'
                ]
            ],
            [
                'LIMIT' => 9,
                'ORDER' => [
                    'news.date_publish' => 'DESC'
                ],
                'AND' => [
                    'news_cities.city' => $zfUser->getCity(),
                    'news.is_top' => false,
                    'news.active' => true,
                    'news.is_draft' => false
                ]
            ]
        );

        if ($slider['paper'])
            foreach ($slider['paper'] as $index => $item){
                foreach ($paper_types as $type){
                    if ($type['id'] == $item['type']){
                        $slider['paper'][$index]['type_icon'] = $type['icon'];
                        $slider['paper'][$index]['type_name'] = $type['name'];
                        break;
                    }
                }
            }
        if ($slider['news'])
            foreach ($slider['news'] as $index => $item){
                foreach ($news_types as $type){
                    if ($type['id'] == $item['type']){
                        $slider['news'][$index]['type_icon'] = $type['icon'];
                        $slider['news'][$index]['type_name'] = $type['name'];
                        break;
                    }
                }
            }
        if ($paper)
            foreach ($paper as $index => $item){
                $paper[$index]['feed_type'] = 'paper';
                foreach ($paper_types as $type){
                    if ($type['id'] == $item['type']){
                        $paper[$index]['type_icon'] = $type['icon'];
                        $paper[$index]['type_name'] = $type['name'];
                        break;
                    }
                }
            }
        if ($news)
            foreach ($news as $index => $item){
                $news[$index]['feed_type'] = 'news';
                foreach ($news_types as $type){
                    if ($type['id'] == $item['type']){
                        $news[$index]['type_icon'] = $type['icon'];
                        $news[$index]['type_name'] = $type['name'];
                        break;
                    }
                }
            }

        $rankAll = \Zelfi\Modules\Rating\Rating::getRankAll($zfUser->getCity(), null, 0, 5);
        $rating_users = [];

        if ($rankAll){
            foreach ($rankAll as $index => $item){
                $user = ZFMedoo::get()->get(
                    'users',
                    [
                        'id',
                        'first_name',
                        'last_name',
                        'photo',
                        'photo_small',
                        'city'
                    ],[
                    'AND' => [
                        'id' => $item['user_id']
                    ]
                ]);

                if ($user){
                    $user['rating'] = $item;


                    $rating_users[] = $user;
                }
            }
        }

        $feed = array_merge($paper ? $paper : [], $news ? $news : []);

        usort($feed, function($a, $b) {
            $ad = new DateTime($a['date_publish']);
            $bd = new DateTime($b['date_publish']);

            if ($ad == $bd) {
                return 0;
            }

            return $ad < $bd ? 1 : -1;
        });

        $gallery = ZFMedoo::get()->get('galleries', '*', [
            'AND' => [
                'is_main' => true,
                'city' => [0, $zfUser->getCity()]
            ]
        ]);
        $gallery['event'] = ZFMedoo::get()->get(
            'events_galleries',
            [
                '[>]events' => [
                    'event_id' => 'id'
                ]
            ],
            [
                'events.id',
                'events.title'
            ],
            [
                'events_galleries.gallery_id' => $gallery['id']
            ]
        );
        $partners = ZFMedoo::get()->select('partners', '*', [
            'AND' => [
                'is_main' => true,
                'city' => [0, $zfUser->getCity()]
            ]
        ]);

        // отдать команды
//        $teams_all = PDO::get()->query('select * from teams')->fetchAll();
      //  $teams_all = PDO::get()->query('select * from teams where city='.$zfUser->getCity())->fetchAll();
$teams_all = PDO::get()->query('select * from teams where city='.$zfUser->getCity())->fetchAll();

        usort($teams_all, function($a, $b){
            if($a['point'] === $b['point'])
                return 0;
            return $a['point'] > $b['point'] ? -1 : 1;
        });

        $getmax = PDO::get()->query('select max(point) as maxpoint from teams where city='.$zfUser->getCity())->fetchAll();

        $teams = []; $count=0; $last=$getmax[0]['maxpoint'];

        $s4et = 1;
        foreach($teams_all as $k=>$team){
            $teams[$k]= $team;
            $captain = ZFMedoo::get()->get(
                'users', ['first_name', 'last_name'],
                [
                    'id' => $team['captain']
                ]);
            $teams[$k]['captain'] = $captain['first_name'].' '.$captain['last_name'];

            if ( $last == $team['point'] ){
                $last = $teams[$count]['point'];

                $teams[$k]['rank'] = $s4et;


            }else{
                $last = $team['point'];
                $s4et++;
                $teams[$k]['rank'] = $s4et;

            }

            $count++;
            if($count == 5)
                break;

        }





        // отдать команды

        $args['slider'] = $slider;
        $args['news'] = $news;
        $args['paper'] = $paper;
        $args['feed'] = $feed;
        $args['gallery'] = $gallery;
        $args['partners'] = $partners;
        $args['rating_users'] = $rating_users;

        $args['teams']= $teams;

        return $this->renderer->render($response, 'index.php', $args);
    });

    $app->get('/paper', function ($request, $response, $args) {
        /* @var \Zelfi\Model\ZFUser $zfUser */

        RendererHelper::get()
            ->addCurrentId(3)
            ->with($request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $types = \Zelfi\DB\ZFMedoo::get()->select('papers_types', '*', ['active'=>true]);
        $type_active = $request->getQueryParam('type');

        $args['types'] = $types;
        $args['type_active'] = $type_active;

        $where = [
            'ORDER' => [
                'papers.date_publish' => 'DESC'
            ],
            'AND' => [
                'papers_cities.city' => $zfUser->getCity(),
                'papers.active' => true,
                'papers.is_draft' => false
            ]
        ];
        if ($type_active){
            $where['AND']['papers.type'] = $type_active;
        }

        $where_hot = $where;
        $where_hot['AND']['papers.is_hot'] = true;

        $hot_paper = ZFMedoo::get()->get(
            'papers',
            [
                '[>]papers_cities' => [
                    'id' => 'paper_id'
                ],
                '[>]users' => [
                    'user_created' => 'id'
                ]
            ],
            [
                'papers.id',
                'papers.title',
                'papers.description_short',
                'papers.description',
                'papers.cover',
                'papers.cover_big',
                'papers.cover_social',
                'papers.alias',
                'papers.type',
                'papers.user_created',
                'papers.date_publish',
                'papers.date_created',
                'papers.is_hot',
                'papers.is_draft',
                'user' => [
                    'users.first_name',
                    'users.last_name',
                    'users.photo',
                    'users.photo_small'
                ]
            ],
            $where_hot
        );

        if ($hot_paper){
            $where['AND']['papers.id[!]'] = $hot_paper['id'];
        }

        $papers = ZFMedoo::get()->select(
            'papers',
            [
                '[>]papers_cities' => [
                    'id' => 'paper_id'
                ],
                '[>]users' => [
                    'user_created' => 'id'
                ]
            ],
            [
                'papers.id',
                'papers.title',
                'papers.description_short',
                'papers.description',
                'papers.cover',
                'papers.cover_big',
                'papers.cover_social',
                'papers.alias',
                'papers.type',
                'papers.user_created',
                'papers.date_publish',
                'papers.date_created',
                'papers.is_hot',
                'papers.is_draft',
                'user' => [
                    'users.first_name',
                    'users.last_name',
                    'users.photo',
                    'users.photo_small'
                ]
            ],
            $where
        );

        foreach ($papers as $index => $item){
            foreach ($types as $type){
                if ($type['id'] == $item['type']){
                    $papers[$index]['type_icon'] = $type['icon'];
                    $papers[$index]['type_name'] = $type['name'];
                    break;
                }
            }
        }
        foreach ($types as $type){
            if ($type['id'] == $hot_paper['type']){
                $hot_paper['type_name'] = $type['name'];
                break;
            }
        }

        $args['papers'] = $papers;
        $args['hot_paper'] = $hot_paper;

        return $this->renderer->render($response, 'paper/paper.php', $args);
    });

    $app->get('/paper/{id}', function ($request, $response, $args) {
        /* @var \Zelfi\Model\ZFUser $zfUser */

        RendererHelper::get()
            ->addCurrentId(3)
            ->addPartMeta([
                'paper-single'
            ])
            ->addFooterData([
                'paper-single'
            ])
            ->with($request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        if ($id){
            $types = ZFMedoo::get()->select('papers_types', '*', ['active'=>true]);

            $paper = ZFMedoo::get()->get(
                'papers',
                [
                    '[>]papers_cities' => [
                        'id' => 'paper_id'
                    ],
                    '[>]users' => [
                        'user_created' => 'id'
                    ]
                ],
                [
                    'papers.id',
                    'papers.title',
                    'papers.description_short',
                    'papers.description',
                    'papers.cover',
                    'papers.cover_big',
                    'papers.cover_social',
                    'papers.alias',
                    'papers.type',
                    'papers.user_created',
                    'papers.date_publish',
                    'papers.date_created',
                    'papers.is_hot',
                    'papers.is_draft',
                    'user' => [
                        'users.first_name',
                        'users.last_name',
                        'users.photo',
                        'users.photo_small'
                    ]
                ],
                [
                    'papers.id' => $id
                ]
            );

            if ($paper){
                foreach ($types as $type){
                    if ($type['id'] == $paper['type']){
                        $paper['type_name'] = $type['name'];
                        break;
                    }
                }

                $args['paper'] = $paper;

                if ($paper){
                    return $this->renderer->render($response, 'paper/single.php', $args);
                } else {
                    throw new \Slim\Exception\NotFoundException($request, $response);
                }
            }
        }

        throw new \Slim\Exception\NotFoundException($request, $response);
    });

    $app->get('/events', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        /* @var \Zelfi\Model\ZFUser $zfUser */

        RendererHelper::get()
            ->addCurrentId(2)
            ->addFooterScripts([
                'events'
            ])
            ->addFooterData([
                'events'
            ])
            ->with($request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $placesCity = ZFMedoo::get()->select('places', 'id', [
            'city' => $zfUser->getCity()
        ]);

        $category_active = ($request->getQueryParam('category') ? $request->getQueryParam('category') : 1);
        $type_active = $request->getQueryParam('type');

        $categories = \Zelfi\DB\ZFMedoo::get()->select('events_categories', '*', ['active'=>true]);
        $types = \Zelfi\DB\ZFMedoo::get()->select('events_types', '*', ['active'=>true]);
        $gallery = ZFMedoo::get()->get('galleries', '*', [
            'AND' => [
                'is_main' => true,
                'city' => [0, $zfUser->getCity()]
            ]
        ]);

        $args['categories'] = $categories;
        $args['types'] = $types;
        $args['category_active'] = $category_active;
        $args['gallery'] = $gallery;

        $args['type_active'] = $type_active;

        $where = [
            'ORDER' => [
                'events.date_start' => 'DESC'
            ],
            'GROUP' => 'events.id',
            'AND' => [
                'events.category' => $category_active,
                'events_places.place_id' => $placesCity,
                'events.active' => true
            ]
        ];

        if ($type_active){
            $where['AND']['events.type'] = $type_active;
        }

        $where_now = $where;
        $where_now['AND']['events.date_end[>=]'] = date('Y-m-d H:i:s');

        $where_recent = $where;
        $where_recent['AND']['events.date_end[<]'] = date('Y-m-d H:i:s');

        $events_now = ZFMedoo::get()->select(
            'events',
            [
                '[>]events_places' => [
                    'id' => 'event_id'
                ]
            ],
            [
                'events.id',
                'events.title',
                'events.description_short',
                'events.description',
                'events.date_start',
                'events.date_end',
                'events.cover',
                'events.cover_big',
                'events.cover_social',
                'events.balls',
                'events.category',
                'events.type',
                'events.date_created',
                'events.user_created',
                'events.active'
            ],
            $where_now
        );

        $events_recent = ZFMedoo::get()->select(
            'events',
            [
                '[>]events_places' => [
                    'id' => 'event_id'
                ]
            ],
            [
                'events.id',
                'events.title',
                'events.description_short',
                'events.description',
                'events.date_start',
                'events.date_end',
                'events.cover',
                'events.cover_big',
                'events.cover_social',
                'events.balls',
                'events.category',
                'events.type',
                'events.date_created',
                'events.user_created',
                'events.active'
            ],
            $where_recent
        );

        foreach ($events_now as $index => $item){
            $events_now[$index]['places'] = ZFMedoo::get()->select(
                'events_places',
                [
                    '[>]places' => ['place_id' => 'id']
                ],
                [
                    'places.id',
                    'places.name',
                    'places.description_short',
                    'places.city'
                ],
                [
                    'AND' => [
                        'events_places.event_id' => $item['id'],
                        'places.city' => $zfUser->getCity()
                    ]
                ]
            );
            foreach ($types as $type){
                if ($type['id'] == $item['type']){
                    $events_now[$index]['type_icon'] = $type['icon'];
                    $events_now[$index]['type_name'] = $type['name'];
                    break;
                }
            }
        }

        foreach ($events_recent as $index => $item){
            $events_recent[$index]['places'] = ZFMedoo::get()->select(
                'events_places',
                [
                    '[>]places' => ['place_id' => 'id']
                ],
                [
                    'places.id',
                    'places.name',
                    'places.description_short',
                    'places.city'
                ],
                [
                    'AND' => [
                        'events_places.event_id' => $item['id'],
                        'places.city' => $zfUser->getCity()
                    ]
                ]
            );
            foreach ($types as $type){
                if ($type['id'] == $item['type']){
                    $events_recent[$index]['type_icon'] = $type['icon'];
                    $events_recent[$index]['type_name'] = $type['name'];
                    break;
                }
            }
        }

        $args['events_now'] = $events_now;
        $args['events_recent'] = $events_recent;

        return $this->renderer->render($response, 'events.php', $args);
    });

    $app->get('/events/{id}', function (\Slim\Http\Request $request, $response, $args) {
        /* @var \Zelfi\Model\ZFUser $zfUser
         * @var \Zelfi\Model\ZFCities $zfCities
         */

        $rendererHelper = RendererHelper::get()
            ->addFooterScripts(['event'])
            ->addBodyClasses(['event-single'])
            ->addPartMeta([
                'event-single'
            ])
            ->addFooterData([
                'event'
            ])
            ->build($request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];
        $zfCities = $args[HelperAttributes::APPCITIES];

        $id = $args['id'];
        $status = $request->getQueryParam('status');

        if ($status == 'success') {
            $rendererHelper = $rendererHelper->addModalMessage(Strings::event_subscribe_success);
        }
        else if ($status == 'fail') {
            $rendererHelper = $rendererHelper->addModalMessage(Strings::event_subscribe_fail);
        }

        if ($id){
            $types = \Zelfi\DB\ZFMedoo::get()->select('events_types', '*', ['active'=>true]);

            $event = ZFMedoo::get()->get(
                'events',
                [
                    '[>]events_places' => [
                        'id' => 'event_id'
                    ]
                ],
                [
                    'events.id',
                    'events.title',
                    'events.description_short',
                    'events.description',
                    'events.date_start',
                    'events.date_end',
                    'events.cover',
                    'events.cover_big',
                    'events.cover_social',
                    'events.balls',
                    'events.city',
                    'events.subscribe',
                    'events.category',
                    'events.type',
                    'events.date_created',
                    'events.user_created',
                    'events.active'
                ],
                [
                    'events.id' => $id
                ]
            );

            if ($event){
                if ($event['city'] != $zfUser->getCity()) return $response->withRedirect('/'.$zfCities->getCityById($event['city'])['alias'].'/events/'.$id);

                $event['gallery'] = ZFMedoo::get()->get('galleries', '*', [
                    'id' => ZFMedoo::get()->get('events_galleries', 'gallery_id', ['event_id'=>$id])
                ]);

                $event['places'] = ZFMedoo::get()->select(
                    'events_places',
                    [
                        '[>]places' => ['place_id' => 'id']
                    ],
                    [
                        'places.id',
                        'places.name',
                        'places.description_short',
                        'places.city',
                        'places.cover'
                    ],
                    [
                        'AND' => [
                            'events_places.event_id' => $id,
                            'places.city' => $zfUser->getCity()
                        ]
                    ]
                );
                $event['isSubscribed'] = ZFMedoo::get()->has('events_members', [
                    'AND' => [
                        'user_id' => $zfUser->getInfoItem('id'),
                        'event_id' => $event['id']
                    ]
                ]);
                foreach ($types as $type){
                    if ($type['id'] == $event['type']){
                        $event['type_icon'] = $type['icon'];
                        $event['type_name'] = $type['name'];
                        break;
                    }
                }

                $args['event'] = $event;

                $rendererHelper->with($request, $args);

                if ($event){
                    return $this->renderer->render($response, 'event.php', $args);
                } else {
                    throw new \Slim\Exception\NotFoundException($request, $response);
                }
            }
        }

        throw new \Slim\Exception\NotFoundException($request, $response);
    });

    $app->get('/news', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        /* @var \Zelfi\Model\ZFUser $zfUser */

        RendererHelper::get()
            ->addCurrentId(4)
            ->with($request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $types = \Zelfi\DB\ZFMedoo::get()->select('news_types', '*', ['active'=>true]);
        $type_active = $request->getQueryParam('type');

        $args['types'] = $types;
        $args['type_active'] = $type_active;

        $where = [
            'ORDER' => [
                'news.date_publish' => 'DESC'
            ],
            'AND' => [
                'news_cities.city' => $zfUser->getCity(),
                'news.active' => true,
                'news.is_draft' => false
            ]
        ];
        if ($type_active){
            $where['AND']['news.type'] = $type_active;
        }

        $where_hot = $where;
        $where_hot['AND']['is_hot'] = true;

        $hot_news = ZFMedoo::get()->get(
            'news',
            [
                '[>]news_cities' => [
                    'id' => 'news_id'
                ],
                '[>]users' => [
                    'user_created' => 'id'
                ]
            ],
            [
                'news.id',
                'news.title',
                'news.description_short',
                'news.description',
                'news.cover',
                'news.cover_big',
                'news.cover_social',
                'news.alias',
                'news.type',
                'news.user_created',
                'news.date_publish',
                'news.date_created',
                'news.is_hot',
                'news.is_draft',
                'user' => [
                    'users.first_name',
                    'users.last_name',
                    'users.photo',
                    'users.photo_small'
                ]
            ],
            $where_hot
        );

        if ($hot_news){
            $where['AND']['news.id[!]'] = $hot_news['id'];
        }

        $news = ZFMedoo::get()->select(
            'news',
            [
                '[>]news_cities' => [
                    'id' => 'news_id'
                ],
                '[>]users' => [
                    'user_created' => 'id'
                ]
            ],
            [
                'news.id',
                'news.title',
                'news.description_short',
                'news.description',
                'news.cover',
                'news.cover_big',
                'news.cover_social',
                'news.alias',
                'news.type',
                'news.user_created',
                'news.date_publish',
                'news.date_created',
                'news.is_hot',
                'news.is_draft',
                'user' => [
                    'users.first_name',
                    'users.last_name',
                    'users.photo',
                    'users.photo_small'
                ]
            ],
            $where
        );

        foreach ($news as $index => $item){
            foreach ($types as $type){
                if ($type['id'] == $item['type']){
                    $news[$index]['type_icon'] = $type['icon'];
                    $news[$index]['type_name'] = $type['name'];
                    break;
                }
            }
        }
        foreach ($types as $type){
            if ($type['id'] == $hot_news['type']){
                $hot_news['type_name'] = $type['name'];
                break;
            }
        }

        $args['news'] = $news;
        $args['hot_news'] = $hot_news;

        return $this->renderer->render($response, 'news.php', $args);
    });

    $app->get('/news/{id}', function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        /* @var \Zelfi\Model\ZFUser $zfUser */

        RendererHelper::get()
            ->addCurrentId(4)
            ->addPartMeta([
                'news-single'
            ])
            ->addFooterData([
                'news-single'
            ])
            ->with($request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $types = \Zelfi\DB\ZFMedoo::get()->select('news_types', '*', ['active'=>true]);
        $type_active = $request->getQueryParam('type');

        $args['types'] = $types;
        $args['type_active'] = $type_active;

        $id = $args['id'];

        if ($id){
            $types = \Zelfi\DB\ZFMedoo::get()->select('news_types', '*', ['active'=>true]);


            $news_item = ZFMedoo::get()->get('news',
                [
                    '[>]news_cities' => [
                        'id' => 'news_id'
                    ],
                    '[>]users' => [
                        'user_created' => 'id'
                    ]
                ],
                [
                    'news.id',
                    'news.title',
                    'news.description_short',
                    'news.description',
                    'news.cover',
                    'news.cover_big',
                    'news.cover_social',
                    'news.alias',
                    'news.type',
                    'news.user_created',
                    'news.date_publish',
                    'news.date_created',
                    'news.is_hot',
                    'news.is_draft',
                    'user' => [
                        'users.first_name',
                        'users.last_name',
                        'users.photo',
                        'users.photo_small'
                    ]
                ], [
                    'news.id' => $id
                ]);

            if ($news_item){
                foreach ($types as $type){
                    if ($type['id'] == $news_item['type']){
                        $news_item['type_name'] = $type['name'];
                        break;
                    }
                }

                $args['news_item'] = $news_item;


                if ($news_item){
                    return $this->renderer->render($response, 'news/single.php', $args);
                } else {
                    throw new \Slim\Exception\NotFoundException($request, $response);
                }
            }
        }

        throw new \Slim\Exception\NotFoundException($request, $response);
    });

    $app->get('/rating', function (\Slim\Http\Request$request, $response, $args) {
        /* @var \Zelfi\Model\ZFUser $zfUser */

        RendererHelper::get()
            ->addFooterData([
                'rating'
            ])
            ->with($request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];
        $page = $request->getQueryParam('page') ? $request->getQueryParam('page') : 1;
        $itemsOnly = $request->getQueryParam('items_only') ? $request->getQueryParam('items_only') : false;
        $count = 10;

        //Search     


        $hiden_team_id = trim(strip_tags($request->getQueryParam('hiden_team_id')));
        $hiden_user_id = trim(strip_tags($request->getQueryParam('hiden_user_id')));



        if($hiden_user_id || $hiden_team_id){
            //search user


            $is_search_user = ZFMedoo::get()->select('users', ['first_name','last_name','id','photo'], [

                'id' => $hiden_user_id

            ]);
            if($is_search_user){
                $get_ball = ZFMedoo::get()->select(
                    'balls_users', 'balls', [
                        'user_id' => $is_search_user[0]['id']
                    ]
                );

                $GetBallUserSeason = \Zelfi\Modules\Rating\Rating::getBallsSeason($is_search_user[0]['id'], null);
                $is_search_user['balls'] = $GetBallUserSeason['balls'];


                $get_team =  ZFMedoo::get()->get('teams_users', '*', [ 'AND'=> [
                    'user_id' => $is_search_user[0]['id'],
                    'team_alert' => 0,

                ] ]);

                $find_team_fo_user = ZFMedoo::get()->get('teams', '*', [
                    'id' => $get_team['team_id']

                ]);
                $is_search_user['is_team_name'] = $find_team_fo_user['name'];
                $is_search_user['is_team_point'] = $find_team_fo_user['point'];




            }
            //end search user
            if($hiden_team_id) {
                //search team

                $is_search_team = [];
                // 1 Найти команду по имени [name/point/captain]
                $get_name_team = PDO::get()->query('select name, point, captain, photo from teams where id='.$hiden_team_id)->fetchAll();

                $is_search_team['name'] = $get_name_team[0]['name'];
                $is_search_team['point'] = $get_name_team[0]['point'];
                $is_search_team['photo'] = $get_name_team[0]['photo'];

                // 2. Найти капитана команды [firs_name, last_name, balls]
                $get_captain_team = PDO::get()->query('select first_name, last_name from users where id=' . $get_name_team[0]['captain'])->fetchAll();

                $is_search_team['captain'] = $get_captain_team[0]['first_name'] . ' ' . $get_captain_team[0]['last_name'];

                $GetBallCaptainSeason = \Zelfi\Modules\Rating\Rating::getBallsSeason($get_name_team[0]['captain'], null);
                $is_search_team['captain_balls'] = $GetBallCaptainSeason['balls'];
//            var_dump($is_search_team);
//            exit();
                //end search team
            }
        }

        //Search

        $rankAll = \Zelfi\Modules\Rating\Rating::getRankAll($zfUser->getCity(), null, ($page-1)*$count, $count);

//        $rankAllTeams = \Zelfi\Modules\Rating\Rating::getRankAllTeam($zfUser->getCity(), null, ($page-1)*$count, $count);
        $users = [];

//        var_dump($rankAllTeams);
//        exit();

        foreach ($rankAll as $index => $item){
            $user = ZFMedoo::get()->get(
                'users',
                [
                    'id',
                    'first_name',
                    'last_name',
                    'photo',
                    'photo_small',
                    'city'
                ],[
                'AND' => [
                    'id' => $item['user_id']
                ]
            ]);
                $user['rating'] = $item;
                $user['team'] = $item['team'];

                if($item['team']) {
                    $user['team'] = $item['team'];
                }else{
                    $user['team'] = "Без команды";
                }
                $users[] = $user;

        }

// Ретинг команд start
   //  $teams_all = PDO::get()->query('select * from teams where city='.$zfUser->getCity().' ORDER BY point DESC '.' LIMIT '.($page-1)*$count.', '.$count)->fetchAll();

       $teams_all = PDO::get()->query('select * from teams where city='.$zfUser->getCity().'  LIMIT 0,'.($page)*$count)->fetchAll();
        usort($teams_all, function($a, $b){
            if($a['point'] === $b['point'])
                return 0;
            return $a['point'] > $b['point'] ? -1 : 1;
        });

        $getmax = PDO::get()->query('select max(point) as maxpoint from teams where city='.$zfUser->getCity())->fetchAll();

        $teams = []; $count=0; $last=$getmax[0]['maxpoint'];

		$s4et = 1;
        foreach($teams_all as $k=>$team){
            $teams[$k]= $team;
            $captain = ZFMedoo::get()->get(
                'users', ['first_name', 'last_name'],
                [
                    'id' => $team['captain']
                ]);
            $teams[$k]['captain'] = $captain['first_name'].' '.$captain['last_name'];

            if ( $last == $team['point'] ){
                $last = $teams[$count]['point'];
				
				$teams[$k]['rank'] = $s4et;
				
              
            }else{
                $last = $team['point'];
                $s4et++;
                $teams[$k]['rank'] = $s4et;
				
            }

            $count++;

        }



//        if(!$_COOKIE['test32']){
//
        $users_autocomplete =  ZFMedoo::get()->select('users', ['id','first_name', 'last_name'], ['AND'=>['active'=>1]]);
        $teams_autocomplete = ZFMedoo::get()->select('teams', ['name','id']);
//        setcookie("test32", $val, time()+300);



        $args['users'] = $users;
        $args['page'] = $page;
        $args['count'] = $count;
        $args['teams']= $teams;
        $args['team_rank']= $team_rank;
        $args['is_search_user']= $is_search_user;
        $args['is_search_team']= $is_search_team;



//var_dump($is_search_team);
//        exit();

        $args['users_autocomplete']= $users_autocomplete;
        $args['teams_autocomplete']= $teams_autocomplete;

        if ($itemsOnly) return $this->renderer->render($response, 'rating/rating-items.php', $args);
        else return $this->renderer->render($response, 'rating/rating.php', $args);
    });

    $app->group('/partners', function () use ($app) {
        $controller = new \Zelfi\Controllers\PartnersController($app);

        $app->get('', $controller('get_partners'));
    });

    $app->group('/store', function () use ($app) {
        $controller = new \Zelfi\Controllers\StoreController($app);

        $app->get('', $controller('get_store'));
    });

    $app->group('/team', function () use ($app) {
        $controller = new \Zelfi\Controllers\TeamController($app);

        $app->get('', $controller('get_team'));
        $app->post('/create', $controller('createTeam'));
        $app->post('/addPhoto', $controller('addPhoto'));
    });

    $app->group('/about', function () use ($app) {
        $controller = new \Zelfi\Controllers\AboutController($app);
    
        
        $app->get('', $controller('get_blog'));
        $app->get('/history', $controller('get_history'));
        $app->get('/blog', $controller('get_blog'));
        $app->get('/smi', $controller('get_smi'));
    });
});