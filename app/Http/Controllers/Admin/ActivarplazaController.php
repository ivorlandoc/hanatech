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

class ActivarplazaController extends Controller { 
    public function index(Request $request){  
       $idUserSession = Sentinel::getUser()->id;     
      return view('admin.activap.index',compact('idUserSession')); 
    }


public function Getdatosparaactivar(Request $Request){
     if($Request->ajax()){
         $id         = $Request->input("txtplazaA");          
         $data= DB::select('SELECT  
          IdPlaza,
          IdEstructura,
          NroPlaza,
          IF(c.IdEstadoPlaza IS NULL," ",(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado,
          DATE_FORMAT(FechaCese,"%d/%m/%Y") AS FechaCese,
          IF(Fechacese>=(SELECT fecha FROM periodopresupuestos WHERE estado="1" LIMIT 1),"SI","NO") AS sino
          FROM cuadronominativo  c 
          WHERE  c.NroPlaza = "'.$id.'"');        
          return Response::json($data); 
        }    

}



public function ProcesaActivaPlazas(Request $Request,$id){
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

                $_NroPza          = $Request->input("nroplazaactivar");
                $_Fcese          = $Request->input("fechaceseActivar");
                $_DocRefActivar  = $Request->input("docrefActivar");  
                $_FileAdjunto    = $Request->hasFile('FileAdjuntoActivar');
                $_Observacion    = $Request->input("obserActivar");  

                //----------------Get contador-------------
                 $getdata     =DB::table('cuadronominativo')->where('NroPlaza', $_NroPza)->select(DB::raw('CONVERT(IdPlaza,CHAR(6)) AS IdPlaza'),'IdEstructura','IdCargo','NroPlaza','Fechacese')->get();
                 $_idPlaza=""; $_idEstr=""; $_idcargo=""; $_Plaza=""; $_fcese="";                
                foreach ($getdata as $key) 
                  {
                    $_idPlaza  =$key->IdPlaza;
                    $_idEstr   =$key->IdEstructura; 
                    $_idcargo  =$key->IdCargo;
                    $_Plaza    =$key->NroPlaza;
                    $_fcese    =$key->Fechacese;
                  }
       
                    $aff=DB::table('cuadronominativo')->where('NroPlaza',$_Plaza)->update([
                      'FechaCese' =>Carbon::parse($_Fcese)->format('Y-m-d'),
                      'IdUsuario' =>$UserSession->email,
                      'Ip' =>$ipAddress,
                      'created_at'    => date('Y-m-d H:i:s'),
                      'updated_at'    => date('Y-m-d H:i:s')
                    ]);
        
                    $fileName=$_idPlaza.$_Plaza;// nombre del archivo .pdf
                    $name="";
                    $res=array($_Plaza);
                    if($_FileAdjunto) {
                        $file = $Request->file('FileAdjuntoActivar'); 
                        $path = public_path('uploads/files/');
                        array_push($res, $path);
                        $name = "A-".$fileName.'.'.$file->getClientOriginalExtension();
                        $file->move($path, $name);
                        } 

                      $Resp=  DB::table('historiamovimiento')->insert([                    
                        'IdPlaza'       => $_idPlaza,
                        'IdPersona'     => '',
                        'IdEstructura'  => $_idEstr,
                        'NroPlaza'      => $_Plaza,
                        'FechaDocRef'   => date('Y-m-d'), // Carbon::parse($_FechaDocInte)->format('Y-m-d H:i:s'), 
                        'IdCargo'       => $_idcargo, 
                        'IdTipoMov'     => '0',
                        'DocRef'        => $_DocRefActivar,
                        'FechaMov'      => date('Y-m-d'),
                        'Observacion'   => "SE ACTIVO LA PLAZA: ".$_Plaza." SIN PRESUPUESTO(".$_fcese."). <br>".$_Observacion,
                        'FileAdjunto'   => $name,
                        'IdTipoBaja'    => '',
                        'IdEstadoPlaza' => '',
                        'IdUsuario'     => $UserSession->email,
                        'Ip'            => $ipAddress,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                     
                if($Resp)  return Response::json($Resp);   else      return Response::json($Resp);                 
            }           
        }         

 }