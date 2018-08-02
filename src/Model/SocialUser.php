<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 06.11.2016
 * Time: 3:46
 */

namespace Zelfi\Model;


use Zelfi\Enum\SocialTypes;

class SocialUser
{
    private $social_type,
        $user_id,
        $access_token,
        $expires,
        $email,
        $first_name,
        $last_name;

    /**
     * @return mixed
     */
    public function getSocialType()
    {
        return $this->social_type;
    }

    /**
     * @param mixed $social_type
     */
    public function setSocialType($social_type)
    {
        $this->social_type = $social_type;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param mixed $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return mixed
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param mixed $expires
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

}