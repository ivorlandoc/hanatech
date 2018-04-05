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

class AltadeplazaController extends JoshController {

    public function index(Request $request){
        $idUserSession = Sentinel::getUser()->id;   //almacena id de sesion activa  
		    $groups = Sentinel::getRoleRepository()->all();
        	$countries = $this->countries;               
        return view('admin.altaplaza.index', compact('groups', 'countries', 'idUserSession'));
    }
     public function getEstructura($id){       
       //$data=DB::table('estructura')->select('IdEstructura','Descripcion')->where('IdEstructura', 'like', "__00000000")->get();    
       $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "2")->get();

      return  $data;
    }

    public function getPlaza($id){   
        $data = DB::select("SELECT CONVERT(IdPlaza, CHAR(6)) AS IdPlaza,IdPersona,IdEstructura,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),7) LIMIT 1) AS dep,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,11)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),11) LIMIT 1) AS dep2,
                (SELECT Descripcion FROM estructura WHERE IdEstructura=c.IdEstructura ) AS descrip,
                c.IdCargo,NroPlaza, IF(ca.IdTipo='1','ADMINISTRATIVO','ASISTENCIAL') AS tipo, IdNivel,ca.Descripcion AS cargo 
                FROM cuadronominativo AS c INNER JOIN cargo ca ON ca.IdCargo=c.IdCargo WHERE NroPlaza='$id'");

        return $data;
    }

     public function getTipoMovForALta($id){   
        $data = DB::select("SELECT IdTipoMov,Descripcion FROM tipomovimiento WHERE Alta='1' ORDER BY IdTipoMov");
        return $data;
    }

 public function getRegimenForAlta($id){   
        $data = DB::select("SELECT IdRegimen,Descripcion FROM regimen");
        return $data;
    }


public function ProcesaInsertAlta(Request $Request){
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
                //=======Datos para insert persona====================
              //  $_IdPersona         = $__IdPersona;  
                $_IdTipoDoc         = $Request->input("IdTipoDocument");
                $_Nrodni            = $Request->input("nrodocumento");
                $_ApellidoPat       = $Request->input("ape_pat");
                $_ApellidoMat       = $Request->input("ape_mat");
                $_Nombres           = $Request->input("txtnombre");
                $_FechaNac          = $Request->input("Fechanac");
                $_Regimen           = $Request->input("IdRegimen");
                $_Genero            = $Request->input("idgenero");
                $_Carreraprof       = $Request->input("idcarrera");
                $_Especialidad      = $Request->input("txtespecialidad");
                $_IdPais            = $Request->input("country");
                $_Direccion         = $Request->input("txtdireccion");          
                /*==Datos para actualziar el cuadro nominativo*/
                $_NroPlaza          = $Request->input("NroPlazaA");
                $_IdCargo           = $Request->input("IdCargoA");
                $_IdEstructura      = $Request->input("IdEstructuraA");
                //======Para insertar en el historial de movimientos============
                $_IdPlaza           = $Request->input("IdPlazaA");
                $_TipoAlta          = $Request->input("selectIdalta");
                $_FechaAlta         = $Request->input("IdFechaalta");
                $_FileAdjuntoAlta   = $Request->hasFile('FileAdjuntoAlta');
                $_ObserAlta         = $Request->input("ObserAlta");
                $_idresid           = $Request->input("idresid");
                /* =================== si existe la persona se actualiza sus datos  */
                $GetDni         =DB::table('persona')->where('Dni','=',$_Nrodni)->select('Dni')->get('Dni');   
                $CheckDni="";
                foreach ($GetDni as $key) $CheckDni  =$key->Dni; 
                //----------------Get Idpersona-------------
                 $GetPersona     =DB::table('persona')->where('Dni','=',$_Nrodni)->select('IdPersona')->get('IdPersona');
                 $_IdPersona="";
                foreach ($GetPersona as $keys) $_IdPersona  =$keys->IdPersona; 
                /*=======================================================================================*/

                if($CheckDni!=""){
                    $Resp=DB::table('persona')->where('Dni', $_Nrodni)->update([
                        'IdTipoDocumento'   =>$_IdTipoDoc, 
                        'ApellidoPat'       =>$_ApellidoPat,
                        'ApellidoMat'       =>$_ApellidoMat, 
                        'Nombres'           =>$_Nombres,
                        'FechaNac'          =>Carbon::parse($_FechaNac)->format('Y-m-d H:i:s'), 
                        'FechaIngreso'      =>Carbon::parse($_FechaAlta)->format('Y-m-d H:i:s'), 
                        'IdRegimen'         =>$_Regimen, 
                        'Genero'            =>$_Genero, 
                        'IdProfesion'       =>$_Carreraprof, 
                        'Especialidad'      =>$_Especialidad, 
                        'IdPais'            =>$_IdPais, 
                        'Direccion'         =>$_Direccion,
                        'Residentado'       =>$_idresid,
                        'IdUsuario'         =>$UserSession->email,
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
                        'ApellidoPat'       => $_ApellidoPat,
                        'ApellidoMat'       => $_ApellidoMat,
                        'Nombres'           => $_Nombres,
                        'FechaNac'          => Carbon::parse($_FechaNac)->format('Y-m-d H:i:s'),
                        'FechaIngreso'      => Carbon::parse($_FechaAlta)->format('Y-m-d H:i:s'),                    
                        'IdRegimen'         => $_Regimen,
                        'Genero'            => $_Genero,                   
                        'IdProfesion'       => $_Carreraprof,
                        'Especialidad'      => $_Especialidad,
                        'IdPais'            => $_IdPais,
                        'Direccion'         => $_Direccion,
                        'Residentado'       => $_idresid,
                        'IdUsuario'         => $UserSession->email,
                        'updated_at'        =>date('Y-m-d H:i:s'),
                        'created_at'        =>date('Y-m-d H:i:s')
                        ]);
                        $_IdPersona=$IdPersona;
                }                              
                // ===Asignamos la persona a la plaza en elnominativo========== 
                if($Resp==1){
                        if($_IdPersona!=""){
                                $aff=DB::table('cuadronominativo')->where('NroPlaza', $_NroPlaza)->where('IdCargo', $_IdCargo)->where('IdEstructura',$_IdEstructura)
                                ->update([
                                            'IdPersona'     =>$_IdPersona,
                                            'IdEstadoPlaza' =>"1",
                                            'FechaCese'     =>"1000-01-01",
                                            'IdUsuario'     =>$UserSession->email,
                                            'Ip'            =>$ipAddress,
                                            'updated_at'    =>date('Y-m-d H:i:s'),
                                            'created_at'    =>date('Y-m-d H:i:s')
                                            ]);
                            }
                       //========Para insertar en el historial de movimientos===========================
                        //if($aff===true){
                                $res=array($_IdPlaza);
                                $fileName=$_IdPersona.$_IdPlaza.$_NroPlaza;// nombre del archivo .pdf
                                $name="";
                                if($_FileAdjuntoAlta) 
                                    {
                                        $file = $Request->file('FileAdjuntoAlta'); 
                                        $path = public_path('uploads/files/');
                                        array_push($res, $path);
                                        $name = $fileName.'.'.$file->getClientOriginalExtension();
                                        $file->move($path, $name);
                                    }               
                                $Resp = DB::table('historiamovimiento')->insert([
                                    'IdPersona'     => $_IdPersona,
                                    'IdPlaza'       => $_IdPlaza,
                                    'IdEstructura'  => $_IdEstructura,
                                    'IdCargo'       => $_IdCargo,
                                    'NroPlaza'      => $_NroPlaza,
                                    'IdTipoMov'     => $_TipoAlta,
                                    'IdTipoBaja'    => "",
                                    'FechaDocRef'   => Carbon::parse($_FechaAlta)->format('Y-m-d H:i:s'),
                                    'FechaMov'      => date('Y-m-d H:i:s'),
                                    'DocRef'        => $_ObserAlta,
                                    'FileAdjunto'   => $name,
                                    'Observacion'   => "",
                                    'IdUsuario'     => $UserSession->email,
                                    'Ip'            => $ipAddress,
                                    'created_at'    => date('Y-m-d H:i:s'),
                                    'updated_at'    => date('Y-m-d H:i:s')
                                ]);
                        //}
                }
                if($Resp)                  
                    return Response::json($Resp); // redirect()->route('admin.gesplazas.index')->with('success','La operación se realizó con éxito!');  
                    else                  
                return Response::json($Resp);                 
            }           
        }   

