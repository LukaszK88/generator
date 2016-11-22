<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 08/11/2016
 * Time: 07:41
 */

namespace Generator\Validation\Contracts ;

interface ValidatorInterface{

    public function validate($request,array $rules);

    public function fails();

}