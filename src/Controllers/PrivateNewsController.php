<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MartynBiz\Slim3Controller\Controller;
use Requests;
use Zelfi\Model\ZFCities;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Modules\Auth\SocialAuth;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;
use Zelfi\Model\ZFUser;
use Zelfi\Utils\Cookies;
use Zelfi\Utils\DateHelper;
use Zelfi\Utils\RendererHelper;

class PrivateNewsController extends Controller
{

    public function get_all(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_news_all'])->addCurrentId(2, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_news = [
            'GROUP' => 'news.id',
            'AND' => [
                'news.active' => true,
                'news.is_draft' => false
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_news['AND']['news_cities.city'] = $privateData['filter_city'];
        }

        $news = ZFMedoo::get()->select(
            'news',
            [
                '[>]news_cities' => [
                    'id' => 'news_id'
                ],
                '[>]news_types' => [
                    'type' => 'id'
                ]
            ],
            [
                'news.id',
                'news.title',
                'news.description',
                'news.description_short',
                'news.cover',
                'news.cover_big',
                'news.cover_social',
                'news.alias',
                'news.type',
                'news.user_created',
                'news.date_publish',
                'news.date_created',
                'news.is_hot',
                'news.is_top',
                'news.is_draft',
                'news.active',
                'news_types.name(type_name)'
            ],
            $where_news
        );

        foreach ($news as $index => $item) {
            $news[$index]['author'] = ZFMedoo::get()->get('users', [
                'id',
                'first_name',
                'last_name',
                'photo',
                'photo_small'
            ],[
                'id' => $item['user_created']
            ]);
        }

        $args['news'] = $news;

        return $this->render('/private/news/newsAll.php', $args);
    }

    public function get_draft(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_news_all'])->addCurrentId(2, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_news = [
            'GROUP' => 'news.id',
            'AND' => [
                'news.active' => true,
                'news.is_draft' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_news['AND']['news_cities.city'] = $privateData['filter_city'];
        }

        $news = ZFMedoo::get()->select(
            'news',
            [
                '[>]news_cities' => [
                    'id' => 'news_id'
                ],
                '[>]news_types' => [
                    'type' => 'id'
                ]
            ],
            [
                'news.id',
                'news.title',
                'news.description',
                'news.description_short',
                'news.cover',
                'news.cover_big',
                'news.cover_social',
                'news.alias',
                'news.type',
                'news.date_publish',
                'news.date_created',
                'news.user_created',
                'news.is_hot',
                'news.is_top',
                'news.is_draft',
                'news.active',
                'news_types.name(type_name)'
            ],
            $where_news
        );

        foreach ($news as $index => $item) {
            $news[$index]['author'] = ZFMedoo::get()->get('users', [
                'id',
                'first_name',
                'last_name',
                'photo',
                'photo_small'
            ],[
                'id' => $item['user_created']
            ]);
        }

        $args['news'] = $news;

        return $this->render('/private/news/newsDraft.php', $args);
    }

    public function get_trash(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_news_all'])->addCurrentId(2, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_news = [
            'GROUP' => 'news.id',
            'AND' => [
                'news.active' => false,
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_news['AND']['news_cities.city'] = $privateData['filter_city'];
        }

        $news = ZFMedoo::get()->select(
            'news',
            [
                '[>]news_cities' => [
                    'id' => 'news_id'
                ],
                '[>]news_types' => [
                    'type' => 'id'
                ]
            ],
            [
                'news.id',
                'news.title',
                'news.description',
                'news.description_short',
                'news.cover',
                'news.cover_big',
                'news.cover_social',
                'news.alias',
                'news.type',
                'news.date_publish',
                'news.date_created',
                'news.user_created',
                'news.is_hot',
                'news.is_top',
                'news.is_draft',
                'news.active',
                'news_types.name(type_name)'
            ],
            $where_news
        );

        foreach ($news as $index => $item) {
            $news[$index]['author'] = ZFMedoo::get()->get('users', [
                'id',
                'first_name',
                'last_name',
                'photo',
                'photo_small'
            ],[
                'id' => $item['user_created']
            ]);
        }

        $args['news'] = $news;

        return $this->render('/private/news/newsTrash.php', $args);
    }

    public function get_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privateNews'])->addCurrentId(2, 0)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $args['news_types'] = ZFMedoo::get()->select('news_types', '*');

