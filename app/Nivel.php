<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model {
    
	protected $fillable = ['IdNivel','Descripcion','Remuneracion','Bonif','BonoProd','BonoAltaResp','BonoExtraord','BonoEspecialidad','FechaUp','IdUsuario',];
	protected $table = 'nivel';

	 	public function scopeSearch($query,$Desc){
	         return $query->where('Descripcion','like',"%$Desc%");

	    }


    }