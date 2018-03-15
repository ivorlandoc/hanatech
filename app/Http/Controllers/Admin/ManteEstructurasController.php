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



class ManteEstructurasController extends Controller { 

    public function index(Request $request){
        $getDosDig=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "2")->get();   
       return view('admin.mantestruct.index',compact('getDosDig')); 
    }
function getResultSelect($id){
  $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "2")->get();
  return $data;       
}

public function GetSelect($id){
          if(strlen($id)=="2"){
            $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "4")->where('NewCodigo', 'like', $id.'%')->get();
        } elseif (strlen($id)=="4") { 
             $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "7")->where('NewCodigo', 'like', $id.'%')->get();
         }elseif (strlen($id)=="7") {           
            $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "11")->where('NewCodigo', 'like', $id.'%')->groupBy('NewCodigo')->get();
        }  /*elseif (strlen($id)=="11") {
           $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "15")->where('NewCodigo', 'like', $id.'%')->groupBy('NewCodigo')->get();
         }*/elseif (strlen($id)=="11") {
             $data=DB::select("SELECT IdEstructura,
              (SELECT Descripcion FROM estructura WHERE LEFT(NewCodigo,4)=LEFT('$id',4) LIMIT 1) AS organo,
              (SELECT Descripcion FROM estructura WHERE LEFT(NewCodigo,7)=LEFT('$id',7) LIMIT 1) AS gerencia,
              (SELECT Descripcion FROM estructura WHERE LEFT(NewCodigo,11)=LEFT('$id',11) LIMIT 1) AS dependencia,             
               descripcion as dep2
              FROM estructura WHERE NewCodigo LIKE '$id%' AND LENGTH(NewCodigo)>11  group by NewCodigo ORDER BY descripcion ASC");             
         }  
         return $data;
    }


    public function showDetails($id){
       $data=DB::select("SELECT Dni, IF(CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres) IS NULL,' VACANTE', CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres))AS nombres,CONVERT(IdPlaza,CHAR(6)) AS IdPlaza, IdEstructura,IdNivel,cu.IdCargo,car.Descripcion as cargo, cu.IdPersona,
                          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),4) limit 1) AS organo,
                          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),7) limit 1) AS dep,
                          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,11)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),11) limit 1) AS dep2,
                          (SELECT Descripcion FROM estructura WHERE IdEstructura=cu.IdEstructura limit 1) AS descrip
                          FROM persona AS p right JOIN  cuadronominativo AS cu ON p.IdPersona=cu.IdPersona
                          INNER JOIN cargo AS car ON car.IdCargo=cu.IdCargo
                           WHERE IdEsTructura LIKE '$id%' AND IdEstadoPlaza='1' ");
        return $data;
    }

function updateOficinaEstruct(Request $request){            
                $ipAddress = '';               
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
                    $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                        $ipAddress = trim($_SERVER['REMOTE_ADDR']);
                    }
                }                
          if($request->ajax()){   
              $_idestru         = $request->input("idestru");         
              $_DescripOfic     = $request->input("Descrip");   

              $aff=DB::table('estructura')->where('IdEstructura', $_idestru)->update(['Descripcion' =>$_DescripOfic,'IdUsuario'     =>$ipAddress,'updated_at'    =>date('Y-m-d H:i:s'),'created_at'    =>date('Y-m-d H:i:s')]);
            }               
            return Response::json($aff);
}

function addNewEstructura(Request $Request){
        $_user="Admin";
        $Resp;
       if($Request->ajax()){          
                     
                $_IdEstructura         = $Request->input("select_10dig");
                $_txtcuartoNivel       = $Request->input("txtcuartoNivel");        
                $_NewCodigo = "";
                $_query     = " SELECT CONCAT(idEst,'',LPAD(MAX(ff)+1,2,'0')) AS NewCod FROM (SELECT LEFT(IdEstructura,10) AS idEst, COUNT(LEFT(IdEstructura,10)) AS id,  IF(LENGTH(IdEstructura)>10,RIGHT(IdEstructura,2),'0') AS ff   FROM  estructura WHERE LEFT(IdEstructura,10) = '$_IdEstructura' GROUP BY IdEstructura ) AS d GROUP BY idEst ";
                $GetNewCod = DB::select($_query); 
                foreach ($GetNewCod as $keys) $_NewCodigo  = $keys->NewCod;            
                $Resp = DB::table('estructura')->insert([
                  'IdEstructura' =>$_NewCodigo,
                  'Descripcion'  =>$_txtcuartoNivel,
                  'IdUsuario'    =>$_user
                ]);         
            }
            if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                  return Response::json($Resp);
      }


