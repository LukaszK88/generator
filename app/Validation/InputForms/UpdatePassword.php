<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 12/11/2016
 * Time: 17:55
 */
namespace Battleheritage\Validation\InputForms;

use Respect\Validation\Validator as v;

class UpdatePassword{

    public static function rules(){

        return[
            'password_current'=>v::alnum(),
            'new_password'=>v::alnum(),
            'new_password_again'=>v::alnum()
        ];
    }

}