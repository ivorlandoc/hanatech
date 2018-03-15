<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

use Illuminate\Database\Eloquent\Model;

class Estructura extends Model {    
	protected $fillable = ['IdEstructura','Descripcion','CodigoCal','CodigoAnt','FechaUp','IdUsuario',];
	protected $table = 'estructura';

	 	/*public function scopeSearch($query,$Desc){
	         return $query->where('Descripcion','like',"__00000000%");

	    }*/

	   function getDetallePlazas($id,$flag){
	   	 $string="";
	   /*	if($flag==""){$string='AND c.IdPersona=""';}else{$string='AND IdTipo="$flag" AND c.IdPersona<>""';	} 

	   	$sql_asist='SELECT  c.IdPersona,IdPlaza, c.NroPlaza, c.IdEstructura,e.Descripcion AS descripcion,
car.IdNivel,car.Descripcion AS cargo,IF(p.ApellidoPat IS NULL,"-",p.ApellidoPat)  AS ApellidoPat,
IF(p.ApellidoMat IS NULL,"-",p.ApellidoMat) AS ApellidoMat,IF(p.Nombres IS NULL,"-",p.Nombres) AS Nombres
FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
  INNER JOIN cargo car ON car.IdCargo=c.IdCargo   INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
   WHERE  c.IdEstructura = "$id" $string';

/*
	   }


    }