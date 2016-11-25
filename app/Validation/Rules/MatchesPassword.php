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


class MatchesPassword extends AbstractRule{

    protected   $password,
            $temp_password;

    public function __construct($temp_password,$password){

        $this->password = $password;
        $this->temp_password = $temp_password;
    }

    public function validate($input){

        if(!empty($this->temp_password)) {
            $user = User::where('temp_password', $this->temp_password)->first();
            return ($input == md5($user->username));
        }elseif (!empty($this->password)){
            
            return password_verify($input, $this->password);
        }

        return false;

    }
}