<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MartynBiz\Slim3Controller\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use Requests;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Modules\Auth\SocialAuth;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;
use Zelfi\Model\ZFUser;
use Zelfi\Utils\Cookies;
use Zelfi\Utils\RendererHelper;

class PrivateGalleriesController extends Controller
{

    public function get_all(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(4, -1)
            ->addFooterData([
                'private_galleries_add'
            ])
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_galleries = [
            'AND' => [
                'active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_galleries['AND']['city'] = [0, $privateData['filter_city']];
        }

        $galleries = ZFMedoo::get()->select('galleries', '*', $where_galleries);

        $args['galleries'] = $galleries;

        return $this->render('/private/galleries/galleriesAll.php', $args);
    }

    public function get_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(4, -1)
            ->addFooterData([
                'private_galleries_add'
            ])
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        return $this->render('/private/galleries/galleryAdd.php', $args);
    }

    public function get_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(4, -1)
            ->addFooterData([
                'private_galleries_edit'
            ])
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        if ($id){
            $args['gallery'] = ZFMedoo::get()->get('galleries', '*', [
                'id' => $id
            ]);
        }

        return $this->render('/private/galleries/galleryEdit.php', $args);

    }

    public function post_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $name = $this->getPost()['name'];
        $description = $this->getPost()['description'];
        $city = $this->getPost()['city'];
        $isMain = $this->getPost()['is_main'];
        $images = [];

        if ($this->getPost()['images']) foreach ($this->getPost()['images'] as $image) {
            if ($image != '' ) $images[] = $image;
        }

        if ($images){
            $id = ZFMedoo::get()
                ->insert('galleries', [
                    'name' => $name,
                    'description' => $description,
                    'images' => serialize($images),
                    'is_main' => !is_null($isMain),
                    'city' => $city,
                    'active' => true
                ]);

            if ($id && !is_null($isMain)) {
                ZFMedoo::get()->update('galleries', [
                    'is_main' => false
                ], [
                    'AND' => [
                        'id[!]' => $id,
                        'city{!}' => $city
                    ]
                ]);
            }
        }

        return $this->redirect('/private/galleries/all');
    }

    public function post_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['gallery_id'];
        $name = $this->getPost()['name'];
        $description = $this->getPost()['description'];
        $city = $this->getPost()['city'];
        $isMain = $this->getPost()['is_main'];
        $images = [];

        if ($this->getPost()['images']) foreach ($this->getPost()['images'] as $image) {
            if ($image != '' ) $images[] = $image;
        }

        if ($images){
            ZFMedoo::get()
                ->update('galleries', [
                    'name' => $name,
                    'description' => $description,
                    'images' => serialize($images),
                    'is_main' => !is_null($isMain),
                    'city' => $city,
                    'active' => true
                ], [
                    'id' => $id
                ]);

            if (!is_null($isMain)) {
                ZFMedoo::get()->update('galleries', [
                    'is_main' => false
                ], [
                    'AND' => [
                        'id[!]' => $id,
                        'city{!}' => $city
                    ]
                ]);
            }
        }

        return $this->redirect('/private/galleries/all');
    }

    public function post_delete(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['gallery_id'];

        if ($id){
            ZFMedoo::get()->update('galleries', [
                'active' => false
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/galleries/all');
    }

    public function post_restore(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['gallery_id'];

        if ($id){
            ZFMedoo::get()->update('galleries', [
                'active' => true
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/galleries/all');
    }

}