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




class SuplenciaController extends Controller {

    public function index(Request $request){
        $idUserSession = Sentinel::getUser()->id;   
        /*
                $suplencia=DB::table('suplencias as s')
                ->leftjoin('persona as p', 'p.IdPersona', '=', 's.IdPersona') 
                ->join('TipoSuplencias as ts','ts.IdTipoSuplencia','=','s.IdTipoSuplencia') 
                ->where(DB::RAW('CONCAT(ApellidoPat," ",ApellidoMat," ",Nombres)'),'like','%')
                ->select(
                    'IdSuplencia',
                    's.IdTipoSuplencia',
                    'ts.Descripcion AS tiposup',
                    's.IdPersona',
                    'NroPlaza',
                    'Finicio',
                    'Ftermino',
                    DB::raw('IF(Proceso IS NULL," - ",Proceso)AS Proceso'),
                    'Estado',
                    'Dni',
                    DB::raw('CONCAT(ApellidoPat," ",ApellidoMat," ",Nombres) AS suplente'),
                    DB::raw('(SELECT CONCAT(ApellidoPat," ",ApellidoMat," ",Nombres) FROM persona WHERE IdPersona=s.Titular) AS Titular')
                )->paginate(10);  */   
        return view('admin.suplencias.index', compact('idUserSession','i'));
    }

 public function getdatasuplencia(Request $request){
        $idUserSession = Sentinel::getUser()->id;

         if($request->ajax()) {  
                $string=$request->input("search_suplencia")."%";
                $data=DB::table('suplencias as s')
                ->leftjoin('persona as p', 'p.IdPersona', '=', 's.IdPersona') 
                ->join('TipoSuplencias as ts','ts.IdTipoSuplencia','=','s.IdTipoSuplencia') 
                ->where(DB::RAW('CONCAT(ApellidoPat," ",ApellidoMat," ",Nombres)'),'like',$string)
                ->select(
                    'IdSuplencia',
                    's.IdTipoSuplencia',
                    'ts.Descripcion AS tiposup',
                    's.IdPersona',
                    'NroPlaza',
                    'Finicio',
                    'Ftermino',
                    DB::raw('IF(Proceso IS NULL," - ",Proceso)AS Proceso'),
                    'Estado',
                    'Dni',
                    DB::raw('CONCAT(ApellidoPat," ",ApellidoMat," ",Nombres) AS suplente'),
                    DB::raw('(SELECT CONCAT(ApellidoPat," ",ApellidoMat," ",Nombres) FROM persona WHERE IdPersona=s.Titular) AS Titular')
                )->get();

       //ORDER BY updated_at DESC
       return Response::json($data); 
            }
       
    }

public function GetDatosTitularHead(Request $request){  
         if($request->ajax()) {  
                $string=$request->input("searchpzSup");
                     $data=DB::table('cuadronominativo as c')
                        ->join('persona as p', 'p.IdPersona', '=', 'c.IdPersona') 
                        ->join('cargo','cargo.IdCargo','=','c.IdCargo') 
                        ->where('NroPlaza','=',$string)
                        ->select(
                            'NroPlaza',
                            'c.IdPersona',
                            'c.IdCargo',
                            'Descripcion',                   
                            DB::raw("CONCAT(ApellidoPat,' ',ApellidoMat,' ',Nombres) AS Nombres")                    
                        )->get();
                return Response::json($data); 
            }
       
    }
    public function GetDatosSuplenteHead(Request $request){  
         if($request->ajax()) {  
                $string=$request->input("txtdnisup");
                     $data=DB::table('persona')->where('dni','=',$string)->select('IdPersona','Dni', DB::raw("CONCAT(ApellidoPat,' ',ApellidoMat,' ',Nombres) AS Nombres"))->get();
                return Response::json($data); 
            }
       
    }


   public function create(Request $request){  
            $idUserSession = Sentinel::getUser()->id;   

            $tiposuple=DB::table('tiposuplencias')->select('IdTipoSuplencia','Descripcion')->get();

           return view('admin.suplencias.create',compact('tiposuple','idUserSession'));                      
    }



public function ProcesaSaveSuplencia(Request $request){
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
                $_NroPlaza         = $request->input("txtplaza");
                $_IdPersona        = $request->input("txtidpersona");
                $_IdTitular        = $request->input("txtidtitular");
                $_IdTipoSuplen     = $request->input("tiposupl");
                $_finicio          = $request->input("datefinicio");
                $_ftermino         = $request->input("dateftermino");
                $_txtproceso       = $request->input("txtproceso");             

               // $_fileadjunto      = $request->hasFile("FileAdjuntoReserva");   

                    /*===========================================*/
                    /*$res=array($_NroPlaza);
                    //$fileName=$_IdPersona.$_IdPlaza.$_NroPlaza;// nombre del archivo .pdf
                    $fileName=$_IdPersona.$_NroPlaza;// nombre del archivo .pdf
                    $name="";
                    if($_fileadjunto) 
                        {
                            $file = $request->file('FileAdjuntoReserva'); 
                            $path = public_path('uploads/files/');
                            array_push($res, $path);
                            $name = $fileName.'.'.$file->getClientOriginalExtension();
                            $file->move($path, $name);
                        } */
                        /*===========================================*/
                    $Resp=DB::table("suplencias")->insert([                           
                        'IdTiposuplencia'   =>$_IdTipoSuplen,
                        'IdPersona'         =>$_IdPersona,
                        'NroPlaza'          =>$_NroPlaza,
                        'Titular'           =>$_IdTitular,
                        'Finicio'           =>$_finicio,
                        'Ftermino'          =>$_ftermino,
                        'Proceso'           =>$_txtproceso,
                        'Estado'            =>'Activo',
                        'IdUsuario'         =>$UserSession->email,
                        'Ip'                =>$ipAddress,
                        'created_at'        =>date('Y-m-d H:i:s'),
                        'updated_at'        =>date('Y-m-d H:i:s')
                        ]);
                    /*
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
                        'DocRef'        => $_DocRefere,
                        'FileAdjunto'   => $name,
                        'Observacion'   => $DesTipo.' | '.$_obserreser,
                        'IdUsuario'     => $UserSession->email,
                        'Ip'            => $ipAddress,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);*/
                                     
                if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                return Response::json($Resp);  

                               
            }           
    }   

}