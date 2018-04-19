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

class ConsplzextController extends Controller {

     public function index(Request $request){
            return view('reportes.externo.index'); 
    }

    public function getdatforConsultExter (Request $request){
       if($request->ajax()) {  
              $string=$request->input("stri_search_ext");
              $_hidden=$request->input("idhidden");
                 if($_hidden=="0"){
                  $data=DB::select("
                    SELECT  
                        c.IdPersona,
                        c.NroPlaza,
                        c.IdEstructura,
                        (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
                        (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) AS gerencia,
                        (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) AS dep2,
                        (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) AS ofi,
                        e.Descripcion AS descripcion,
                        car.IdNivel,
                        (SELECT descripcion FROM nivel WHERE IdNivel=car.IdNivel) AS Nivel,
                        car.Descripcion AS cargo,
                        IF(p.ApellidoPat IS NULL,'-',p.ApellidoPat)  AS ApellidoPat,
                        IF(p.ApellidoMat IS NULL,'-',p.ApellidoMat) AS ApellidoMat,
                        IF(p.Nombres IS NULL,'-',p.Nombres) AS Nombres,
                        (SELECT descripcion FROM estadoplaza WHERE IdEstadoPlaza=c.IdEstadoPlaza) AS estado,
                        IF(FechaCese='1000-01-01','',DATE_FORMAT(Fechacese,'%d/%m/%Y')) AS fcese,
                        IF(Fechacese>=(SELECT fecha FROM periodopresupuesto WHERE estado='1' LIMIT 1),'SI','NO') AS sino
                    FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
                    INNER JOIN cargo car ON car.IdCargo=c.IdCargo   
                    INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
                    WHERE  c.NroPlaza = '$string'"
                  );  
                   return response()->json($data); 
                }
                if($_hidden=="1"){
                    $data = DB::SELECT("
                        SELECT 
                            perso,
                            dni,
                            ApellidoPat,
                            ApellidoMat,
                            Nombres,
                            IF(NroPlaza IS NULL,'No',NroPlaza) AS NroPlaza,
                            (SELECT Descripcion FROM cargo WHERE IdCargo=c.IdCargo)AS cargo,
                            (SELECT sigla FROM regimen WHERE IdRegimen=regimen) AS reg
                            FROM (
                                    SELECT 
                                        p.IdPersona AS perso,
                                        dni, 
                                        IF(ApellidoPat IS NULL,'-',ApellidoPat) AS ApellidoPat,
                                        IF(ApellidoMat IS NULL,'-',ApellidoMat) AS ApellidoMat,
                                        IF(Nombres IS NULL,'-',Nombres) AS Nombres,
                                        IdRegimen AS regimen    
                                    FROM persona p 
                                    WHERE 
                                        (CONCAT(ApellidoPat,' ',ApellidoMat) LIKE '%$string%' OR dni LIKE '$string%')
                                    ) xy
                            LEFT JOIN cuadronominativo c 
                            ON 
                                perso =c.IdPersona"
                        );
                    return response()->json($data);
                }             
                         
        }
    		      
    }

 public function GetEstadoDePlazasMov($id){ 
      $data = DB::select("SELECT 
        IdHistoria,
        IF((SELECT CONCAT(Dni,' ', ApellidoPat,' ',ApellidoMat,' ', Nombres) FROM persona WHERE IdPersona=h.IdPersona ) IS NULL,'---',(SELECT CONCAT(Dni,' | ', ApellidoPat,' ',ApellidoMat,' ', Nombres) FROM persona WHERE IdPersona=h.IdPersona )) AS Persona,
        IF(h.IdTipoMov<>'',(SELECT CASE WHEN IdTipoMov IN ('12','13','14','15','16','17','18','19','20') THEN CONCAT('MOV. POR ',descripcion)  ELSE CONCAT('MOV. POR ',descripcion) END AS ss FROM tipomovimiento WHERE IdTipoMov=h.IdTipoMov), IF(IdTipoBaja<>'',(SELECT CONCAT('BAJA POR ',descripcion) FROM tipobaja WHERE IdTipoBaja=h.IdTipoBaja),
          (SELECT descripcion FROM estadoplaza WHERE IdEstadoPlaza=h.IdEstadoPlaza))) AS tipomov, 

         (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),2) LIMIT 1) AS sede,
            (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1) AS organo,
          (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),6) LIMIT 1) AS gerencia,
            (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),8) LIMIT 1) AS dep2,
            (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),10) LIMIT 1) AS ofi, 
        IdEstructura,
        (SELECT Descripcion FROM cargo WHERE IdCargo=h.IdCargo) AS cargo,
        DocRef,
        IF(Observacion IS NULL,'',Observacion) AS Observacion,
        DATE_FORMAT(FechaMov,'%d/%m/%y') AS fm,
        DATE_FORMAT(FechaDocRef,'%d/%m/%y') AS fd,
        FileAdjunto
        FROM historiamovimiento h WHERE NroPlaza='$id'");
        return Response::json($data);                 
        }



}