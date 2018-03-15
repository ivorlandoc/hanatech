<?php namespace App\Http\Controllers\Servicio;

//use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
//use App\User; // by iv.orlando.c
use DB;
USE json;
use Response;
use input;
use Carbon\Carbon;

// use App\Http\Requests\UserRequest;
// use App\Http\Requests\FrontendRequest;

use Sentinel;

class ReservaPlazaController extends Controller {
	public  function __construct() {
/*
        $data = array();
	 	if (Sentinel::check()) {
    	       $user    = Sentinel::getUser();
               $data['email'] = $user['email']
               
        }*/
	 }

     public function index(Request $request){
			$getnivel = DB::table('nivel')->select('IdNivel', 'Descripcion')->orderby('Descripcion','asc')->get();
            $getTipo  = DB::table('estadoplaza')->select('IdEstadoPlaza', 'Descripcion')->where('Flat', '=', '2')->get();            
            return view('servicio.reservas.index',compact('getTipo'),compact('getnivel')); 
    }

 public function GetDetalleReserva(Request $request){	
 			$data = DB::select("SELECT CONVERT(Id,CHAR(6)) as Id, CONVERT(IdSolicitud,CHAR(6)) AS IdSolicitud, (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT(IdEstructuraorigen,2) AND Descripcion IS NOT NULL LIMIT 1) AS sede,
(SELECT Descripcion FROM estructura WHERE IdEstructura=IdEstructuraorigen) AS dep,Apenombres,IdNivel,(SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=ss.IdEstadoPlaza) AS tipo,DATE_FORMAT(FechaDoc,'%d/%m/%y') AS FechaDoc,DocReferencia,IdEstadoSer FROM solicitudservicio ss ORDER BY created_at desc "); 
         return $data; 
    }

public function ProcesaInsertSolicitudReserva(Request $Request){
    		$getUser="";
	        if($Request->ajax()){    
                $_selectTipoR       = $Request->input("selectTipoR");
                $_txtdni            = $Request->input("txtdni");
                $_txtnombres        = $Request->input("txtnombres");
                $_fechadoc       	= $Request->input("datetime3");
                $_txtreferencia     = $Request->input("txtreferencia");
                $_idselectNivel     = $Request->input("idselectNivel");
                /* =================== si existe la persona se actualiza sus datos  */  
                $MaxCod = DB::table('solicitudservicio')->max('IdSolicitud'); 

                $Resp = DB::table('solicitudservicio')->insert([
                	'IdSolicitud'			=> str_pad($MaxCod+1,6, '0', STR_PAD_LEFT),
                    'IdEstructuraorigen'    => "0113001000",
                    'IdEstructuraDestino'   => "0113002001",
                    'Dni'  					=> $_txtdni,
                    'Apenombres'       		=> $_txtnombres,
                    'IdNivel'      			=> $_idselectNivel,
                    'IdEstadoPlaza'     	=> $_selectTipoR,                                   
                    'FechaDoc'   			=> Carbon::parse($_fechadoc)->format('Y-m-d'),                                    
                    'DocReferencia'        	=> $_txtreferencia, 
                    'IdEstadoSer'			=> "1", 
                    'IdUsuario'				=> $getEmail,                                
                    'created_at'    		=> date('Y-m-d H:i:s'),
                    'updated_at'    		=> date('Y-m-d H:i:s')
                ]);                  
              
                if($Resp)                  
                    return Response::json($Resp);
                        else                  
                    return Response::json($Resp);                 
            }           
        }   
/* ============================= */
public function getshow(Request $request){
			$data = DB::select("SELECT CONVERT(Id,CHAR(6)) as Id, CONVERT(IdSolicitud,CHAR(6)) AS IdSolicitud, (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT(IdEstructuraorigen,2) AND Descripcion IS NOT NULL LIMIT 1) AS sede,
(SELECT Descripcion FROM estructura WHERE IdEstructura=IdEstructuraorigen) AS dep,Apenombres,IdNivel,(SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=ss.IdEstadoPlaza) AS tipo,DATE_FORMAT(FechaDoc,'%d/%m/%y') AS FechaDoc,DocReferencia,IdEstadoSer FROM solicitudservicio ss ORDER BY created_at desc ");  //GROUP BY IdSolicitud
         return view('servicio.reservas.bandeja',compact('data')); 
    }



public function AtenderSolicitudServ(Request $Request){
            $user                  ="";//Sentinel::getUser()->email;           
            if($Request->ajax()){    
            	$_IdSolici      = $Request->input("IdSolicitud");
                $_ObserAt       = $Request->input("ObservacionAt");
                $_EstadoSer     = $Request->input("idSetValCheck");
                /*====================================================*/
                  /*  $_IdSolicitud 	="";
                	$_EstructOrig 	="";
                	$_EstructDest	="";
					$_Dni 			="";
                	$_txtNombres 	="";
                	$_txtNivel 		="";
                	$_txtEstadoPlaza="";
                $data = DB::select("SELECT IdSolicitud,IdEstructuraorigen,IdEstructuraDestino, Dni,Apenombres,IdNivel,IdEstadoPlaza from solicitudservicio WHERE Id='$_IdSolici'");
                foreach ($data AS $keys) $_IdSolicitud  = $keys->IdSolicitud;  $_EstructOrig  = $keys->IdEstructuraorigen; $_EstructDest  = $keys->IdEstructuraDestino; $_Dni=$keys->Dni; $_txtNombres=$keys->Apenombres; $_txtNivel=$keys->IdNivel; $_txtEstadoPlaza=$keys->IdEstadoPlaza;
                                                     
                $Resp = DB::table('solicitudservicio')->insert([
                	'IdSolicitud'			=>$_IdSolicitud,
                    'IdEstructuraorigen'    =>$_EstructOrig,
                    'IdEstructuraDestino'   =>$_EstructDest,
                    'Dni'  					=>$_Dni,
                    'Apenombres'       		=>$_txtNombres,
                    'IdNivel'      			=>$_txtNivel,
                    'IdEstadoPlaza'     	=>$_txtEstadoPlaza,                                   
                    'FechaDoc'   			=>date('Y-m-d H:i:s'),                                    
                    'Observacion'        	=>$_ObserAt,  
                    'IdEstadoSer'        	=>$_EstadoSer,                            
                    'created_at'    		=> date('Y-m-d H:i:s'),
                    'updated_at'    		=> date('Y-m-d H:i:s')
                ]);  */

                 $Resp=DB::table('solicitudservicio')->where('Id',$_IdSolici)->update([
                  'IdEstadoSer' =>$_EstadoSer, 
                  'Observacion' =>$_ObserAt." ". date('Y-m-d H:i:s'),
                  'IdUsuario'    =>$user,
                  'updated_at'   =>date('Y-m-d H:i:s'),
                  'created_at'   =>date('Y-m-d H:i:s') 
                ]);    
                                 
                if($Resp)                  
                return Response::json($Resp);
                    else                  
                return Response::json($Resp);                 
            }           
        }   
/* ============================= */
public function GetShowObservacion($id){
			$data = DB::select("SELECT * from solicitudservicio WHERE Id='$id'");
         return $data; 
    }

}