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
use Zelfi\Utils\RendererHelper;

class PrivatePlacesController extends Controller
{

    public function get_all(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privatePlaces'])->addCurrentId(1, 2)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_places = [];

        if ($privateData['filter_city'] != 0){
            $where_places['AND']['city'] = $privateData['filter_city'];
        }

        $args['places'] = ZFMedoo::get()->select('places', '*', $where_places);

        return $this->render('/private/places/placesAll.php', $args);
    }

    public function get_new(){
        $args = RendererHelper::get()->addFooterScripts(['privatePlaces'])->addCurrentId(1, 2)->with($this->request);

        return $this->render('/private/places/placeAdd.php', $args);
    }

    public function get_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterScripts(['privatePlaces'])->addCurrentId(1, 2)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $id = $args['id'];

        $place = ZFMedoo::get()->get('places', '*', [
            'id' => $id
        ]);

        $args['place'] = $place;

        if (!$place) throw new \Slim\Exception\NotFoundException($this->request, $this->response);
        return $this->render('/private/places/placeEdit.php', $args);
    }

    public function post_delete(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['place_id'];

        if ($id){
            ZFMedoo::get()->update('places', [
                'active' => false
            ],[
                'id' => $id
            ]);
        }

        return $this->redirect('/private/places/all');
    }

    public function post_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addFooterScripts(['privatePlaces'])
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $userId = $zfUser->getInfoItem('id');
        $title = $this->getPost()['title'];
        $description_short = $this->getPost()['description_short'];
        $description = $this->getPost()['description'];
        $city = $this->getPost()['city'];
        $cover = $this->getPost()['cover'];

        $result = ZFMedoo::get()
            ->insert('places', [
                'name' => $title,
                'description_short' => $description_short,
                'description' => $description,
                'city' => $city,
                'cover' => $cover,
                'user_created' => $userId,
                'coordinates' => '',
                'date_created' => date("Y-m-d H:i:s"),
                'active' => true
            ]);

        if ($result){
            return $this->redirect('/private/places/all');
        } else {
           return $this->redirect('/private/places/all?message=result:'.$result);
        }
    }

    public function post_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addFooterScripts(['privatePlaces'])
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $place_id = $this->getPost()['place_id'];

        $title = $this->getPost()['title'];
        $description_short = $this->getPost()['description_short'];
        $description = $this->getPost()['description'];
        $city = $this->getPost()['city'];
        $cover = $this->getPost()['cover'];

        if ($place_id){
            ZFMedoo::get()->update('places', [
                'name' => $title,
                'description_short' => $description_short,
                'description' => $description,
                'city' => $city,
                'cover' => $cover,
                'coordinates' => '',
            ], [
                'id' => $place_id
            ]);
        }

        return $this->redirect('/private/places/all');
    }

}