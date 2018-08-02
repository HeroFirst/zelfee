<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 03.11.2016
 * Time: 0:59
 */

namespace Zelfi\Utils;

abstract class Enum {

    static public function __callStatic($name, $arguments){
        return new static(constant(get_called_class() . '::' . $name)); // не нужно проверять, php сам кинет ошибку.
    }

    private $current_val;

    private function __construct($value) {
        $this->current_val = $value;
    }

    final public function __toString() {
        return $this->current_val;
    }
}