<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.11.2016
 * Time: 15:14
 */

namespace Zelfi\Controllers;


use MartynBiz\Slim3Controller\Controller;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Mail\Mail;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Utils\RendererHelper;

class StoreController extends Controller
{
    function get_store(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->addCurrentId(7)
            ->addFooterData([
                'store'
            ])
            ->with($this->request);
        $zfUser = $args[HelperAttributes::APPUSER];

        $category = $this->getQueryParams()['category'];

        $where_store_items = [
            'AND' => [
                'active' => true,
                'city' => [0, $zfUser->getCity()]
            ]
        ];

        if ($category>0) {
            $where_store_items['AND']['category'] = $category;
        }

        $store_categories = ZFMedoo::get()->select('store_categories', '*');
        $store_items = ZFMedoo::get()->select('store', '*', $where_store_items);

        $args['store_categories'] = $store_categories;
        $args['store_items'] = $store_items;
        $args['category_active'] = $category;

        return $this->render('/store/store.php', $args);
    }

    /**
     * currency [1 - balls, 2 - price]
     */
    public function post_order_new(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        $mainCity = ZFMedoo::get()->get('cities', '*', [
            'id' => $zfUser->getCity()
        ]);

        $currency = $this->getPost()['currency'];
        $count = $this->getPost()['count'];
        $item_id = $this->getPost()['item_id'];
        $email = $this->getPost()['email'];
        $phone = $this->getPost()['phone'];
        $user_id = $zfUser->getId();
        $user_first_name = $zfUser->getInfoItem('first_name');
        $user_last_name = $zfUser->getInfoItem('last_name');
        $city = $zfUser->getCity();

        $store_item = ZFMedoo::get()->get('store', '*',[
            'AND' => [
                'city' => [0, $city],
                'id' => $item_id
            ]
        ]);

        if ($store_item){
            $result = ZFMedoo::get()->insert('store_orders', [
                'item_id' => $item_id,
                'user_id' => $user_id,
                'currency' => $currency,
                'count' => $count,
                'active' => true
            ]);

            if ($result){
                ZFMedoo::get()->update('store', [
                    'count[-]' => $count
                ], [
                    'id' => $item_id
                ]);

                Mail::sendStoreOrderConfirm($email, $user_first_name, $result, $store_item['name'], $count);
                Mail::sendStoreOrderNewNotification($user_id, $user_first_name, $result, $store_item['name'], $count, $email, $phone);

                $result_price = -1;

                switch ($currency){
                    case 1:
                        $result_price = $store_item['balls'] * $count;

                        Rating::takeZelfiStore($user_id, $item_id, $result_price);

                        return $this->redirect('/'.$mainCity['alias'].'/store?modal-message=Ваша заявка принята, мы с Вами свяжемся в ближайшее время. Дальнейшую информацию Вы сможете получить по электронной почте');
                    case 2:
                        $result_price = $store_item['price'] * $count;

                        return $this->redirect('/'.$mainCity['alias'].'/store?modal-message=Ваша заявка принята, мы с Вами свяжемся в ближайшее время. Дальнейшую информацию Вы сможете получить по электронной почте');
                }}
        }

        return $this->redirect('/'.$mainCity['alias'].'/store?modal-message=Ошибка при заказе. Пожалуйста, повторите попытку через некоторое время.');
    }

    public function post_order_remove(){
        /* @var ZFUser $zfUser
         *
         */
        $args = RendererHelper::get()
            ->with($this->request, $args);

        $zfUser = $args[HelperAttributes::APPUSER];

        echo json_encode($this->getPost());
    }
}