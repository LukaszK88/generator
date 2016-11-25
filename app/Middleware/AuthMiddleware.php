<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 25/11/2016
 * Time: 11:12
 */
namespace Generator\Middleware;

class AuthMiddleware extends Middleware{

    public function __invoke($request, $response, $next){

        if(!$this->container->auth->check()){
            $this->container->flash->addMessage('error','Please sign in before doing that');
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }

        $response = $next($request,$response);

        return $response;
    }
}