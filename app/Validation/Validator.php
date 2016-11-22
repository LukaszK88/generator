<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 08/11/2016
 * Time: 07:44
 */

namespace Generator\Validation;

use Generator\Validation\Contracts\ValidatorInterface;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator implements ValidatorInterface{

    protected $errors = [];

    public function validate($request,array $rules)
    {
        var_dump($rules);

        foreach ($rules as $field => $rule){
            try{

                $rule->setName(ucfirst($field))->assert($request->getParam($field));

            }catch (NestedValidationException $e){
                $this->errors[$field] = $e->getMessages();
            }
        }
        
        $_SESSION['errors'] = $this->errors;

        return $this;

    }
    
    public static function validationError($error){

        if(isset($_SESSION['errors'][$error]) and (!empty($_SESSION['errors'][$error]))){
            echo $_SESSION['errors'][$error][0];
            unset( $_SESSION['errors'][$error][0]);
        }
    }

    public static function validationErrorExists($error){

        if(!empty($_SESSION['errors'][$error])){
           
            return true;
        }
        
        return false ;
    }

    public function fails(){

        return !empty($this->errors);
    }

}