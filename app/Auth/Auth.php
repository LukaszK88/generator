<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 24/11/2016
 * Time: 17:02
 */

namespace Generator\Auth;

use Generator\Models\User;

class Auth{

    public function user(){
        if($this->check()) {
            return User::find($_SESSION['user']);
        }
    }

    public function check(){

        return isset($_SESSION['user']);
    }

    public function attempt($email,$password){

        $user = User::where('username',$email)->first();
          
        if(!$user){
            return false;
        }

        if(password_verify($password,$user->password) or ($user->temp_password == md5($email))){

            $_SESSION['user'] = $user->id;

            return true;
        }

        return false;

    }

    public function logOut(){
        
        unset($_SESSION['user']);
    }
}