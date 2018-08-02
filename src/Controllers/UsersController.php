<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MartynBiz\Slim3Controller\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use Requests;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Modules\Mail\Mail;
use Zelfi\DB\ZFMedoo;
use Zelfi\DB\PDO;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Modules\Subscription\Subscription;
use Zelfi\Modules\Upload\Upload;
use Zelfi\Utils\AppUtils;
use Zelfi\Utils\Cookies;
use Zelfi\Utils\RendererHelper;

class UsersController extends Controller
{
    public function getJSON()
    {
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

//        $users = ZFMedoo::get()->select('users', [
//                'first_name', 'last_name']
//        );
        echo json_encode('hello');
    }

    public function get_me()
    {
        $args = RendererHelper::get()
            ->addCurrentId(9)
            ->addFooterData([
                'users_me'
            ])
            ->addFooterScripts([
                'jquery-ui',
                'users_me',
                //'autocomplete'
            ])
            ->with($this->request);

        /* @var \Zelfi\Model\ZFUser $zfUser */
        $zfUser = $args[HelperAttributes::APPUSER];

        if ($zfUser->getRole() < 6) { // не гость
            $balls_all = Rating::getAllBalls($zfUser->getInfoItem('id'));
            $balls_seasons = Rating::getBallsSeasons($zfUser->getInfoItem('id'));
            $balls_season = Rating::getBallsSeason($zfUser->getInfoItem('id'));
            $rank = Rating::getRank($zfUser->getInfoItem('id'), $zfUser->getResidence());
            $seasons = \Zelfi\Modules\Seasons\Seasons::getAll();

            $events_now = ZFMedoo::get()->select(
                'events',
                [
                    'events.id',
                    'events.title',
                    'events.description_short',
                    'events.description',
                    'events.date_start',
                    'events.date_end',
                    'events.cover',
                    'events.cover_big',
                    'events.balls',
                    'events.category',
                    'events.type',
                    'events.date_created',
                    'events.user_created',
                    'events.active'
                ],
                [
                    'ORDER' => [
                        'events.date_start' => 'DESC'
                    ],
                    'AND' => [
                        'events.id' => ZFMedoo::get()->select('events_members', 'event_id', [
                            'AND' => [
                                'active' => true,
                                'user_id' => $zfUser->getInfoItem('id'),
                                'event_id' => ZFMedoo::get()->select('events', 'id', [
                                    'events.date_end[>=]' => date('Y-m-d H:i:s')
                                ])
                            ]
                        ])
                    ]
                ]
            );

            $events_recent = ZFMedoo::get()->select(
                'events',
                [
                    'events.id',
                    'events.title',
                    'events.description_short',
                    'events.description',
                    'events.date_start',
                    'events.date_end',
                    'events.cover',
                    'events.cover_big',
                    'events.balls',
                    'events.category',
                    'events.type',
                    'events.date_created',
                    'events.user_created',
                    'events.active'
                ],
                [
                    'ORDER' => [
                        'events.date_start' => 'DESC'
                    ],
                    'AND' => [
                        'events.id' => ZFMedoo::get()->select('events_members', 'event_id', [
                            'AND' => [
                                'active' => true,
                                'user_id' => $zfUser->getInfoItem('id'),
                                'event_id' => ZFMedoo::get()->select('events', 'id', [
                                    'events.date_end[<]' => date('Y-m-d H:i:s')
                                ])
                            ]
                        ])
                    ]
                ]
            );

            $balls_history = ZFMedoo::get()->select('balls_history',
                [
                    '[>]balls_type' => ['type' => 'id']
                ],
                [
                    'balls_history.balls',
                    'balls_history.description',
                    'balls_history.type',
                    'balls_history.season',
                    'balls_history.date_created',
                    'balls_type.name(type_name)'
                ],
                [
                    'ORDER' => [
                        'balls_history.date_created' => 'DESC'
                    ],
                    'AND' => [
                        'user_id' => $zfUser->getInfoItem('id'),
                        'season' => \Zelfi\Modules\Seasons\Seasons::getCurrentSeason(),
                        'is_service' => false
                    ]
                ]);
            foreach ($seasons as $index => $season) {
                foreach ($balls_seasons as $balls_season) {
                    if ($balls_season['season'] == $season['id']) {
                        $seasons[$index]['user_balls'] = $balls_season['balls'];
                        break;
                    }
                }
            }

            $balls_users_video_may_upload = !ZFMedoo::get()->has('balls_users_video', [
                'AND' => [
                    'user_id' => $zfUser->getId(),
                    'active' => true,
                    'date_created[>=]' => date('Y-m-d 00:00:00'),
                    'date_created[<=]' => date('Y-m-d 23:59:59')
                ]
            ]);
            $balls_users_video_not_approved = ZFMedoo::get()->select('balls_users_video', '*', [
                'AND' => [
                    'user_id' => $zfUser->getId(),
                    'approved' => false,
                    'active' => true
                ]
            ]);
            $team = ZFMedoo::get()->get('teams', [
                '[><]teams_users' => ['id' => 'team_id'],
            ], '*', [
                'teams_users.user_id' => $zfUser->getId()
            ]);
            if ($team) {
                if ($team['photo']) {
                    $team_photo = $team['photo'];
                }
                $crew = ZFMedoo::get()->select('teams', [
                    '[><]teams_users' => ['id' => 'team_id'],
                    '[><]users' => ['teams_users.user_id' => 'id']], '*', [
                    'teams_users.team_id' => $team['team_id'],
                ]);
                $teams_points = PDO::get()->query('SELECT team_id, sum(points) as sum from teams_points group by team_id order by sum desc ')->fetchAll();




                $all_points = [];
                $found = false;
                foreach ($teams_points as $key => $row) {
                    if (!in_array($row['sum'], $all_points)) {
                        $all_points[] = $row['sum'];
                    }
                    if ($row['team_id'] == $team['team_id']) {
                        $found = true;
                        break;
                    }
                }
                if ($found) {
                    $team_rank = count($all_points);
                    $team_total = $all_points[$team_rank - 1];
                } else {
                    $team_rank = count($all_points) + 1;
                    $team_total = 0;
                }
            }

            $store_orders_active = ZFMedoo::get()->select('store_orders', '*', [
                'ORDER' => [
                    'date_created' => 'DESC'
                ],
                'AND' => [
                    'user_id' => $zfUser->getId(),
                    'active' => true,
                    'finished' => false
                ]
            ]);
            if ($store_orders_active) foreach ($store_orders_active as $index => $item) {
                $store_orders_active[$index]['store_item'] = ZFMedoo::get()->get('store', '*', [
                    'id' => $item['item_id']
                ]);
                $store_orders_active[$index]['price_print'] = $item['currency'] == 1 ?
                    AppUtils::plural_form(($store_orders_active[$index]['store_item']['balls'] * $item['count']), ['зелфи', 'зелфи', 'зелфи'])
                    :
                    AppUtils::plural_form(($store_orders_active[$index]['store_item']['price'] * $item['count']), ['рубль', 'рубля', 'рублей']);
            }

            $team_alert_id = ZFMedoo::get()->select('teams_users', 'team_alert', [
                'user_id' => $zfUser->getId()
            ], [
                'AND' => [
                    'team_alert' => $zfUser->getId(),

                ]
            ]);
            //
            $team['city'];
            $team_city = ZFMedoo::get()->get('cities', 'name', [
                'id' => $team['city']
            ]);
            //
            for($i=0; $i<count($team_alert_id); $i++){
                $get_teams =  ZFMedoo::get()->get('teams', '*', [
                    'id' => $team_alert_id[$i]['team_alert']
                ]);
                $teams_alert[]=$get_teams;
            }

            $users_autocomplete =  ZFMedoo::get()->select('users', ['id','first_name', 'last_name'], ['AND'=>['active'=>1]]);

            $args['cities'] = ZFMedoo::get()->select('cities', ['id','name'], ['AND'=>['active'=>1]]);
            $args['zfUser'] = $zfUser;
            $args['balls_all'] = $balls_all;
            $args['balls_season'] = $balls_season;
            $args['balls_seasons'] = $balls_seasons;
            $args['seasons'] = $seasons;
            $args['rank'] = $rank;
            $args['balls_history'] = $balls_history;
            $args['events_now'] = $events_now;
            $args['events_recent'] = $events_recent;
            $args['balls_users_video_may_upload'] = $balls_users_video_may_upload;
            $args['balls_users_video_not_approved'] = $balls_users_video_not_approved;
            $args['team'] = $team;
            $args['team_photo'] = $team_photo;
            $args['crew'] = $crew;
            $args['team_rank'] = $team_rank;
            $args['team_total'] = $team_total;
            $args['store_orders_active'] = $store_orders_active;
            $args['teams_alert'] = $teams_alert;
            $args['users_autocomplete'] = $users_autocomplete;
            //$team_city
            $args['team_city'] = $team_city;

//var_dump($teams_alert);
//            exit();


            return $this->render('users_me.php', $args);
        }

        throw new \Slim\Exception\NotFoundException($this->request, $this->response);
    }


