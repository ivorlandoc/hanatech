<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use\App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Facade;
use DB;
use Sentinel;
use Input;
use Response;
use Carbon\Carbon;
use File;
use Hash;

class IntegrarPlazaController extends Controller { 
    public function index(Request $request){  
       $idUserSession = Sentinel::getUser()->id;  
  
       $data = DB::select("SELECT IdTipoMov,Descripcion FROM tipomovimiento WHERE Alta='1' ORDER BY IdTipoMov");   
      return view('admin.integra.index',compact('idUserSession','data')); 
    }


public function getdatosintegra(Request $Request){
     if($Request->ajax()){
         $id         = $Request->input("txtplaza");          
         $data= DB::select('SELECT  IdPlaza,c.IdEstructura,
           --  (SELECT Descripcion FROM Estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
           --  (SELECT Descripcion FROM Estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
           -- (SELECT Descripcion FROM Estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),7) LIMIT 1) AS dep,
           -- e.Descripcion AS descripcion,
          c.NroPlaza,car.Descripcion AS cargo,car.IdNivel,
          IF(c.IdEstadoPlaza IS NULL," ",(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado
          FROM cuadronominativo  c  INNER JOIN cargo car ON car.IdCargo=c.IdCargo INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
             WHERE  c.NroPlaza = "'.$id.'" AND c.IdEstadoPlaza NOT IN("0","1")');        
          return Response::json($data); 
        }    

}



public function Procesaintegraplaza(Request $Request,$id){
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
                $_DocRef         = $Request->input("docrefintegra");
                $_FechaDocInte   = $Request->input("fechadocintegra");
                $_SelMotivo      = $Request->input("_selectMotivo");
                $_NroPlazaInteg  = $Request->input("nroplazaintegrada");  
                $_FileAdjunto    = $Request->hasFile('FileAdjuntoIntegra');

                //----------------Get contador-------------
                 $getdata     =DB::table('cuadronominativo')->where('NroPlaza', $_NroPlazaInteg)->select(DB::raw('CONVERT(IdPlaza,CHAR(6)) AS IdPlaza'),'IdEstructura','IdCargo')->get();
                 $_idPlaza=""; $_idEstr=""; $_idcargo="";
                 $key="";
                foreach ($getdata as $key) $_idPlaza  =$key->IdPlaza;   $_idEstr  =$key->IdEstructura;  $_idcargo  =$key->IdCargo; 
       
                   
                 
                    /*================================*/
                    $i=0;
                    $_PlazasUnificadas="";
                    while($i<=4){$i++;
                      if($Request->input("IN".$i)) $_PlazasUnificadas =$_PlazasUnificadas.$Request->input("IN".$i)." | ";
                    }
                    /*================================*/
                    $fileName=$_NroPlazaInteg;// nombre del archivo .pdf
                    $name="";
                    $res=array($_NroPlazaInteg);
                    if($_FileAdjunto) {
                        $file = $Request->file('FileAdjuntoIntegra'); 
                        $path = public_path('uploads/files/');
                        array_push($res, $path);
                        $name = "I-".$fileName.'.'.$file->getClientOriginalExtension();
                        $file->move($path, $name);
                        } 

                      $Resp=  DB::table('historiamovimiento')->insert([                    
                        'IdPlaza'       => $_idPlaza,
                        'IdPersona'     =>'',
                        'IdEstructura'  => $_idEstr,
                        'NroPlaza'      => $_NroPlazaInteg,
                        'FechaDocRef'   => Carbon::parse($_FechaDocInte)->format('Y-m-d H:i:s'), 
                        'IdCargo'       => $_idcargo, 
                        'IdTipoMov'     => $_SelMotivo,
                        'DocRef'        => $_DocRef,
                        'FechaMov'      => date('Y-m-d'),
                        'Observacion'   => "SE INTEGRÓ LAS SIGUIENTES PLAZAS: ".$_PlazasUnificadas." A LA PLAZA:".$_NroPlazaInteg,
                        'FileAdjunto'   => $name,
                        'IdTipoBaja'    => '',
                        'IdUsuario'     => $UserSession->email,
                        'Ip'            => $ipAddress,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                      if($Resp==true){
                         $j=0;
                        $_idPlazaSet="";
                        while($j<=4){$j++;
                          if($Request->input("IN".$j)) {
                              $_idPlazaSet =$Request->input("IN".$j);
                              $Resp = DB::table('cuadronominativo')->where('NroPlaza',$_idPlazaSet)->update([
                                              'IdEstadoPlaza' => "0",                                 
                                              'IdUsuario'     => $UserSession->email,
                                              'Ip'            => $ipAddress,
                                              'created_at'    => date('Y-m-d H:i:s'),
                                              'updated_at'    => date('Y-m-d H:i:s')
                                          ]);  
                              /*=================================*/
                              $getdata     =DB::table('cuadronominativo')->where('NroPlaza',$_idPlazaSet)->select(DB::raw('CONVERT(IdPlaza,CHAR(6)) AS IdPlaza'),'IdEstructura','IdCargo')->get();
                               $_idPlaza2=""; $_idEstr2=""; $_idcargo2="";
                              foreach ($getdata as $key) $_idPlaza2  =$key->IdPlaza;   $_idEstr2  =$key->IdEstructura;  $_idcargo2  =$key->IdCargo;
                              /*=================================*/
                              DB::table('historiamovimiento')->insert([                    
                                            'IdPlaza'       => $_idPlaza2,
                                            'IdPersona'     =>'',
                                            'IdEstructura'  => $_idEstr2,
                                            'NroPlaza'      => $_idPlazaSet,
                                            'FechaDocRef'   => Carbon::parse($_FechaDocInte)->format('Y-m-d H:i:s'), 
                                            'IdCargo'       => $_idcargo2, 
                                            'IdTipoBaja'    => '17',
                                            'DocRef'        => $_DocRef,
                                            'FechaMov'      => date('Y-m-d'),
                                            'Observacion'   => $_idPlazaSet." | SE INTEGRÓ A PLAZA: ".$_NroPlazaInteg,
                                            'FileAdjunto'   => $name,
                                            'IdTipoBaja'    => '',
                                            'IdUsuario'     => $UserSession->email,
                                            'Ip'            => $ipAddress,
                                            'created_at'    => date('Y-m-d H:i:s'),
                                            'updated_at'    => date('Y-m-d H:i:s')
                                        ]);

                          }
                        }                  
                    }
                if($Resp)                  
                    return Response::json($Resp); 
                    else                  
                return Response::json($Resp);                 
            }           
        }   

 }