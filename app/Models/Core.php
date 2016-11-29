<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 29/11/2016
 * Time: 08:06
 */
namespace Generator\Models;

use Illuminate\Database\Eloquent\Model;

class Core extends Model{

    protected $table = 'core';
    

    public function level(){

        return $this->hasOne('Generator\models\Levels','id');
    }

}