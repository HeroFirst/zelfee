<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MartynBiz\Slim3Controller\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use Requests;

use Zelfi\DB\PDO;
use Zelfi\Enum\SettingsDefValues;
use Zelfi\Enum\SettingsNames;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Modules\Auth\SocialAuth;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Modules\Seasons\Seasons;
use Zelfi\Modules\Settings\Settings;
use Zelfi\Utils\Cookies;
use Zelfi\Utils\RendererHelper;


class PrivateUsersController extends Controller
{
//++

    public function get_all_team(){
        /* @var ZFUser $zfUser
         *
         */


        $args = RendererHelper::get()
            ->addFooterScripts(['privateUsers'])
            ->addCurrentId(5, 1)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];
        $filter_city = trim(strip_tags(($this->getQueryParams()['filter-city'])))*1;



        $go_delete = trim(strip_tags(($this->getQueryParams()['delete'])))*1;




        if($go_delete){
            ZFMedoo::get()->delete('teams', ['id' => $go_delete ] );
            ZFMedoo::get()->delete('teams_users',
                ['AND' => [
                    'team_id' => $go_delete,

                ]]
            );
            ZFMedoo::get()->delete('teams_users',
                ['AND' => [

                    'team_alert' => $go_delete
                ]]
            );

        }

        ($filter_city) ? $where=['city'=>$filter_city] : false;

        {
            $get_teams = ZFMedoo::get()->select(
                'teams', '*', $where);
        }


        $teams =[];
        foreach($get_teams as $k=>$v){
            $teams[$k]=$v;
            $id = $v['id'];
            $get_count = PDO::get()->query('SELECT count(*) as count from teams_users where team_id='.$id.' AND team_alert=0')->fetchAll();

            $teams[$k]['count_team'] = $get_count[0]['count'];

        }




        $args['teams'] = $teams;


        return $this->render('/private/users/teamsAll.php', $args);
    }
        public function edit_team(){
        /* @var ZFUser $zfUser
         *
         */

        $args = RendererHelper::get()
            ->addFooterScripts(['privateUsers'])
            ->addCurrentId(5, 1)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];


        $go_delete = trim(strip_tags(($this->getQueryParams()['delete'])))*1;



        $id = $args['id'];

        if($go_delete){
            ZFMedoo::get()->delete('teams_users', ['id' => $go_delete ] );
            PDO::get()->query('DELETE FROM teams_users WHERE user_id='.$go_delete.' AND team_id='.$id);

        }
        if($id) {
            $team = ZFMedoo::get()->get(
                'teams', '*',
                [
                    'id' => $id
                ]
            );



            $crew = PDO::get()->query('SELECT users.id, users.first_name, users.photo_small, users.last_name FROM users JOIN teams_users ON users.id = teams_users.user_id AND teams_users.team_id=' . $id)->fetchAll();
            $users_autocomplete =  ZFMedoo::get()->select('users', ['id','first_name', 'last_name'], ['AND'=>['active'=>1]]);
            $args['users_autocomplete'] = $users_autocomplete;
        }

