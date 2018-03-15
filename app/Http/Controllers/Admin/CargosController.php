<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Cargo;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;


class CargosController extends Controller {

     public function index(Request $request){
			$getAll = DB::table('cargo')
            ->join('nivel', 'Nivel.IdNivel', '=', 'cargo.IdNivel')
            ->join('tipocargo', 'tipocargo.IdTipo', '=', 'cargo.IdTipo')
            ->select('cargo.*', 'tipocargo.Descripcion as TipoCargo', 'nivel.Descripcion as Nivel')
            ->where('cargo.Descripcion', 'like', '%')
            ->orderby('TipoCargo.Descripcion','DESC')->paginate(10);
            
            return view('admin.cargo.index',compact('getAll')); 
    }

}