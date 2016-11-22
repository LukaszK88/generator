<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 16:15
 */
namespace Generator\Middleware;



class Middleware{

    protected $container;

    public function __construct($container){

        $this->container = $container;
    }

}