        return $this->render('/private/news/newsAdd.php', $args);
    }

    public function get_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privateNews'])->addCurrentId(2, -1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        $args['news_types'] = ZFMedoo::get()->select('news_types', '*');

        $news_item = ZFMedoo::get()->get('news', '*', [
            'id' => $id
        ]);
        $cities = ZFMedoo::get()->select('news_cities', ['city'], ['news_id' => $id]);
        foreach ($cities as $index => $city) {
            $news_item['cities'][] = $city['city'];
        }

        $args['news_item'] = $news_item;

        if (!$news_item) throw new \Slim\Exception\NotFoundException($this->request, $this->response);
        return $this->render('/private/news/newsEdit.php', $args);
    }

    public function post_new(){
        /* @var ZFUser $zfUser
         * @var ZFCities $zfCities
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $zfCities = $args[HelperAttributes::APPCITIES];

        $title = $this->getPost()['title'];
        $description_short = $this->getPost()['description_short'];
        $description = $this->getPost()['description'];
        $publish_at_once = $this->getPost()['publish_at_once'];
        $time_publication = $this->getPost()['time_publication'];
        $date_publication = $this->getPost()['date_publication'];
        $is_hot = $this->getPost()['is_hot'];
        $is_top = $this->getPost()['is_top'];
        $is_draft = $this->getPost()['is_draft'];
        $city = $this->getPost()['city'];
        $type = $this->getPost()['type'];
        $cover = $this->getPost()['cover'];
        $cover_big = $this->getPost()['cover_big'];
        $cover_social = $this->getPost()['cover_social'];

        $news_id = ZFMedoo::get()->insert('news', [
            'title' => $title,
            'description' => $description,
            'description_short' => $description_short,
            'type' => $type,
            'cover' => $cover,
            'cover_big' => $cover_big,
            'cover_social' => $cover_social,
            'is_hot' => ($is_hot != null),
            'is_top' => ($is_top != null),
            'is_draft' => ($is_draft != null),
            'user_created' => $zfUser->getInfoItem('id'),
            'date_publish' => ($publish_at_once) ? date('Y-m-d H:i:s') : DateHelper::getDateFromRU($date_publication, $time_publication),
            'date_created' => date('Y-m-d H:i:s'),
            'active' => true
        ]);

        if ($news_id > 0){
            if ($city && count($city)>0){
                foreach ($city as $index => $item){
                    $city_id = ZFMedoo::get()->insert('news_cities', [
                        'news_id' => $news_id,
                        'city' => $item
                    ]);
                }
            } else {
                foreach ($zfCities->getCities() as $index => $item){
                    $city_id = ZFMedoo::get()->insert('news_cities', [
                        'news_id' => $news_id,
                        'city' => $item['id']
                    ]);
                }
            }
        }

       return $this->redirect('/private/news/all');
    }

    public function post_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $news_id = $this->getPost()['news_item_id'];
        $title = $this->getPost()['title'];
        $description_short = $this->getPost()['description_short'];
        $description = $this->getPost()['description'];
        $publish_at_once = $this->getPost()['publish_at_once'];
        $time_publication = $this->getPost()['time_publication'];
        $date_publication = $this->getPost()['date_publication'];
        $is_hot = $this->getPost()['is_hot'];
        $is_top = $this->getPost()['is_top'];
        $is_draft = $this->getPost()['is_draft'];
        $city = $this->getPost()['city'];
        $type = $this->getPost()['type'];
        $cover = $this->getPost()['cover'];
        $cover_big = $this->getPost()['cover_big'];
        $cover_social = $this->getPost()['cover_social'];

        if ($news_id){
            ZFMedoo::get()->update('news', [
                'title' => $title,
                'description' => $description,
                'description_short' => $description_short,
                'type' => $type,
                'cover' => $cover,
                'cover_big' => $cover_big,
                'cover_social' => $cover_social,
                'is_hot' => ($is_hot != null),
                'is_top' => ($is_top != null),
                'is_draft' => ($is_draft != null),
                'date_publish' => ($publish_at_once) ? date('Y-m-d H:i:s') : DateHelper::getDateFromRU($date_publication, $time_publication)
            ], [
                'id' => $news_id
            ]);

            if ($news_id != null){
                if ($city && count($city)>0){
                    ZFMedoo::get()->delete('news_cities', [
                        'news_id' => $news_id
                    ]);

                    foreach ($city as $index => $item){
                        $city_id = ZFMedoo::get()->insert('news_cities', [
                            'news_id' => $news_id,
                            'city' => $item
                        ]);
                    }
                }
            }
        }

        return $this->redirect('/private/news/all');
    }

    public function post_delete(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['news_item_id'];

        if ($id){
            ZFMedoo::get()->update('news', [
                'active' => false
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/news/all');
    }

    public function post_restore(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['news_item_id'];

        if ($id){
            ZFMedoo::get()->update('news', [
                'active' => true
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/news/all');
    }
}