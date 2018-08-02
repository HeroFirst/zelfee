<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 03.11.2016
 * Time: 0:41
 */

namespace Zelfi\Modules\Auth;

use Exception;
use J4k\OAuth2\Client\Provider\User;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\FacebookUser;
use League\OAuth2\Client\Provider\GoogleUser;
use Zelfi\DB\ZFMedoo;
use Zelfi\Enum\SocialTypes;
use Zelfi\Model\SocialUser;

class SocialAuth
{
    var
        $providerVk,
        $providerFb,
        $providerOk,
        $providerMailRu,
        $providerGPlus;

    /**
     * SocialAuth constructor.
     */
    public function __construct(){
        $host = 'http://'.$_SERVER['HTTP_HOST'];

        $this->providerVk = new \J4k\OAuth2\Client\Provider\Vkontakte([
            'clientId'     => '5707294',
            'clientSecret' => '7E5Mxs7k2KtpwD44TyEa',
            'redirectUri'  => $host.'/auth/callback/vk',
            'scopes'       => ['email', 'offline']
        ]);

        $this->providerFb = new \League\OAuth2\Client\Provider\Facebook([
            'clientId'          => '1366228416743416',
            'clientSecret'      => 'fe590fbad1e2dbb059b8fb8954288141',
            'redirectUri'       => $host.'/auth/callback/fb',
            'graphApiVersion'   => 'v2.8',
        ]);

        $this->providerOk = new \Aego\OAuth2\Client\Provider\Odnoklassniki([
            'clientId' => '1234567890',
            'clientPublic' => 'BA57A2DACCE55C0DE',
            'clientSecret' => '5ADC0DE2ADD1C7ED70C0FFEE',
            'redirectUri' => $host.'/auth/callback/ok'
        ]);

        $this->providerMailRu = new \Max107\OAuth2\Client\Provider\Mailru([
            'clientId' => '749682',
            'clientSecret' => 'bba38c56c8eb09468cf09d91906fd86c',
            'redirectUri' => $host
        ]);

        $this->providerGPlus = new \League\OAuth2\Client\Provider\Google([
            'clientId'     => '901662448677-vqod8vkip13ccev7ll4pdes9572tkuk3.apps.googleusercontent.com',
            'clientSecret' => 'C_FXtlbZZHFII1JVGiH_TBwj',
            'redirectUri'  => $host.'/auth/callback/gplus',
            'hostedDomain' => $host
        ]);
    }

    /**
     * @param Integer $socialType
     * @return string
     *
     */
    public function getAuthorizationUrl($socialType){

        switch ($socialType){
            case SocialTypes::VK:
                return $this->providerVk->getAuthorizationUrl();
            case SocialTypes::FB:
                return $this->providerFb->getAuthorizationUrl();
            case SocialTypes::OK:
                return $this->providerOk->getAuthorizationUrl();
            case SocialTypes::MAILRU:
                return $this->providerMailRu->getAuthorizationUrl();
            case SocialTypes::GPLUS:
                return $this->providerGPlus->getAuthorizationUrl();
        }

        return "";
    }

    /**
     * @param $socialType
     * @param $code
     * @return SocialUser
     */
    public function getInfoByCode($socialType, $code){
        $socialUser = new SocialUser();

        switch ($socialType){
            case SocialTypes::VK:
                try {
                    $providerAccessToken = $this->providerVk->getAccessToken('authorization_code', ['code' => $code]);

                    $user_id = $providerAccessToken->getValues()['user_id'];
                    $email = $providerAccessToken->getValues()['email'];
                    $access_token = $providerAccessToken->getToken();
                    $expires = $providerAccessToken->getExpires();

                    /* @var User[] $user */
                    $users = $this->providerVk->usersGet([$user_id]);

                    $first_name = $users[0]->getFirstName();
                    $last_name = $users[0]->getLastName();

                    $socialUser->setSocialType(SocialTypes::VK);
                    $socialUser->setAccessToken($access_token);
                    $socialUser->setExpires($expires);
                    $socialUser->setUserId($user_id);
                    $socialUser->setFirstName($first_name);
                    $socialUser->setLastName($last_name);
                    $socialUser->setEmail($email);
                }
                catch (IdentityProviderException $e) {
                    error_log($e->getMessage());
                }

                return $socialUser;
            case SocialTypes::FB:
                try {
                    $token = $this->providerFb->getAccessToken('authorization_code', [
                        'code' => $_GET['code']
                    ]);

                    /* @var FacebookUser $user*/
                    $user = $this->providerFb->getResourceOwner($token);

                    $access_token = $token->getToken();
                    $expires = $token->getExpires();
                    $user_id = $user->getId();
                    $first_name = $user->getFirstName();
                    $last_name = $user->getLastName();
                    $email = $user->getEmail();

                    $socialUser->setSocialType(SocialTypes::FB);
                    $socialUser->setAccessToken($access_token);
                    $socialUser->setExpires($expires);
                    $socialUser->setUserId($user_id);
                    $socialUser->setFirstName($first_name);
                    $socialUser->setLastName($last_name);
                    $socialUser->setEmail($email);

                }  catch (IdentityProviderException $e) {
                    error_log($e->getMessage());
                }

                return $socialUser;
            case SocialTypes::GPLUS:
                try {
                    $token = $this->providerGPlus->getAccessToken('authorization_code', [
                        'code' => $_GET['code']
                    ]);

                    /* @var GoogleUser $user */
                    $user = $this->providerGPlus->getResourceOwner($token);

                    $access_token = $token->getToken();
                    $expires = $token->getExpires();
                    $user_id = $user->getId();
                    $first_name = $user->getFirstName();
                    $last_name = $user->getLastName();
                    $email = $user->getEmail();

                    $socialUser->setSocialType(SocialTypes::GPLUS);
                    $socialUser->setAccessToken($access_token);
                    $socialUser->setExpires($expires);
                    $socialUser->setUserId($user_id);
                    $socialUser->setFirstName($first_name);
                    $socialUser->setLastName($last_name);
                    $socialUser->setEmail($email);

                } catch (Exception $e) {
                    error_log($e->getMessage());
                }

                return $socialUser;
        }

        return null;
    }

    /**
     * @param Integer $socialType
     * @return string
     *
     */
    public function getState($socialType){
        switch ($socialType){
            case SocialTypes::VK:
                return $this->providerVk->getState();
            case SocialTypes::FB:
                return $this->providerFb->getState();
            case SocialTypes::OK:
                return $this->providerOk->getState();
            case SocialTypes::MAILRU:
                return $this->providerMailRu->getState();
            case SocialTypes::GPLUS:
                return $this->providerGPlus->getState();
        }

        return null;
    }

    /**
     * @param int $socialId
     * @param int $socialType
     * @return bool|array
     */
    public function dbFindSocialToken($socialId, $socialType){
        return ZFMedoo::get()->get('social_tokens', '*', [
            'AND' => [
                'social_user_id' => $socialId,
                'social_type' => $socialType
            ]
        ]);
    }
}

