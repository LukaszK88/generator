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


class MatchesPasswordConfirmation extends AbstractRule{

    protected   $password,
                $password_again;

    public function __construct($password_again,$password){

        $this->password = $password;
        $this->password_again = $password_again;
    }

    public function validate($input){

        return ($this->password === $this->password_again);
    }
}