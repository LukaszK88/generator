<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 16:18
 */

namespace Generator\Middleware;

class OldInputMiddleware extends Middleware{

    public function __invoke($request, $response, $next){

            $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);

        $_SESSION['old'] = $request->getParams();

        $response = $next($request,$response);

        return $response;
    }
}