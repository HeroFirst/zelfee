<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 06.11.2016
 * Time: 18:50
 */

namespace Zelfi\Modules\Auth;

use PHPMailer\PHPMailer\PHPMailer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zelfi\Config\Config;
use Zelfi\DB\ZFMedoo;
use Zelfi\Model\ZFUser;
use Zelfi\Modules\Mail\Mail;
use Zelfi\Modules\Rating\Rating;
use Zelfi\Utils\Cookies;

class SimpleAuth
{

    public static function checkPassword($pwd) {
        $errors = [];

        if (strlen($pwd) < 8) {
            $errors[] = "Длина пароля меньше 8.";
        }

        if (!preg_match("#[0-9]+#", $pwd)) {
            $errors[] = "Пароль должен содержать как минимум одну цифру.";
        }

        if (!preg_match("#[a-zA-Z]+#", $pwd)) {
            $errors[] = "Пароль должен содержать как минимум одну латинскую букву.";
        }

        return count($errors) > 0 ? implode(' ', $errors) : false;
    }

    public static function getUserById($id){
        return ZFMedoo::get()->get('users', '*', ['id' => $id]);
    }

    public static function getUserByEmail($email){
        return ZFMedoo::get()->get('users', '*', ['email' => $email]);
    }

    public function getUserDeveloper(){
        ZFMedoo::get()->update('users',[
            'is_developer' => true
        ], [
            'id' => 1
        ]);

        return ZFMedoo::get()->get('users', '*', ['id' => 1]);
    }

    /**
     * @param $email
     * @param $password
     * @return bool|array
     */
    public function auth($email, $password){
        return ZFMedoo::get()->get('users', '*', [
            'AND' => [
                'email' => $email,
                'password' => md5($password)
            ]
        ]);
    }

    public function isHasUserWithId($id){
        return ZFMedoo::get()->has('users', ['id' => $id]);
    }

    public function register($firstName, $lastName, $email = '', $password = null, $phone = '', $residence = 1, $description = '', $role = 5, $active = false){
        if (ZFMedoo::get()->count('users')==0){
            $role = 1;
        }

        if ($password == null){
            $password = $this->generateRandomString(10);
        }

        if ($email == '' || !ZFMedoo::get()->has('users', [
            'email' => $email
        ])){

            $result = ZFMedoo::get()->insert('users', [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => md5($password),
                'hash' => md5($firstName.$lastName.time().Config::SALT),
                'city' => 1,
                'residence' => $residence,
                'phone' => $phone,
                'description' => $description,
                'role' => $role,
                'active' => $active
            ]);
        } else {
            $result = false;
        }

        if ($result > 0){
            Rating::initialize($result);

            if ($email != ''){
                Mail::sendRegistrationData($email, $firstName, $password);
            }
        }

        return $result;
    }

    public function update($id, $firstName, $lastName, $email, $password, $phone = ' ', $residence, $description, $role){
        Rating::initialize($id);

        $params = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone
        ];

        if (!is_null($password)){
            $params['password'] = $password;
        }

        if (!is_null($residence)){
            $params['residence'] = $residence;
        }

        if (!is_null($description)){
            $params['description'] = $description;
        }

        if (!is_null($role)){
            $params['role'] = $role;
        }

        return ZFMedoo::get()->update('users', $params, [
            'id' => $id
        ]);
    }

    public function updateInfo($id, array $values){
        return ZFMedoo::get()->update('users', $values, [
            'id' => $id
        ]);
    }

    public function getUserByHash($hash){
        return ZFMedoo::get()->get('users', '*', [
            'hash' => $hash
        ]);
    }

    public function getUserByRFDID($rfidid)
    {
        $userId = ZFMedoo::get()->get('users_rfidids', 'user_id', [
            'rfidid' => $rfidid
        ]);

        if ($userId){
            return ZFMedoo::get()->get('users', '*', [
                'id' => $userId
            ]);
        }

        return false;
    }

    public function setCity(ResponseInterface &$response, $city, $hash){
        Cookies::set($response, Cookies::COOKIE_APP_AUTH_CITY, $city);

        if ($hash !== ''){
            ZFMedoo::get()->update('users', ['city'=>$city], ['hash'=>$hash]);
        }
    }

    public function setAuth(ResponseInterface &$response, ZFUser $user){
        Cookies::set($response, Cookies::COOKIE_APP_AUTH_SESSION, $user->getInfoItem('hash'));
        Cookies::set($response, Cookies::COOKIE_APP_AUTH_CITY, $user->getInfoItem('city'));

    }

    public function clearAuth(ResponseInterface &$response){
        Cookies::set($response, Cookies::COOKIE_APP_AUTH_SESSION, null);
        Cookies::set($response, Cookies::COOKIE_APP_AUTH_CITY, null);
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function setRFDID($user_id, $rfidid)
    {
        if (!ZFMedoo::get()->has('users_rfidids', [
            'user_id' => $user_id
        ])){
            if (!ZFMedoo::get()->has('users_rfidids', [
                'rfidid' => $rfidid
            ])){
            ZFMedoo::get()->insert('users_rfidids', [
                'user_id' => $user_id,
                'rfidid' => $rfidid
            ]);
            }
        } else {
            ZFMedoo::get()->update('users_rfidids', [
                'rfidid' => $rfidid
            ], [
                'user_id' => $user_id
            ]);
        }
    }

    /**
     * @param $user_id
     * @return bool
     */
    public function reset($user_id)
    {
        Rating::initialize($user_id);

        $user = ZFMedoo::get()->get('users', '*', [
            'id' => $user_id
        ]);

        if ($user){
            $password = $this->generateRandomString(10);

            $update_result = ZFMedoo::get()->update('users', [
                'password' => md5($password)
            ], [
                'id' => $user_id
            ]);

            if ($update_result){
                if ($user['email'] != ''){
                    return Mail::sendRegistrationData($user['email'], $user['first_name'], $password);
                }
            }
        }

        return false;
    }
}