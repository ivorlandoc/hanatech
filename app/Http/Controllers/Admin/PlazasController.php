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

class PlazasController extends Controller { 
   /* public function __construct(\Maatwebsite\Excel\Excel $excel)
    {
        $this->excel = $excel;
    }
*/
    public function index(Request $request){ 
      $nivel=DB::select("SELECT LEFT(IdNivel,1) AS id, IF(LEFT(IdNivel,1)='E','EJECUTIVOS',IF(LEFT(IdNivel,1)='P','PROFESIONALES',IF(LEFT(IdNivel,1)='T','TECNICOS','AUXILIARES'))) AS nom FROM nivel  
GROUP BY LEFT(IdNivel,1) ");
      $getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "4")->get();
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
          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) AS dep,
      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) AS centro,
      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) AS ofi,
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
     $_nivel = $_GET["select_e"];


          $results=DB::select("
            SELECT  
                IdPlaza,  
                c.IdEstructura,
           --   (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) AS dep,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) AS dep2,
               (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) AS oficina,
              e.Descripcion AS descripcion,
              c.NroPlaza,
              IF(dni IS NULL,'--',dni) AS dni,
              CONCAT(IF(p.ApellidoPat IS NULL,'-',p.ApellidoPat),' ', IF(p.ApellidoMat IS NULL,'-',p.ApellidoMat),' ',IF(p.Nombres IS NULL,'-',p.Nombres)) AS Nombres,
              IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,'---',(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS condicion,
              IF(fechaingreso IS NULL,'--',DATE_FORMAT(fechaingreso,'%d/%m/%Y')) AS fi,
              car.CodigoAnt AS CodCargo,
              car.Descripcion AS cargo,car.IdNivel,
              IF(c.IdEstadoPlaza IS NULL,' ',(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado,
              IF(fechaCese='1000-01-01','',DATE_FORMAT(fechaCese,'%d/%m/%Y')) AS fcese,                      
              CodigoAntEst
              FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
              INNER JOIN cargo car ON car.IdCargo=c.IdCargo  
              INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
              WHERE  c.IdEstructura LIKE '$_string%' AND NroPlaza NOT LIKE '9______9%' AND IdEstadoplaza<>'0'  and c.IdCargo like '$_nivel%' AND flat IS NULL 
            ");
/*
          $results=DB::table('cuadronominativo as cu')        
          ->leftjoin('persona as p', 'p.IdPersona', '=', 'cu.IdPersona')          
            ->join('cargo as car','car.IdCargo','=','cu.IdCargo') 
            ->join('estructura as e','e.IdEstructura','=','cu.IdEstructura')
            ->select(
              'cu.IdPlaza',
              'cu.IdEstructura as IdEstructura',
               DB::raw('(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),4) LIMIT 1) AS organo'),
               DB::raw('(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),6) LIMIT 1) AS dep'),
               DB::raw('(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),8) LIMIT 1) AS dep2'),
               DB::raw('(SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=cu.IdEstructura),10) LIMIT 1) AS oficina'),
              'e.Descripcion AS descripcion',
              'cu.NroPlaza',
              DB::raw('IF(dni IS NULL,"--",dni) AS dni'),
              DB::raw('CONCAT(IF(p.ApellidoPat IS NULL,"-",p.ApellidoPat)," " , IF(p.ApellidoMat IS NULL," - ",p.ApellidoMat)," ",IF(p.Nombres IS NULL,"-",p.Nombres)) AS Nombres'),
              DB::raw('IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,"---",(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS condicion'),
              DB::raw('IF(fechaingreso IS NULL,"--",DATE_FORMAT(fechaingreso,"%m/%d/%Y")) AS fi'),
              'car.CodigoAnt AS CodCargo',
              'car.Descripcion AS cargo',
              'car.IdNivel',
              DB::raw('IF(cu.IdEstadoPlaza IS NULL," ",(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=cu.IdEstadoPlaza)) AS Estado'),
              DB::raw('IF(fechaCese="1000-01-01"," ",DATE_FORMAT(fechaCese,"%m/%d/%Y")) AS fcese')
            )
            ->where('cu.IdEstructura','like','$_string%')
            ->where('cu.NroPlaza','not like','9______9%')
            ->where('cu.IdEstadoplaza','<>','0')
            ->orderby('organo','asc')->get();*/
      

      $data = array();
      foreach ($results as $key) { $data[] = (array)$key;}

       Excel::create('Nominativo-'.date('d-m-Y'), function($excel) use ($data){
            $excel->sheet('Nominativo-'.date('d-m-Y'), function($sheet)  use ($data) {   

                $sheet->fromArray($data);
                $sheet->setOrientation('landscape');
            });
        })->export('xls');

      } 
  

 }
//  {{ Form::open(array( 'route' => ['get-export-excel','1'], 'method' => 'post', 'id' => 'frmexportex','name' => 'frmexportex','class'=>'form-inline'))}}  
 /*

   $results=DB::select("
            SELECT  
                IdPlaza,  
                c.IdEstructura,
           --   (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
                (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) AS dep,
           --  (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) AS dep2,
            -- (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) AS oficina,
              e.Descripcion AS descripcion,
              c.NroPlaza,IF(dni IS NULL,'--',dni) AS dni,
              CONCAT(IF(p.ApellidoPat IS NULL,'-',p.ApellidoPat),' ', IF(p.ApellidoMat IS NULL,'-',p.ApellidoMat),' ',IF(p.Nombres IS NULL,'-',p.Nombres)) AS Nombres,
              IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,'---',(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS condicion,
              IF(fechaingreso IS NULL,'--',DATE_FORMAT(fechaingreso,'%m/%d/%Y')) AS fi,
              car.CodigoAnt AS CodCargo,
              car.Descripcion AS cargo,car.IdNivel,
              IF(c.IdEstadoPlaza IS NULL,' ',(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado,
              IF(fechaCese='1000-01-01','',DATE_FORMAT(fechaCese,'%m/%d/%Y')) AS fcese -- ,
              -- IF(Fechacese>=(SELECT fecha FROM periodopresupuesto WHERE estado='1' LIMIT 1),'SI','NO') AS sino            
              FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
              INNER JOIN cargo car ON car.IdCargo=c.IdCargo  
              INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
              WHERE  c.IdEstructura LIKE '%' AND NroPlaza NOT LIKE '9______9%' AND IdEstadoplaza<>'0'  limit 500
            ");

 */