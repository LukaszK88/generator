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
    
    public function getSignOut($request, $response){

        $this->auth->logOut();

        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignIn($request, $response){

        return $this->view->render($response, 'auth/signin.twig');
    }

    public function postSignIn($request, $response){

        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if(!$auth){
            $this->flash->addMessage('error','Could not sign you in, wrong details');
          return  $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        if($this->auth->user()->temp_password){
            $this->flash->addMessage('success','You have logged in for the first time, change your temporary password');
            return  $response->withRedirect($this->router->pathFor('auth.password.change'));
        }

       return $response->withRedirect($this->router->pathFor('home'));

    }

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

        $this->flash->addMessage('success','You have registered, we have sent you temporary password');

        return $response->withRedirect($this->router->pathFor('home'));


    }
}