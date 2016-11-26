<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 25/11/2016
 * Time: 08:47
 */
namespace Generator\Controllers\Auth;

use Generator\Models\User;
use Generator\Controllers\Controller;

use Respect\Validation\Validator as v;

class PasswordController extends Controller{

    public function getChangePassword($request, $response){
        
        return $this->view->render($response , 'auth/password/change.twig');
    }

    public function postChangePassword($request, $response){

        if($this->auth->user()->password) {
            $validation = $this->validator->validate($request, [
                'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->auth->user()->temp_password, $this->auth->user()->password),
                'password' => v::noWhitespace()->notEmpty()->alnum(),
                'password_again' => v::noWhitespace()->notEmpty()->matchesPasswordConfirmation($request->getParam('password_again'), $request->getParam('password'))
            ]);
        }else{
            $validation = $this->validator->validate($request, [
                'password' => v::noWhitespace()->notEmpty()->alnum(),
                'password_again' => v::noWhitespace()->notEmpty()->matchesPasswordConfirmation($request->getParam('password_again'), $request->getParam('password'))
            ]);
        }
        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('auth.password.change'));
        }
        
        $this->auth->user()->setPassword($request->getParam('password'));

        $this->flash->addMessage('success','You have updated your password');

        return $response->withRedirect($this->router->pathFor('home'));

    }
    
    public function getForgotPassword($request, $response){

        return $this->view->render($response , 'auth/password/forgot.twig');
    }

    public function postForgotPassword($request, $response){

        $validation = $this->validator->validate($request,[
            'username' => v::noWhitespace()->notEmpty()->email()->userExists()
        ]);

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('auth.password.forgot'));
        }


        $this->auth->user()->setTempPassword($request->getParam('username'));
       //send md username as temp password
        
        $this->flash->addMessage('success','We have sent you temporary password');

        return $response->withRedirect($this->router->pathFor('auth.signin'));
    }

}