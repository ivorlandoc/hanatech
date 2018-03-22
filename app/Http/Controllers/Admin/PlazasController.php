<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
//use App\Estructura;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;


class PlazasController extends Controller { 

    public function index(Request $request){ // Aun no se usa, verificar
     
      // $getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where('IdEstructura', 'like', "__00000000")->get();
      $getDosDig=DB::table('estructuraorganica')->select('IdEstructuraorg as IdEstructura','Descripcion')->get();
      return view('admin.plazas.index',compact('getDosDig')); 
    }


 public function create(Request $request){     // aun no se usa, verificar 
       //$getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where('IdEstructura', 'like', "__00000000")->get(); 
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

    /*substr('abcdef', -1, 1); // f
      $dataP = DB::table('cuadronominativo')
             ->select('IdPlaza', 'cuadronominativo.NroPlaza', 'cuadronominativo.IdEstructura','estructura.Descripcion AS descripcion','cargo.IdNivel','cargo.Descripcion AS cargo','if(persona.ApellidoPat is null,"",persona.ApellidoPat) as persona.ApellidoPat','persona.ApellidoMat','persona.Nombres','DocReferencia','FechaDocRef','cuadronominativo.Estado')
            ->leftjoin('persona', 'persona.IdPersona', '=', 'cuadronominativo.IdPersona')
            ->join('cargo', 'cargo.IdCargo', '=', 'cuadronominativo.IdCargo')
            ->join('estructura', 'estructura.IdEstructura', '=', 'cuadronominativo.IdEstructura')           
            ->where('cuadronominativo.IdEstructura','like',$id.'%')
            ->get();
      */

      return $dataP;//sview('admin.plazas.index',compact('AllData')); 
    }
    


 }