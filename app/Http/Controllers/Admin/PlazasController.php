<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
//use App\Estructura;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use Input;
use json;
use Sentinel;

class PlazasController extends Controller { 
    public function index(Request $request){ 
       $IdUser = Sentinel::findById(Sentinel::getUser()->id); $IdEstrUser=$IdUser->IdEstructura;


      $nivel=DB::select("SELECT LEFT(IdNivel,1) AS id, IF(LEFT(IdNivel,1)='E','EJECUTIVOS',IF(LEFT(IdNivel,1)='P','PROFESIONALES',IF(LEFT(IdNivel,1)='T','TECNICOS','AUXILIARES'))) AS nom FROM nivel GROUP BY LEFT(IdNivel,1) ");
      $getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "4")->where('IdEstructura', 'like', $IdEstrUser."%")->get(); 
      return view('admin.plazas.index',compact('getDosDig','nivel')); 
    }


 public function create(Request $request){  
       $getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "2")->get();
      return view('admin.plazas.create',compact('getDosDig')); 
    }

public function show($id){
      $id2  =substr($id,-1,1);       
      $where= "";
      
      if($id2=="C"){ 
        $where=" AND NroPlaza LIKE '9______9%'";
        $id   =substr($id,0,strlen($id)-1); 
      }else{ 
        $where=" AND NroPlaza NOT LIKE '9______9%'";
         $id   =substr($id,0,strlen($id)); 
      }

      $sql='SELECT  IdPlaza,  c.IdEstructura,
      (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=2 and LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
      (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 and LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
      (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 and LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) AS dep,
      (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 and LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) AS centro,
      (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 and LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) AS ofi,
      e.Descripcion AS descripcion,c.NroPlaza,IF(dni IS NULL,"--",dni) AS dni,
      IF(p.ApellidoPat IS NULL,"-",p.ApellidoPat)  AS ApellidoPat,IF(p.ApellidoMat IS NULL,"-",p.ApellidoMat) AS ApellidoMat,IF(p.Nombres IS NULL,"-",p.Nombres) AS Nombres,
      IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,"---",(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS condicion,
      IF(fechaingreso IS NULL,"--",DATE_FORMAT(fechaingreso,"%m/%d/%y")) AS fi,car.Descripcion AS cargo,car.IdNivel,
      IF(c.IdEstadoPlaza IS NULL," ",(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado,c.IdPersona
      FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
        INNER JOIN cargo car ON car.IdCargo=c.IdCargo   INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
         WHERE  c.IdEstructura LIKE "'.$id.'%"'.$where. " AND IdEstadoplaza<>'0'";
      $dataP =DB::select($sql);  


      return $dataP;//sview('admin.plazas.index',compact('AllData')); 
    }
    
/*========================*/
public function excel(Request $request, $id) { 

    $_string = $_GET["select_10dig"];
    $_nivel  = $_GET["select_e"];
    $_sqlvac="";
    $_vacant = $_GET["txtcheckbox"];
    if($_vacant=="1"){$_sqlvac= " and c.IdEstadoPlaza='2' AND c.IdPersona='' ";} else {$_sqlvac="";}

          $results=DB::select("
            SELECT  
                IdPlaza,  
                c.IdEstructura,
           --   (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
                (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 and LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
                (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 and LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) AS dep,
                (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 and LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) AS dep2,
               (SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 and LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) AS oficina,
              e.Descripcion AS descripcion,
              c.NroPlaza,
              IF(dni IS NULL,'--',dni) AS dni,
              CONCAT(IF(p.ApellidoPat IS NULL,'-',p.ApellidoPat),' ', IF(p.ApellidoMat IS NULL,'-',p.ApellidoMat),' ',IF(p.Nombres IS NULL,'-',p.Nombres)) AS Nombres,
              IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,'---',(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS condicion,
              IF((FechaInicio IS NULL OR FechaInicio ='1000-01-01'),'--',DATE_FORMAT(FechaInicio,'%d/%m/%Y')) AS fi,
              car.CodigoAnt AS CodCargo,
              car.Descripcion AS cargo,car.IdNivel,
              IF(c.IdEstadoPlaza IS NULL,' ',(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado,
              IF(c.SubIdEstadoPlaza IS NULL,' ',(SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=c.SubIdEstadoPlaza)) AS SubEstado,
              IF(fechaCese='1000-01-01','',DATE_FORMAT(fechaCese,'%d/%m/%Y') ) AS fcese,
              Edan, 
              Observ,                   
              CodigoAntEst
              FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
              INNER JOIN cargo car ON car.IdCargo=c.IdCargo  
              INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
              WHERE  c.IdEstructura LIKE '$_string%' AND NroPlaza NOT LIKE '9______9%' AND IdEstadoplaza<>'0'  and c.IdCargo like '$_nivel%' 
            ". $_sqlvac);

      $data = array();
      foreach ($results as $key) { $data[] = (array)$key;}

       Excel::create('Nominativo-'.date('d-m-Y'), function($excel) use ($data){
            $excel->sheet('Nominativo-'.date('d-m-Y'), function($sheet)  use ($data) {  
                $sheet->fromArray($data);                
              }
                $sheet->setOrientation('landscape');
            });
        })->export('xls');

      } 
  

 }