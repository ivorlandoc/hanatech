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

class BajaPlazasController extends Controller {
  protected $currentUser;
  public function __construct() {    
 // $this->currentUser = Sentinel::getUser()->id;
  }

		public function index(Request $request){	
          $idUserSession = Sentinel::getUser()->id;   //almacena id de sesion activa	     	
		     	 if(empty($request->string_search)) {$string_search='NOEXISTEREGISTRO';} else  {$string_search=$request->string_search."%";}

		    	$GetSearch=DB::table('cuadronominativo as cu')				
					->leftjoin('persona as p', 'p.IdPersona', '=', 'cu.IdPersona')
				    ->join('cargo as car','car.IdCargo','=','cu.IdCargo')	
				    ->select('cu.NroPlaza as NroPlaza','cu.IdEstructura as IdEstructura','car.IdNivel','car.Descripcion AS cargo','cu.IdPersona',
			    	  DB::raw('CONCAT(p.ApellidoPat, " ",p.ApellidoMat," ",p.Nombres) AS Nombres'),
            DB::raw('CONVERT(cu.IdPlaza,CHAR(6)) as IdPlaza'))   
			    	->where('IdEstadoPlaza','=','1')
			    	->where('cu.NroPlaza','like',$string_search)
			    	->orWhere(DB::raw('CONCAT(p.ApellidoPat, " ",p.ApellidoMat," ",p.Nombres)'),'like',$string_search)
            ->orWhere('Dni','like',$string_search)
			    	->orderby('Nombres','asc')->paginate(10); 

        			//->orWhere(function($query) { $query->where('votes', '>', 100)
		 	return view('admin.bajaplazas.index',compact('GetSearch', 'idUserSession')); 	
     // return view('admin.bajaplazas.index',compact('GetSearch', 'idUserSession')); // envia idsesion a la vista para un input hidden		
		}


		public function creeate(Request $request){  
  	 		return redirect()->view('admin.bajaplazas.create');
  		}

  		
public function ProcesaBajaInsert(Request $Request){ 
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
                $_IdPersona         = $Request->input("IdPersona");
                $_IdPlaza           = $Request->input("IdPlaza");
                $_IdEstructura      = $Request->input("IdEstructura");
                $_IdCargo           = $Request->input("IdCargo");
                $_NroPlaza          = $Request->input("NroPlaza");
                $_IdTipobaja        = $Request->input("IdTipoMovbaja");
                $_FechaBaja         = $Request->input("FechaDocRefbja");
                $_FecMovBaj         = $Request->input("FechaMovbaja");                
                $_DocRefeferencia   = $Request->input("DocRefBaja");
                $_FileAdjunto       = $Request->hasFile('FileAdjuntoBaja');
                $_Observacion       = $Request->input("Observacion");
                               
                $res=array($_IdPersona);
                $fileName=$_IdPersona.$_IdPlaza.$_NroPlaza;// nombre del archivo .pdf
                if($_FileAdjunto) {
                    $file = $Request->file('FileAdjuntoBaja');       //$imgextension = $file->getClientOriginalExtension();
                    $path = public_path('uploads/files/');
                    array_push($res, $path);
                    $name = $fileName.'.'.$file->getClientOriginalExtension();
                    $file->move($path, $name);
                }           
                //str_pad($_IdPlaza,6,'0',STR_PAD_LEFT),
                IF($_IdTipobaja!="13"){
                 $aff=DB::table('cuadronominativo')->where('NroPlaza', $_NroPlaza)->where('IdPersona', $_IdPersona)->where('IdPlaza',$_IdPlaza)->update(
                  [
                    'Idpersona' =>'',
                    'IdEstadoPlaza'=>'2',
                    'FechaInicio'=>'1000-01-01',
                    'FechaCese'=>Carbon::parse($_FecMovBaj)->format('Y-m-d'),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'Ip'=>$ipAddress,
                    'IdUsuario'=>$UserSession->email
                  ]);                 
               }
                $Resp = DB::table('historiamovimiento')->insert([
                    'IdPersona'     => $_IdPersona,
                    'IdPlaza'       => $_IdPlaza, 
                    'IdEstructura'  => $_IdEstructura,
                    'IdCargo'       => $_IdCargo,
                    'NroPlaza'      => $_NroPlaza,
                    'IdTipoMov'     => '',
                    'IdTipoBaja'    => $_IdTipobaja,
                    'IdEstadoPlaza' => "",
                    'FechaDocRef'   => Carbon::parse($_FechaBaja)->format('Y-m-d H:i:s'),
                    'FechaMov'      => Carbon::parse($_FecMovBaj)->format('Y-m-d H:i:s'),
                    'DocRef'        => $_DocRefeferencia,
                    'FileAdjunto'   => $name,
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
		
	
  		public function edit($id) {	 
	        return view('admin.bajaplazas.edit',compact('idEdit',$id));
	    }
  		public function udpate(){
  			return redirect('admin.bajaplazas.index');
  		}

  		public function destroy(Request $request,$id){
  			return redirect('admin.bajaplazas.index');
  		}

  	
    	public function GeTHeadPlaza($id){		
        		$GetHeadPlazaHow = DB::select("SELECT CONVERT(IdPlaza, char) as IdPlaza,p.IdPersona,c.IdEstructura,c.IdCargo,NroPlaza,
              (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS desc1,
              (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) AS desc2,
              (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) AS desc3,
              (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) AS ofi, 

							e.Descripcion,CONCAT(ApellidoPat,' ', ApellidoMat,' ',Nombres)AS nombres,
							ca.Descripcion AS cargo,IdNivel
							FROM cuadronominativo AS c
							INNER JOIN estructura AS e ON e.IdEstructura=c.IdEstructura 
							INNER JOIN persona AS p ON p.IdPersona = c.IdPersona
							INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo
							WHERE NroPlaza='$id'");
        		return $GetHeadPlazaHow;
   		}

 		public function GeTtipoBaja($id){	
                $GetCarg     =DB::table('cuadronominativo')->where('NroPlaza','=',$id)->select(DB::raw('LEFT(IdCargo,1) AS IdCargo'))->get('IdCargo');
                $_IdCarg="";
                foreach ($GetCarg as $key) $_IdCarg  =$key->IdCargo; 
                IF($_IdCarg=="E"){
			             $GetTipoB = DB::select("SELECT IdTipobaja,Descripcion FROM tipobaja WHERE Nivel like left('$_IdCarg',1) ORDER BY 2");
                  }else{
                    $GetTipoB = DB::select("SELECT IdTipobaja,Descripcion FROM tipobaja WHERE Nivel not like 'E%' ORDER BY 2");
                }
			return $GetTipoB;
			//return response()->json($GetTipoB);
   		}


}