<?php

namespace Zelfi\Controllers;

use MartynBiz\Slim3Controller\Controller;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SettingsDefValues;
use Zelfi\Enum\SettingsNames;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Modules\Settings\Settings;
use Zelfi\Utils\RendererHelper;

class PrivateBallsSystemController extends Controller
{
    public function get_users_all()
    {
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addFooterScripts(['privateUsers'])
            ->addCurrentId(6, 0)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_users = [
            'AND' => [
                'users.active' => true,
                'users.id[!]' => $zfUser->getInfoItem('id')
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_users['AND']['users.residence'] = $privateData['filter_city'];
        }

        $users = ZFMedoo::get()->select(
            'users',
            [
                '[>]users_rfidids' => ['id' => 'user_id'],
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
                'users_roles.name(role_name)',
                'users_rfidids.rfidid'
            ], $where_users
        );

        foreach ($users as $index => $user) {
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

        $args['users'] = $users;

        return $this->render('private/balls-system/usersAll.php', $args);
    }

    function get_users_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(6, -1)
            ->addFooterData(['balls_system_user_edit'])
            ->with($this->request, $args);


        $id = $args['id'];

        $user = ZFMedoo::get()->get('users', '*',[
            'id' => $id
        ]);

        if ($user){
            $balls_seasons = ZFMedoo::get()->select('balls_users',
                [
                    '[>]seasons' => ['season' => 'id']
                ],
                [
                    'balls_users.balls',
                    'balls_users.zelfi',
                    'balls_users.season',
                    'seasons.name(season_name)'
                ] ,
                [
                    'user_id' => $id
                ]);

            $balls_history = ZFMedoo::get()->select('balls_history',
                [
                    '[>]seasons' => ['season' => 'id'],
                    '[>]balls_type' => ['type' => 'id']
                ],
                [
                    'balls_history.id',
                    'balls_history.balls',
                    'balls_history.zelfi',
                    'balls_history.description',
                    'balls_history.type',
                    'balls_history.season',
                    'balls_history.date_created',
                    'seasons.name(season_name)',
                    'balls_type.name(type_name)'
                ] ,
                [
                    'ORDER' => [
                        'balls_history.date_created' => 'DESC'
                    ],
                    'user_id' => $id
            ]);

            $args['user'] = $user;
            $args['balls_history'] = $balls_history;
            $args['balls_seasons'] = $balls_seasons;
        }

        return $this->render('/private/balls-system/usersEdit.php', $args);
    }

    public function get_bonuses_attending_events(){
        $args = RendererHelper::get()->addCurrentId(6, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $events_suprizes = ZFMedoo::get()->select('events_suprizes', '*', [
            'ORDER' => 'events_count'
        ]);

        $args['events_suprizes'] = $events_suprizes;

        return $this->render('private/balls-system/BonusesAttendingEvents.php', $args);
    }

    public function get_bonuses_attending_events_add(){
        $args = RendererHelper::get()->addCurrentId(6, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        return $this->render('private/balls-system/BonusesAttendingEventsAdd.php', $args);
    }

    public function get_bonuses_attending_events_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privateEvents'])->addCurrentId(6, -1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        if ($id){
            $bonus = ZFMedoo::get()->get('events_suprizes', '*', [
                'id' => $id
            ]);

            $args['bonus'] = $bonus;
        }

        return $this->render('private/balls-system/BonusesAttendingEventsEdit.php', $args);
    }

    public function get_users_video_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['balls_system_users_video'])->addCurrentId(6, 2)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_videos = [
            'AND' => [
                'balls_users_video.approved' => false,
                'balls_users_video.active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_videos['AND']['users.residence'] = $privateData['filter_city'];
        }

        $videos = ZFMedoo::get()->select(
            'balls_users_video', [
            '[>]users' => [
                'user_id' => 'id'
            ]
        ], [
            'balls_users_video.id',
            'balls_users_video.name',
            'balls_users_video.description',
            'balls_users_video.url',
            'balls_users_video.user_id',
            'balls_users_video.date_created',
            'balls_users_video.approved',
            'balls_users_video.active',
            'balls_users_video.user_id_approved'
        ],
            $where_videos);

        if ($videos){
            foreach ($videos as $index => $video){
                $videos[$index]['user'] = ZFMedoo::get()->get('users', [
                    'id',
                    'first_name',
                    'last_name',
                    'residence'
                ],[
                    'id' => $video['user_id']
                ]);
            }
        }

        $args['videos'] = $videos;

        return $this->render('private/balls-system/BonusesUsersVideoNew.php', $args);
    }

