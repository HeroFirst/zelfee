<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MartynBiz\Slim3Controller\Controller;
use Requests;
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

class PrivatePaperController extends Controller
{

    public function get_all(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_papers_all'])->addCurrentId(3, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_papers = [
            'GROUP' => 'papers.id',
            'AND' => [
                'papers.active' => true,
                'papers.is_draft' => false
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_papers['AND']['papers_cities.city'] = $privateData['filter_city'];
        }

        $papers = ZFMedoo::get()->select(
            'papers',
            [
                '[>]papers_cities' => [
                    'id' => 'paper_id'
                ],
                '[>]papers_types' => [
                    'type' => 'id'
                ]
            ],
            [
                'papers.id',
                'papers.title',
                'papers.description',
                'papers.description_short',
                'papers.cover',
                'papers.cover_big',
                'papers.cover_social',
                'papers.alias',
                'papers.type',
                'papers.date_publish',
                'papers.date_created',
                'papers.user_created',
                'papers.is_hot',
                'papers.is_top',
                'papers.is_draft',
                'papers.active',
                'papers_types.name(type_name)'
            ],
            $where_papers
        );

        foreach ($papers as $index => $item) {
            $papers[$index]['author'] = ZFMedoo::get()->get('users', [
                'id',
                'first_name',
                'last_name',
                'photo',
                'photo_small'
            ],[
                'id' => $item['user_created']
            ]);
        }

        $args['papers'] = $papers;

        return $this->render('/private/paper/paperAll.php', $args);
    }

    public function get_draft(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_papers_all'])->addCurrentId(3, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_papers = [
            'GROUP' => 'papers.id',
            'AND' => [
                'papers.active' => true,
                'papers.is_draft' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_papers['AND']['papers_cities.city'] = $privateData['filter_city'];
        }

        $papers = ZFMedoo::get()->select(
            'papers',
            [
                '[>]papers_cities' => [
                    'id' => 'paper_id'
                ],
                '[>]papers_types' => [
                    'type' => 'id'
                ]
            ],
            [
                'papers.id',
                'papers.title',
                'papers.description',
                'papers.description_short',
                'papers.cover',
                'papers.cover_big',
                'papers.cover_social',
                'papers.alias',
                'papers.type',
                'papers.date_publish',
                'papers.date_created',
                'papers.user_created',
                'papers.is_hot',
                'papers.is_top',
                'papers.is_draft',
                'papers.active',
                'papers_types.name(type_name)'
            ],
            $where_papers
        );

        foreach ($papers as $index => $item) {
            $papers[$index]['author'] = ZFMedoo::get()->get('users', [
                'id',
                'first_name',
                'last_name',
                'photo',
                'photo_small'
            ],[
                'id' => $item['user_created']
            ]);
        }

        $args['papers'] = $papers;

        return $this->render('/private/paper/paperDraft.php', $args);
    }

    public function get_trash(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_papers_all'])->addCurrentId(3, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_papers = [
            'GROUP' => 'papers.id',
            'AND' => [
                'papers.active' => false,
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_papers['AND']['papers_cities.city'] = $privateData['filter_city'];
        }

        $papers = ZFMedoo::get()->select(
            'papers',
            [
                '[>]papers_cities' => [
                    'id' => 'paper_id'
                ],
                '[>]papers_types' => [
                    'type' => 'id'
                ]
            ],
            [
                'papers.id',
                'papers.title',
                'papers.description',
                'papers.description_short',
                'papers.cover',
                'papers.cover_big',
                'papers.cover_social',
                'papers.alias',
                'papers.type',
                'papers.date_publish',
                'papers.date_created',
                'papers.user_created',
                'papers.is_hot',
                'papers.is_top',
                'papers.is_draft',
                'papers.active',
                'papers_types.name(type_name)'
            ],
            $where_papers
        );

        foreach ($papers as $index => $item) {
            $papers[$index]['author'] = ZFMedoo::get()->get('users', [
                'id',
                'first_name',
                'last_name',
                'photo',
                'photo_small'
            ],[
                'id' => $item['user_created']
            ]);
        }

        $args['papers'] = $papers;

        return $this->render('/private/paper/paperTrash.php', $args);
    }

    public function get_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privatePaper'])->addCurrentId(3, 0)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $args['paper_types'] = ZFMedoo::get()->select('papers_types', '*');
        $args['paper_categories'] = ZFMedoo::get()->select('papers_categories', '*');

        return $this->render('/private/paper/paperAdd.php', $args);
    }

    public function get_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privatePaper'])->addCurrentId(3, -1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        $args['paper_types'] = ZFMedoo::get()->select('papers_types', '*');
        $args['paper_categories'] = ZFMedoo::get()->select('papers_categories', '*');

        $paper = ZFMedoo::get()->get('papers', '*', [
            'id' => $id
        ]);
        $cities = ZFMedoo::get()->select('papers_cities', ['city'], ['paper_id' => $id]);
        foreach ($cities as $index => $city) {
            $paper['cities'][] = $city['city'];
        }

        $args['paper'] = $paper;

        if (!$paper) throw new \Slim\Exception\NotFoundException($this->request, $this->response);
        return $this->render('/private/paper/paperEdit.php', $args);
    }

    public function post_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privatePaper'])->addCurrentId(3, 0)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

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

        $paper_id = ZFMedoo::get()->insert('papers', [
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

        if ($paper_id > 0){
            if ($city && count($city)>0){
                foreach ($city as $index => $item){
                    $city_id = ZFMedoo::get()->insert('papers_cities', [
                        'paper_id' => $paper_id,
                        'city' => $item
                    ]);
                }
            }
        }

        return $this->redirect('/private/paper/all');
    }

    public function post_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privatePaper'])->addCurrentId(3, 0)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $paper_id = $this->getPost()['paper_id'];
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

        if ($paper_id){
            ZFMedoo::get()->update('papers', [
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
                'id' => $paper_id
            ]);

            if ($paper_id != null){
                if ($city && count($city)>0){
                    ZFMedoo::get()->delete('papers_cities', [
                        'paper_id' => $paper_id
                    ]);

                    foreach ($city as $index => $item){
                        $city_id = ZFMedoo::get()->insert('papers_cities', [
                            'paper_id' => $paper_id,
                            'city' => $item
                        ]);
                    }
                }
            }
        }

        return $this->redirect('/private/paper/all');
    }

    public function post_delete(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['paper_id'];

        if ($id){
            ZFMedoo::get()->update('papers', [
                'active' => false
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/paper/all');
    }

    public function post_restore(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['paper_id'];

        if ($id){
            ZFMedoo::get()->update('papers', [
                'active' => true
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/paper/all');
    }
}