<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use\App\Http\Controllers\JoshController;
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




class ReservaController extends Controller {

    public function index(Request $request){
        $idUserSession = Sentinel::getUser()->id;   //almacena id de sesion activa    SELECT IdEstadoPlaza,Descripcion FROM estadoplaza ORDER BY 1   
        $allEsta=DB::table('estadoplaza')->where('Flat', '1')->select('IdEstadoPlaza','Descripcion')->orderBy('IdEstadoPlaza')->Get();
        $alltipo=DB::table('estadoplaza')->where('Flat', '2')->select('IdEstadoPlaza','Descripcion')->orderBy('Comentario')->Get();
        return view('admin.reserva.index', compact('idUserSession','alltipo','allEsta'));
    }

   public function GetDatosRserva(Request $request){  
            if($request->ajax()) { 
                $plz         = $request->input("reserva_plaza"); 
                $data = DB::select("SELECT IdPersona AS persona,CONVERT(IdPlaza,CHAR(7)) as IdPlaza,
                          (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),2) LIMIT 1) AS sede,
                          (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),4) LIMIT 1) AS organo,
                          (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),6) LIMIT 1) AS gerencia,
                          (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),8) LIMIT 1) AS dep,
                          (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),10) LIMIT 1) AS servicio,
                          (SELECT descripcion FROM estructura WHERE IdEstructura=cu.IdEstructura LIMIT 1) AS dependencia,
                          (SELECT  Descripcion FROM estadoplaza WHERE IdEstadoPlaza=cu.IdEstadoPlaza)AS estado,
                          IdNivel, c.Descripcion AS cargo,NroPlaza,c.IdCargo,IdEstructura,IdEstadoPlaza
                          FROM  cuadronominativo AS cu INNER JOIN cargo c ON c.IdCargo=cu.IdCargo
                          WHERE NroPlaza= '$plz' and IdPersona='' -- and IdEstadoPlaza='2'");
                return response()->json($data);
           }           
    }

public function Procesareservaplaza(Request $request,$id){
             $UserSession = Sentinel::findById($request->input("idUserSession"));
                $ipAddress = '';               
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
                    $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                        $ipAddress = trim($_SERVER['REMOTE_ADDR']);
                    }
                }
               
            if($request->ajax()){
                $_NroPlaza         = $request->input("nroplazar");
                $_IdCargo          = $request->input("txtidcargo");
                $_IdPlaza          = $request->input("txtidplaza");
                $_IdEstructura     = $request->input("txtestructura");

                $_tiporeserva      = $request->input("IdTipoMotivoreser");
                $_fechareserv      = $request->input("fechaRserv");

                $_DocRefere        = $request->input("DocRefRser");
                $_obserreser       = $request->input("obserRser");

                $_fileadjunto      = $request->hasFile("FileAdjuntoReserva");
           
                              
                if($_NroPlaza!=""){
                        $aff=DB::table('cuadronominativo')->where('NroPlaza', $_NroPlaza)->where('IdCargo', $_IdCargo)
                        ->update([                                           
                                    'IdEstadoPlaza'     =>'2',
                                    'SubIdEstadoPlaza'  =>$_tiporeserva,
                                    'Observ'            =>strtoupper($_obserreser),
                                    'IdUsuario'         =>$UserSession->email,
                                    'Ip'                =>$ipAddress,
                                    'updated_at'        =>date('Y-m-d H:i:s'),
                                    'created_at'        =>date('Y-m-d H:i:s')
                                    ]);
                    }

                            $GetTipoR         =DB::table('estadoplaza')->where('IdEstadoPlaza','=',$_tiporeserva)->select('Descripcion')->get('Descripcion');   
                            $DesTipo="";
                            foreach ($GetTipoR as $key) $DesTipo  =$key->Descripcion; 
                                  
                        /*===========================================*/
                        $res=array($_IdPlaza);
                        //$fileName=$_IdPersona.$_IdPlaza.$_NroPlaza;// nombre del archivo .pdf
                        $fileName=$_IdPlaza.$_NroPlaza;// nombre del archivo .pdf
                        $name="";
                        if($_fileadjunto) 
                            {
                                $file = $request->file('FileAdjuntoReserva'); 
                                $path = public_path('uploads/files/');
                                array_push($res, $path);
                                $name = $fileName.'.'.$file->getClientOriginalExtension();
                                $file->move($path, $name);
                            } 
                        /*===========================================*/

                        $Resp = DB::table('historiamovimiento')->insert([
                            'IdPersona'     => '',
                            'IdPlaza'       => $_IdPlaza,
                            'IdEstructura'  => $_IdEstructura,
                            'IdCargo'       => $_IdCargo,
                            'NroPlaza'      => $_NroPlaza,
                            'IdTipoMov'     => "",
                            'IdTipoBaja'    => "",
                            'IdEstadoPlaza' => $_tiporeserva,
                            'FechaDocRef'   => Carbon::parse($_fechareserv)->format('Y-m-d H:i:s'),
                            'FechaMov'      => date('Y-m-d H:i:s'),
                            'DocRef'        => strtoupper($_DocRefere),
                            'FileAdjunto'   => $name,
                            'Observacion'   => strtoupper($DesTipo.' | '.$_obserreser),
                            'IdUsuario'     => $UserSession->email,
                            'Ip'            => $ipAddress,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s')
                        ]);
                                     
                if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                return Response::json($Resp);  

                               
            }           
    }   

public function ProcesaChangeEstado(Request $request,$id,$idx){
             $UserSession = Sentinel::findById($request->input("idUserSession"));
                $ipAddress = '';               
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
                    $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                        $ipAddress = trim($_SERVER['REMOTE_ADDR']);
                    }
                }
               
            if($request->ajax()){
                $_NroPlaza         = $request->input("nroplazarEst");
                $_IdEstado          = $request->input("IdEstadoPlazaChange");
                           
                if($_NroPlaza!=""){
                        $aff=DB::table('cuadronominativo')->where('NroPlaza', $_NroPlaza)
                        ->update([                                           
                                    'IdEstadoPlaza' =>$_IdEstado,
                                    'IdUsuario'     =>$UserSession->email,
                                    'Ip'            =>$ipAddress,
                                    'updated_at'    =>date('Y-m-d H:i:s'),
                                    'created_at'    =>date('Y-m-d H:i:s')
                                    ]);
                    }

                              $GetTipoR =DB::table('estadoplaza')->where('IdEstadoPlaza','=',$_IdEstado)->select('Descripcion')->get('Descripcion');   
                             $DesTipo="";
                            foreach ($GetTipoR as $key) $DesTipo  =$key->Descripcion;
                        $strin="Cambió el estado de la plaza: ".$_NroPlaza." a ".$DesTipo;
                        $Resp = DB::table('_log')->insert([
                            'Actividad'     => $strin,                           
                            'IdUsuario'     => $UserSession->email,
                            'Ip'            => $ipAddress,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s')
                        ]);
                                     
                if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                return Response::json($Resp);  

                               
            }           
        }   



}