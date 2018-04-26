<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

use Illuminate\Database\Eloquent\Model;

class Estructura extends Model {    
	protected $fillable = ['IdEstructura','Descripcion','CodigoCal','CodigoAnt','FechaUp','IdUsuario',];
	protected $table = 'estructura';




    }