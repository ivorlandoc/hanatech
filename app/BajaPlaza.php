<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

use Illuminate\Database\Eloquent\Model;

class BajaPlaza extends Model {   

	protected $table = 'historiamovimiento';
	//protected $fillable = ['IdPersona','IdEstructura','IdCargo','NroPlaza',];
	protected $primarykey='IdHistoria';
	protected $fillable = ['IdPersona',
							'IdEstructura',
							'IdCargo',
							'NroPlaza',
							'IdTipoMov',
							'DocRef',
							'IdUsuario'
							'FechaDocRef',
							'FileAdjunto',
							'Observacion',							
						];

protected $guarded=[];
	 /*
	 public function GetDataPlazas($Desc){	 		
	         return $query->where('Descripcion','like',"__00000000%");

	    }
	    */

	    public function scopeSearch($string){ // no se usa aun

	         $query->where(\DB::raw('CONCAT(p.ApellidoPat," ",p.ApellidoMat," ",p.Nombres) AS Nombres)',"like","$Search")
	     				   \DB::orwhere('cu.NroPlaza','like','$string')); 

	    }




}