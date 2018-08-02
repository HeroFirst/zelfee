<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use DrewM\MailChimp\Webhook;
use MartynBiz\Slim3Controller\Controller;
use Requests;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Modules\Auth\SocialAuth;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Mail\MailChimpHelper;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Modules\Subscription\Subscription;
use Zelfi\Utils\Cookies;
use Zelfi\Utils\ExportDataExcel;
use Zelfi\Utils\RendererHelper;

class APIController extends Controller
{
    var $SALT = "jd1sSqZ";

    public function events(){

        if ($this->getQueryParams()['hash'] != $this->SALT) return $this->response->withJson(
            ['error'=>['code'=>300, 'message' => 'WHERE HASH??']]
        );

        $events = ZFMedoo::get()->select(
            'events_places',
        [
            '[>]places' => ['place_id' => 'id'],
            '[>]events' => ['event_id' => 'id']
        ],
            [
                'events.id', 'events.title', 'events.description_short', 'events.cover', 'events.date_start', 'events.date_end', 'events_places.place_id', 'places.name(place_name)', 'events.city(city_id)'
            ], [
                'AND' => [
                    'events.date_end[>=]' => date('Y-m-d H:i:s'),
                    'events.active' => true
                ]
            ]
        );

        $cities = ZFMedoo::get()->select('cities', '*');

        foreach ($events as $index1 => $event){
            foreach ($cities as $index2 => $city){
                if ($event['city_id'] == $city['id']) {
                    $events[$index1]['city_name'] = $city['name'];
                    break;
                } else $events[$index1]['city_name'] = null;
            }
        }

        return $this->response->withJson($events);
    }

    public function authorizeMember(){
        /* @var ZFUser $zfUser
         *
         */

        $event = null;
        $place = null;
        $user = null;
        $user_id = null;

        if ($this->getQueryParams()['hash'] != $this->SALT) return $this->response->withJson(['error'=>['code'=>300, 'message' => 'WHERE HASH??']]);


        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];
        if ($zfUser->getRole()>3){
            $simpleAuth = new SimpleAuth();
            $dev_user = $simpleAuth->getUserDeveloper();

            if ($dev_user && $dev_user['hash']){
                $simpleAuth->setAuth($this->response, new ZFUser($dev_user));
            }
        }

        $event_id = $this->getQueryParams()['event_id'];
        $place_id = $this->getQueryParams()['place_id'];
        $rfidid = $this->getQueryParams()['rfidid'];

        if ($event_id && $place_id){
            $event = ZFMedoo::get()->get('events', '*', [
                'id' => $event_id
            ]);

            $place = ZFMedoo::get()->get('places', '*', [
                'id' => $place_id
            ]);

            $args['event'] = $event;
            $args['place'] = $place;
        }

        if ($rfidid){
            $user_id = ZFMedoo::get()->get('users_rfidids', 'user_id', [
                'rfidid' => $rfidid
            ]);

            if ($user_id){
                $user = ZFMedoo::get()->get('users', '*', [
                    'id' => $user_id
                ]);
            }
        }

        if ($event && $place && $user){
            $member_info = ZFMedoo::get()->get('events_members', '*', [
                'AND' => [
                    'user_id' => $user_id,
                    'event_id' => $event_id
                ]
            ]);
            $needAddBalls = false;

            if (!$member_info){
				
					/*
					team_alert - приглашение от команды (0, team_id)
					point - баллы команды					
					*/
					$team_id = ZFMedoo::get()->select('teams_users', 'team_id', [

						'AND' => [
							'user_id' => $user_id,
							'team_alert' => 0
						]
					]);			

					
					$team_id['team_id'] = $team_id[0];
					
					ZFMedoo::get()->insert('events_members', [
						'user_id' => $user_id,
						'team_id' => $team_id['team_id'], // + id команды участника
						'event_id' => $event_id,
						'place_id' => $place_id,
						'is_subscribe_online' => false,
						'finished' => true,
						'active' => true
					]);
					$needAddBalls = true;

					


            } else {
                if (!$member_info['finished']){
                    $needAddBalls = true;
					
                    ZFMedoo::get()->update('events_members', [
                        'finished' => true,
                        'active' => true
                    ], [
                        'AND' => [
                            'user_id' => $user_id,
                            'event_id' => $event_id
                        ]
                    ]);
                }
            }

            if ($needAddBalls){
                $balls_add = $event['balls'];

                if ($member_info && $member_info['is_subscribe_online']){
                    $balls_add += 5;
                }

				Rating::addBallsEvent($user_id, $event_id, $place_id, $balls_add);
				$team_id = ZFMedoo::get()->select('teams_users', 'team_id', [

						'AND' => [
							'user_id' => $user_id,
							'team_alert' => 0
						]
					]);			

					
					$team_id['team_id'] = $team_id[0];
				// кол-во членов в команде
					$count_member_team = ZFMedoo::get()->select('teams_users', 'user_id', [

						'AND' => [
							'team_id' => $team_id['team_id'],
							'team_alert' => 0 
						]
					]);

					
					//если в команде один участник баллы не начисляем
					if(count($count_member_team) >= 2) {   

							//добавляем баллы и зелфи индивидуально каждому, столько сколько членов в команде
							Rating::addBallsUserDifferenCountTeam($user_id, count($count_member_team), count($count_member_team));


						//тянем количество записей, где команда id:
						$count_user_on_events = ZFMedoo::get()->select('events_members', 'team_id', [
							'AND' => [
								'event_id' => $event_id,
								'team_id' => $team_id['team_id']
							]
						]);
						
						//Тянем кол-во баллов команды, для добавления при true проверке
						$point_team = ZFMedoo::get()->get('teams', 'point', ['id' => $team_id['team_id']]);

						//Если участник зафиксировался как 5 из команды, плюсуем 6 баллов его команде, иначе добавить 1 очко команде.
						(count($count_user_on_events) == 5) ? $point_team += 6 : $point_team += 1;
						
						
						// Обновить баллы
						ZFMedoo::get()->update('teams', [
							'point' => $point_team,
						], [
							'id' => $team_id['team_id']
						]);

						//end
					}
				
            }

            $user['balls_all'] = Rating::getAllBalls($user_id);
            $user['events_count'] = ZFMedoo::get()->count('events_members', [
                'AND' => [
                    'user_id' => $user_id,
                    'finished' => true
                ]
            ]);
            if ($user['events_count']){
                $user['surprize'] = ZFMedoo::get()->get('events_suprizes', 'name', [
                    'events_count' => $user['events_count']
                ]);
            }
            ($point_team) ? $user['point_team'] = $point_team : $user['point_team'] = 'Ok';
            $args['user'] = $user;
            $args['finished_already'] = !$needAddBalls;
        }

        $args['rfidid'] = $rfidid;

        return $this->render('/private/service/authorize_member.php', $args);

    }
}