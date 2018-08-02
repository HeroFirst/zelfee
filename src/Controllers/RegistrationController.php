<?php

namespace Zelfi\Controllers;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MartynBiz\Slim3Controller\Controller;
use Psr\Http\Message\RequestInterface;
use Zelfi\Modules\Auth\SimpleAuth;
use Zelfi\Modules\Auth\SocialAuth;
use Zelfi\DB\Medoo;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\HelperAttributes;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Modules\Subscription\Subscription;
use Zelfi\Utils\Cookies;

class RegistrationController extends Controller
{

    public function registrationStepOne(){
        $first_name = $this->getPost()['first_name'];
        $last_name = $this->getPost()['last_name'];
        $email = $this->getPost()['email'];
        $password = $this->getPost()['password'];
        $password_check = $this->getPost()['password_check'];
        $agree_subscription = $this->getPost()['agree_subscription'];
        $agree_license = $this->getPost()['agree_license'];

        if (!is_null($agree_license)){
            if ($password == $password_check){
                $passwordCheckErrors = SimpleAuth::checkPassword($password);
                if ($passwordCheckErrors) return $this->redirect('/register?modal-message='.$passwordCheckErrors);

                $simpleAuth = new SimpleAuth();

                $user_id = $simpleAuth->register($first_name, $last_name, $email, $password);

                if ($user_id){
                    $user = $simpleAuth->getUserById($user_id);

                    if ($user && $user['hash']){
                        $subscription = new Subscription($user_id);
                        $subscription->setSubscribe(!is_null($agree_subscription));

                        $simpleAuth->setAuth($this->response, new ZFUser($user));
                    } else return $this->redirect('/register?modal-message=Ошибка при регистрации');
                } else return $this->redirect('/register?modal-message=Ошибка при регистрации: такой email уже существует');
            } else return $this->redirect('/register?modal-message=Пароли должны совпадать');
        } else return $this->redirect('/register?modal-message=Вы не согласились с правилами и условиями соглашения');

        return $this->redirect((strlen($user['phone'])>0) ? '/' : '/register/step/2');
    }

    public function registrationStepTwo(){
        $residence = $this->getPost()['residence'];
        $phone = $this->getPost()['phone'];
        $kids = $this->getPost()['kids'];

        if ($residence && $phone){
            $simpleAuth = new SimpleAuth();
            /* @var ZFUser $user */
            $user = $this->request->getAttribute(HelperAttributes::APPUSER);
            $simpleAuth->updateInfo($user->getInfoItem('id'), [
                'residence' => $residence,
                'phone' => $phone,
                'active' => true
            ]);

            if (!is_null($kids) && count($kids)>0){
                foreach ($kids as $index => $item){
                    $gender = $item['gender'];
                    $first_name = $item['first_name'];
                    $age = $item['age'];

                    ZFMedoo::get()->insert('users_childs', [
                        'gender' => $gender,
                        'first_name' => $first_name,
                        'age' => $age,
                        'parent_user_id' => $user->getInfoItem('id')
                    ]);
                }
            }

            Rating::addBallsRegistration($user->getInfoItem('id'));
        }

        return $this->redirect('/');
    }
}