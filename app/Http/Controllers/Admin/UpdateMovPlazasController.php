<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Facade;
use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use Response;
use Carbon\Carbon;
use Sentinel;

class UpdateMovPlazasController extends Controller {    
    public function index(Request $request){ 
      $idUserSession = Sentinel::getUser()->id; 
      $getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "2")->get();

      return view('admin.upmov.index',compact('getDosDig', 'idUserSession')); 

  }

public function _getalldatosMov(Request $Request){
  if($Request->ajax()){ 
    $fg =  $Request->input("flag");
    if($fg!=""){ 
        $data = DB::select("SELECT IdHistoria,IdPlaza,IdPersona,
                (SELECT dni FROM Persona WHERE IdPersona =h.IdPersona) AS dni,
                (SELECT CONCAT(ApellidoPat,' ',ApellidoMat,' ',Nombres) FROM Persona WHERE IdPersona =h.IdPersona) AS Nombres,
                IdEstructura,IdCargo,NroPlaza,IF(IdTipoMov<>'','MOV.',IF(IdTipoBaja<>'','BAJA','OTROS')) AS mov,FechaMov,FechaDocRef,Docref,Observacion,FileAdjunto
                 FROM historiamovimiento h where IdHistoria='$fg'");
    }else{
        $id =  $Request->input("search_plaza_mov");
                $data = DB::select("SELECT IdHistoria,IdPlaza,IdPersona,
                (SELECT dni FROM Persona WHERE IdPersona =h.IdPersona) AS dni,
                (SELECT CONCAT(ApellidoPat,' ',ApellidoMat,' ',Nombres) FROM Persona WHERE IdPersona =h.IdPersona) AS Nombres,
                IdEstructura,IdCargo,NroPlaza,IF(IdTipoMov<>'','MOV.',IF(IdTipoBaja<>'','BAJA','OTROS')) AS mov,FechaMov,FechaDocRef,Docref,Observacion,FileAdjunto
                 FROM historiamovimiento h HAVING (Nombres LIKE '$id%' OR NroPlaza LIKE '$id%' OR dni LIKE '$id%')"); 
    }
         return Response::json($data); 
    }   
}




public function ProcesaUpdateMov(Request $Request){
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
        $_IdHistoria         = $Request->input("IdHistoria");
        $_IdPlaza            = $Request->input("IdPlaza");
        $_IdPersona          = $Request->input("IdPersona");
        $_NroPlaza           = $Request->input("NroPlaza");

        $_FechaMov           = $Request->input("FechaMov");
        $_FechaDoc           = $Request->input("FechaDocRef");            
        $_DocRefmov          = $Request->input("DocRefmov");
        $_Observacion        = $Request->input("Observacion");
        $_FileAdjuntomov     = $Request->hasFile('FileAdjuntoUpdate');

        if($_FileAdjuntomov!=""){ 
                $res=array($_IdHistoria);
                $fileName=$_IdPersona.$_IdPlaza.$_NroPlaza;// nombre del archivo .pdf
                if($_FileAdjuntomov) {
                    $file = $Request->file('FileAdjuntoUpdate');       //$imgextension = $file->getClientOriginalExtension();
                    $path = public_path('uploads/files/');
                    array_push($res, $path);
                    $name = $fileName.'.'.$file->getClientOriginalExtension();
                    $file->move($path, $name);
                }
                   $Resp = DB::table('historiamovimiento')->where('IdHistoria',$_IdHistoria)->update([                   
                            'FechaDocRef'   => Carbon::parse($_FechaDoc)->format('Y-m-d H:i:s'),
                            'FechaMov'      => Carbon::parse($_FechaMov)->format('Y-m-d H:i:s'),
                            'DocRef'        => $_DocRefmov,
                            'FileAdjunto'   => $name,
                            'Observacion'   => $_Observacion,
                            'IdUsuario'     => $UserSession->email,
                            'Ip'            => $ipAddress,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s')
                        ]);
        } else {
            $Resp = DB::table('historiamovimiento')->where('IdHistoria',$_IdHistoria)->update([                   
                            'FechaDocRef'   => Carbon::parse($_FechaDoc)->format('Y-m-d H:i:s'),
                            'FechaMov'      => Carbon::parse($_FechaMov)->format('Y-m-d H:i:s'),
                            'DocRef'        => $_DocRefmov,                  
                            'Observacion'   => $_Observacion,
                            'IdUsuario'     => $UserSession->email,
                            'Ip'            => $ipAddress,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s')
                            ]);
        }
            if($Resp)                  
                 return Response::json($Resp); // redirect()->route('admin.gesplazas.index')->with('success','La operación se realizó con éxito!');  
                    else                  
                 return Response::json($Resp); // redirect()->route('admin.gesplazas.index')->with('Danger','La operación no se realizó!'); 
           
    }           
}   

}