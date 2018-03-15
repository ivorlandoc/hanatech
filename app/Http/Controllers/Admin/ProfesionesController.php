<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class ProfesionesController extends Controller {

 
    public function index(Request $request){
        //$getAllCargo=\App\TipoCargo::Search($request->nombres)->orderby('IdTipo','asc')->paginate(10);
        $getAllCargo="";//=DB::table('tipocargo')->get();
      return "";
    }

    public function getListProfesionesForAlta($id){		
		$alldata =DB::select('SELECT IdProfesion,Descripcion,Estado FROM profesiones WHERE Estado="1" order by Descripcion');  
        return $alldata;
    }

}