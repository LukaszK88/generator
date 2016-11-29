<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 29/11/2016
 * Time: 08:06
 */
namespace Generator\Models;

use Illuminate\Database\Eloquent\Model;

class Levels extends Model{

    protected $table = 'levels';

    public function getLevelId($level){

       return Levels::where('level',$level)->first();
        
    }


    public function core(){

        return $this->belongsTo('Generator\models\Core','level_id');

    }

}