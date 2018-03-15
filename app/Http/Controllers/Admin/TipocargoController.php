<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class TipocargoController extends Controller {

 
    public function index(Request $request){
        //$getAllCargo=\App\TipoCargo::Search($request->nombres)->orderby('IdTipo','asc')->paginate(10);
        $getAllCargo=DB::table('tipocargo')->get();
      return view('admin.tipo.index',compact('getAllCargo')); 
    }
}