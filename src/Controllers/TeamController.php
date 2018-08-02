<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.11.2016
 * Time: 15:14
 */

namespace Zelfi\Controllers;

use Zelfi\DB\ZFMedoo;
use MartynBiz\Slim3Controller\Controller;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Utils\RendererHelper;
use Zelfi\Modules\Upload\Upload;

class TeamController extends Controller
{
    function get_team(){

        $args = RendererHelper::get()
            ->addCurrentId(6)
            ->with($this->request);

        $team_categories = ZFMedoo::get()->select('teams', '*');
        

        if ($team_categories){
            foreach ($team_categories as $index => $team_category) {
                $team_categories[$index]['teams_users'] = ZFMedoo::get()->select('teams_users', '*', [
                    'AND' => [
                        'team_id' => $team_category['id']
                    ]
                ]);
            }
        }

        $args['team_categories'] = $team_categories;


        return $this->render('/team/team.php', $args);
    }
    public function addPhoto()
    {
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $teamName = trim(strip_tags($this->getPost()['team_name']));
        $teamCity = trim(strip_tags($this->getPost()['city']));

        $captain_id = ZFMedoo::get()->get('teams', 'captain', [
            'id' => $zfUser->getTeamId()
        ]);


    if($zfUser->getTeamId() && $zfUser->getId()==$captain_id) {

        // Добавить функцию смены города
        if(!empty($teamCity)){
            ZFMedoo::get()->update('teams',[
                'city' => $teamCity,
                //'photo_small' => $files['small']
            ], [
                'id' => $zfUser->getTeamId()
            ]);
        }
        // Добавить функцию смены города

        if(!empty($teamName)){

                ZFMedoo::get()->update('teams',[
                    'name' => $teamName,
                    //'photo_small' => $files['small']
                ], [
                    'id' => $zfUser->getTeamId()
                ]);
            }


            if ($_FILES['team_photo']['size']){
                $files = Upload::uploadUserCover($zfUser->getTeamId(),'team_photo');
                ZFMedoo::get()->update('teams',[
                    'photo' => $files['normal'],
                    //'photo_small' => $files['small']
                ], [
                    'captain' => $captain_id
                ]);
                unset($files['normal']);
            }
        }
        $args['errors'][]=$captain_id;
        //return $this->render('layout.html', $args);
        return $this->redirect('/users/me');
        
    }
    public function createTeam()
    {


        $name = $this->getPost()['name'];
        $name = trim(strip_tags($name));
        $city_crew = $this->getPost()['city'];
        $city_crew = trim(strip_tags($city_crew));

        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $errors=[];
        if ($name){
            $team = ZFMedoo::get()->get('teams_users', '*', [
               'user_id' => $zfUser->getInfoItem('id')
            ]);
//            if (!$team) {
                $teamId = ZFMedoo::get()->insert('teams',[
                    'name' => $name,
                    'captain' => $zfUser->getInfoItem('id'),
                    'date_created' => date('Y-m-d H:i:s')
                ]);

            // Добавить функцию записи города
            if($city_crew){
                ZFMedoo::get()->update('teams',[
                    'city' => $city_crew,
                    //'photo_small' => $files['small']
                ], [
                    'id' => $teamId
                ]);
            }
            // Добавить функцию записи города
			
            if ($teamId) {



                if ($_FILES['team_photo']['size']){
                    $files = Upload::uploadUserCover($teamId,'team_photo');
                    ZFMedoo::get()->update('teams',[
                        'photo' => $files['normal'],
                        //'photo_small' => $files['small']
                    ], [
                        'id' => $teamId
                    ]);
                }
            }


                ZFMedoo::get()->insert('teams_users',[
                    'team_id' => $teamId,
                    'user_id' => $zfUser->getInfoItem('id'),
                ]);

           
//            } else {
//                $errors='Вы уже состоите в команде';
//            }
        } else {
            $errors='Не указано название команды';
        }
        if (count($errors)==0) {
            $errors = 'Команда: '.$name.' успешно зарегистрирована';
        }
        $args['errors'] = $errors;

        return $this->redirect('/users/me?modal-message='.$errors);
//        return $this->render('layout.html', $args);
    }
}