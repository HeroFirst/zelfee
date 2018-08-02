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
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Subscription\Subscription;
use Zelfi\Utils\Cookies;

class AuthSocialController extends Controller
{
    /* @var SocialAuth $socialAuth
     * @var SimpleAuth $simpleAuth
     */
    private $socialAuth, $simpleAuth;

    public function __construct(\Slim\App $app)
    {
        $this->socialAuth = new SocialAuth();
        $this->simpleAuth = new SimpleAuth();

        parent::__construct($app);
    }

    public function logout(){
        $redirect = $this->getQueryParams()['redirect'];

        $this->simpleAuth->clearAuth($this->response);

        return $this->redirect($redirect ? $redirect : '/');
    }

    public function authEmail(){
        $redirect = $this->getQueryParams()['redirect'];

        $email = $this->getPost()['email'];
        $password = $this->getPost()['password'];

        $user = $this->simpleAuth->auth($email, $password);

        if ($user){
            $this->simpleAuth->setAuth($this->response, new ZFUser($user));

            return $this->redirect($redirect ? $redirect : '/');
        } else {
            return $this->redirect('/?modal-message=Пользователь не найден');
        }
    }

    public function authVk(){

        $authUrl = $this->socialAuth->getAuthorizationUrl(SocialTypes::VK);
        $state = $this->socialAuth->getState(SocialTypes::VK);

        Cookies::set($this->response, Cookies::COOKIE_OAUTH2STATE, $state);

        $redirect = $this->getQueryParams()['redirect'];
        if ($redirect){
            Cookies::set($this->response, Cookies::COOKIE_OAUTH2REDIRECT, $redirect);
        }

        return $this->redirect($authUrl);
   }

   public function callbackVk(){
       $this->checkState();

       $redirectUrl = Cookies::get($this->request, Cookies::COOKIE_OAUTH2REDIRECT);
       Cookies::set($this->response, Cookies::COOKIE_OAUTH2REDIRECT, null);

       $socialUser = $this->socialAuth->getInfoByCode(SocialTypes::VK, $_GET['code']);

       $socialToken = $this->socialAuth->dbFindSocialToken($socialUser->getUserId(), SocialTypes::VK);

       $user = array();

       if (!$socialToken){
           if (Cookies::get($this->request, Cookies::COOKIE_APP_AUTH_SESSION) !== ''){
               $user = $this->simpleAuth->getUserByHash(Cookies::get($this->request, Cookies::COOKIE_APP_AUTH_SESSION));

               if ($user['id']){
                   $user_id = $user['id'];
               } else {
                   $user_id = $this->simpleAuth->register($socialUser->getFirstName(), $socialUser->getLastName(), $socialUser->getEmail());
                   $user = $this->simpleAuth->getUserById($user_id);
                   $subscription = new Subscription($user_id, true);
               }
           } else {
               $user_id = $this->simpleAuth->register($socialUser->getFirstName(), $socialUser->getLastName(), $socialUser->getEmail());
               $user = $this->simpleAuth->getUserById($user_id);
               $subscription = new Subscription($user_id, true);
           }

           if ($user_id) $this->updateSocialToken($user_id, $socialUser);
       } else {
           $this->updateSocialToken($socialToken['user_id'], $socialUser);

           $user = $this->simpleAuth->getUserById($socialToken['user_id']);
       }

       if ($user && $user['hash']){
           $this->simpleAuth->setAuth($this->response, new ZFUser($user));
       }

       return $this->redirect($user['active'] ? ($redirectUrl ? $redirectUrl : '/') : '/register/step/2');
   }

    public function authFb(){
        $authUrl = $this->socialAuth->getAuthorizationUrl(SocialTypes::FB);
        $state = $this->socialAuth->getState(SocialTypes::FB);

        Cookies::set($this->response, Cookies::COOKIE_OAUTH2STATE, $state);

        $redirect = $this->getQueryParams()['redirect'];
        if ($redirect){
            Cookies::set($this->response, Cookies::COOKIE_OAUTH2REDIRECT, $redirect);
        }

        return $this->redirect($authUrl);
    }

    public function callbackFb(){
        $this->checkState();

        $redirectUrl = Cookies::get($this->request, Cookies::COOKIE_OAUTH2REDIRECT);
        Cookies::set($this->response, Cookies::COOKIE_OAUTH2REDIRECT, null);

        $socialUser = $this->socialAuth->getInfoByCode(SocialTypes::FB, $_GET['code']);

        $socialToken = $this->socialAuth->dbFindSocialToken($socialUser->getUserId(), SocialTypes::FB);

        if (!$socialToken){
            if (Cookies::get($this->request, Cookies::COOKIE_APP_AUTH_SESSION) !== ''){
                $user = $this->simpleAuth->getUserByHash(Cookies::get($this->request, Cookies::COOKIE_APP_AUTH_SESSION));

                if ($user['id']){
                    $user_id = $user['id'];
                } else {
                    $user_id = $this->simpleAuth->register($socialUser->getFirstName(), $socialUser->getLastName(), $socialUser->getEmail());
                    $user = $this->simpleAuth->getUserById($user_id);
                    $subscription = new Subscription($user_id, true);
                }
            } else {
                $user_id = $this->simpleAuth->register($socialUser->getFirstName(), $socialUser->getLastName(), $socialUser->getEmail());
                $user = $this->simpleAuth->getUserById($user_id);
                $subscription = new Subscription($user_id, true);
            }

            if ($user_id) $this->updateSocialToken($user_id, $socialUser);
        } else {
            $this->updateSocialToken($socialToken['user_id'], $socialUser);

            $user = $this->simpleAuth->getUserById($socialToken['user_id']);
        }

        if ($user && $user['hash']){
            $this->simpleAuth->setAuth($this->response, new ZFUser($user));
        }

        return $this->redirect($user['active'] ? ($redirectUrl ? $redirectUrl : '/') : '/register/step/2');
    }

