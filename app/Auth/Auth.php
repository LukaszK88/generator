<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 24/11/2016
 * Time: 17:02
 */

namespace Generator\Auth;

use Generator\Models\User;

use Illuminate\Database\Capsule\Manager as DB;

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

                if($this->hasPermission('admin')){
                    $_SESSION['admin'] = 'administrator';
                }

            return true;
        }

        return false;

    }

    public function hasPermission($key){
        if($this->check()) {
            $group = DB::table('groups')->where('id', $this->user()->role)->get();

            if ($group->count()) {
                $permissions = json_decode($group->first()->permission, true);

                if ($permissions[$key] == true) {
                    return true;

                }
            }
            return false;
        }
    }

    public function logOut(){
        
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
    }
}