    public function get_me_settings()
    {
        $args = RendererHelper::get()
            ->addCurrentId(9)
            ->addFooterData([
                'users_me_settings'
            ])
            ->with($this->request);

        /* @var \Zelfi\Model\ZFUser $zfUser */
        $zfUser = $args[HelperAttributes::APPUSER];

        if ($zfUser->getRole() < 6) {
            $subscription = new Subscription($zfUser->getId());

            $args['subscription'] = $subscription->getSubscriptionInfo();

            return $this->render('users/users_me_settings.php', $args);
        }

        throw new \Slim\Exception\NotFoundException($this->request, $this->response);
    }

    public function post_update_cover()
    {
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $files = Upload::uploadUserCover($zfUser->getInfo()['id'], 'cover');

        if ($files && $zfUser->getInfo()['id']) {
            ZFMedoo::get()->update('users', [
                'photo' => $files['normal'],
                'photo_small' => $files['small']
            ], [
                'id' => $zfUser->getInfo()['id']
            ]);
        }

        return $this->response;
    }

    function post_settings_info()
    {
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $first_name = $this->getPost()['first_name'];
        $last_name = $this->getPost()['last_name'];
        $email = $this->getPost()['email'];
        $phone = $this->getPost()['phone'];

        $values = [];

        if ($first_name && strlen($first_name) > 0) {
            $values['first_name'] = $first_name;
        }

        if ($last_name && strlen($last_name) > 0) {
            $values['last_name'] = $last_name;
        }

        if ($email && strlen($email) > 0) {
            if (ZFMedoo::get()->has('users', [
                'AND' => [
                    'email' => $email,
                    'id[!]' => $zfUser->getId()
                ]
            ])
            ) return $this->redirect('/users/me/settings?modal-message=Данный email уже привязан к другой учетной записи');

            $values['email'] = $email;
        }

        if ($phone && strlen($phone) > 0) {
            if (ZFMedoo::get()->has('users', [
                'AND' => [
                    'phone' => $phone,
                    'id[!]' => $zfUser->getId()
                ]
            ])
            ) return $this->redirect('/users/me/settings?modal-message=Данный номер телефона уже привязан к другой учетной записи');

            $values['phone'] = $phone;
        }

        if (count($values) > 0) {
            ZFMedoo::get()->update('users', $values, [
                'id' => $zfUser->getId()
            ]);

            return $this->redirect('/users/me/settings?modal-message=Информация успешно обновлена');
        }


        return $this->redirect('/users/me/settings?modal-message=Ошибка при сохранении');
    }