    public function authOk(){
        $this->socialAuth->getAuthorizationUrl(SocialTypes::OK);
    }

    public function authMailRu(){
        $this->socialAuth->getAuthorizationUrl(SocialTypes::MAILRU);
    }

    public function authGPlus(){
        $authUrl = $this->socialAuth->getAuthorizationUrl(SocialTypes::GPLUS);
        $state = $this->socialAuth->getState(SocialTypes::GPLUS);

        Cookies::set($this->response, Cookies::COOKIE_OAUTH2STATE, $state);

        $redirect = $this->getQueryParams()['redirect'];
        if ($redirect){
            Cookies::set($this->response, Cookies::COOKIE_OAUTH2REDIRECT, $redirect);
        }

        return $this->redirect($authUrl);
    }

    public function callbackGPlus(){
        $this->checkState();

        $redirectUrl = Cookies::get($this->request, Cookies::COOKIE_OAUTH2REDIRECT);
        Cookies::set($this->response, Cookies::COOKIE_OAUTH2REDIRECT, null);

        $socialUser = $this->socialAuth->getInfoByCode(SocialTypes::GPLUS, $_GET['code']);

        $socialToken = $this->socialAuth->dbFindSocialToken($socialUser->getUserId(), SocialTypes::GPLUS);

        if (!$socialToken){
            if (Cookies::get($this->request, Cookies::COOKIE_APP_AUTH_SESSION) !== ''){
                $user = $this->simpleAuth->getUserByHash(Cookies::get($this->request, Cookies::COOKIE_APP_AUTH_SESSION));

                if ($user['id']){
                    $user_id = $user['id'];
                } else {
                    $user_id = $this->simpleAuth->register($socialUser->getFirstName(), $socialUser->getLastName(), $socialUser->getEmail());
                    $user = $this->simpleAuth->getUserById($user_id);
                    $subscription = new Subscription($user_id, true);
                }
            } else {
                $user_id = $this->simpleAuth->register($socialUser->getFirstName(), $socialUser->getLastName(), $socialUser->getEmail());
                $user = $this->simpleAuth->getUserById($user_id);
                $subscription = new Subscription($user_id, true);
            }

            if ($user_id) $this->updateSocialToken($user_id, $socialUser);
        } else {
            $this->updateSocialToken($socialToken['user_id'], $socialUser);

            $user = $this->simpleAuth->getUserById($socialToken['user_id']);
        }

        if ($user && $user['hash']){
            $this->simpleAuth->setAuth($this->response, new ZFUser($user));
        }

        return $this->redirect($user['active'] ? ($redirectUrl ? $redirectUrl : '/') : '/register/step/2');
    }

    public function callbackDigits(){
        $headers = array(
            'Authorization' => $this->getQueryParams()['authHeader']
        );
        $request = Requests::get($this->getQueryParams()['apiUrl'], $headers);

        return $this->response->withJson($request->body);
    }

    public function checkState(){
        $state_get = $this->request->getQueryParam('state');
        $state_cookie = Cookies::get($this->request, Cookies::COOKIE_OAUTH2STATE);

        if ($state_cookie !== $state_get){
            throw new \RuntimeException('Invalid state: '.$state_get.' !=='.$state_cookie);
        }
    }

    /**
     * @param int $userId
     * @param SocialUser $socialUser
     */
    public function updateSocialToken($userId, SocialUser $socialUser){

        if (ZFMedoo::get()
            ->has('social_tokens', [
                'AND' => [
                    'social_user_id' => $socialUser->getUserId(),
                    'social_type' => $socialUser->getSocialType()
                ]
            ])){
            ZFMedoo::get()
                ->update('social_tokens', [
                    'user_id' => $userId,
                    'social_access_token' => $socialUser->getAccessToken(),
                    'social_expires' => $socialUser->getExpires()
                ], [
                    'AND' => [
                        'social_user_id' => $socialUser->getUserId(),
                        'social_type' => $socialUser->getSocialType()
                    ]
                ]);
        } else {
            ZFMedoo::get()
                ->insert('social_tokens', [
                    'user_id' => $userId,
                    'social_access_token' => $socialUser->getAccessToken(),
                    'social_expires' => $socialUser->getExpires(),
                    'social_user_id' => $socialUser->getUserId(),
                    'social_type' => $socialUser->getSocialType()
                ]);
        }
    }
}