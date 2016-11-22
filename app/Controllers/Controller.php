<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 11:27
 */

namespace Generator\Controllers;

class Controller{

    protected $container;

    public function __construct($container){

        $this->container = $container;

    }
    
    public function __get($property){
        
        if($this->container->{$property}){
            return $this->container->{$property};
        }
    }
}