    function post_settings_password()
    {
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $password = $this->getPost()['password'];
        $password_check = $this->getPost()['password_check'];

        $passwordCheckErrors = SimpleAuth::checkPassword($password);

        if ($password == $password_check) {
            if ($passwordCheckErrors) return $this->redirect('/users/me/settings?modal-message=' . $passwordCheckErrors);

            ZFMedoo::get()->update('users', [
                'password' => md5($password)
            ], [
                'id' => $zfUser->getId()
            ]);

            return $this->redirect('/users/me/settings?modal-message=Пароль успешно изменен');
        } else return $this->redirect('/users/me/settings?modal-message=Пароли не совпадают');

        return $this->redirect('/users/me/settings');
    }

    function post_settings_subscribe()
    {
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $agree_subscription = $this->getPost()['agree_subscription'];

        $subscription = new Subscription($zfUser->getId());
        $subscription->setSubscribe(!is_null($agree_subscription));

        return $this->redirect('/users/me/settings?modal-message=Информация успешно обновлена');
    }

    function post_balls_videos_new()
    {
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $title = $this->getPost()['title'];
        $url = $this->getPost()['url'];

        if ($title && $url) {
            $id = ZFMedoo::get()->insert('balls_users_video', [
                'name' => $title,
                'url' => $url,
                'user_id' => $zfUser->getId(),
                'active' => true
            ]);

            if ($id) return $this->redirect('/users/me?modal-message=Ваше видео будет проверено в ближайшее время. При соответствии всем условиям, Вам будут начислены дополнительные баллы рейтинга');
        }

        return $this->redirect('/users/me?modal-message=Ошибка при добавлении видео. Пожалуйста, повторите попытку');
    }

