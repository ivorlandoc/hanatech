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

class PlazasporcargoController extends Controller {

     public function index(Request $request){     			
     			$data=DB::select("SELECT IdRegimen,Sigla FROM  regimen WHERE IdRegimen IN('9','4')");		   
            return view('reportes.plazacargo.index')->with('dataR',$data); 
    }

 public function getallplazascargo(Request $request){ 
      if($request->ajax()) {  
                $id         = $request->input("idregimen"); 
                if($id=="9"){
                    $data=DB::select("SELECT IdNivel,IdCargo,Descripcion,SUM(act) AS act,SUM(vac) AS vac,SUM(inac) AS inac,0 as jud,0 as otros, SUM(act) + SUM(vac)+SUM(inac)  AS total FROM (

                                SELECT IdNivel,c.IdCargo,ca.Descripcion,
                                IF(IdEstadoPlaza='1',COUNT(NroPlaza),0) AS act, 0 AS vac,0 AS inac
                                FROM cuadronominativo c INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo WHERE IdEstadoPlaza='1' AND NroPlaza LIKE '9______9'
                                GROUP BY IdNivel,c.IdCargo 

                                UNION 
                                SELECT IdNivel,c.IdCargo,ca.Descripcion,0 AS act,
                                IF(IdEstadoPlaza='2',COUNT(NroPlaza),0) AS vac ,0 AS inac
                                FROM cuadronominativo c INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo WHERE IdEstadoPlaza='2' AND NroPlaza LIKE '9______9'
                                GROUP BY IdNivel,c.IdCargo 

                                UNION 
                                SELECT IdNivel,c.IdCargo,ca.Descripcion,0 AS act, 0 AS vac,
                                IF(IdEstadoPlaza='0',COUNT(NroPlaza),0) AS inac
                                FROM cuadronominativo c INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo WHERE IdEstadoPlaza='0' AND NroPlaza LIKE '9______9'
                                GROUP BY IdNivel,c.IdCargo 

                                ) AS d GROUP BY IdCargo ORDER BY IdNivel");
                }else {
                    $data=DB::select("SELECT IdNivel,IdCargo,Descripcion,SUM(act) AS act,SUM(vac) AS vac, SUM(inac) AS inac, SUM(jud) AS jud,SUM(otros) AS otros, SUM(act) + SUM(vac)+SUM(inac) +SUM(jud) +SUM(otros) AS total FROM (

                              SELECT IdNivel,c.IdCargo,ca.Descripcion,
                              IF(IdEstadoPlaza='1',COUNT(NroPlaza),0) AS act, 0 AS vac, 0 AS inac, 0 AS jud,0 AS otros
                              FROM cuadronominativo c INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo WHERE IdEstadoPlaza='1' AND NroPlaza NOT LIKE '9______9'
                              GROUP BY IdNivel,c.IdCargo 
                              UNION 
                              SELECT IdNivel,c.IdCargo,ca.Descripcion,'' AS act,
                              IF(IdEstadoPlaza='2',COUNT(NroPlaza),0) AS vac, 0 AS inac, 0 AS jud,0 AS otros
                              FROM cuadronominativo c INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo WHERE IdEstadoPlaza='2' AND NroPlaza NOT LIKE '9______9'
                              GROUP BY IdNivel,c.IdCargo 
                              UNION 
                              SELECT IdNivel,c.IdCargo,ca.Descripcion,
                              '' AS act, 0 AS vac,
                              IF(IdEstadoPlaza='0',COUNT(NroPlaza),0) AS inac, 0 AS jud,0 AS otros
                              FROM cuadronominativo c INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo WHERE IdEstadoPlaza='0' AND NroPlaza NOT LIKE '9______9'
                              GROUP BY IdNivel,c.IdCargo 

                              UNION 
                              SELECT IdNivel,c.IdCargo,ca.Descripcion,
                              '' AS act, 0 AS vac,
                              0 AS inac,
                              IF(IdEstadoPlaza='3',COUNT(NroPlaza),0) AS jud, 0 AS otros
                              FROM cuadronominativo c INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo WHERE IdEstadoPlaza='3' AND NroPlaza NOT LIKE '9______9'
                              GROUP BY IdNivel,c.IdCargo

                              UNION 
                              SELECT IdNivel,c.IdCargo,ca.Descripcion,
                              '' AS act, 0 AS vac,
                              0 AS inac, 0 AS jud,
                              IF(IdEstadoPlaza IN('4','5','6','8','10','11','12','13'),COUNT(NroPlaza),0) AS otros
                              FROM cuadronominativo c INNER JOIN cargo AS ca ON ca.IdCargo=c.IdCargo WHERE IdEstadoPlaza IN('4','5','6','8','10','11','12','13') AND NroPlaza NOT LIKE '9______9'
                              GROUP BY IdNivel,c.IdCargo

                              ) AS d GROUP BY IdCargo ORDER BY IdNivel
                        ");
                  }
                return response()->json($data);
            }
    
    }
  
}