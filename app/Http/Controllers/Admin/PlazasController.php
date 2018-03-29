<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
//use App\Estructura;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use DB;


//use Maatwebsite\Excel\Excel;

class PlazasController extends Controller { 
   /* public function __construct(\Maatwebsite\Excel\Excel $excel)
    {
        $this->excel = $excel;
    }
*/
    public function index(Request $request){ 
      $getDosDig=DB::table('estructuraorganica')->select('IdEstructuraorg as IdEstructura','Descripcion')->get();
      return view('admin.plazas.index',compact('getDosDig')); 
    }


 public function create(Request $request){  
       $getDosDig=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "2")->get();
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
      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
      (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),7) LIMIT 1) AS dep,
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
public function ExportExcel(Request $request, $format) {   
    if($request->ajax()){
      $data=DB::select('SELECT  IdPlaza,  c.IdEstructura,
                    (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
                    (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
                    (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),7) LIMIT 1) AS dep,
                    e.Descripcion AS descripcion,c.NroPlaza,IF(dni IS NULL,"--",dni) AS dni,
                    IF(p.ApellidoPat IS NULL,"-",p.ApellidoPat)  AS ApellidoPat,IF(p.ApellidoMat IS NULL,"-",p.ApellidoMat) AS ApellidoMat,IF(p.Nombres IS NULL,"-",p.Nombres) AS Nombres,
                    IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,"---",(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS condicion,
                    IF(fechaingreso IS NULL,"--",DATE_FORMAT(fechaingreso,"%m/%d/%y")) AS fi,car.Descripcion AS cargo,car.IdNivel,
                    IF(c.IdEstadoPlaza IS NULL," ",(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado,c.IdPersona
                    FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
                      INNER JOIN cargo car ON car.IdCargo=c.IdCargo   INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
                       WHERE  c.IdEstructura LIKE "0104%" AND IdEstadoplaza<>"0"');


       Excel::create('Nomina de Plazas', function($excel) use ($data)  {
                $excel->sheet('Nomina', function($sheet) use ($data){
                    $sheet->fromArray($data);
                    $sheet->loadView('admin.plazas.nominaexcel', array('Nomina de Plazas' => $payments));
                    $sheet->setOrientation('landscape');
                });
            })->download('xls');

        }
    }
/*
 public function all_users_report($format)
    {
        Excel::create('all_users_records', function ($excel) use ($format) {
            $excel->sheet('Epay.Li - all users report', function ($sheet) use ($format) {
                $all_records = ChangeMoney::all();
                $sheet->loadView('layouts.admin.all_users_report', array(  'all_records' => $all_records,));
            });
        })->export($format);
    }
*/





 }