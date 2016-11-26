<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 25/11/2016
 * Time: 09:29
 */

namespace Generator\Validation\Rules;

use Generator\Models\User;
use Respect\Validation\Rules\AbstractRule;


class UserExists extends AbstractRule{

    public function validate($input){
        $user = User::where('username',$input)->count();
        if($user == 1){
            return true;
        }else{
            return false;
        }


    }
}