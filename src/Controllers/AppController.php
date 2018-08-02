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

class AppController extends Controller
{

    public function feedback(){
        $name = $this->getPost()['name'];
        $email = $this->getPost()['email'];
        $topic = $this->getPost()['topic'];
        $text = $this->getPost()['text'];
        $redirect = $this->getPost()['redirect'];

        if ($name && $email && $topic && $text){
            $mail = new PHPMailer;

            $mail->setFrom('no-reply@zelfi.ru', 'Зеленый фитнес');
            $mail->addAddress('promo.zf@gmail.com');
            $mail->isHTML(true);
            $mail->Subject = 'Зеленый фитнес - Форма обратной связи: '.$topic;
            $mail->Body    =
                'Пользователь:'.$name.'<br />'
                .'E-mail:'.$email.'<br /><br />'
                .$text;
            $mail->CharSet = 'utf-8';

            $mail->send();
        }

        return $this->redirect(($redirect ? $redirect : '/'));
    }

    public function authorizeMember(){

        if ($this->getQueryParams()['hash'] != $this->SALT) return $this->response->withJson(['error'=>['code'=>300, 'message' => 'WHERE HASH??']]);

        $result = [
            'result' => true
        ];

        return $this->response->withJson($result);
    }

}