//

            $team_city = ZFMedoo::get()->get('cities', 'name', [
                'id' => $team['city']
            ]);
            //

        $args['team_city'] = $team_city;
        $args['team'] = $team;
        $args['cities'] = ZFMedoo::get()->select('cities', ['id','name'], ['AND'=>['active'=>1]]);
        $args['crew'] = $crew;


        return $this->render('/private/users/updateTeam.php', $args);
    }
        public function ball_edit_team(){
        /* @var ZFUser $zfUser
         *
         */
            
            $args = RendererHelper::get()->with($this->request);
            $zfUser = $args[HelperAttributes::APPUSER];



            $ball = trim(strip_tags($this->getPost()['editball']));
            $teamId = trim(strip_tags( $this->getPost()['teamId']));

            if(is_numeric($ball)){
                ZFMedoo::get()->update('teams',  ['point' => $ball ] ,  ['id' => $teamId ] );

            }


            return $this->redirect('/private/users/team/'.$teamId.'/edit');
        }

    public function changecity(){
    $args = RendererHelper::get()->with($this->request);
    $zfUser = $args[HelperAttributes::APPUSER];



        $city = trim(strip_tags($this->getPost()['city']));
    $teamId = trim(strip_tags( $this->getPost()['teamId']));

    if(is_numeric($city)){
        ZFMedoo::get()->update('teams',  ['city' => $city ] ,  ['id' => $teamId ] );
    }


    return $this->redirect('/private/users/team/'.$teamId.'/edit');
}









    public function add_member_team(){

        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $teamId = $this->getPost()['crew'];



        for ($i=1; $i<=4; $i++) {
            $teammate = 'teammember'.$i;
//хук - прооптимезировать !
            $id_user_from_ac = trim(strip_tags($this->getPost()[$teammate]));


            $name_lastname = ZFMedoo::get()->select('users', ['first_name', 'last_name'], [
                    'id' => $id_user_from_ac
                ]
            );

            //хук - прооптимезировать !
            $users2 = $name_lastname[0]['first_name'].' '.$name_lastname[0]['last_name'];
//            $this->getPost()[$teammate] = trim(strip_tags($this->getPost()[$teammate]));
            //Отклонить приглашение
            //дублирование при приглашении

            if ($users2) {
                $post = explode(' ', $users2);
                if (count($post)>=2) {
                    $first_name = $post[0];
                    $last_name = $post[1];


                    $user = ZFMedoo::get()->get('users', '*', [
                        'and' => [
                            'first_name' => $first_name,
                            'last_name' => $last_name
                        ]
                    ]);



                    if ($user['first_name']){ // пользователь существует

                        $temp_user_alert = ZFMedoo::get()->get('teams_users', '*', [ 'AND' => [
                                'user_id' => $user['id'],
                                'team_id' => $teamId,

                            ]]
                        );

                        $is_crew_user = PDO::get()->query('SELECT id from teams_users where user_id='.$id_user_from_ac.' AND team_alert=0')->fetchAll();
//                        var_dump($is_crew_user);
//                        exit();
                        if (!$is_crew_user) { // если пользователь уже имеет команду

                            ZFMedoo::get()->insert('teams_users',[

                                'user_id' => $user['id'],
                                'team_id' => $teamId
                            ]);
                            $errors[] = "Готово";

                        } else {
                            $errors[] ='Пользователь уже существует: '.$user['first_name'];
                        }

                    }else{

                        $errors[] ='Пользователя не существует: '.$user['first_name'];
                    }

                } else {
                    $errors[] ='Требуется имя и фамилия участника';
                }
            }
        }

        return $this->redirect('/private/users/team/'.$teamId.'/edit');
    }

    public function create_team(){
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $teamId = trim(strip_tags($this->getPost()['crew_name']));


        $users_autocomplete =  ZFMedoo::get()->select('users', ['id','first_name', 'last_name'], ['AND'=>['active'=>1]]);
        $args['users_autocomplete'] = $users_autocomplete;
        $args['cities'] = ZFMedoo::get()->select('cities', ['id','name'], ['AND'=>['active'=>1]]);

        return $this->render('/private/users/createTeam.php', $args);
        //сослать на все команды







    }
    public function create_db_team(){
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $crew_name = trim(strip_tags($this->getPost()['crew_name']));

        $user_one_captain = trim(strip_tags($this->getPost()['teammember1']));

        if($crew_name and $user_one_captain){


            $is_crew_user_captain = PDO::get()->query('SELECT id from teams_users where user_id='.$user_one_captain.' AND team_alert=0')->fetchAll();
            if(!$is_crew_user_captain) {
                $teamId = ZFMedoo::get()->insert('teams', ['name' => $crew_name, 'captain' => $user_one_captain]);
            }else{

                $errors[] = "Капитан состоит в другой команде";
                return $this->redirect('/private/users/teams/create');
            }
            $teamCity = trim(strip_tags($this->getPost()['city']));

            //добавить название команды
// Добавить функцию смены города
            if(!empty($teamCity)){
                ZFMedoo::get()->update('teams',[
                    'city' => $teamCity,
                    //'photo_small' => $files['small']
                ], [
                    'id' => $teamId
                ]);
            }
            // Добавить функцию смены города
            //сослать на все команды
            for ($i=1; $i<=5; $i++) {
                $teammate = 'teammember'.$i;
//хук - прооптимезировать !

                $id_user_from_ac = trim(strip_tags($this->getPost()[$teammate]));



                $name_lastname = ZFMedoo::get()->select('users', ['first_name', 'last_name'], [
                        'id' => $id_user_from_ac
                    ]
                );

                //хук - прооптимезировать !
                $users2 = $name_lastname[0]['first_name'].' '.$name_lastname[0]['last_name'];
//            $this->getPost()[$teammate] = trim(strip_tags($this->getPost()[$teammate]));
                //Отклонить приглашение
                //дублирование при приглашении

                if ($users2) {
                    $post = explode(' ', $users2);
                    if (count($post)>=2) {
                        $first_name = $post[0];
                        $last_name = $post[1];


                        $user = ZFMedoo::get()->get('users', '*', [
                            'and' => [
                                'first_name' => $first_name,
                                'last_name' => $last_name
                            ]
                        ]);



                        if ($user['first_name']){ // пользователь существует

//                            $temp_user_alert = ZFMedoo::get()->get('teams_users', '*', [ 'AND' => [
//                                    'user_id' => $user['id'],
//                                    'team_id' => $teamId,
//
//                                ]]
//                            );





                            $is_crew_user = PDO::get()->query('SELECT id from teams_users where user_id='.$id_user_from_ac.' AND team_alert=0')->fetchAll();

                            if (!$is_crew_user) { // если пользователь существует в других командах

                                ZFMedoo::get()->insert('teams_users',[

                                    'user_id' => $user['id'],
                                    'team_id' => $teamId
                                ]);
                                $errors[] = "Готово";

                            } else {
                                $errors[] ='Пользователь уже состоит в другой команде: '.$user['first_name'];
                            }

                        }else{

                            $errors[] ='Пользователя не существует: '.$user['first_name'];
                        }

                    } else {
                        $errors[] ='Требуется имя и фамилия участника';
                    }
                }
            }

        }


        //добавить название команды

        //сослать на все команды

        $users_autocomplete =  ZFMedoo::get()->select('users', ['id','first_name', 'last_name']);
        $args['users_autocomplete'] = $users_autocomplete;

        return $this->redirect('/private/users/team/'.$teamId.'/edit');
        //сослать на все команды







    }