public function create(){ 
  return view('admin.mantestruct.create');
}

  function getresult_change($id){
          $data=DB::select("SELECT Dni, CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres) AS nombres,CONVERT(IdPlaza,CHAR(6)) AS IdPlaza, IdEstructura,IdNivel,cu.IdCargo,car.Descripcion as cargo, cu.IdPersona,
                          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT(cu.IdEstructura,4) limit 1) AS organo,
                          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT(cu.IdEstructura,7) limit 1) AS dep,
                          (SELECT Descripcion FROM estructura WHERE IdEstructura=cu.IdEstructura limit 1) AS descrip
                          FROM persona AS p LEFT JOIN  cuadronominativo AS cu ON p.IdPersona=cu.IdPersona
                          INNER JOIN cargo AS car ON car.IdCargo=cu.IdCargo
                           WHERE (Dni LIKE '$id%' OR CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres) LIKE '$id%') AND IdEstadoPlaza='1' limit 20");
        return $data;
      }

      /*==============================*/
       function _cambiarDeEstructurapersona(Request $Request){
        $_user="Admin";
        $Resp="";
       if($Request->ajax()){          
                     
                $_txt4toNivel       = $Request->input("sel4");
                $_txt5toNivel       = $Request->input("sel5");
                $_txtIdPlaza        = $Request->input("txtidplaza");
                $_txtDocRef        = $Request->input("txtreferencia");   
                $_txtFecDoc        = $Request->input("txtfechadoc");         
                $_FileAdjChamge     = $Request->hasFile('FileAdjuntoChange');
               /*===========================================================================*/
               $_NewCodigo = "";
               if($_txt5toNivel=="") $_NewCodigo=$_txt4toNivel; else $_NewCodigo=$_txt5toNivel;
                $Rpta=DB::table('cuadronominativo')->where('IdPlaza',$_txtIdPlaza)->update([
                  'IdEstructura' =>$_NewCodigo,                  
                  'IdUsuario'    =>$_user,
                  'updated_at'   =>date('Y-m-d H:i:s'),
                  'created_at'   =>date('Y-m-d H:i:s') 
                ]);  
                /*===========================================================================*/
                $_IdPersona=""; $_NroPlaza =""; $_IdCargo ="";
                $GetData = DB::select("SELECT IdPersona,IdCargo,NroPlaza FROM  cuadronominativo WHERE IdPlaza='$_txtIdPlaza'");
                foreach ($GetData as $keys) $_IdPersona  = $keys->IdPersona;  $_NroPlaza  = $keys->NroPlaza; $_IdCargo  = $keys->IdCargo;

                if($Rpta===1){
                  $res=array($_txtIdPlaza);
                    $fileName=$_IdPersona.$_txtIdPlaza.$_NroPlaza;// nombre del archivo .pdf
                    $name="";
                    if($_FileAdjChamge) {
                        $file = $Request->file('FileAdjuntoChange'); 
                        $path = public_path('uploads/files/');
                        array_push($res, $path);
                        $name = $fileName.'.'.$file->getClientOriginalExtension();
                        $file->move($path, $name);
                        }               
                    $Resp = DB::table('historiamovimiento')->insert([
                        'IdPersona'     => $_IdPersona, // *
                        'IdPlaza'       => $_txtIdPlaza,
                        'IdEstructura'  => $_NewCodigo,
                        'IdCargo'       => $_IdCargo, // *
                        'NroPlaza'      => $_NroPlaza,
                        'IdTipoMov'     => "0", // *
                        'IdTipoBaja'    => "",
                        'FechaDocRef'   => Carbon::parse($_txtFecDoc)->format('Y-m-d H:i:s'),
                        'FechaMov'      => date('Y-m-d H:i:s'),
                        'DocRef'        => $_txtDocRef,
                        'FileAdjunto'   => $name,
                        'Observacion'   => "",
                        'IdUsuario'     => $_user,
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
      /*=============================*/
       
  }