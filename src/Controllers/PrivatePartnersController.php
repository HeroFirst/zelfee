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

class PrivatePartnersController extends Controller
{

    public function get_all(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_partners_all'])->addCurrentId(9, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_partners = [
            'AND' => [
                'partners.active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_partners['AND']['partners.city'] = [0, $privateData['filter_city']];
        }

        $partners = ZFMedoo::get()->select(
            'partners',
            ['[>]partners_types' => ['type' => 'id']],
            [
                'partners.id',
                'partners.title',
                'partners.description',
                'partners.cover',
                'partners.url',
                'partners.type',
                'partners.city',
                'partners.is_main',
                'partners_types.name(type_name)',
            ], $where_partners
        );

        $args['partners'] = $partners;

        return $this->render('/private/partners/partnersAll.php', $args);
    }

    public function get_new(){
        $args = RendererHelper::get()
            ->addFooterData([
                'private_partners_new'
            ])
            ->addCurrentId(9, 0)
            ->with($this->request);

        $partners_types = ZFMedoo::get()->select('partners_types', '*');

        $args['partners_types'] = $partners_types;

        return $this->render('/private/partners/partnerNew.php', $args);
    }

    public function get_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_partners_new'])->addCurrentId(9, -1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        $partner = ZFMedoo::get()->get('partners', '*', [
            'id' => $id
        ]);
        $partners_types = ZFMedoo::get()->select('partners_types', '*');

        $args['partner'] = $partner;
        $args['partners_types'] = $partners_types;

        if (!$partner) throw new \Slim\Exception\NotFoundException($this->request, $this->response);
        return $this->render('/private/partners/partnerEdit.php', $args);
    }

    public function post_delete(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['partner_id'];

        if ($id){
            ZFMedoo::get()->delete('partners', [
                'id' => $id
            ]);
        }

        return $this->redirect('/private/partners/all');
    }

    public function post_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $title = $this->getPost()['title'];
        $description = $this->getPost()['description'];
        $url = $this->getPost()['url'];
        $type = $this->getPost()['type'];
        $city = $this->getPost()['city'];
        $cover = $this->getPost()['cover'];
        $isMain = $this->getPost()['is_main'];

        $result = ZFMedoo::get()
            ->insert('partners', [
                'title' => $title,
                'description' => $description,
                'city' => $city,
                'type' => $type,
                'url' => $url,
                'cover' => $cover,
                'is_main' => !is_null($isMain),
                'active' => true
            ]);

        if ($result){
            return $this->redirect('/private/partners/all');
        } else {
           return $this->redirect('/private/partners/all?message=result:'.$result);
        }
    }

    public function post_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $partner_id = $this->getPost()['partner_id'];

        $title = $this->getPost()['title'];
        $description = $this->getPost()['description'];
        $url = $this->getPost()['url'];
        $type = $this->getPost()['type'];
        $city = $this->getPost()['city'];
        $cover = $this->getPost()['cover'];
        $isMain = $this->getPost()['is_main'];

        if ($partner_id){
            ZFMedoo::get()->update('partners', [
                'title' => $title,
                'description' => $description,
                'city' => $city,
                'type' => $type,
                'url' => $url,
                'cover' => $cover,
                'is_main' => !is_null($isMain),
                'active' => true
            ], [
                'id' => $partner_id
            ]);
        }

        return $this->redirect('/private/partners/all');
    }

}