<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 16.11.2016
 * Time: 18:50
 */

namespace Zelfi\Modules\Rating;

use PDO;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\BallsTypes;
use Zelfi\Enum\SettingsDefValues;
use Zelfi\Enum\SettingsNames;
use Zelfi\Modules\Seasons\Seasons;
use Zelfi\Modules\Settings\Settings;

class Rating
{

    public static function takeZelfiStore($userId, $item_id, $zelfi){
        if (!is_null($userId) && !is_null($item_id) && !is_null($zelfi)){
            $store_item = ZFMedoo::get()->get('store', '*', [
                'id' => $item_id
            ]);

            if ($store_item){
                $description = 'Заказ товара #'.$store_item['id'].' "'.$store_item['name'].'"';

                self::addHistoryServiceItem($userId, BallsTypes::STORE_ORDER, 0, 0 - $zelfi, $description);
                self::takeZelfi($userId, $zelfi);
            }
        }
    }

    public static function returnZelfiStore($userId, $orderId, $zelfi){
        if (!is_null($userId) && !is_null($orderId) && !is_null($zelfi)){
            $description = 'Возврат средств за заказ #'.$orderId;

            self::addHistoryServiceItem($userId, BallsTypes::STORE_ORDER_RETURN, 0, $zelfi, $description);
            self::addBallsUser($userId, 0, $zelfi);
        }
    }

    public static function addBallsRegistration($userId){
        $balls_count = 20;

        self::addHistoryItem($userId, BallsTypes::REGISTRATION, $balls_count, 0);
        self::addBallsUser($userId, $balls_count, $balls_count);
    }

    public static function addBallsEvent($userId, $event_id, $place_id, $balls_count){
        if (!is_null($userId) && !is_null($event_id) && !is_null($place_id) && !is_null($balls_count)){

            if (ZFMedoo::get()->has('events_places',[
                'AND' => [
                    'event_id' => $event_id,
                    'place_id' => $place_id
                ]
            ])){
                $event = ZFMedoo::get()->get('events', '*', [
                    'id' => $event_id
                ]);

                if ($event){
                    $description = 'Участие в мероприятии "'.$event['title'].'"';

                    self::addHistoryItem($userId, BallsTypes::EVENT, $balls_count, $description);
                    self::addBallsUser($userId, $balls_count, $balls_count);
                }
            }
        }
    }

    public static function addBallsVideo($userId, $video_id, $balls_count){
        if (!is_null($userId) && !is_null($video_id) && !is_null($balls_count)){

            if (ZFMedoo::get()->has('balls_users_video',[
                'AND' => [
                    'user_id' => $userId,
                    'id' => $video_id
                ]
            ])){
                $video = ZFMedoo::get()->get('balls_users_video', '*', [
                    'id' => $video_id
                ]);

                if ($video){
                    $description = 'Загружено видео: "'.$video['name'].'"';

                    self::addHistoryItem($userId, BallsTypes::VIDEO_UPLOAD, $balls_count, 0, $description);
                    self::addBallsUser($userId, $balls_count, $balls_count);
                }
            }
        }
    }

    public static function correctBalls($userId, $balls, $zelfi, $season){
        if (!is_null($userId) && !is_null($balls) && !is_null($zelfi) && !is_null($season)){
            $user_balls = self::getBallsSeason($userId, $season);
            $season_data = Seasons::getSeason($season);

            if ($user_balls && $season_data){
                $current_balls = $user_balls['balls'];
                $current_zelfi = $user_balls['zelfi'];
                $description = 'Корректировка баллов ('.$current_balls.' -> '.$balls.') и зелфи ('.$current_zelfi.' -> '.$zelfi.')';

                if ($current_balls!=$balls || $current_zelfi!=$zelfi){
                    $result = ZFMedoo::get()->update('balls_users', [
                        'balls' => $balls,
                        'zelfi' => $zelfi
                    ], [
                        'AND' => [
                            'user_id' => $userId,
                            'season' => $season
                        ]
                    ]);

                    if ($result) self::addHistoryItem($userId, BallsTypes::CORRECTION, $balls - $current_balls, $zelfi - $current_zelfi, $description, $season);
                }
            }
        }
    }

