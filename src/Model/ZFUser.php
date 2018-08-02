<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 07.11.2016
 * Time: 1:22
 */

namespace Zelfi\Model;


use Zelfi\DB\ZFMedoo;

class ZFUser{
    /* @var array */
    var $info;

    /**
     * ZFUser constructor.
     * @param array $info
     */
    public function __construct(array $info)
    {
        $this->info = $info;
    }


    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    public function getInfoItem($key)
    {
        return $this->info[$key];
    }

    /**
     * @param array $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return int
     */
    public function getRole(){
        return ($this->getInfo()['role']) ? $this->getInfo()['role'] : 6;
    }

    public function getResidence(){
        return ($this->getInfo()['residence']) ? $this->getInfo()['residence'] : 1;
    }

    public function getCity(){
        return ($this->getInfo()['city']) ? $this->getInfo()['city'] : 1;
    }

    public function getActive()
    {
        return ($this->getInfo()['active']) ? $this->getInfo()['active'] : false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getInfo()['id'];
    }
    
    public function getTeamId()
    {
        return ZFMedoo::get()->get('teams_users', 'team_id', [
            'user_id' => $this->getId() 
        ]);
    }
}