    function post_balls_videos_remove()
    {
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['user_video_id'];

        if ($id) {
            ZFMedoo::get()->update('balls_users_video', [
                'active' => false
            ], [
                'AND' => [
                    'id' => $id,
                    'user_id' => $zfUser->getId()
                ]
            ]);
        }

        return $this->redirect('/users/me?modal-message=Запрос на подтверждение видео успешно отменен');
    }

    function change_capitan_team()
    {

        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $id = $args['id'] * 1;

//        echo $zfUser->getTeamId();
//        exit();

        if ($zfUser && $id) {
            ZFMedoo::get()->update('teams', [
                'captain' => $id,
                //'photo_small' => $files['small']
            ], [
                'id' => $zfUser->getTeamId()
            ]);
        }


//        echo $id;
//        echo $zfUser->getId();
        return $this->redirect('/users/me?modal-message=Капитан успешно сменен');
    }

    function out_from_team()
    {

        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $id = $args['id'] * 1;


        if ($zfUser && $id) {

            $capitan_id = ZFMedoo::get()->get('teams', [
                'captain'
                //'photo_small' => $files['small']
            ], [
                'id' => $zfUser->getTeamId()
            ]);



            if ($capitan_id['captain'] != $zfUser->getId()) { //усли это не капитан то выход
                    ZFMedoo::get()->delete('teams_users',
                    ['AND' => [
                        'user_id' => $zfUser->getId(),
                        'team_id' => $zfUser->getTeamId()]]

                );
                $msg = 'Выход успешно выполнен';
                 }else{  //усли это капитан то
                    ZFMedoo::get()->delete('teams_users',

                        [
                            'user_id' => $id
                        ],
                        ['AND' => ['team_id' => $zfUser->getTeamId()]]

                    );
                $msg = 'Удаление прошло успешно';
            }


//        echo $zfUser->getId();
            return $this->redirect('/users/me?modal-message='.$msg);
        }
    }
    function add_member_toteam()
    {

        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $teamId = $zfUser->getTeamId();




        for ($i=1; $i<=4; $i++) {
            $teammate = 'teammember'.$i;
            $teammate_mail = 'teammate_mail'.$i;
            $user_mail = trim(strip_tags($this->getPost()[$teammate_mail]));
//хук - прооптимезировать !
             $id_user_from_ac = trim(strip_tags($this->getPost()[$teammate]));


            $name_lastname = ZFMedoo::get()->select('users', ['first_name', 'last_name'], [
                'id' => $id_user_from_ac
                ]
            );

            //хук - прооптимезировать !

            // Сообщение письма, если указан email
//            var_dump($this->getPost()[$teammate]);
//            exit();
            if($user_mail) {
                Mail::sendAddMemmberToTeam($user_mail);
            }
            // Сообщение письма, если указан email

            $users2 = $name_lastname[0]['first_name'].' '.$name_lastname[0]['last_name'];
//            $this->getPost()[$teammate] = trim(strip_tags($this->getPost()[$teammate]));
            //Отклонить приглашение
            //дублирование при приглашении
//            var_dump($user);
//            exit();
            if ($users2) {
                $post = explode(' ', $users2);
                if (count($post)>=2) {
                    $first_name = $post[0];
                    $last_name = $post[1];
                    $users = ZFMedoo::get()->select('users', '*', [
                        'and' => [
                            'first_name' => $first_name,
                            'last_name' => $last_name
                        ]
                    ]);


                        $user = ZFMedoo::get()->get('users', '*', [
                            'and' => [
                                'first_name' => $first_name,
                                'last_name' => $last_name
                            ]
                        ]);



                        if ($user['first_name']){ // пользователь существует
										
								$teamA = ZFMedoo::get()->get('teams', 'id', ['captain'=>$zfUser->getId()]);										
                                $temp_user_alert = ZFMedoo::get()->get('teams_users', '*', [ 'AND' => [
                                        'user_id' => $user['id'],
                                        'team_alert' => $teamA,

                                    ]]
                                 );
								//var_dump($teamA);
								//exit();
                                if (!$temp_user_alert) { // если приглашение уже высланно этой командой

                                    ZFMedoo::get()->insert('teams_users',[
    //                                    'team_id' => $teamId,
                                        'user_id' => $user['id'],
                                        'team_alert' => $teamA
                                    ]);
                                     $errors[] = "Приглашение выслано";

                                } else {
                                    $errors[] ='Пользователь уже приглашен: '.$user['first_name'];
                                }
                            }else{

                            $errors[] ='Приглашение выслано';
                            }

                } else {
                    $errors[] ='Требуется имя и фамилия участника';
                }
            }
        }

        return $this->redirect('/users/me?modal-message='.$errors[0]);
    }
    function accede_to_team()
    {

        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $teamId = $zfUser->getTeamId();

        $id = trim(strip_tags($args['id'])) * 1; //

        $capitan_id = ZFMedoo::get()->get('teams','captain', [
            'captain' => $zfUser->getId()
        ]);
        $user_have_team = ZFMedoo::get()->get('teams_users', '*', [ 'AND' => [
                'team_alert' => 0,
                'user_id' => $zfUser->getId(),
            ]]
        );


        $is_all_member = PDO::get()->query('SELECT count(*) as count from teams_users WHERE team_id='.$id.' AND team_alert=0')->fetchAll();
    

        if($is_all_member[0]['count'] <= 5) {
            if (!$capitan_id['captain']) {
              if (!$user_have_team) {
                 if ($id && $zfUser) {
                     ZFMedoo::get()->update('teams_users', [
                         'team_id' => $id,
                         'team_alert' => false,
                     ], [
                         'user_id' => $zfUser->getId(),

                     ]);
                     $errors = 'Вы успешно вступили в команду';
                 } else {
                     $errors = 'Ошибка, попробуйте снова';
                 }
             } else {
                 $errors = 'Необходимо выйти из вашей команды и после принять приглашение';
             }
         } else {
             $errors = 'Вы капитан команды, капитан команды не может перейти в другую команду';
         }
     }else{
         $errors = 'Команда уже состоит из пяти участников, попробуйте позже';
     }




        return $this->redirect('/users/me?modal-message='.$errors);
    }
    function delete_team()
    {

        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];


