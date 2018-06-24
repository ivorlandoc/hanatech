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
use PDO;
class RptegeneralplazasController extends Controller {

     public function index(Request $request){     			
     			$dataE=DB::select("SELECT IdEstadoPlaza, Descripcion FROM estadoplaza where IdEstadoPlaza in ('0','1','2')");
          $dataSub=DB::select("SELECT IdEstadoPlaza, Descripcion FROM estadoplaza where IdEstadoPlaza not in ('0','1','2')");
		     	$dataR=DB::select("SELECT IdRegimen, Descripcion FROM regimen");		          
            return view('reportes.rplazas.index')->with('dataE',$dataE)->with('dataR',$dataR)->with('dataSub',$dataSub); 
    }

    function getrpteplazas(Request $request){
       if($request->ajax()) {  
                $_esta        = $request->input("idestado"); 
                $_Subesta        = $request->input("Subidestado"); 
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
                    DB::raw('IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL," ",(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS reg'),
                     DB::raw('IF(FechaCese="1000-01-01","--",FechaCese) AS FechaCese'),
                    'c.IdPersona')                               
                   ->join('estructura as e','e.IdEstructura','=','c.IdEstructura')
                   ->leftJoin('persona as p','p.IdPersona','=','c.IdPersona')
                   ->where('c.IdEstadoPlaza','=',$_esta)
                   ->where('c.SubIdEstadoPlaza','=',$_Subesta)
                   ->where('NroPlaza','not like','9______9%')
                   ->orderby('Nombres','asc')->get();
                   //->paginate(20); NroPlaza NOT LIKE '9______9'
                  } 
          
        }
    		return response()->json($data);
        // return view('reportes.rplazas.index')->with('data',$data); 
    }

function getRpteExcel($id){			  	
/*====================unicamente para el store procedure== Hoja 1===================================*/
$db = new PDO('mysql:host=localhost;dbname=gpessalud;charset=utf8', 'root', 'rootech*2018');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$query1 = $db->prepare("CALL rpteplazavacredes()");
$query1->execute();
$data = $query1->fetchAll(PDO::FETCH_ASSOC);

//==============Hoja 2===========================
$db_ = new PDO('mysql:host=localhost;dbname=gpessalud;charset=utf8', 'root', 'rootech*2018');
$db_->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$callsql = $db_->prepare("CALL rpteplazaspromocion()");
$callsql->execute();
$datapro = $callsql->fetchAll(PDO::FETCH_ASSOC);
//===================hoja 3==============
$dbc = new PDO('mysql:host=localhost;dbname=gpessalud;charset=utf8', 'root', 'rootech*2018');
$dbc->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$callsqlC = $dbc->prepare("CALL rpteplazaspromComple()");
$callsqlC->execute();
$dataproC = $callsqlC->fetchAll(PDO::FETCH_ASSOC);

/*====================Resumen hoja 4=======================================*/
$datta=DB::select("
      SELECT 
        (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND IdEstructura=LEFT(c.IdEstructura,4) LIMIT 1) AS sede,
        (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 AND IdEstructura=LEFT(c.IdEstructura,6) LIMIT 1) AS organo,
        (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 AND IdEstructura=LEFT(c.IdEstructura,8) LIMIT 1) AS dep,
        (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 AND IdEstructura=LEFT(c.IdEstructura,10) LIMIT 1) AS ofi, 
        NroPlaza,
        (SELECT descripcion FROM cargo WHERE IdCargo=c.IdCargo)AS cargo,
        (SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=SubIdEstadoPlaza) AS estado,
        DATE_FORMAT(FechaCese,'%m/%d/%Y') AS fc,
        IF(Fechacese>=(SELECT fecha FROM periodopresupuestos WHERE estado='1' LIMIT 1) AND IdEstadoPlaza <>'0' ,'SI','NO') AS ptto,
        Observ
     FROM cuadronominativo  AS c WHERE IdEstadoPlaza='2' AND IdPersona='' AND NroPlaza NOT LIKE '9______9%' ORDER BY 1
 ");  
/*===========================================================*/
    	  		Excel::create('Plazas Vacantes', function($excel)use($data,$datta,$datapro,$dataproC) {
              
			            $excel->sheet('Plazas Vac. Cargo- y ptto', function($sheet)use($data) { 			            	
			               $data=json_decode(json_encode($data), true);             
			               $sheet->fromArray($data);
//			               $sheet->setAttribute  setOrientation('landscape');
			           });

              $excel->sheet('Plazas Vac. para Promocion', function($sheet)use($datapro) {                    
                  $datapro=json_decode(json_encode($datapro), true);             
                  $sheet->fromArray($datapro);
              });


              $excel->sheet('Plazas Vac. Promocion Compleme', function($sheet)use($dataproC) {                    
                  $dataproC=json_decode(json_encode($dataproC), true);             
                  $sheet->fromArray($dataproC);
              });

               $excel->sheet('Plazas Vac. por Estado', function($sheet)use($datta) {                    
                  $datta=json_decode(json_encode($datta), true);             
                  $sheet->fromArray($datta);
              });
              
              
              

        		})->export('xls');
    }
}