    public static function addBallsUserDifferenCountTeam($user_id, $balls=1, $zelfi=1){
        if (!is_null($balls) && $balls>0){
            if(!ZFMedoo::get()->has('balls_users', [
                'AND' => [
                    'user_id' => $user_id,
                    'season' => Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF)
                ]
            ])) {
                self::initialize($user_id);
            }

            ZFMedoo::get()->update('balls_users', [
                'balls[+]' => $balls,
                'zelfi[+]' => $zelfi
            ], [
                'AND' => [
                    'user_id' => $user_id,
                    'season' => Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF)
                ]
            ]);
        }
    }


    private static function addBallsUser($user_id, $balls, $zelfi){
        if (!is_null($balls) && $balls>0){
            if(!ZFMedoo::get()->has('balls_users', [
                'AND' => [
                    'user_id' => $user_id,
                    'season' => Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF)
                ]
            ])) {
                self::initialize($user_id);
            }

            ZFMedoo::get()->update('balls_users', [
                'balls[+]' => $balls,
                'zelfi[+]' => $zelfi
            ], [
                'AND' => [
                    'user_id' => $user_id,
                    'season' => Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF)
                ]
            ]);
        }
    }

    /**
     * @param $userId
     * @param $type
     * @param $balls
     * @param string $description
     * @return bool
     */
    private static function addHistoryItem($userId, $type, $balls, $zelfi = 0, $description = '', $season = null){
        $result = false;

        if (!is_null($balls)){
            $result = ZFMedoo::get()->insert('balls_history', [
                'user_id' => $userId,
                'group_id' => -1,
                'type' => $type,
                'description' => $description,
                'season' => is_null($season) ? Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF) : $season,
                'balls' => $balls,
                'zelfi' => $zelfi,
                'date_created' => date('Y-m-d H:i:s'),
                'is_service' => false
            ]);
        }

        return !($result == false);
    }

    /**
     * @param $userId
     * @param $type
     * @param $balls
     * @param string $description
     * @return bool
     */
    private static function addHistoryServiceItem($userId, $type, $balls, $zelfi = 0, $description = '', $season = null){
        $result = false;

        if (!is_null($balls)){
            $result = ZFMedoo::get()->insert('balls_history', [
                'user_id' => $userId,
                'group_id' => -1,
                'type' => $type,
                'description' => $description,
                'season' => is_null($season) ? Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF) : $season,
                'balls' => $balls,
                'zelfi' => $zelfi,
                'date_created' => date('Y-m-d H:i:s'),
                'is_service' => true
            ]);
        }

        return !($result == false);
    }

    private static function takeZelfi($user_id, $zelfi)
    {
        if (!is_null($zelfi) && $zelfi>0){
            if(!ZFMedoo::get()->has('balls_users', [
                'user_id' => $user_id
            ])) {
                self::initialize($user_id);
            }

            $user_zelfi_count = self::getAllBalls($user_id)['zelfi'];

            if ($user_zelfi_count >= $zelfi){
                $user_zelfi_list = ZFMedoo::get()->select('balls_users', [
                    'id', 'zelfi', 'season'
                ], [
                    'user_id' => $user_id
                ]);

                if ($user_zelfi_list)
                foreach ($user_zelfi_list as $item){
                    if ($zelfi == 0) break;

                    $item_zelfi = $item['zelfi'];

                    ZFMedoo::get()->update('balls_users', [
                        'zelfi[-]' => min($zelfi, $item_zelfi)
                    ], [
                        'id' => $item['id']
                    ]);

                    $zelfi -= min($zelfi, $item_zelfi);
                }
            }
        }

        return false;
    }

    public static function getBallsSeasons($userId){

        return ZFMedoo::get()->select('balls_users', '*', [
            'AND' => [
                'user_id' => $userId
            ]
        ]);
    }

    public static function getBallsSeason($userId, $season = null){
        if ($season == null) $season = Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF);

        return ZFMedoo::get()->get('balls_users', '*', [
            'AND' => [
                'user_id' => $userId,
                'season' => $season
            ]
        ]);
    }

    public static function getAllBalls($userId){

        $allBalls = [];

        $allBalls['balls'] = ZFMedoo::get()->sum('balls_users', 'balls', [
            'user_id' => $userId
        ]);
        $allBalls['zelfi'] = ZFMedoo::get()->sum('balls_users', 'zelfi', [
            'user_id' => $userId
        ]);

        return $allBalls;
    }

    public static function getRankAll($city, $season = null, $offset = 0, $count = 10){
        if ($season == null) $season = Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF);

        $balls_rating = false;
        $balls_ranks = [];
        $balls_table = ZFMedoo::get()->select(
            'balls_users', 'balls', [
            'GROUP' => 'balls',
            'ORDER' => [
                'balls' => 'DESC'
            ],
            'AND' => [
                'season' => $season,
                'user_id' => ZFMedoo::get()->select('users', 'id', [
                    'AND' => [
                        'residence' => $city,
                        'active' => true
                    ]
                ])
            ]
        ]);
        if ($balls_table){
            foreach ($balls_table as $index => $balls_rank){
                $balls_ranks[$balls_rank] = $index+1;
            }

            $balls_rating = ZFMedoo::get()->select(
                'balls_users', '*', [
                    'ORDER' => [
                        'balls' => 'DESC',
                        'user_id' => 'ASC'
                    ],
                    'AND' => [
                        'season' => $season,
                        'user_id' => ZFMedoo::get()->select('users', 'id', [
                            'AND' => [
                                'residence' => $city,
                                'active' => true
                            ]
                        ])
                    ],
                    'LIMIT' => [$offset, $count]
                ]
            );

            foreach ($balls_rating as $index => $value) {
                $balls_rating[$index]['rank'] = $balls_ranks[$value['balls']];
 // ADD
                    $user_team_id = ZFMedoo::get()->get(
                        'teams_users', 'team_id', [
                        'AND' => [
                            'user_id' => $value['user_id'],
                            'team_alert' => 0
                        ]
                    ]);
                    if($user_team_id) {
                        $user_team = ZFMedoo::get()->get(
                            'teams', 'name',
                            [
                                'id' => $user_team_id
                            ]
                        );
                    }

                    if ($value['user_id']){


                        if($user_team_id) {
                            $balls_rating[$index]['team'] = $user_team;
                        }else{
                            $balls_rating[$index]['team']= false;
                        }

                    }
    // ADD


            }
        }


        return $balls_rating;
    }

    public static function getRankAllTeam($city, $season = null, $offset = 0, $count = 10){
        $teams_all = PDO::get()->query('select * from teams where city=' . $city . 'LIMIT ' . $offset . ', ' . $count)->fetchAll();

        usort($teams_all, function ($a, $b) {
            if ($a['point'] === $b['point'])
                return 0;
            return $a['point'] > $b['point'] ? -1 : 1;
        });

        $getmax = PDO::get()->query('select max(point) as maxpoint from teams where city=' . $zfUser->getCity())->fetchAll();

        $teams = [];
        $s4et = 1;
        $count_rank = 0;
        $last = $getmax[0]['maxpoint'];


        foreach ($teams_all as $k => $team) {
            $teams[$k] = $team;
            $captain = ZFMedoo::get()->get(
                'users', ['first_name', 'last_name'],
                [
                    'id' => $team['captain']
                ]);
            $teams[$k]['captain'] = $captain['first_name'] . ' ' . $captain['last_name'];

            if ($last == $team['point'] || count($teams_all) == 1) {
                $last = $teams[$count_rank]['point'];
                $teams[$k]['rank'] = $s4et;
            } else {
                $last = $team['point'];
                $s4et++;
                $teams[$k]['rank'] = $s4et;
            }

            $count_rank++;
        }
        return $teams;
    }




    
    public static function getRank($userId, $city, $season = null){
        if ($season == null) $season = Settings::get(SettingsNames::SEASON, SettingsDefValues::SEASON_DEF);

        $balls_ranks = [];
        foreach (ZFMedoo::get()->select(
            'balls_users', 'balls', [
                'GROUP' => 'balls',
                'ORDER' => [
                    'balls' => 'DESC',
                    'user_id' => 'ASC'
                ],
                'AND' => [
                    'season' => $season,
                    'user_id' => ZFMedoo::get()->select('users', 'id', [
                        'AND' => [
                            'residence' => $city,
                            'active' => true
                        ]
                    ])
                ]
            ]
        ) as $index => $balls_rank){
            $balls_ranks[$balls_rank] = $index+1;
        }

        $balls_rating = ZFMedoo::get()->get(
            'balls_users', '*', [
                'ORDER' => [
                    'balls' => 'DESC'
                ],
                'AND' => [
                    'season' => $season,
                    'user_id' => $userId
                ]
            ]
        );

        $balls_rating['rank'] = $balls_ranks[$balls_rating['balls']];

        return $balls_rating;
    }

    public static function initialize($userId){
        if ($userId == null) return;

        $seasons = ZFMedoo::get()->select('seasons', '*');

        foreach ($seasons as $season) {
            if (!ZFMedoo::get()->has('balls_users', [
                'AND' => [
                    'user_id' => $userId,
                    'season' => $season['id']
                ]
            ])){
                ZFMedoo::get()->insert('balls_users', [
                    'user_id' => $userId,
                    'season' => $season['id'],
                    'group_id' => -1,
                    'zelfi' => 0,
                    'balls' => 0
                ]);
            }
        }
    }
}