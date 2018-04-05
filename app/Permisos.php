<?php namespace App;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Model;

class Permisos extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'permissions';
	protected $fillable = ['name','slug','description'];

}