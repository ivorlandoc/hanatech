<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Tipodocumento;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;

class TipodocumentoController extends Controller {
     public function index(Request $des){
		$alldata = DB::table('tipodocumento')->select('IdTipoDocumento', 'Descripcion')->orderby('IdTipoDocumento','DESC');            
        return $alldata;
    }

public function getListaForAlta($id){
		//$alldata = DB::table('tipodocumento')->select('IdTipoDocumento', 'Descripcion')->orderby('IdTipoDocumento','DESC');  
		$alldata =DB::select('SELECT * FROM tipodocumento ORDER BY 1');  

        return $alldata;
    }

}