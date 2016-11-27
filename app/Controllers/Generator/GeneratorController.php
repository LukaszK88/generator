<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 10:33
 */
namespace Generator\Controllers\Generator;

use Slim\Views\Twig as View;
use Generator\Controllers\Controller;

class GeneratorController extends Controller{


    public function index($request,$response){
        
        
        return $this->view->render($response, 'generator/index.twig');
    }

    public function getLevel($request,$response,$part){

       

        return $this->view->render($response, 'generator/level.twig',[
            'part'=> $part
        ]);
    }

    public function getEquipment($request,$response,$part){


        return $this->view->render($response, 'generator/equipment.twig',[
            'part'=> $part,
        ]);
    }
}