<?php

namespace Zelfi\Modules\Mail;

use \DrewM\MailChimp\MailChimp;
use \DrewM\MailChimp\Batch;
use Zelfi\DB\ZFMedoo;

class MailChimpHelper
{
    var $apiKey = "324118d2bbdf287ce96fb56e74af6e5a-us14";
    var $listId = "478961066c";

    public function sync($batch_id = null){
        $MailChimp = new MailChimp($this->apiKey);
        $Batch     = $MailChimp->new_batch();

        if ($batch_id != null){
            $MailChimp->new_batch($batch_id);
            $result = $Batch->check_status();

            echo json_encode($result);
        } else {
            $users = ZFMedoo::get()->select(
                'users',
                [
                    '[>]users_subscribe' => [
                        'id' => 'user_id'
                    ]
                ],
                [
                    'users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.email',
                    'users_subscribe.subscribe'
                ],
                [
                    'AND' => [
                        'users.email[!]' => '',
                        'users.active' => true,
                        'users_subscribe.subscribe[!]' => null
                    ]
                ]
            );

            foreach ($users as $index => $user) {
                $subscriber_hash = $MailChimp->subscriberHash($user['email']);

                $Batch->post("op_post".$index, "lists/$this->listId/members", [
                    'email_address' => $user['email'],
                    'merge_fields' => ['FNAME'=>$user['first_name'], 'LNAME'=>$user['last_name']],
                    'status'        => $user['subscribe'] == 1 ? 'subscribed' : 'unsubscribed',
                ]);

                $Batch->patch("op_patch".$index, "lists/$this->listId/members/$subscriber_hash", [
                    'email_address' => $user['email'],
                    'merge_fields' => ['FNAME'=>$user['first_name'], 'LNAME'=>$user['last_name']],
                    'status'        => $user['subscribe'] == 1 ? 'subscribed' : 'unsubscribed',
                ]);
            }

            $result = $Batch->execute();

            echo json_encode($result);
        }
    }
}