<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Nivel;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;


class NivelesController extends Controller { 
    public function index(Request $request){
        $getAllnivel=\App\Nivel::Search($request->Desc)->orderby('IdNivel','asc')->paginate(18);    
      return view('admin.nivel.index',compact('getAllnivel')); 
    }

}