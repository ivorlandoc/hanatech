<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use PDF;
use input;

class PdfEstructuraController extends Controller {

	public function index(Request $Request){
		$sede        ="01";
        //$sede  = $Request->input("select_nivel1");

    	$data = DB::select("SELECT LEFT(IdEstructura,2) as IdEstructura ,Descripcion FROM estructura WHERE IdEstructura like '".$sede."00000000%'");
		$pdf=PDF::loadView('admin.filespdf.index',compact('data'))->setPaper('a4', 'portrait')->setWarnings(false)->download('IVOC301178'.date("dmYhis").'.pdf');
		return  $pdf;
	}
	
}