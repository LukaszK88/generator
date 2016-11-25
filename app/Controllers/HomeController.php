<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 10:33
 */
namespace Generator\Controllers;

use Slim\Views\Twig as View;

class HomeController extends Controller{


    public function index($request,$response){
        
         
        return $this->view->render($response, 'home.twig');
    }
}