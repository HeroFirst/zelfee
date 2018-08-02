<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use DrewM\MailChimp\Webhook;
use MartynBiz\Slim3Controller\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use Requests;
use Zelfi\Config\Config;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Modules\Auth\SocialAuth;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Mail\MailChimpHelper;
use Zelfi\Modules\Subscription\Subscription;
use Zelfi\Utils\Cookies;
use Zelfi\Utils\ProductionHelper;
use Zelfi\Utils\RendererHelper;

class ServicesController extends Controller
{

    public function get_test(){
        echo 'version code: '.Config::CURRENT_VERSION_CODE;

        return $this->response;
    }

    public function mailchimpWebhook(){

        Webhook::subscribe('subscribe', function($data){
            $email = $data['email'];
            $user = SimpleAuth::getUserByEmail($email);

            if ($user){
                $subscription = new Subscription($user['id']);
                $subscription->setSubscribe(true);
            }
        });

        Webhook::subscribe('unsubscribe', function($data){
            $email = $data['email'];
            $user = SimpleAuth::getUserByEmail($email);

            if ($user){
                $subscription = new Subscription($user['id']);
                $subscription->setSubscribe(false);
            }
        });

        return $this->response;
    }

    public function mailChimpSync(){
        $mailchimp = new MailChimpHelper();
        $mailchimp->sync($this->getQueryParams()['batch_id']);
    }

    public function gitPull(){
        $site_folder = null;
        $git_brach = null;

        switch (ProductionHelper::getServerType()){
            case 0:
                $site_folder = 'zelfiru';
                $git_brach = 'master';
                break;
            case 1:
                $site_folder = 'betazelfiru';
                $git_brach = 'dev';
                break;
        }

        echo 'START PULL: ';

        if (!is_null($site_folder) && !is_null($git_brach)){
            $exec_command = 'cd /var/www/'.$site_folder.'/ && git reset --hard HEAD && git pull https://FreelanceIsMyChance:slavabogkoda228@bitbucket.org/zelfi-ru/zelfi.ru.git '.$git_brach.'';
            $result = shell_exec($exec_command.' 2>&1');

            echo $result;
        }

        return $this->response;
    }
}