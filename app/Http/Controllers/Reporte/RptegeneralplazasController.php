<?php namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Facade;
use Illuminate\Database\Eloquent\Model;
use DB;
USE json;
use Response;
use input;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class RptegeneralplazasController extends Controller {

     public function index(Request $request){     			
     			$dataE=DB::select("SELECT IdEstadoPlaza, Descripcion FROM estadoplaza");
		     	$dataR=DB::select("SELECT IdRegimen, Descripcion FROM regimen");		          
            return view('reportes.rplazas.index')->with('dataE',$dataE)->with('dataR',$dataR); 
    }

    function getrpteplazas(Request $request){
       if($request->ajax()) {  
                $_esta        = $request->input("idestado"); 
                $_reg         = $request->input("regim");    

                if($_reg=="9") {
                  $data=DB::table('cuadronominativo as c')
                   ->select('e.IdEstructura as codestru','e.Descripcion as Descripcion','NroPlaza',
                    DB::raw('(SELECT descripcion FROM cargo WHERE IdCargo=c.IdCargo) AS Cargo'),
                    DB::raw('IF(p.dni IS NULL, "",p.dni) as dni'),'ApellidoPat','ApellidoMat',
                    DB::raw('IF(Nombres IS NULL,"",Nombres) AS Nombres'),
                    DB::raw('(SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=c.IdEstadoPlaza) as EstadoPlaza'),
                    DB::raw('IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,"",(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS Regimen'),'c.IdPersona')
                   ->join('estructura as e','e.IdEstructura','=','c.IdEstructura')
                   ->leftJoin('persona as p','p.IdPersona','=','c.IdPersona')
                   ->where('c.IdEstadoPlaza','=',$_esta)
                   ->where('IdRegimen','=',$_reg)
                   ->orderby('Nombres','asc')->get();
                   //->paginate(20); 
                }else {
                    $data=DB::table('cuadronominativo as c')
                   ->select('e.IdEstructura as codestru','e.Descripcion as Descripcion','NroPlaza',
                    DB::raw('(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) limit 1) AS organo'),
                    DB::raw('(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) limit 1) AS dep'),
                    DB::raw('(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) limit 1) AS subg'),
                    DB::raw('(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) limit 1) AS ofi'),
                    DB::raw('(SELECT descripcion FROM cargo WHERE IdCargo=c.IdCargo) AS Cargo'),
                    DB::raw('IF(p.dni IS NULL, "",p.dni) as dni'),
                    DB::raw('IF(p.ApellidoPat IS NULL, "",p.ApellidoPat) as ApellidoPat'),
                    DB::raw('IF(p.ApellidoMat IS NULL, "",p.ApellidoMat) as ApellidoMat'),
                    DB::raw('IF(Nombres IS NULL,"",Nombres) AS Nombres'),
                    DB::raw('(SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=c.IdEstadoPlaza) as EstadoPlaza'),
                    DB::raw('if((SELECT DocRef FROM historiamovimiento WHERE IdEstadoPlaza =c.IdEstadoPlaza and NroPlaza=c.NroPlaza limit 1) is null,"",(SELECT DocRef FROM historiamovimiento WHERE IdEstadoPlaza =c.IdEstadoPlaza and NroPlaza=c.NroPlaza limit 1)) AS DocRef'),
                    DB::raw('IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,"",(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS Regimen'),'c.IdPersona')
                               
                   ->join('estructura as e','e.IdEstructura','=','c.IdEstructura')
                   ->leftJoin('persona as p','p.IdPersona','=','c.IdPersona')
                   ->where('c.IdEstadoPlaza','=',$_esta)
                   ->where('NroPlaza','not like','9______9%')
                   ->orderby('Nombres','asc')->get();
                   //->paginate(20); NroPlaza NOT LIKE '9______9'
                  } 
          
        }
    		return response()->json($data);
        // return view('reportes.rplazas.index')->with('data',$data); 
    }

function getRpteExcel($id){			
	    		//$id = $request->input("idestado");//$id=$_POST['idestado'];
	    		if($id=="") $where  = " "; else $where= " WHERE c.IdEstadoPlaza='$id' ";

				$data=DB::select("SELECT e.IdEstructura,e.Descripcion,NroPlaza,(SELECT descripcion FROM cargo WHERE IdCargo=c.IdCargo) AS Cargo,
	    		 	IF(dni IS NULL, '',dni) AS dni, IF(CONCAT(apellidoPat,' ',ApellidoMat,' ',Nombres) IS NULL,'',CONCAT(apellidoPat,' ',ApellidoMat,' ',Nombres)) AS nombres, 
	                (SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=c.IdEstadoPlaza) AS EstadoPlaza ,
	                IF((SELECT sigla FROM regimen WHERE IdRegimen=pe.IdRegimen) IS NULL,'',(SELECT sigla FROM regimen WHERE IdRegimen=pe.IdRegimen)) AS Regimen,c.IdPersona
	                 FROM cuadronominativo c INNER JOIN estructura e ON c.IdEstructura=e.IdEstructura
	                LEFT JOIN persona pe ON c.IdPersona=pe.Idpersona $where ");	

    	  		Excel::create('Reporte de Plazas', function($excel)use($data){
			            $excel->sheet('Plazas', function($sheet)use($data) { 
			            	// aquí el query
			            $data=json_decode(json_encode($data), true);             
			            $sheet->fromArray($data);
			            $sheet->setOrientation('landscape');
			        });
        		})->export('xls');
    }
}