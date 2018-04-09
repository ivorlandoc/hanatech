<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Cargo;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use Hash;
use Illuminate\Support\Facades\Mail;
use Redirect;
use Sentinel;
use URL;
use View;
use Yajra\DataTables\DataTables;
use Validator;
Use App\Mail\Restore;
use stdClass;
use Input;
use Response;
use Carbon\Carbon;
use Persona;
use Illuminate\Database\Eloquent;


class ManteEstructurasController extends Controller { 

    public function index(Request $request){
          
        $getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "2")->get();   
       return view('admin.mantestruct.index',compact('getDosDig')); 
    }
function getResultSelect($id){
  $data=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "2")->get();
  return $data;       
}

public function GetSelect($id){
          if(strlen($id)=="2"){
            $data=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "4")->where('IdEstructura', 'like', $id.'%')->get();
        } elseif (strlen($id)=="4") { 
             $data=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "6")->where('IdEstructura', 'like', $id.'%')->get();
         }elseif (strlen($id)=="6") {           
            $data=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "8")->where('IdEstructura', 'like', $id.'%')->get();//->groupBy('NewCodigo')->get();
        } elseif (strlen($id)=="8" ) {
          $data=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "10")->where('IdEstructura', 'like', $id.'%')->get();
               
         } elseif (strlen($id)=="10" ) {     
          $data=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "12")->where('IdEstructura', 'like', $id.'%')->get();       
         }   
         return $data;
    }

public function showdetalleestructura(Request $request,$id){
    $_string="";
  if($request->ajax()){ 
        $idx                      = $request->input("id");
        if($idx==2) {$_string     = $request->input("select_4dig"); }        
        if($idx==3) {$_string     = $request->input("select_6dig"); }
        if($idx==4) {$_string     = $request->input("select_8dig"); }
        if($idx==5) {$_string     = $request->input("select_10dig"); }
        $data=DB::select("SELECT IdEstructura,
        (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT('$_string',4) LIMIT 1) AS organo,
        (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 AND LEFT(IdEstructura,6)=LEFT('$_string',6) LIMIT 1) AS gerencia,
        (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 AND LEFT(IdEstructura,8)=LEFT('$_string%',8) LIMIT 1) AS dependencia,
        (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 AND LEFT(IdEstructura,10)=LEFT('$_string%',10) LIMIT 1) AS oficina,
        descripcion AS servicio
        FROM estructura WHERE IdEstructura like '$_string%' ");  
  }               
      return Response::json($data);

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

public function showDetails( $id){
$data=DB::select("SELECT Dni, IF(CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres) IS NULL,' VACANTE', CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres))AS nombres,
            CONVERT(IdPlaza,CHAR(6)) AS IdPlaza, IdEstructura,IdNivel,cu.IdCargo,car.Descripcion AS cargo, cu.IdPersona,
            (SELECT Descripcion FROM estructura WHERE IdEstructura=cu.IdEstructura LIMIT 1) AS descrip
            FROM persona AS p RIGHT JOIN  cuadronominativo AS cu ON p.IdPersona=cu.IdPersona
            INNER JOIN cargo AS car ON car.IdCargo=cu.IdCargo
             WHERE IdEsTructura LIKE '$id%' AND IdEstadoPlaza='1' ");
return $data;
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
    $idUserSession = Sentinel::getUser()->id;   //almacena id de sesion activa  
  return view('admin.mantestruct.create',compact('idUserSession'));
}

  function getresult_change(Request $Request,$id){
     if($Request->ajax()){   
          $data=DB::select("SELECT Dni, CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres) AS nombres,CONVERT(IdPlaza,CHAR(6)) AS IdPlaza, IdEstructura,IdNivel,cu.IdCargo,car.Descripcion as cargo, cu.IdPersona,
                      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT(cu.IdEstructura,4) LIMIT 1) AS organo,
                      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT(cu.IdEstructura,6) LIMIT 1) AS dep,
                      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT(cu.IdEstructura,8) LIMIT 1) AS centro,
                      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT(cu.IdEstructura,10) LIMIT 1) AS oficina,
                      (SELECT Descripcion FROM estructura WHERE IdEstructura=cu.IdEstructura limit 1) AS descrip
                      FROM persona AS p LEFT JOIN  cuadronominativo AS cu ON p.IdPersona=cu.IdPersona
                      INNER JOIN cargo AS car ON car.IdCargo=cu.IdCargo
                       WHERE (Dni LIKE '$id%' OR CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres) LIKE '$id%') AND IdEstadoPlaza='1' limit 20");
        }                            
         return Response::json($data); 
      }

      /*==============================*/
  public function _cambiarDeEstructurapersona(Request $Request){
          $UserSession = Sentinel::findById($Request->input("idUserSession"));
             $ipAddress = '';               
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
                    $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                        $ipAddress = trim($_SERVER['REMOTE_ADDR']);
                    }
                } 

        $Resp="";
       if($Request->ajax()){          
                     
                $_txt5toNivel       = $Request->input("sel5");
                $_txt6toNivel       = $Request->input("sel6");
                $_txtIdPlaza        = $Request->input("txtidplaza");
                $_txtDocRef        = $Request->input("txtreferencia");   
                $_txtFecDoc        = $Request->input("txtfechadoc");         
                $_FileAdjChamge     = $Request->hasFile('FileAdjuntoChange');
               /*===========================================================================*/
               $_NewCodigo = "";
               if($_txt6toNivel=="") $_NewCodigo=$_txt5toNivel; else $_NewCodigo=$_txt6toNivel;
                $Rpta=DB::table('cuadronominativo')->where('IdPlaza',$_txtIdPlaza)->update([
                  'IdEstructura' =>$_NewCodigo,                  
                  'IdUsuario'     =>$UserSession->email,
                  'Ip'            =>$ipAddress,
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
                        'IdUsuario'     =>$UserSession->email,
                        'Ip'            =>$ipAddress,
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