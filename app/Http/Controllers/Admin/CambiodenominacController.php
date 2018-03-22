<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Facade;
use DB;
use Sentinel;
use Input;
use Response;
use Carbon\Carbon;
use File;
use Hash;
use lib\libController;

class CambiodenominacController extends Controller { 
  /*private $ipAddress;
  public function __construct(){
     $ipAddress= libController::_getIpAddress();
   }*/

    public function index(Request $request){  
       $idUserSession = Sentinel::getUser()->id;  
       $data = DB::table('cargo')->select('IdCargo','Descripcion')->where('Flag','=','O')->orderby('IdCargo','asc')->get(); 
       $datan = DB::table('nivel')->select('IdNivel','Descripcion')->get(); 
      return view('admin.cambio.index',compact('idUserSession','data','datan')); 
    }


public function SearchCargo(Request $Request){
     if($Request->ajax()){
         $id         = $Request->input("txtSearchPlz");          
         $data= DB::select('SELECT  IdPlaza,c.IdEstructura,          
          c.NroPlaza,car.Descripcion AS cargo,car.IdNivel,c.IdCargo,
          IF(c.IdEstadoPlaza IS NULL," ",(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado
          FROM cuadronominativo  c  INNER JOIN cargo car ON car.IdCargo=c.IdCargo INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
             WHERE  c.NroPlaza = "'.$id.'" ');        
          return Response::json($data); 
        }    

}


public function SaveChangeCargo(Request $Request,$id){
             $UserSession = Sentinel::findById($Request->input("idUserSession"));
            // $ipAddress = $ipAddress->_getIpAddress();          
              
                  $ipAddress = '';               
                  if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
                      $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
                  } else {
                      if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                          $ipAddress = trim($_SERVER['REMOTE_ADDR']);
                      }
                  } 
                           

            if($Request->ajax()){
                $_NroPlaza          = $Request->input("nroplazaSearch");
                $_idcargo           = $Request->input("_selectCargo");
                $_DocRef            = $Request->input("docrefchange");                
                $_FileAdjunto       = $Request->hasFile('FileAdjuntoChange');
                $_obser             = $Request->input("idObservacion");
                $_FechaDoc          = $Request->input("FechaDocChang");

                //-----------------------------
                 $getdata     =DB::table('cuadronominativo')->where('NroPlaza', $_NroPlaza)->select('IdPersona',DB::raw('CONVERT(IdPlaza,CHAR(6)) AS IdPlaza'),'IdEstructura','IdCargo')->get();
                 $_idPlaza=""; $_idEstr=""; $_idPer="";$_idCarg="";                 
                foreach ($getdata as $key) 
                  {
                    $_idPer     =   $key->IdPersona;
                    $_idPlaza   =   $key->IdPlaza;
                    $_idEstr    =   $key->IdEstructura; 
                    $_idCarg    =   $key->IdCargo;                    
                  }          
                    /*================================*/
                      $Resp = DB::table('cuadronominativo')->where('NroPlaza',$_NroPlaza)->update(['IdCargo'=> $_idcargo,'IdUsuario' => $UserSession->email,'Ip'=> $ipAddress,'created_at'=> date('Y-m-d H:i:s'),'updated_at'=> date('Y-m-d H:i:s')]);  
                    /*=============================================================================*/
                    $fileName   =   $_idPer.$_idPlaza.$_NroPlaza;// nombre del archivo .pdf
                    $name="";
                    $res=array($_NroPlaza);
                    if($_FileAdjunto) {
                        $file = $Request->file('FileAdjuntoChange'); 
                        $path = public_path('uploads/files/');
                        array_push($res, $path);
                        $name = "CD".$fileName.'.'.$file->getClientOriginalExtension();
                        $file->move($path, $name);
                        } 

                      $Resp=  DB::table('historiamovimiento')->insert([                    
                        'IdPlaza'       => $_idPlaza,
                        'IdPersona'     => $_idPer,
                        'IdEstructura'  => $_idEstr,
                        'NroPlaza'      => $_NroPlaza,
                        'FechaDocRef'   => Carbon::parse($_FechaDoc)->format('Y-m-d H:i:s'), 
                        'IdCargo'       => $_idCarg, 
                        'IdTipoMov'     => "0",
                        'DocRef'        => $_DocRef,
                        'FechaMov'      => date('Y-m-d'),
                        'Observacion'   => $_obser,
                        'FileAdjunto'   => $name,
                        'IdTipoBaja'    => '',
                        'IdEstadoPlaza' => '',
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