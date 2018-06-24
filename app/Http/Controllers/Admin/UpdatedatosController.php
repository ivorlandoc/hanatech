<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use \App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Facade;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Input;
use Response;
USE json;
use Carbon\Carbon;
use Sentinel;
use User;
use File;
use Hash;
use Redirect;

class UpdatedatosController extends Controller {

    public function index(Request $request){
        $idUserSession = Sentinel::getUser()->id; 
        $IdUser = Sentinel::findById(Sentinel::getUser()->id);$IdEstrUser=$IdUser->IdEstructura; 

                $dataEsp=DB::table('especialidad')->select('IdEspecialidad','Descripcion')->orderBy('IdEspecialidad')->get();
                $data   =DB::table('persona as p')
                ->leftjoin('cuadronominativo as c', 'p.IdPersona', '=', 'c.IdPersona')   
                ->join('cargo AS ca','ca.IdCargo','=','c.IdCargo')
                ->leftjoin('especialidad AS e','e.IdEspecialidad','=','p.Especialidad')             
                ->where('c.IdPersona','<>','')
                ->where('IdEstructura','like',$IdEstrUser.'%')
                ->where('NroPlaza','not like','9______9%')
                ->where('c.IdCargo','like','P1%')
                ->select(
                    'p.IdPersona',
                    'Dni',
                    'ApellidoPat',
                    'ApellidoMat',
                    'Nombres',
                    'FechaNac',
                    'FechaIngreso',
                    'IdProfesion',
                    'Especialidad as codEsp',
                    'c.IdPersona',
                    'ca.Descripcion  as cargo',
                    'e.Descripcion AS Especialidad',
                   // DB::raw('(SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT(c.IdEstructura,8) LIMIT 1) AS dep'),
                   // DB::raw('(SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT(c.IdEstructura,10) LIMIT 1) AS servicio'),
                    'NroPlaza'
                )
                ->orderBy('ApellidoPat')
                ->orderBy('ApellidoMat')
                ->orderBy('Nombres')
                ->paginate(10);  
        

        return view('admin.updatedatos.index', compact('idUserSession','i','data','dataEsp'));
    }


public function Procesaupdatdatos(Request $request){ 
             $GetUser = Sentinel::findById(Sentinel::getUser()->id);
             $UserSession=$GetUser->email; 

                $ipAddress = '';               
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
                    $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                        $ipAddress = trim($_SERVER['REMOTE_ADDR']);
                    }
                }
               
            if($request->ajax()){
              
                $i=0;
               while($i<=10){$i++;
                          if($request->input("P".$i)) {

                              $_Especialidad =$request->input("E".$i);

                              $Resp = DB::table('persona')
                                ->where('IdPersona',$request->input("P".$i))
                                ->update([
                                      'Especialidad' => $_Especialidad,                                 
                                      'IdUsuario'     => $UserSession,
                                      'Ip'            => $ipAddress,
                                      'created_at'    => date('Y-m-d H:i:s'),
                                      'updated_at'    => date('Y-m-d H:i:s')
                                ]);                             

                          }
                        }       

                  
                                     
                if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                return Response::json($Resp);  

                               
            }           
    }  
  


}