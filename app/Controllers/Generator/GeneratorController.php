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


    public function index($request,$response,$part){



       
        if(!empty($part['level'])) {
            if ($part['level'] == 'easy') {
                $level = 3;
            }
            if ($part['level'] == 'medium') {
                $level = 4;
            }
            if ($part['level'] == 'hard') {
                $level = 5;
            }

            $levelId = $this->levels->getLevelId($part['level']);
        }

        if(!empty($part['equipment'])) {
            $equipmentArray = explode('/', $part['equipment']);


            $sql = DB::table($part['part']);
            foreach ($equipmentArray as $equipment) {
                $sql->orWhere($equipment, '=', 1)->where('level_id',$levelId->id);
            }
            $workout = $sql->inRandomOrder()->limit($level)->get();

        }else{
            $workout='';
        }


        return $this->view->render($response, 'generator/index.twig',[
            'part'=> $part,
            'workout' => $workout
        ]);
    }

    public function postEquipment($request,$response,$part)
    {

        $validation = $this->validator->validate($request, [
            'equipment' => v::notEmpty()
        ]);

        if (!empty($part['aim'])) {
            if ($validation->fails()) {

                return $response->withRedirect($this->router->pathFor('generator', ['part' => $part['part'],'aim'=>$part['aim'], 'level' => $part['level']]));
            }

            $equipment = implode('/', $request->getParam('equipment'));

            return $response->withRedirect($this->router->pathFor('generator', ['part' => $part['part'],'aim'=>$part['aim'],  'level' => $part['level'], 'equipment' => $equipment]));
        } else {


            if ($validation->fails()) {

                return $response->withRedirect($this->router->pathFor('generator.level', ['part' => $part['part'], 'level' => $part['level']]));
            }

            $equipment = implode('/', $request->getParam('equipment'));

            return $response->withRedirect($this->router->pathFor('generator.level', ['part' => $part['part'], 'level' => $part['level'], 'equipment' => $equipment]));
        }
    }
}