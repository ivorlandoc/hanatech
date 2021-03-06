<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Cargo;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;


class CargosController extends Controller {

     public function index(Request $request){
			$getAll = DB::table('cargo as c')
            ->join('nivel as n', 'n.IdNivel', '=', 'c.IdNivel')
            ->join('tipocargo as t', 't.IdTipo', '=', 'c.IdTipo')
            ->select('c.IdCargo','c.IdTipo','c.IdNivel','c.Descripcion','CodigoAnt', 't.Descripcion as TipoCargo', 'n.Descripcion as Nivel')
            ->where('c.Descripcion', 'like', '%')
            ->where('c.Flag', '=', 'O')
            ->orderby('t.Descripcion','DESC')->paginate(10);            
            return view('admin.cargo.index',compact('getAll'));  //IdCargo,IdTipo,IdNivel,Descripcion,CodigoAnt
    }

}