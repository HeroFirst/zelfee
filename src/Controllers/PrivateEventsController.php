<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MartynBiz\Slim3Controller\Controller;
use Requests;
use Zelfi\Enum\SettingsDefValues;
use Zelfi\Enum\SettingsNames;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Modules\Auth\SocialAuth;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Settings\Settings;
use Zelfi\Utils\Cookies;
use Zelfi\Utils\ExportDataExcel;
use Zelfi\Utils\RendererHelper;

class PrivateEventsController extends Controller
{

    public function get_all(){
        $args = RendererHelper::get()->addFooterData(['private_events_all'])->addCurrentId(1, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_events = [
            'AND' => [
                'events.active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_events['AND']['events.city'] = $privateData['filter_city'];
        }

        $events = ZFMedoo::get()->select('events', [
            '[>]events_categories' => ['category' => 'id']
        ], [
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
            'events.category',
            'events_categories.name(category_name)',
            'events.date_created',
            'events.user_created',
            'events.active'
        ], $where_events);

        foreach ($events as $index => $event){
            $events[$index]['places'] = ZFMedoo::get()->select(
                'events_places',
                [
                    '[>]places' => ['place_id' => 'id']
                ],
                [
                    'places.id',
                    'places.name'

                ], [
                'event_id' => $event['id']
            ]);
            $events[$index]['members_count_online'] = ZFMedoo::get()->count('events_members', [
                'AND' => [
                    'event_id' => $event['id'],
                    'is_subscribe_online' => true
                ]
            ]);
            $events[$index]['members_count_finished'] = ZFMedoo::get()->count('events_members', [
                'AND' => [
                    'event_id' => $event['id'],
                    'finished' => true
                ]
            ]);
            $events[$index]['members_count_all'] = ZFMedoo::get()->count('events_members', [
                'event_id' => $event['id']
            ]);
            $events[$index]['gallery'] = ZFMedoo::get()->get('events_galleries', 'gallery_id', ['event_id'=>$event['id']]);
        }

        $args['events'] = $events;

        return $this->render('/private/events/eventsAll.php', $args);
    }

    public function get_trash(){
        $args = RendererHelper::get()->addFooterData(['private_events_all'])->addCurrentId(1, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_events = [
            'AND' => [
                'events.active' => false
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_events['AND']['events.city'] = $privateData['filter_city'];
        }

        $events = ZFMedoo::get()->select('events', [
            '[>]events_categories' => ['category' => 'id']
        ], [
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
            'events.category',
            'events_categories.name(category_name)',
            'events.date_created',
            'events.user_created',
            'events.active'
        ], $where_events);

        foreach ($events as $index => $event){
            $events[$index]['places'] = ZFMedoo::get()->select(
                'events_places',
                [
                    '[>]places' => ['place_id' => 'id']
                ],
                [
                    'places.id',
                    'places.name'

                ], [
                'event_id' => $event['id']
            ]);
            $events[$index]['members_count_online'] = ZFMedoo::get()->count('events_members', [
                'AND' => [
                    'event_id' => $event['id'],
                    'is_subscribe_online' => true
                ]
            ]);
            $events[$index]['members_count_finished'] = ZFMedoo::get()->count('events_members', [
                'AND' => [
                    'event_id' => $event['id'],
                    'finished' => true
                ]
            ]);
            $events[$index]['members_count_all'] = ZFMedoo::get()->count('events_members', [
                'event_id' => $event['id']
            ]);
        }

        $args['events'] = $events;

        return $this->render('/private/events/eventsTrash.php', $args);
    }

    public function get_members(){
        /* @var ZFUser $zfUser
         * @var RendererHelper $zfRendererHelper
         *
         */
        $args = RendererHelper::get()
            ->addFooterScripts(['privatePlaces'])
            ->addFooterData([
                'private_events_members'
            ])
            ->addCurrentId(1, -1)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $zfRendererHelper = $args[HelperAttributes::APPRENDERERHELPER];

        $places_users = [];
        $id = $args['id'];
        $type = $args['type'];

        $event = ZFMedoo::get()->get('events', '*', [
            'id' => $id
        ]);
        $event_places = ZFMedoo::get()->select('events_places', [
            '[>]places' => [
                'place_id' => 'id'
            ]
        ], [
            'places.id',
            'places.name'
        ], [
            'event_id' => $id
        ]);

        if ($event_places)
        foreach ($event_places as $index => $place){
            $where_event_members = [
                'AND' => [
                    'event_id' => $id,
                    'place_id' => $place['id']
                ]
            ];

            switch ($type){
                case 'all':
                    $zfRendererHelper->setHeaderTitle($event['title'], 'Все заявки');
                    break;
                case 'online':
                    $where_event_members['AND']['is_subscribe_online'] = true;
                    $zfRendererHelper->setHeaderTitle($event['title'], 'Онлайн заявки');
                    break;
                case 'finished':
                    $where_event_members['AND']['finished'] = true;
                    $zfRendererHelper->setHeaderTitle($event['title'], 'Пришедшие');
                    break;
            }


            $event_members = ZFMedoo::get()->select('events_members', 'user_id', $where_event_members);

            $users = ZFMedoo::get()->select(
                'users',
                [
                    '[>]users_roles' => ['role' => 'id']
                ],
                [
                    'users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.city',
                    'users.residence',
                    'users.email',
                    'users.phone',
                    'users.role',
                    'users_roles.name(role_name)'
                ],[
                    'AND' => [
                        'users.id' => $event_members,
                        'users.active' => true
                    ]
                ]
            );

            if ($users)
            foreach ($users as $index => $user){
                $balls = [];
                $balls_count = 0;
                $zelfi_count = 0;

                $users[$index]['events_count'] = ZFMedoo::get()->count('events_members', [
                    'user_id' => $user['id']
                ]);

                $users[$index]['childs'] = ZFMedoo::get()->count('users_childs', [
                    'parent_user_id' => $user['id']
                ]);

                $balls_count = ZFMedoo::get()->sum('balls_users', 'balls',  [
                    'AND' => [
                        'user_id' => $user['id'],
                        'season' => Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF)
                    ]
                ]);
                $zelfi_count = ZFMedoo::get()->sum('balls_users', 'zelfi',[
                    'user_id' => $user['id']
                ]);
                $users[$index]['balls_count'] = $balls_count ? $balls_count : 0;
                $users[$index]['zelfi_count'] = $zelfi_count ? $zelfi_count : 0;
            }

            $places_users[] = [
                'title' => $place['name'],
                'users' => $users
            ];
        }

        $args['event'] = $event;
        $args['places_users'] = $places_users;

        return $this->render('/private/events/eventsMembers.php', $args);
    }

    public function get_members_export_excel(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $places_users = [];
        $id = $args['id'];

        $event = ZFMedoo::get()->get('events', '*', [
            'id' => $id
        ]);
        $event_places = ZFMedoo::get()->select('events_places', [
            '[>]places' => [
                'place_id' => 'id'
            ]
        ], [
            'places.id',
            'places.name'
        ], [
            'event_id' => $id
        ]);

        if ($event_places)
            foreach ($event_places as $index => $place){
                $event_members = ZFMedoo::get()->select('events_members', 'user_id', [
                    'AND' => [
                        'event_id' => $id,
                        'place_id' => $place['id']
                    ]
                ]);

                $users = ZFMedoo::get()->select(
                    'users',
                    [
                        '[>]users_roles' => ['role' => 'id']
                    ],
                    [
                        'users.id',
                        'users.first_name',
                        'users.last_name',
                        'users.city',
                        'users.residence',
                        'users.email',
                        'users.phone',
                        'users.role',
                        'users_roles.name(role_name)'
                    ],[
                        'users.id' => $event_members
                    ]
                );

                if ($users)
                    foreach ($users as $index => $user){
                        $balls = [];
                        $balls_count = 0;
                        $zelfi_count = 0;

                        $users[$index]['events_count'] = ZFMedoo::get()->count('events_members', [
                            'user_id' => $user['id']
                        ]);

                        $users[$index]['childs'] = ZFMedoo::get()->count('users_childs', [
                            'parent_user_id' => $user['id']
                        ]);

                        $balls_count = ZFMedoo::get()->sum('balls_users', 'balls',  [
                            'AND' => [
                                'user_id' => $user['id'],
                                'season' => Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF)
                            ]
                        ]);
                        $zelfi_count = ZFMedoo::get()->sum('balls_users', 'zelfi',[
                            'user_id' => $user['id']
                        ]);
                        $users[$index]['balls_count'] = $balls_count ? $balls_count : 0;
                        $users[$index]['zelfi_count'] = $zelfi_count ? $zelfi_count : 0;
                    }

                $places_users[] = [
                    'title' => $place['name'],
                    'users' => $users
                ];
            }

        $args['event'] = $event;
        $args['places_users'] = $places_users;

        $exporter = new ExportDataExcel('browser', $event['date'].' '.$event['title'].'.xls');

        $exporter->initialize();
        $exporter->addRow(array(
            'ID',
            'Имя',
            'Город',
            'E-mail',
            'Телефон',
            'Дети',
            'Посещенные мероприятия',
            'Баллы',
            'Зелфи'
        ));

        if ($places_users){
            foreach ($places_users as $index_place => $place_users) {
                $exporter->addRow(array($place_users['title']));
                $exporter->addRow(array(''));

                if ($place_users['users'] && count($place_users['users'])>0){
                    foreach ($place_users['users'] as $index_user => $place_user) {

                        $exporter->addRow(array(
                            $place_user['id'],
                            $place_user['first_name'].' '.$place_user['last_name'],
                            $args[HelperAttributes::APPCITIES]->getCityById($place_user['residence'])['name'],
                            $place_user['email'],
                            $place_user['phone'],
                            $place_user['childs'] ? $place_user['childs'] : 0,
                            $place_user['events_count'] ? $place_user['events_count'] : 0,
                            $place_user['balls_count'] ? $place_user['balls_count'] : 0,
                            $place_user['zelfi_count'] ? $place_user['zelfi_count'] : 0
                        ));
                    }
                }
                $exporter->addRow(array(''));
                $exporter->addRow(array(''));
            }
        }

        $exporter->finalize();
    }

    public function get_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privateEvents'])->addFooterData(['private_events_new'])->addCurrentId(1, 0)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $args['places'] = ZFMedoo::get()->select('places', '*');
        $args['events_categories'] = ZFMedoo::get()->select('events_categories', '*');
        $args['events_types'] = ZFMedoo::get()->select('events_types', '*');
        $args['galleries'] = ZFMedoo::get()->select('galleries', '*', [
            'active' => true
        ]);

        return $this->render('/private/events/eventAdd.php', $args);
    }

    public function get_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privateEvents'])->addFooterData(['private_events_edit'])->addCurrentId(1, -1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        $args['places'] = ZFMedoo::get()->select('places', '*');
        $args['events_categories'] = ZFMedoo::get()->select('events_categories', '*');
        $args['events_types'] = ZFMedoo::get()->select('events_types', '*');
        $args['galleries'] = ZFMedoo::get()->select('galleries', '*', [
            'active' => true
        ]);

        $event = ZFMedoo::get()->get('events', '*', [
            'id' => $id
        ]);
        $event_places = ZFMedoo::get()->select('events_places', '*', [
            'event_id' => $id
        ]);

        if ($event_places)
        foreach ($event_places as $index => $event_place){
            $event['places'][] = $event_place['place_id'];
        }

        $event['gallery_id'] = ZFMedoo::get()->get('events_galleries', 'gallery_id', [
            'event_id' => $id
        ]);

        $args['event'] = $event;

        if (!$event) throw new \Slim\Exception\NotFoundException($this->request, $this->response);
        return $this->render('/private/events/eventEdit.php', $args);
    }

