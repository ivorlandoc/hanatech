<?php namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

use Illuminate\Database\Eloquent\Model;

class Tipodocumento extends Model {  
	protected $fillable = ['IdTipoDocumento','Descripcion',];
	protected $table = 'tipodocumento';
	
	 	public function scopeSearch($query,$Desc){
	         return $query->where('Descripcion','like',"$Desc%");
	    }


    }