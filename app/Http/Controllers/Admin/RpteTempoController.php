<?php namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Facade;
use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use response;
use json;

class RpteTempoController extends Controller { 

	public function index( Request $request){
		if(empty($request->input("search_tempo"))) {$_string='NOEXISTEREGISTRO';} else  {$_string=$request->input("search_tempo")."%";}
	/*	$DataM =DB::select("SELECT cod_estru,organo,centro,denominaci,nro_plaza,cond_ingre AS regimen,nombres,lib_elect1,descri_car,detalle,nivel,resolucion,observ AS observacion FROM tempo_historico WHERE NOMBRES LIKE '$_string'");*/

		 $DataM=DB::table('tempo_historico')
		 				->select('cod_estru','organo','centro','denominaci','nro_plaza','regimen','nombres','lib_elect1','descri_car','detalle','nivel','resolucion','observ AS observacion')
				       ->where('nro_plaza', 'like',$_string)
				       ->orwhere('nombres', 'like',$_string)
				       ->orwhere('lib_elect1', 'like',$_string)->paginate(8);  

		 return view('admin.rptetempo.index',compact('DataM')); 
	}

		 public function GetResultDet($id){		
		 		$Data=db::select("SELECT cod_estru,organo,centro,denominaci,nro_plaza, regimen,nombres,lib_elect1,descri_car,detalle,nivel,resolucion,observ AS observacion FROM tempo_historico WHERE Nro_Plaza='$id'");
		      return $Data;
		    }

}