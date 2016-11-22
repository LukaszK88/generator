<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 13:44
 */
namespace Generator\Controllers\Auth;

use Generator\Models\User;
use Generator\Controllers\Controller;
use Generator\Validation\InputForms\RegisterUser;

class AuthController extends Controller{

    public function getSignUp($request, $response){
        
        return $this->view->render($response, 'auth/signup.twig');
    }

    public function postSignUp($request, $response){

        $valiation = $this->validator->validate($request,RegisterUser::rules());
     
        if($valiation->fails()){

            return $response->withRedirect($this->router->pathFor('auth.signup'));

        }

        $user = User::create([
            'username'=> $request->getParam('email'),
            'temp_password'=> md5($request->getParam('email')),
            'role'=> 1

        ]);

        return $response->withRedirect($this->router->pathFor('home'));


    }
}