public function getEstructuraShowLink($id){
             $dataP =DB::select('SELECT  c.IdPersona,IdPlaza, c.NroPlaza, c.IdEstructura,e.Descripcion AS descripcion,
                      car.IdNivel,car.Descripcion AS cargo,IF(p.ApellidoPat IS NULL,"-",p.ApellidoPat)  AS ApellidoPat,
                      IF(p.ApellidoMat IS NULL,"-",p.ApellidoMat) AS ApellidoMat,IF(p.Nombres IS NULL,"-",p.Nombres) AS Nombres
                      FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
                        INNER JOIN cargo car ON car.IdCargo=c.IdCargo   INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
                         WHERE  c.IdEstructura LIKE "'.$id.'%" GROUP BY e.IdEstructura,IdTipo,NroPlaza');  

        return $dataP;//sview('admin.plazas.index',compact('AllData')); 
    }

    public function getResultSearchPer($id){
    $dataP =DB::select("SELECT Dni,CONCAT(ApellidoPat,' ',ApellidoMat,' ',Nombres) AS Nombres,convert(NroPlaza, char(8)) as NroPlaza FROM persona p LEFT JOIN cuadronominativo c ON c.IdPersona=p.IdPersona WHERE (Dni LIKE '".$id."%' OR CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres) LIKE '".$id."%') GROUP BY c.IdPersona limit 10");  
        return $dataP;
    }

     public function getResultSearchPerSet($id){
            $id=str_pad($id,8, "0", STR_PAD_LEFT);
            $dataP=DB::table('persona')->select('IdPersona','IdTipoDocumento','Dni','ApellidoPat','ApellidoMat','Nombres',
               'FechaNac','FechaIngreso','IdRegimen','Genero','IdProfesion','Especialidad','IdPais','Direccion', 'Residentado')->where('Dni','=',$id)->get(); 

        return $dataP;
    }

}