        $teamId = $zfUser->getTeamId();
        


        $capitan_id = ZFMedoo::get()->get('teams','*', [
            'captain' => $zfUser->getId()
        ]);





        if($capitan_id['captain'] == $zfUser->getId()){
            $teamId = $zfUser->getTeamId();
            $userId = $zfUser->getId();
            ZFMedoo::get()->delete('teams', ['captain' => $zfUser->getId() ] );
            ZFMedoo::get()->delete('teams_users',
                ['AND' => [
                    'team_id' => $teamId,

                ]]

            );
            ZFMedoo::get()->delete('teams_users',
                ['AND' => [

                    'team_alert' => $teamId
                ]]

            );


            $errors = 'Команда успешно удалена';
        }else{
            $errors = 'Ошибка при удалении команды';
        }





        return $this->redirect('/users/me?modal-message='.$errors);
    }
    function search_item_rating()
    {

        $args = RendererHelper::get()->with($this->request);
        $item_check = trim(strip_tags($this->getPost()['search_name']));
        $item_check_id = trim(strip_tags($this->getPost()['search_id_item']));

        if($item_check or $item_check_id) {


            //user

            $item_is_serach = ZFMedoo::get()->get(
                'users', '*', [
                    'id' => $item_check_id
                ]
            );

            if(!$item_is_serach){}
            $item_is_serach = ZFMedoo::get()->get(
                'teams', '*', [
                    'id' => $item_check_id
                ]
            );

        }



//        if ($itemsOnly) return $this->renderer->render($response, 'rating/rating-items.php', $args);
//        else return $this->renderer->render($response, 'rating/rating.php', $args);
        }


}