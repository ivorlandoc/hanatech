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
use Carbon\Carbon;
use Sentinel;
use User;
use File;
use Hash;

class CrearplazaController extends Controller {
    public function index(Request $request){
        $idUserSession = Sentinel::getUser()->id;   //almacena id de sesion activa  
        $allNivel=DB::table('nivel')->select('IdNivel','Descripcion')->orderBy('IdNivel')->Get();
        $allCargo=DB::table('cargo')->select('IdCargo','Descripcion')->where('Flag','O')->orderBy('IdCargo')->Get();
        $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "2")->get();
        $conta=DB::table('contadorplaza')->select('r728','rcas')->get();
        return view('admin.creaplaza.index', compact('idUserSession','allNivel','allCargo','data','conta'));
    }
public function getStructuras(Request $request,$id){
        $id= $request->input("id");      
        if(strlen($id)=="2"){   
            $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "4")->where('NewCodigo', 'like', $id.'%')->get();
        } elseif (strlen($id)=="4") { 
             $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "7")->where('NewCodigo', 'like', $id.'%')->get();
         }elseif (strlen($id)=="7") {
             $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "11")->where('NewCodigo', 'like', $id.'%')->get();           
         }elseif (strlen($id)=="11") {
            $data=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "15")->where('NewCodigo', 'like', $id.'%')->get();           
         }         
        return Response::json($data);   
    }
 
/*
   public function showDatosdep(Request $request,$id){   
        $data = DB::select("SELECT IdEstructura,NewCodigo,LEFT(NewCodigo,2) AS org,LEFT(NewCodigo,4) AS geren, LEFT(NewCodigo,7) AS dep,
                        (SELECT Descripcion FROM estructura WHERE IdEstructura=org AND LENGTH(NewCodigo)=2 LIMIT 1) AS organo,
                        (SELECT Descripcion FROM estructura WHERE IdEstructura=geren AND LENGTH(NewCodigo)=4 LIMIT 1) AS gerencia,
                        (SELECT Descripcion FROM estructura WHERE IdEstructura=dep AND LENGTH(NewCodigo)=7 LIMIT 1) AS dependencia,
                        Descripcion FROM estructura WHERE IdEstructura ='$id'");
         return Response::json($data);  
    }
*/


public function Procesacreaplaza(Request $Request,$id,$idx){
             $UserSession = Sentinel::findById($Request->input("idUserSession"));
                $ipAddress = '';               
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
                    $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                        $ipAddress = trim($_SERVER['REMOTE_ADDR']);
                    }
                }
               
            if($Request->ajax()){
                $_IdReg         = $Request->input("selereg");
                $_IdEstructura  = $Request->input("txthidenEstru");
                $_Nivel         = $Request->input("selNivel");
                $_IdCargo       = $Request->input("selecargo");
                $_DocRef        = $Request->input("docrefcrea");
                $_FechaDoc      = $Request->input("fechadoccrea");
                $_observac      = $Request->input("obserCrea");
                $NroPlaza       ="";
                $_FileAdjunto   =  $Request->hasFile('FileAdjuntoCrea');
                //----------------Get contador-------------
                 $getconta     =DB::table('contadorplaza')->select('r728','rcas')->get();
                 $_idConta728=""; $_idContaCas="";
                foreach ($getconta as $key) $_idConta728  =$key->r728;   $_idContaCas  =$key->rcas; 
                           
                if($_IdReg=="1"){
                    $NroPlaza   =   $_Nivel.$_idConta728;
                    DB::table('contadorplaza')->update(['r728'     =>$_idConta728+1]);}
                if($_IdReg=="0"){
                    $NroPlaza   =   $_idContaCas."9";
                    DB::table('contadorplaza')->update(['rcas'     =>$_idContaCas+1]);
                }
                         
                    $Resp = DB::table('cuadronominativo')->insert([                    
                        'IdEstructura'  => $_IdEstructura,
                        'IdCargo'       => $_IdCargo,
                        'NroPlaza'      => $NroPlaza,
                        'IdEstadoPlaza' => "2",                                 
                        'IdUsuario'     => $UserSession->email,
                        'Ip'            => $ipAddress,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                       
                    $fileName=$NroPlaza;// nombre del archivo .pdf
                    $name="";
                    $res=array($_IdEstructura);
                    if($_FileAdjunto) {
                        $file = $Request->file('FileAdjuntoCrea'); 
                        $path = public_path('uploads/files/');
                        array_push($res, $path);
                        $name = $fileName.'.'.$file->getClientOriginalExtension();
                        $file->move($path, $name);
                        } 

                        DB::table('plaza')->insert([                    
                        'plaza'         => $NroPlaza,
                        'DocRef'        => $_DocRef,
                        'FecDoc'        => Carbon::parse($_FechaDoc)->format('Y-m-d H:i:s'), 
                        'Observ'        => $_observac,                                 
                        'IdFile'        => $name,
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