<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 10:25
 */

namespace Generator\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $fillable=[
        'name',
        'username',
        'temp_password',
        'salt',
        'password',
        'role',
        'weight',
    ];

    protected $table = 'users';




    
}