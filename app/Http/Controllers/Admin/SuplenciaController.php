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


class SuplenciaController extends JoshController {

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
                    DB::raw('convert(IdSuplencia, char(5)) as IdSuplencia'),                   
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
           $groups = Sentinel::getRoleRepository()->all();
            $countries = $this->countries;

            $tiposuple=DB::table('tiposuplencias')->select('IdTipoSuplencia','Descripcion')->get();
            $dataEsp=DB::table('especialidad')->select('IdEspecialidad','Descripcion')->orderBy('IdEspecialidad')->get();   
            $tipodoc=DB::table('tipodocumento')->select('IdTipoDocumento','Descripcion')->get();  
            $profes=DB::table('profesiones')->select('IdProfesion','Descripcion')->where('Estado','=','1')->get();     

            $regime=DB::table('regimen')->select('IdRegimen','Descripcion','Sigla')->where('Descripcion','<>','')->get();
      
           return view('admin.suplencias.create',compact('tiposuple','idUserSession','groups', 'countries','dataEsp','tipodoc','profes','regime'));                      
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
                    $Resp=DB::table("suplencias")->insert([                           
                        'IdTiposuplencia'   =>$_IdTipoSuplen,
                        'IdPersona'         =>$_IdPersona,
                        'NroPlaza'          =>$_NroPlaza,
                        'Titular'           =>$_IdTitular,
                        'Finicio'           =>Carbon::parse($_finicio)->format('Y-m-d'),
                        'Ftermino'          =>Carbon::parse($_ftermino)->format('Y-m-d'),
                        'Proceso'           =>$_txtproceso,
                        'Estado'            =>'Activo',
                        'IdUsuario'         =>$UserSession->email,
                        'Ip'                =>$ipAddress,
                        'created_at'        =>date('Y-m-d H:i:s'),
                        'updated_at'        =>date('Y-m-d H:i:s')
                        ]);
                      
                if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                return Response::json($Resp);  

                               
            }           
    }  

    public function deleteSuplencia(Request $request){
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
                $_id         = $request->input("id"); 
              
                    $Resp=DB::table("suplencias")
                    ->where('IdSuplencia',$_id)
                    ->update([
                        'Estado'            =>'Inactivo',
                        'IdUsuario'         =>$UserSession->email,
                        'Ip'                =>$ipAddress,
                        'created_at'        =>date('Y-m-d H:i:s'),
                        'updated_at'        =>date('Y-m-d H:i:s')
                        ]);                  
                                     
                if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                return Response::json($Resp);  

                               
            }           
    }   


public function ProcesaAltaSuplente(Request $request){
           //  $UserSession = Sentinel::findById($request->input("idUserSession"));
             $IdUser = Sentinel::findById(Sentinel::getUser()->id); $GetUser=$IdUser->email;
                $ipAddress = '';               
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
                    $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                        $ipAddress = trim($_SERVER['REMOTE_ADDR']);
                    }
                }
               
            if($request->ajax()){

                $_IdTipoDoc         = $request->input("IdTipoDocument");
                $_Nrodni            = $request->input("nrodocumento");
                $_ApellidoPat       = $request->input("ape_pat");
                $_ApellidoMat       = $request->input("ape_mat");
                $_Nombres           = $request->input("txtnombre");
                $_FechaNac          = $request->input("idfechanac");      
                $_Genero            = $request->input("idgenero");
                $_IdPais            = $request->input("country");
                $_Direccion         = $request->input("txtdireccion"); 
                $_Carreraprof       = $request->input("idcarrera");
                $_Especialidad      = $request->input("txtespecialidad");                
                $_Regimen           = $request->input("IdRegimen");
                $_Fingreso          = $request->input("idfechaingreso"); 
                 
                 /* =================== si existe la persona se actualiza sus datos  */
                $GetDni         =DB::table('persona')->where('Dni','=',$_Nrodni)->select('Dni')->get('Dni');   
                $CheckDni="";
                foreach ($GetDni as $key) $CheckDni  =$key->Dni; 
                //----------------Get Idpersona-------------
                $GetPersona     =DB::table('persona')->where('Dni','=',$_Nrodni)->select('IdPersona')->get('IdPersona');
                $_IdPersona="";
                foreach ($GetPersona as $keys) $_IdPersona  =$keys->IdPersona; 

                if($CheckDni!=""){
                    $Resp=DB::table('persona')->where('Dni', $_Nrodni)->update([
                        'IdTipoDocumento'   =>$_IdTipoDoc, 
                        'ApellidoPat'       =>strtoupper($_ApellidoPat),
                        'ApellidoMat'       =>strtoupper($_ApellidoMat), 
                        'Nombres'           =>strtoupper($_Nombres),
                        'FechaNac'          =>Carbon::parse($_FechaNac)->format('Y-m-d H:i:s'), 
                        'FechaIngreso'      =>Carbon::parse($_Fingreso)->format('Y-m-d H:i:s'), 
                        'IdRegimen'         =>$_Regimen, 
                        'Genero'            =>$_Genero, 
                        'IdProfesion'       =>$_Carreraprof, 
                        'Especialidad'      =>$_Especialidad, 
                        'IdPais'            =>$_IdPais, 
                        'Direccion'         =>$_Direccion,                        
                        'IdUsuario'         =>$GetUser,
                        'Ip'                => $ipAddress,
                        'updated_at'        =>date('Y-m-d H:i:s'),
                        'created_at'        =>date('Y-m-d H:i:s')                     
                        ]); 
                } else{  /* ============ Si no existe obtenemos Id de la Persona +1 */                   
                        $MaxCod = DB::table('persona')->max('IdPersona');
                        $IdPersona=str_pad($MaxCod+1,7, '0', STR_PAD_LEFT);
                        // ----------------------------------------------
                         $Resp = DB::table('persona')->insert([
                        'IdPersona'         => $IdPersona,
                        'IdTipoDocumento'   => $_IdTipoDoc,
                        'Dni'               => $_Nrodni,
                        'ApellidoPat'       => strtoupper($_ApellidoPat),
                        'ApellidoMat'       => strtoupper($_ApellidoMat),
                        'Nombres'           => strtoupper($_Nombres),
                        'FechaNac'          => Carbon::parse($_FechaNac)->format('Y-m-d'),
                        'FechaIngreso'      => Carbon::parse($_Fingreso)->format('Y-m-d'),                    
                        'IdRegimen'         => $_Regimen,
                        'Genero'            => $_Genero,                   
                        'IdProfesion'       => $_Carreraprof,
                        'Especialidad'      => strtoupper($_Especialidad),
                        'IdPais'            => $_IdPais,
                        'Direccion'         => strtoupper($_Direccion),                       
                        'IdUsuario'         => $GetUser,
                        'Ip'                => $ipAddress,
                        'updated_at'        =>date('Y-m-d H:i:s'),
                        'created_at'        =>date('Y-m-d H:i:s')
                        ]);
                       
                }   
                      
                if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                return Response::json($Resp);  
                               
            }           
    } 


}