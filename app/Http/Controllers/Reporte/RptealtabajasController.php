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

class RptealtabajasController extends Controller {
  public function __construct(){}

     public function index(Request $request){     			
     			$data=DB::select("SELECT CONCAT(Mes,Anio) AS periodo, Descripcion, Anio,Mes FROM periodo");	
          $data2=DB::select("SELECT IdTipoMov,Descripcion, IF(Alta='','Mov.','Alt.') AS f FROM tipomovimiento ORDER BY 3,1"); 
          $data3=DB::select("SELECT IdTipoBaja AS IdTipoMov,Descripcion,'Baja' AS f FROM tipobaja ORDER BY 1");  	   
            return view('reportes.rbajas.index',compact('data2','data3'))->with('data',$data); 
    }

 public function getallrptealtabajas(Request $request){ 
      if($request->ajax()) {                
                $idAltaB       = $request->input("idbajaalta");
                $idPeriodo     = $request->input("idperiodo");                
                if($idAltaB=="1"){ 
                  $idConcept     = $request->input("IdConceptoa"); 
                    $data=DB::select("SELECT 
                                      IF(p.IdRegimen='9',(SELECT Descripcion FROM estructura WHERE IdEstructura=h.IdEstructura),(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1)) AS organo,
                                      h.IdPersona,apellidoPat,ApellidoMat,Nombres,NroPlaza,
                                      (SELECT IF(Alta=1,'ALTA','MOV.')  FROM tipomovimiento WHERE IdTipoMov= h.IdTipoMov) AS al,
                                      (SELECT Descripcion FROM tipomovimiento WHERE IdTipoMov= h.IdTipoMov) AS tipobaja,
                                      DATE_FORMAT(FechaMov,'%d/%m/%Y') AS fechaMov, DocRef,Observacion,dni,(SELECT Sigla FROM regimen WHERE IdRegimen=p.IdRegimen)AS regimen
                                      FROM historiamovimiento AS h INNER JOIN persona AS p ON p.IdPersona=h.IdPersona
                                      WHERE  IdTipoMov <>'' AND if(LEFT('$idPeriodo',2)='--',FechaMov LIKE '%',MONTH(FechaMov)=LEFT('$idPeriodo',2)) AND YEAR(FechaMov) =RIGHT('$idPeriodo',4) AND IdTipoMov LIKE '$idConcept%'");
                }else {
                  $idConcept     = $request->input("IdConceptob"); 
                    $data=DB::select("SELECT IF(p.IdRegimen='9',(SELECT Descripcion FROM estructura WHERE IdEstructura=h.IdEstructura),(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1)) AS organo,h.IdPersona,apellidoPat,ApellidoMat,Nombres,NroPlaza,'BAJA' AS al,(SELECT Descripcion FROM tipobaja WHERE IdTipoBaja= h.IdTipoBaja) AS tipobaja,DATE_FORMAT(FechaMov,'%d/%m/%Y') AS fechaMov, DocRef,Observacion,dni,(SELECT Sigla FROM regimen WHERE IdRegimen=p.IdRegimen)AS regimen FROM historiamovimiento AS h INNER JOIN persona AS p ON p.IdPersona=h.IdPersona
                            WHERE  IdTipoBaja <>'' AND if (LEFT('$idPeriodo',2)='--',FechaMov LIKE '%',MONTH(FechaMov)=LEFT('$idPeriodo',2)) AND YEAR(FechaMov) =RIGHT('$idPeriodo',4) AND IdTipoBaja LIKE '$idConcept%'");
                  }
                return response()->json($data);
            }    
    }
  
}