<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/21/18
 * Time: 2:36 AM
 */

namespace App\Traits;

trait MagicSetTrait
{
    protected $data;

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }


    public function __get($name)
    {
        return $this->data[$name];
    }


    public function __isset($name)
    {
        return isset($this->data[$name]);
    }


    public function __unset($name)
    {
        unset($this->data[$name]);
    }


    public function getData()
    {
        return $this->data;
    }
}