//++

    public function get_all(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addFooterScripts(['privateUsers'])
            ->addCurrentId(5, 1)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_users = [
            'AND' => [
                'users.active' => true
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

        foreach ($users as $index => $user){
            $users[$index]['events_count'] = ZFMedoo::get()->count('events_members', [
                'user_id' => $user['id']
            ]);

            $users[$index]['childs'] = ZFMedoo::get()->count('users_childs', [
                'parent_user_id' => $user['id']
            ]);
        }

        $args['users'] = $users;

        return $this->render('/private/users/usersAll.php', $args);
    }

    public function get_disabled(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addFooterScripts(['privateUsers'])
            ->addCurrentId(5, 1)
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_users = [
            'AND' => [
                'users.active' => false
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

        foreach ($users as $index => $user){
            $users[$index]['events_count'] = ZFMedoo::get()->count('events_members', [
                'user_id' => $user['id']
            ]);

            $users[$index]['childs'] = ZFMedoo::get()->count('users_childs', [
                'parent_user_id' => $user['id']
            ]);
        }

        $args['users'] = $users;

        return $this->render('/private/users/usersDisabled.php', $args);
    }

    public function get_new(){
        $args = RendererHelper::get()
            ->addFooterScripts(['privateUsers'])
            ->addFooterData(['private_user_add'])
            ->addCurrentId(5, 0)
            ->with($this->request);

        $roles = ZFMedoo::get()->select('users_roles', '*');

        $args['roles'] = $roles;

        return $this->render('/private/users/userAdd.php', $args);
    }

    public function get_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(5, -1)
            ->addFooterData(['private_user_add'])
            ->addFooterScripts(['privateUsers'])
            ->with($this->request, $args);

        $roles = ZFMedoo::get()->select('users_roles', '*');

        $args['roles'] = $roles;

        $id = $args['id'];

        $user = ZFMedoo::get()->get('users', '*',[
            'id' => $id
        ]);

        if ($user){
            $user['rfidid'] = ZFMedoo::get()->get('users_rfidids', 'rfidid', ['user_id'=>$id]);
            $args['user'] = $user;
        }

        return $this->render('/private/users/userEdit.php', $args);
    }

    public function get_events(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privateUsers'])->addCurrentId(5, -1)->with($this->request);


        $id = $args['id'];

        $user = ZFMedoo::get()->get('users', '*',[
            'id' => $id
        ]);

        $events = ZFMedoo::get()->select('events_members', [
            '[>]events' => ['event_id' => 'id'],
            '[>]places' => ['place_id' => 'id'],
            '[>]events_categories' => ['events.category' => 'id']
        ], [
            'events.id',
            'events.title',
            'events.description_short',
            'events.description',
            'events.date',
            'events.time',
            'events.cover',
            'events.balls',
            'events.category',
            'events_categories.name(category_name)',
            'events.date_created',
            'events.user_created',
            'events.active',
            'places.id(place_id)',
            'places.name(place_name)'
        ], [
            'user_id' => $id
        ]);

        foreach ($events as $index => $event){
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

        $args['user'] = $user;
        $args['events'] = $events;

        return $this->render('/private/users/userEvents.php', $args);
    }

    public function post_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addFooterScripts(['privateUsers'])
            ->with($this->request, $args);

        $first_name = $this->getPost()['first_name'];
        $last_name = $this->getPost()['last_name'];
        $city = $this->getPost()['city'];
        $email = $this->getPost()['email'];
        $phone = $this->getPost()['phone'];
        $description = $this->getPost()['description'];
        $role = $this->getPost()['role'];
        $rfidid = $this->getPost()['rfidid'];
        $kids = $this->getPost()['kids'];

        $simpleAuth = new SimpleAuth();

        if (!is_null($rfidid) && $rfidid != ''){
            $user = $simpleAuth->getUserByRFDID($rfidid);

            if ($user){
                return $this->redirect('/private/users/all?message=RFIDID '.$rfidid.' уже существует');
            }
        }

        $result = $simpleAuth->register($first_name, $last_name, $email, null, $phone, $city, $description, $role, true);

        if ($result){
            if (!is_null($kids) && count($kids)>0){
                foreach ($kids as $index => $item){
                    $gender = $item['gender'];
                    $first_name = $item['first_name'];
                    $age = $item['age'];

                    ZFMedoo::get()->insert('users_childs', [
                        'gender' => $gender,
                        'first_name' => $first_name,
                        'age' => $age,
                        'parent_user_id' => $result
                    ]);
                }
            }

            Rating::addBallsRegistration($result);

            if (!is_null($rfidid)) {
                $simpleAuth->setRFDID($result, $rfidid);
            }

            return $this->redirect('/private/users/all');
        } else {
           return $this->redirect('/private/users/all?message=Ошибка при регистрации');
        }

    }

    public function post_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['user_id'];
        $first_name = $this->getPost()['first_name'];
        $last_name = $this->getPost()['last_name'];
        $city = $this->getPost()['city'];
        $email = $this->getPost()['email'];
        $phone = $this->getPost()['phone'];
        $description = $this->getPost()['description'];
        $role = $this->getPost()['role'];
        $rfidid = $this->getPost()['rfidid'];

        if (!is_null($id)){
            $simpleAuth = new SimpleAuth();
            $simpleAuth->update($id, $first_name, $last_name, $email, null, $phone, $city, $description, $role);

            if (!is_null($rfidid)) {
                $simpleAuth->setRFDID($id, $rfidid);
            }

            return $this->redirect('/private/users/all');
        }
    }

    public function post_disable(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['user_id'];

        if ($id){
            ZFMedoo::get()->update('users', [
                'active' => false
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/users/all');
    }

    public function post_enable(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['user_id'];

        if ($id){
            ZFMedoo::get()->update('users', [
                'active' => true
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/users/all');
    }

    public function post_reset(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['user_id'];

        if ($id){
            $simpleAuth = new SimpleAuth();
            $user = $simpleAuth->getUserById($id);

            if ($user){
                if ($simpleAuth->reset($id)){
                    return $this->redirect('/private/users/edit/'.$id.'?message=Письмо с логином и новым паролем отправлено на почту '.$user['email']);
                } else {
                    return $this->redirect('/private/users/edit/'.$id.'?message=Ошибка при сбросе учетной записи '.$user['email']);
                }

            }
        }

        return $this->redirect('/private/users/edit/'.$id);
    }

}