    public function get_members_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privateEvents'])->addCurrentId(1, -1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        if ($id){
            $event = ZFMedoo::get()->get('events', '*', [
                'id' => $id
            ]);
            $event_places = ZFMedoo::get()->select(
                'events_places',
                [
                    '[>]places' => [
                        'place_id' => 'id'
                    ]
                ],
                [
                    'places.id',
                    'places.name'
                ],
                [
                    'event_id' => $id
                ]
            );
            $args['event'] = $event;
            $args['places'] = $event_places;

            return $this->render('/private/events/eventMembersNew.php', $args);
        }

        throw new \Slim\Exception\NotFoundException($this->request, $this->response);
    }

    public function post_delete(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['event_id'];

        if ($id){
            ZFMedoo::get()->update('events', [
                'active' => false
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/events/all');
    }

    public function post_restore(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['event_id'];

        if ($id){
            ZFMedoo::get()->update('events', [
                'active' => true
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/events/all');
    }

    public function post_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $userId = $zfUser->getInfoItem('id');
        $title = $this->getPost()['title'];
        $description_short = $this->getPost()['description_short'];
        $description = $this->getPost()['description'];
        $places = $this->getPost()['places'];
        $balls = $this->getPost()['balls'];
        $cover = $this->getPost()['cover'];
        $cover_big = $this->getPost()['cover_big'];
        $cover_social = $this->getPost()['cover_social'];
        $category = $this->getPost()['category'];
        $type = $this->getPost()['type'];
        $city = $this->getPost()['city'];
        $time = $this->getPost()['time'];
        $time_end = $this->getPost()['time_end'];
        $date = $this->getPost()['date'];
        $subscribe = $this->getPost()['subscribe'];
        $gallery = $this->getPost()['gallery'];

        $date_start = $date.' '.$time;
        $date_end = $date.' '.$time_end;

        $id = ZFMedoo::get()
            ->insert('events', [
                'title' => $title,
                'description_short' => $description_short,
                'description' => $description,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'cover' => $cover,
                'cover_big' => $cover_big,
                'cover_social' => $cover_social,
                'balls' => $balls,
                'city' => $city,
                'category' => $category,
                'type' => $type,
                'subscribe' => !is_null($subscribe),
                'user_created' => $userId,
                'date_created' => date("Y-m-d H:i:s"),
                'active' => true
            ]);

        if ($id){
            if ($places!=null && count($places)>0){

                $values = [];

                foreach ($places as $place) {
                    $values[] = [
                        'event_id' => $id,
                        'place_id' => $place
                    ];
                }

                ZFMedoo::get()
                    ->insert('events_places', $values);
            }

            if (!is_null($gallery)){
                $hasGallery = ZFMedoo::get()->has('events_galleries', [
                    'event_id' => $id
                ]);

                if ($hasGallery){
                    ZFMedoo::get()->update('events_galleries', [
                        'gallery_id' => $gallery
                    ], [
                        'event_id' => $id
                    ]);
                } else {
                    ZFMedoo::get()->insert('events_galleries', [
                        'event_id' => $id,
                        'gallery_id' => $gallery
                    ]);
                }
            } else {
                ZFMedoo::get()->delete('events_galleries', [
                    'event_id' => $id
                ]);
            }
        }

        return $this->redirect('/private/events/all');
    }

    public function post_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $event_id = $this->getPost()['event_id'];
        $title = $this->getPost()['title'];
        $description_short = $this->getPost()['description_short'];
        $description = $this->getPost()['description'];
        $places = $this->getPost()['places'];
        $cover = $this->getPost()['cover'];
        $cover_big = $this->getPost()['cover_big'];
        $cover_social = $this->getPost()['cover_social'];
        $category = $this->getPost()['category'];
        $type = $this->getPost()['type'];
        $city = $this->getPost()['city'];
        $time = $this->getPost()['time'];
        $time_end = $this->getPost()['time_end'];
        $date = $this->getPost()['date'];
        $subscribe = $this->getPost()['subscribe'];
        $gallery = $this->getPost()['gallery'];

        $date_start = $date.' '.$time;
        $date_end = $date.' '.$time_end;

        if ($event_id != null){

            ZFMedoo::get()->update('events', [
                'title' => $title,
                'description_short' => $description_short,
                'description' => $description,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'city' => $city,
                'cover' => $cover,
                'cover_big' => $cover_big,
                'cover_social' => $cover_social,
                'category' => $category,
                'subscribe' => !is_null($subscribe),
                'type' => $type
            ], [
                'id' => $event_id
            ]);

            if ($places!=null && count($places)>0){

                ZFMedoo::get()->delete('events_places', [
                    'event_id' => $event_id
                ]);

                $values = [];

                foreach ($places as $place) {
                    $values[] = [
                        'event_id' => $event_id,
                        'place_id' => $place
                    ];
                }

                ZFMedoo::get()
                    ->insert('events_places', $values);
            } else {
                ZFMedoo::get()->delete('events_places', [
                    'event_id' => $event_id
                ]);
            }

            if (!$subscribe){
                ZFMedoo::get()->update('events_members',[
                    'active' => false
                ], [
                    'event_id' => $event_id
                ]);
            } else {
                ZFMedoo::get()->update('events_members',[
                    'active' => true
                ], [
                    'event_id' => $event_id
                ]);
            }

            if (!is_null($gallery)){
                $hasGallery = ZFMedoo::get()->has('events_galleries', [
                    'event_id' => $event_id
                ]);

                if ($hasGallery){
                    ZFMedoo::get()->update('events_galleries', [
                        'gallery_id' => $gallery
                    ], [
                        'event_id' => $event_id
                    ]);
                } else {
                    ZFMedoo::get()->insert('events_galleries', [
                        'event_id' => $event_id,
                        'gallery_id' => $gallery
                    ]);
                }
            } else {
                ZFMedoo::get()->delete('events_galleries', [
                    'event_id' => $event_id
                ]);
            }
        }

        return $this->redirect('/private/events/all');
    }

    public function post_members_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $event_id = $this->getPost()['event_id'];
        $place_id = $this->getPost()['place_id'];
        $user_id = $this->getPost()['user_id'];

        if (ZFMedoo::get()->has('users', ['id' => $user_id])){
            if (!ZFMedoo::get()->has('events_members', ['AND' => ['user_id' => $user_id, 'event_id' => $event_id]])){
                ZFMedoo::get()->insert('events_members', [
                    'finished' => true,
                    'place_id' => $place_id,
                    'user_id' => $user_id,
                    'event_id' => $event_id
                ]);

                return $this->redirect('/private/events/members/'.$event_id.'?message=Пользователь зарегистрирован');
            } else {
                ZFMedoo::get()->update('events_members', [
                    'finished' => true,
                    'place_id' => $place_id
                ], [
                    'AND' => [
                        'user_id' => $user_id,
                        'event_id' => $event_id
                    ]
                ]);

                return $this->redirect('/private/events/members/'.$event_id.'?message=Пользователь уже зарегистрирован, инфомация обновлена');
            }
        } else {
            return $this->redirect('/private/events/members/'.$event_id.'?message=Пользователь не найден');
        }

        return $this->redirect('/private/events/members/'.$event_id);
    }

    public function post_members_remove(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $event_id = $this->getPost()['event_id'];
        $user_id = $this->getPost()['user_id'];

        if (ZFMedoo::get()->has('events_members', ['AND' => ['user_id' => $user_id, 'event_id' => $event_id]])){
            ZFMedoo::get()->delete('events_members', [
                'AND' => [
                    'user_id' => $user_id,
                    'event_id' => $event_id
                ]
            ]);

            return $this->redirect('/private/events/members/'.$event_id.'?message=Пользователь удален');
        } else {
            return $this->redirect('/private/events/members/'.$event_id.'?message=Ошибка при удалении: Пользователь не зарегистрирован');
        }

        return $this->redirect('/private/events/members/'.$event_id);
    }
}