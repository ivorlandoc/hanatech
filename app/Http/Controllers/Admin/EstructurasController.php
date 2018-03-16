<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Estructura;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;


class EstructurasController extends Controller { 

    public function index(Request $request){
       //$getPriNivel=\App\Estructura::Search($request->Desc)->orderby('Descripcion','asc')->paginate(10);        
       //$getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where('IdEstructura', 'like', "__00000000")->get();
       $getDosDig=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "2")->get();
       return view('admin.estructura.index',compact('getDosDig')); 
    }

public function GetSelectSegundoNivel($id){
        if(strlen($id)=="2"){    
            $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "4")->where('NewCodigo', 'like', $id.'%')->get();
        } elseif (strlen($id)=="4") { 
             $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "7")->where('NewCodigo', 'like', $id.'%')->get();

         }elseif (strlen($id)=="7") {           
            $data=DB::table('estructura')->select('NewCodigo as IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "11")->where('NewCodigo', 'like', $id.'%')->groupBy('NewCodigo')->get();           
         } elseif (strlen($id)=="11") {
           $data=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(NewCodigo)'), '=', "15")->where('NewCodigo', 'like', $id.'%')->groupBy('NewCodigo')->get();
         } 
         return $data;
    }

public function showdata($id){
      $dataP =DB::select('
            SELECT IdEstructura,descripcion,SUM(Asist) AS Asist,SUM(Adm) AS admin,SUM(vac) AS vac,SUM(Asist + Adm+vac) AS total FROM (
            SELECT c.IdEstructura,e.descripcion, IF(IdTipo="1" AND c.IdPersona<>"",COUNT(IdTipo),"0") AS Adm, IF(IdTipo="2" AND c.IdPersona<>"" ,COUNT(IdTipo),"0") AS Asist,
            IF(c.IdPersona="",1,0) AS vac
            FROM cuadronominativo c 
            INNER JOIN  cargo ca ON ca.IdCargo=c.IdCargo
            INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
            WHERE c.IdEstructura LIKE "'.$id.'%" GROUP BY e.IdEstructura,IdTipo,NroPlaza
            ) AS d GROUP BY IdEstructura');  

      return $dataP;//sview('admin.plazas.index',compact('AllData')); 
    }

    public function showDetails($id){
      $len= strlen($id);
      $NewId=substr($id,0,($len-1));
      $newflag=substr($id,($len-1),1);
      $string=""; 
      if($newflag=="0") $string=' AND c.IdPersona=""'; else   $string=' AND IdTipo="'.$newflag.'" AND c.IdPersona<>""';

      $sql='SELECT  c.IdPersona,IdPlaza, c.NroPlaza, c.IdEstructura,e.Descripcion AS descripcion,
                      car.IdNivel,IF(LEFT(car.IdNivel,1)="A",CONCAT("Z",RIGHT(car.IdNivel,1)),car.IdNivel) AS niv_orden,car.Descripcion AS cargo,IF(p.ApellidoPat IS NULL,"-",p.ApellidoPat)  AS ApellidoPat,
                      IF(p.ApellidoMat IS NULL,"-",p.ApellidoMat) AS ApellidoMat,IF(p.Nombres IS NULL,"-",p.Nombres) AS Nombres
                      FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
                        INNER JOIN cargo car ON car.IdCargo=c.IdCargo   INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
                         WHERE  c.IdEstructura = "'.$NewId.'" '.$string.'ORDER BY niv_orden' ;
     $dataP =DB::select($sql);

      return $dataP;
    }

    
  }