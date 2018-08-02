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
use Zelfi\Modules\Rating\Rating;
use Zelfi\Utils\Cookies;
use Zelfi\Utils\RendererHelper;

class PrivateStoreController extends Controller
{

    public function get_all(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_partners_all'])->addCurrentId(10, 0)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_store_items = [
            'AND' => [
                'active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_store_items['AND']['store.city'] = [0, $privateData['filter_city']];
        }

        $store_items = ZFMedoo::get()->select(
            'store',
            ['[>]store_categories' => ['category' => 'id']],
            [
                'store.id',
                'store.name',
                'store.description',
                'store.cover',
                'store.city',
                'store.price',
                'store.count',
                'store.balls',
                'store_categories.name(category_name)',
            ], $where_store_items
        );

        $args['store_items'] = $store_items;

        return $this->render('/private/store/storeAll.php', $args);
    }

    public function get_orders_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_store_orders_new'])->addCurrentId(10, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_store_orders = [
            'AND' => [
                'store_orders.accepted' => false,
                'store_orders.finished' => false,
                'store_orders.active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_store_orders['AND']['users.residence'] = $privateData['filter_city'];
        }

        $orders = ZFMedoo::get()->select(
            'store_orders', [
                '[>]users' => [
                    'user_id' => 'id'
                ]
        ],
            [
                'store_orders.id',
                'store_orders.item_id',
                'store_orders.user_id',
                'store_orders.count',
                'store_orders.currency',
                'store_orders.date_created',
                'store_orders.user_id_accepted',
                'store_orders.date_accepted',
                'store_orders.date_finished',
                'store_orders.accepted',
                'store_orders.finished',
                'store_orders.active'
            ],
            $where_store_orders);

        foreach ($orders as $index => $order){
            $orders[$index]['info'] = ZFMedoo::get()->get('store', '*', [
                'id' => $order['item_id']
            ]);

            $orders[$index]['user'] = ZFMedoo::get()->get('users', '*',[
                'id' => $order['user_id']
            ]);
        }

        $args['orders'] = $orders;

