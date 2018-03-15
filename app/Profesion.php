<?php namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

use Illuminate\Database\Eloquent\Model;

class Profesion extends Model {  
	protected $fillable = ['IdProfesion','Descripcion','Estado',];
	protected $table = 'profesiones';
	
	 	public function scopeSearch($query,$Desc){
	         return $query->where('Descripcion','like',"$Desc%");
	    }


    }