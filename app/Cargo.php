<?php namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model {  
	protected $fillable = ['IdCargo','IdTipo','IdNivel','Descripcion','CodigoAnt','FechaUp','IdUsuario',];
	protected $table = 'cargo';

	 	public function scopeSearch($query,$Desc){
	         return $query->where('Descripcion','like',"%$Desc%");

	    }


    }