    public function get_users_video_approved(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['balls_system_users_video'])->addCurrentId(6, 2)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_videos = [
            'AND' => [
                'balls_users_video.approved' => true,
                'balls_users_video.active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_videos['AND']['users.residence'] = $privateData['filter_city'];
        }

        $videos = ZFMedoo::get()->select(
            'balls_users_video', [
                '[>]users' => [
                    'user_id' => 'id'
                ]
        ], [
            'balls_users_video.id',
            'balls_users_video.name',
            'balls_users_video.description',
            'balls_users_video.url',
            'balls_users_video.user_id',
            'balls_users_video.date_created',
            'balls_users_video.approved',
            'balls_users_video.active',
            'balls_users_video.user_id_approved'
        ],
            $where_videos);

        if ($videos){
            foreach ($videos as $index => $video){
                $videos[$index]['user'] = ZFMedoo::get()->get('users', [
                    'id',
                    'first_name',
                    'last_name',
                    'residence'
                ],[
                    'id' => $video['user_id']
                ]);

                $videos[$index]['user_approved'] = ZFMedoo::get()->get('users', [
                    'id',
                    'first_name',
                    'last_name',
                    'residence'
                ],[
                    'id' => $video['user_id_approved']
                ]);
            }
        }

        $args['videos'] = $videos;

        return $this->render('private/balls-system/BonusesUsersVideoApproved.php', $args);
    }

    public function post_users_video_remove(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $video_id = $this->getPost()['user_video_id'];
        $user_id = $this->getPost()['user_id'];

        if ($video_id){
            ZFMedoo::get()->update('balls_users_video', [
                'active' => false,
                'user_id_approved' => $zfUser->getId()
            ], [
                'AND' => [
                    'id' => $video_id,
                    'user_id' => $user_id
                ]
            ]);
        }

        return $this->redirect('/private/balls-system/bonuses/users-video/new');
    }
    public function post_users_video_approve(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $video_id = $this->getPost()['user_video_id'];
        $user_id = $this->getPost()['user_id'];

        if ($video_id && $user_id){
            ZFMedoo::get()->update('balls_users_video', [
                'approved' => true,
                'user_id_approved' => $zfUser->getId()
            ], [
                'AND' => [
                    'id' => $video_id,
                    'user_id' => $user_id
                ]
            ]);

            Rating::addBallsVideo($user_id, $video_id, 2);
        }

        return $this->redirect('/private/balls-system/bonuses/users-video/new');
    }

    public function post_users_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['user_id'];
        $balls = $this->getPost()['balls'];
        $zelfi = $this->getPost()['zelfi'];
        $season = $this->getPost()['season'];

        if (!is_null($id) && !is_null($balls) && !is_null($zelfi) && !is_null($season)){
            Rating::correctBalls($id, $balls, $zelfi, $season);
        }

        return $this->redirect('/private/balls-system/users/edit/'.$id);
    }

    public function post_bonuses_attending_events_add(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $name = $this->getPost()['name'];
        $events_count = $this->getPost()['events_count'];

        if (!is_null($name) && !is_null($events_count)){
            if (!ZFMedoo::get()->has('events_suprizes', [
                'events_count' => $events_count
            ])){
                ZFMedoo::get()->insert('events_suprizes', [
                    'name' => $name,
                    'events_count' => $events_count
                ]);
            } else return $this->redirect('/private/balls-system/bonuses/attending-events/add?message=Бонус с таким количеством мероприятий уже есть');
        }

        return $this->redirect('/private/balls-system/bonuses/attending-events');
    }

    public function post_bonuses_attending_events_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['bonus_id'];
        $name = $this->getPost()['name'];
        $events_count = $this->getPost()['events_count'];

        if (!is_null($id)){
            ZFMedoo::get()->update('events_suprizes', [
                'name' => $name,
                'events_count' => $events_count
            ], [
                'id' => $id
            ]);
        }

        return $this->redirect('/private/balls-system/bonuses/attending-events');
    }

    public function post_bonuses_attending_events_remove(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['bonus_id'];

        if (!is_null($id)){
            ZFMedoo::get()->delete('events_suprizes', [
                'id' => $id
            ]);
        }

        return $this->redirect('/private/balls-system/bonuses/attending-events');
    }
}