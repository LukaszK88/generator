<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 25/11/2016
 * Time: 09:34
 */

namespace Generator\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class MatchesPasswordException extends ValidationException{

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Current password does not match'
        ]
    ];
}