<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 16:18
 */

namespace Generator\Middleware;

class CsrfViewMiddleware extends Middleware{

    public function __invoke($request, $response, $next){

        $this->container->view->getEnvironment()->addGlobal('csrf',[
        'field'=>'
        <input type="hidden" name="'.$this->container->csrf->getTokenNameKey().'" 
        value="'.$this->container->csrf->getTokenName().'">
                <input type="hidden" name="'.$this->container->csrf->getTokenValueKey().'"
                 value="'.$this->container->csrf->getTokenValue().'">
        '

        ]);

        $response = $next($request,$response);

        return $response;
    }
}