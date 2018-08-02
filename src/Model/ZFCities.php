<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 11.11.2016
 * Time: 15:55
 */

namespace Zelfi\Model;


class ZFCities
{
    /**
     * @var array $cities
     */
    var $cities;

    public function __construct($cities)
    {
        $this->cities = $cities;
    }


    /**
     * @return array
     */
    public function getCities(): array
    {
        return $this->cities;
    }

    /**
     * @param array $cities
     */
    public function setCities(array $cities)
    {
        $this->cities = $cities;
    }

    /**
     * @param $id
     * @return array|null
     */
    public function getCityById($id){
        foreach ($this->getCities() as $city){
            if ($city['id'] === $id) return $city;
        }

        return null;
    }

}