        return $this->render('/private/store/storeOrdersNew.php', $args);
    }

    public function get_orders_accepted(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_store_orders_accepted'])->addCurrentId(10, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_store_orders = [
            'AND' => [
                'store_orders.accepted' => true,
                'store_orders.finished' => false,
                'store_orders.active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_store_orders['AND']['users.residence'] = $privateData['filter_city'];
        }

        $orders = ZFMedoo::get()->select(
            'store_orders', [
            '[>]users' => [
                'user_id' => 'id'
            ]
        ],
            [
                'store_orders.id',
                'store_orders.item_id',
                'store_orders.user_id',
                'store_orders.count',
                'store_orders.currency',
                'store_orders.date_created',
                'store_orders.user_id_accepted',
                'store_orders.date_accepted',
                'store_orders.date_finished',
                'store_orders.accepted',
                'store_orders.finished',
                'store_orders.active'
            ],
            $where_store_orders);

        foreach ($orders as $index => $order){
            $orders[$index]['info'] = ZFMedoo::get()->get('store', '*', [
                'id' => $order['item_id']
            ]);

            $orders[$index]['user'] = ZFMedoo::get()->get('users', '*',[
                'id' => $order['user_id']
            ]);
        }

        $args['orders'] = $orders;

        return $this->render('/private/store/storeOrdersAccepted.php', $args);
    }

    public function get_orders_finished(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_store_orders_finished'])->addCurrentId(10, 1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];
        $privateData = $args[\Zelfi\Enum\HelperAttributes::APPPRIVATEDATA];

        $where_store_orders = [
            'AND' => [
                'store_orders.accepted' => true,
                'store_orders.finished' => true,
                'store_orders.active' => true
            ]
        ];

        if ($privateData['filter_city'] != 0){
            $where_store_orders['AND']['users.residence'] = $privateData['filter_city'];
        }

        $orders = ZFMedoo::get()->select(
            'store_orders', [
            '[>]users' => [
                'user_id' => 'id'
            ]
        ],
            [
                'store_orders.id',
                'store_orders.item_id',
                'store_orders.user_id',
                'store_orders.count',
                'store_orders.currency',
                'store_orders.date_created',
                'store_orders.user_id_accepted',
                'store_orders.date_accepted',
                'store_orders.date_finished',
                'store_orders.accepted',
                'store_orders.finished',
                'store_orders.active'
            ],
            $where_store_orders);

        foreach ($orders as $index => $order){
            $orders[$index]['info'] = ZFMedoo::get()->get('store', '*', [
                'id' => $order['item_id']
            ]);

            $orders[$index]['user'] = ZFMedoo::get()->get('users', '*',[
                'id' => $order['user_id']
            ]);
        }

        $args['orders'] = $orders;

        return $this->render('/private/store/storeOrdersFinished.php', $args);
    }

    public function get_new(){
        $args = RendererHelper::get()
            ->addFooterData([
                'private_partners_new'
            ])
            ->addCurrentId(10, -1)
            ->with($this->request);

        $store_categories = ZFMedoo::get()->select('store_categories', '*');

        $args['store_categories'] = $store_categories;

        return $this->render('/private/store/storeNew.php', $args);
    }

    public function get_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->addFooterData(['private_partners_new'])->addCurrentId(10, -1)->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $args['id'];

        $store_item = ZFMedoo::get()->get('store', '*', [
            'id' => $id
        ]);
        $store_categories = ZFMedoo::get()->select('store_categories', '*');

        $args['store_item'] = $store_item;
        $args['store_categories'] = $store_categories;

        if (!$store_item) throw new \Slim\Exception\NotFoundException($this->request, $this->response);
        return $this->render('/private/store/storeEdit.php', $args);
    }

    public function post_delete(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['store_item_id'];

        if ($id){
            ZFMedoo::get()->update('store', [
                'active' => false
            ], [
                'id' => $id
            ]);
        }

        return $this->redirect('/private/store/all');
    }

    public function post_restore(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()->with($this->request);

        $zfUser = $args[HelperAttributes::APPUSER];

        $id = $this->getPost()['store_item_id'];

        if ($id){
            ZFMedoo::get()->update('store', [
                'active' => true
            ], [
                'id' => $id
            ]);
        }

        return $this->redirect('/private/store/all');
    }

    public function post_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $name = $this->getPost()['name'];
        $description = $this->getPost()['description'];
        $balls = $this->getPost()['balls'];
        $price = $this->getPost()['price'];
        $category = $this->getPost()['category'];
        $count = $this->getPost()['count'];
        $city = $this->getPost()['city'];
        $cover = $this->getPost()['cover'];

        $result = ZFMedoo::get()
            ->insert('store', [
                'name' => $name,
                'description' => $description,
                'city' => $city,
                'category' => $category,
                'count' => $count,
                'balls' => $balls,
                'price' => $price,
                'cover' => $cover,
                'active' => true
            ]);

        if ($result){
            return $this->redirect('/private/store/all');
        } else {
           return $this->redirect('/private/store/all?message=result:'.$result);
        }
    }

    public function post_edit(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $store_item_id = $this->getPost()['store_item_id'];

        $name = $this->getPost()['name'];
        $description = $this->getPost()['description'];
        $balls = $this->getPost()['balls'];
        $price = $this->getPost()['price'];
        $category = $this->getPost()['category'];
        $count = $this->getPost()['count'];
        $city = $this->getPost()['city'];
        $cover = $this->getPost()['cover'];

        if ($store_item_id){
            ZFMedoo::get()->update('store', [
                'name' => $name,
                'description' => $description,
                'city' => $city,
                'category' => $category,
                'count' => $count,
                'balls' => $balls,
                'price' => $price,
                'cover' => $cover,
                'active' => true
            ], [
                'id' => $store_item_id
            ]);
        }

        return $this->redirect('/private/store/all');
    }

    function post_orders_accept(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $store_order_id = $this->getPost()['order_id'];

        if ($store_order_id){
            ZFMedoo::get()->update('store_orders', [
                'accepted' => true,
                'finished' => false,
                'active' => true
            ], [
                'id' => $store_order_id
            ]);
        }

        return $this->redirect('/private/store/orders/accepted');
    }

    function post_orders_finish(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $store_order_id = $this->getPost()['order_id'];

        if ($store_order_id){
            ZFMedoo::get()->update('store_orders', [
                'accepted' => true,
                'finished' => true,
                'active' => true
            ], [
                'id' => $store_order_id
            ]);
        }


        return $this->redirect('/private/store/orders/finished');
    }

    function post_orders_remove(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $store_order_id = $this->getPost()['order_id'];

        if ($store_order_id){
            $store_order = ZFMedoo::get()->get('store_orders', '*', [
                'id' => $store_order_id
            ]);

            $store_item = ZFMedoo::get()->get('store', '*', [
                'id' => $store_order['item_id']
            ]);

            if ($store_order && $store_item){
                if ($store_order['currency'] == 1){
                    Rating::returnZelfiStore($store_order['user_id'], $store_order['id'], ($store_item['balls'] * $store_order['count']));
                }

                ZFMedoo::get()->update('store', [
                    'count[+]' => $store_order['count']
                ], [
                    'id' => $store_order['item_id']
                ]);

                ZFMedoo::get()->update('store_orders', [
                    'accepted' => false,
                    'finished' => false,
                    'active' => false
                ], [
                    'id' => $store_order_id
                ]);
            }
        }


        return $this->redirect('/private/store/orders/new');
    }

}