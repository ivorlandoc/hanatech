<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Cargo;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;


class PeriodopptoController extends Controller {

     public function index(Request $request){
			/*$getAll = DB::table('cargo as c')
            ->join('nivel as n', 'n.IdNivel', '=', 'c.IdNivel')
            ->join('tipocargo as t', 't.IdTipo', '=', 'c.IdTipo')
            ->select('c.IdCargo','c.IdTipo','c.IdNivel','c.Descripcion','CodigoAnt', 't.Descripcion as TipoCargo', 'n.Descripcion as Nivel')
            ->where('c.Descripcion', 'like', '%')
            ->orderby('t.Descripcion','DESC')->paginate(10);  */          
            return view('admin.periodop.index');  //IdCargo,IdTipo,IdNivel,Descripcion,CodigoAnt
    }

}