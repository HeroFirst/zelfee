<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 02.12.2016
 * Time: 1:34
 */

namespace Zelfi\Modules\Subscription;


use Zelfi\DB\ZFMedoo;

class Subscription
{
    /**
     * @var array|bool
     */
    private $subscription = [];
    private $userId;

    /**
     * Subscription constructor.
     * @param int $user_id
     * @param bool $subscribe
     */
    public function __construct($user_id, $subscribe = true)
    {
        if (!is_null($user_id) && is_numeric($user_id)){
            $this->userId = $user_id;

            $this->subscription = ZFMedoo::get()->get('users_subscribe', '*', [
                'user_id' => $this->userId
            ]);

            if (!$this->subscription){
                $id = ZFMedoo::get()->insert('users_subscribe', [
                    'user_id' => $this->userId,
                    'subscribe' => $subscribe
                ]);

                $this->subscription = ZFMedoo::get()->get('users_subscribe', '*', [
                    'id' => $id
                ]);
            }
        } else  throw new \Exception('user_id is empty');
    }

    /**
     * @return array|bool
     */
    public function getSubscriptionInfo()
    {
        return $this->subscription;
    }

    /**
     * @param array|bool $subscription
     */
    public function setSubscribe($subscribe)
    {
        ZFMedoo::get()->update('users_subscribe', [
            'subscribe' => $subscribe
        ], [
            'user_id' => $this->userId
        ]);

        $this->subscription = ZFMedoo::get()->get('users_subscribe', '*', [
            'user_id' => $this->userId
        ]);
    }

}