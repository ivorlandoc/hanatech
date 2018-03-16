<?php namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;


class RptejectController extends Controller { 

    public function index(Request $request){     
      $getDosDig=DB::table('estructuraorganica')->select('IdEstructuraorg as IdEstructura','Descripcion')->get();
      return view('reportes.reject.index',compact('getDosDig')); 
    }


public function showejec(Request $request){   
       if($request->ajax()) {  
          $id         = $request->input("select4"); 
          $sql='SELECT  IdPlaza,  c.IdEstructura,
          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
          (SELECT Descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),7) LIMIT 1) AS dep,
          e.Descripcion AS descripcion,c.NroPlaza,IF(dni IS NULL,"--",dni) AS dni,
          IF(p.ApellidoPat IS NULL,"-",p.ApellidoPat)  AS ApellidoPat,IF(p.ApellidoMat IS NULL,"-",p.ApellidoMat) AS ApellidoMat,IF(p.Nombres IS NULL,"-",p.Nombres) AS Nombres,
          IF((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) IS NULL,"---",(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS condicion,
          IF(fechaingreso IS NULL,"--",DATE_FORMAT(fechaingreso,"%m/%d/%y")) AS fi,car.Descripcion AS cargo,car.IdNivel,
          IF(c.IdEstadoPlaza IS NULL," ",(SELECT Descripcion FROM estadoplaza WHERE IdEstadoplaza=c.IdEstadoPlaza)) AS Estado,c.IdPersona,CONCAT(p.IdPersona,IdPlaza,NroPlaza) AS FileAdjunto
          FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
            INNER JOIN cargo car ON car.IdCargo=c.IdCargo   INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
             WHERE  c.IdEstructura LIKE "'.$id.'%" AND NroPlaza NOT LIKE "9______9%" AND IdNivel LIKE "E%" ';
          $data =DB::select($sql);  
          return response()->json($data);
        }
    
    }

 }