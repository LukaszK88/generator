<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 16:18
 */

namespace Generator\Middleware;

class ValidationErrorsMiddleware extends Middleware{

    public function __invoke($request, $response, $next){

        if(!empty($_SESSION['errors'])) {
            $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

            unset($_SESSION['errors']);

        }



        $response = $next($request,$response);

        return $response;
    }
}