<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 10:33
 */
namespace Generator\Controllers\Generator;

use Generator\Models\Core;
use Generator\Models\User;
use Slim\Views\Twig as View;
use Generator\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Database\Capsule\Manager as DB;


class GeneratorController extends Controller{
    
    public $reps = '';


    public function index($request,$response,$param){



       
        if(!empty($param['level'])) {
            if ($param['level'] == 'easy') {
                $limit = 4;
            }
            if ($param['level'] == 'medium') {
                $limit = 5;
            }
            if ($param['level'] == 'hard') {
                $limit = 6;
            }


        }

        if(!empty($param['equipment'])) {
            $equipmentArray = explode('/', $param['equipment']);


            $sql = DB::table($param['part']);
            foreach ($equipmentArray as $equipment) {
                $sql->orWhere($equipment, '=', 1);
            }
            $workout = $sql->inRandomOrder()->limit($limit)->get()->sortBy('type_id');

        }else{
            $workout='';
        }
        


        return $this->view->render($response, 'generator/index.twig',[
            'param'=> $param,
            'workout' => $workout,
            'reps' =>$this->reps
        ]);
    }

    public function postEquipment($request,$response,$param)
    {

        $validation = $this->validator->validate($request, [
            'equipment' => v::notEmpty()
        ]);

        if (!empty($param['aim'])) {
            if ($validation->fails()) {

                return $response->withRedirect($this->router->pathFor('generator', ['part' => $param['part'],'aim'=>$param['aim'], 'level' => $param['level']]));
            }

            $equipment = implode('/', $request->getParam('equipment'));

            return $response->withRedirect($this->router->pathFor('generator', ['part' => $param['part'],'aim'=>$param['aim'],  'level' => $param['level'], 'equipment' => $equipment]));
        } else {


            if ($validation->fails()) {

                return $response->withRedirect($this->router->pathFor('generator.level', ['part' => $param['part'], 'level' => $param['level']]));
            }

            $equipment = implode('/', $request->getParam('equipment'));

            return $response->withRedirect($this->router->pathFor('generator.level', ['part' => $param['part'], 'level' => $param['level'], 'equipment' => $equipment]));
        }
    }
}