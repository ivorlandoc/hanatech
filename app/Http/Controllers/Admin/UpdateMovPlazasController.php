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
      $getDosDig=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "2")->get();
      return view('admin.upmov.index',compact('getDosDig', 'idUserSession')); 

  }

      public function _getalldatosMov(Request $Request){
          if($Request->ajax()){            
            $id =  $Request->input("search_plaza_mov");
                $data = DB::select("SELECT IdHistoria,IdPlaza,IdPersona,
                        (SELECT dni FROM Persona WHERE IdPersona =h.IdPersona) AS dni,
                        (SELECT CONCAT(ApellidoPat,' ',ApellidoMat,' ',Nombres) FROM Persona WHERE IdPersona =h.IdPersona) AS Nombres,
                        IdEstructura,IdCargo,NroPlaza,IF(IdTipoMov<>'','MOV.',IF(IdTipoBaja<>'','BAJA','OTROS')) AS mov,FechaMov,FechaDocRef,Docref,Observacion,FileAdjunto
                         FROM historiamovimiento h HAVING (Nombres LIKE '$id%' OR NroPlaza LIKE '$id%' OR dni LIKE '$id%')");
                 return Response::json($data); 
            }   
    }






        public function GeTtipoMov($id){        
            $GetTipoM = DB::select("SELECT IdTipoMov,Descripcion FROM tipomovimiento where tipomov='1' ORDER BY 1");
            return $GetTipoM;   
        }


        public function ProcesaInsert(Request $Request){

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
                $_IdPersona         = $Request->input("IdPersonaG");
                $_IdPlaza           = $Request->input("IdPlazaG");
                $_IdEstrOrigen      = $Request->input("IdEstructuraG");
                $_IdEstrDestino     = $Request->input("select_44");
                $_IdCargo           = $Request->input("IdCargoG");
                $_NroPlaza          = $Request->input("NroPlazaG");
                $_IdTipoMov         = $Request->input("IdTipoMovimiento");
                $_FechaMov          = $Request->input("FechaMov");
                $_FechaDocRef       = $Request->input("FechaDocRef");
                $_DocRefmov         = $Request->input("DocRefmov");
                $_Observacion       = $Request->input("Observacion");
                $_FileAdjuntomov    = $Request->hasFile('FileAdjuntomov');
               
                $res=array($_IdPersona);
                $fileName=$_IdPersona.$_IdPlaza.$_NroPlaza;// nombre del archivo .pdf
                if($_FileAdjuntomov) {
                    $file = $Request->file('FileAdjuntomov');       //$imgextension = $file->getClientOriginalExtension();
                    $path = public_path('uploads/files/');
                    array_push($res, $path);
                    $name = $fileName.'.'.$file->getClientOriginalExtension();
                    $file->move($path, $name);
                }
            if($_IdTipoMov==6 && $_IdPersona==""){ // Unicamente cuando es transferencia, la plaza debe estar vacante. Se actualiza la dependencia en el nominativo y se add al movimiento
                $aff=DB::table('cuadronominativo')->where('IdPlaza',$_IdPlaza)->update(['IdEstructura' =>$_IdEstrDestino,'IdUsuario' =>$UserSession->email,'Ip' =>$ipAddress]);
           }elseif($_IdTipoMov==1 || $_IdTipoMov==2) { // Desplazamientos y/o Rotaciones Permanentes, se actualiza la dependencia en el nominativo y se add al movimiento
                $aff=DB::table('cuadronominativo')->where('IdPersona', $_IdPersona)->where('IdPlaza',$_IdPlaza)->update(['IdEstructura' =>$_IdEstrDestino,'IdUsuario' =>$UserSession->email,'Ip' =>$ipAddress]);
           }elseif($_IdTipoMov==3 && $_IdPersona!="") { // Para Permutas: debe existir la persona en la plaza. Se actualiza la dependencia en el nominativo y se add a la movimiento
            $aff=DB::table('cuadronominativo')->where('IdPersona', $_IdPersona)->where('IdPlaza',$_IdPlaza)->update(['IdEstructura' =>$_IdEstrDestino,'IdUsuario' =>$UserSession->email,'Ip' =>$ipAddress]);
           }else{ // Desplazamientos y/o Rotaciones Temporales, se mantiene la dependencia de origen en el nominativo, y se add al movimiento.
                $aff=DB::table('cuadronominativo')->where('IdPersona', $_IdPersona)->where('IdPlaza',$_IdPlaza)->update(['IdEstructura' =>$_IdEstrOrigen,'IdUsuario' =>$UserSession->email,'Ip' =>$ipAddress]);
                $_IdEstrDestino=$_IdEstrOrigen;
           }

            if($_IdTipoMov==21 || $_IdTipoMov==23 ) $_IdEstrDestino=$_IdEstrOrigen;
            
                $Resp = DB::table('historiamovimiento')->insert([
                    'IdPersona'     => $_IdPersona,
                    'IdPlaza'       => $_IdPlaza,
                    'IdEstructura'  => $_IdEstrDestino,
                    'IdCargo'       => $_IdCargo,
                    'NroPlaza'      => $_NroPlaza,
                    'IdTipoMov'     => $_IdTipoMov,
                    'IdTipoBaja'    => "",
                    'IdEstadoPlaza' => "",
                    'FechaDocRef'   => Carbon::parse($_FechaDocRef)->format('Y-m-d H:i:s'),
                    'FechaMov'      => Carbon::parse($_FechaMov)->format('Y-m-d H:i:s'),
                    'DocRef'        => $_DocRefmov,
                    'FileAdjunto'   =>  $name,
                    'Observacion'   => $_Observacion,
                    'IdUsuario'     => $UserSession->email,
                    'Ip'            => $ipAddress,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);

                    if($Resp)                  
                         return Response::json($Resp); // redirect()->route('admin.gesplazas.index')->with('success','La operación se realizó con éxito!');  
                            else                  
                         return Response::json($Resp); // redirect()->route('admin.gesplazas.index')->with('Danger','La operación no se realizó!'); 
                   
            }           
        }   

}