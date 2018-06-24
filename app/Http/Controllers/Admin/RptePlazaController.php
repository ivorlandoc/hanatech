<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Estructura;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use json;
use Response;

class RptePlazaController extends Controller { 
public function index(Request $request){
   return  view('admin.rpteplazas.index'); 
}
public function getindex(Request $request){

     if($request->ajax()){
     $_string  =  $request->input("stri_search");
          
              $data = DB::select("
                SELECT
                  h.IdPersona AS persona, 
                  IF((SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1) IS NULL,'-*-',(SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1)) AS sede,
                  IF((SELECT descripcion FROM estructura WHERE IdEstructura=h.IdEstructura LIMIT 1) IS NULL,'-*-',(SELECT descripcion FROM estructura WHERE IdEstructura=h.IdEstructura LIMIT 1)) AS dependencia,
                  if(IdNivel is null,'-*-',IdNivel) AS IdNivel,
                   c.Descripcion AS cargo,
                   IF(NroPlaza IS NULL, '',NroPlaza) AS NroPlaza,
                   CONCAT(ApellidoPat, ' ', ApellidoMat,' ', Nombres ) AS nom,
                   Dni as dni          
              FROM 
                cuadronominativo AS h INNER JOIN cargo c
              ON 
                c.IdCargo=h.IdCargo 
              RIGHT JOIN persona AS p ON p.IdPersona =h.IdPersona                
              HAVING (nom LIKE '$_string%' OR dni LIKE '$_string%' OR NroPlaza LIKE '$_string%') LIMIT 10
              ");

        return  Response::json($data);   // view('admin.rpteplazas.index',compact('DataM')); 
    }
}

 public function GetFichaJobs(Request $request){  
    if($request->ajax()){
       $_plaza="";
        $dni    =  $request->input("txtdnificha");
        $plaza  =  $request->input("txtplazaficha");

        if($plaza=="") {
            $_plaza='';
            } else{
               $_plaza=" HAVING NroPlaza='".$plaza."' ";
              
            }

       $data=DB::select("
              SELECT 
                    IF((SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) IS NULL,'-*-',(SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1)) AS organo,
                    IF((SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 AND LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) IS NULL,'-*-',(SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 AND LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1)) AS gerencia,
                    IF((SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 AND LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) IS NULL,'-*-',(SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 AND LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1)) AS dep2,
                    IF((SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 AND LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) IS NULL,'-*-',(SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 AND LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1)) AS ofi,
                    IF((SELECT descripcion FROM estructura WHERE IdEstructura=c.IdEstructura LIMIT 1) IS NULL,'-*-',(SELECT descripcion FROM estructura WHERE IdEstructura=c.IdEstructura LIMIT 1)) AS dependencia,
                 persona,
                 dni,
                 nom,
                 regimen,
                 FechaNac,
                 fingreso,
                 Genero,
                 Direccion,
                 IF(NroPlaza IS NULL,'-*-',NroPlaza) AS NroPlaza,
                 IF(FechaInicio='1000-01-01' OR FechaInicio IS NULL,'-*-',FechaInicio) AS FechaInicio,
                 IF(LEFT(c.IdCargo,2) IS NULL,'-*-', LEFT(c.IdCargo,2)) AS idNivel,
                 IF((SELECT Descripcion FROM nivel WHERE IdNivel=LEFT(c.IdCargo,2)) IS NULL,'-*-',(SELECT Descripcion FROM nivel WHERE IdNivel=LEFT(c.IdCargo,2))) AS nivel,
                 IF((SELECT Descripcion FROM cargo WHERE IdCargo=c.IdCargo) IS NULL,'-*-',(SELECT Descripcion FROM cargo WHERE IdCargo=c.IdCargo)) AS cargo,
                 IF((SELECT DocRef FROM historiamovimiento WHERE NroPlaza=c.NroPlaza ORDER BY updated_at DESC LIMIT 1) IS NULL,'-*-',(SELECT DocRef FROM historiamovimiento WHERE NroPlaza=c.NroPlaza ORDER BY updated_at DESC LIMIT 1)) AS documento
              FROM (           
                      SELECT 
                      IdPersona AS persona,
                      dni,
                      CONCAT(ApellidoPat, ' ', ApellidoMat,' ', Nombres) AS nom,
                      (SELECT Descripcion FROM regimen WHERE IdRegimen=p.IdRegimen) AS regimen,
                      DATE_FORMAT(FechaNac, '%d/%m/%Y')  AS FechaNac,
                      DATE_FORMAT(FechaIngreso, '%d/%m/%Y')  AS fingreso,
                      Genero,Direccion          
                      FROM  persona AS p WHERE dni='".$dni."'  
              ) as p LEFT JOIN cuadronominativo c 
              ON 
              p.persona=c.IdPersona $_plaza
        ");


           return  Response::json($data);  
    }       
}


public function GetEstadoDePlazas(Request $request){    
if($request->ajax()){           
        $plz    =  $request->input("searchPlazaForRpte");              
        $data = DB::select("
              SELECT  
                c.IdPersona,
                c.NroPlaza,
                c.IdEstructura,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=2 AND LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 AND LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),6) LIMIT 1) AS gerencia,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 AND LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),8) LIMIT 1) AS dep2,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 AND LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),10) LIMIT 1) AS ofi,
                e.Descripcion AS descripcion,
                  car.IdNivel,
                  (SELECT descripcion FROM nivel WHERE IdNivel=car.IdNivel) AS Nivel,
                  car.Descripcion AS cargo,
                  IF(p.ApellidoPat IS NULL,'-',p.ApellidoPat)  AS ApellidoPat,
                  IF(p.ApellidoMat IS NULL,'-',p.ApellidoMat) AS ApellidoMat,
                  IF(p.Nombres IS NULL,'-',p.Nombres) AS Nombres,
                  (SELECT descripcion FROM estadoplaza WHERE IdEstadoPlaza=c.IdEstadoPlaza) AS estado,
                  IF(FechaCese='1000-01-01','',DATE_FORMAT(Fechacese,'%d/%m/%Y')) AS fcese,
                  IF(Fechacese>=(SELECT fecha FROM periodopresupuestos WHERE estado='1' LIMIT 1) AND IdEstadoPlaza <>'0' ,'SI','NO') AS sino,
                  
                  IF((SELECT IdPersona FROM suplencias WHERE Estado='Activo' AND NroPlaza=c.NroPlaza) IS NULL,'',(SELECT IdPersona FROM suplencias WHERE Estado='Activo' AND NroPlaza=c.NroPlaza)) AS idsuplente,
                  (SELECT CONCAT(ApellidoPat,' ',ApellidoMat,' ',nombres) FROM persona WHERE IdPersona=idsuplente)AS nombresuplente,
                  if((SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen) is null,' ',(SELECT sigla FROM regimen WHERE IdRegimen=p.IdRegimen)) AS regimen,
                  if(Especialidad is null,' ',Especialidad) as Especialidad,
                  CONCAT(DATE_FORMAT(CURDATE(),'%d/%m/%Y'),' ', CURTIME()) AS fecha,

                  IF(SubIdEstadoPlaza IS NULL,'',SubIdEstadoPlaza) AS SubIdEstadoPlaza,
                  IF((SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=SubIdEstadoPlaza) IS NULL,' ',(SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza=SubIdEstadoPlaza)) AS desSubEstado,
                  IF(Observ IS NULL,' ',Observ) AS Observ
              FROM 
                  cuadronominativo  c  LEFT JOIN persona p 
              ON 
                  p.IdPersona=c.IdPersona
              INNER JOIN 
                    cargo car ON car.IdCargo=c.IdCargo   
              INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
              WHERE  c.NroPlaza = '$plz'
          "); 
         return  Response::json($data);  
       }          
}



public function getDetalleMovimientos(Request $request){ 
    if($request->ajax()){           
        $plz    =  $request->input("txtplazamovdet"); 

            $data = DB::select("
            SELECT 
                  IdHistoria,
                  IF((SELECT CONCAT(Dni,' ', ApellidoPat,' ',ApellidoMat,' ', Nombres) FROM persona WHERE IdPersona=h.IdPersona ) IS NULL,'---',(SELECT CONCAT(Dni,' | ', ApellidoPat,' ',ApellidoMat,' ', Nombres) FROM persona WHERE IdPersona=h.IdPersona )) AS Persona,
                  IF(h.IdTipoMov<>'',(
                                        SELECT 
                                              CASE 
                                                  WHEN 
                                                      IdTipoMov IN ('12','13','14','15','16','17','18','19','20') 
                                                  THEN 
                                                      CONCAT('MOV. POR ',descripcion)  
                                                  ELSE 
                                                      CONCAT('MOV. POR ',descripcion) 
                                              END AS ss 
                                        FROM 
                                              tipomovimiento 
                                        WHERE 
                                              IdTipoMov=h.IdTipoMov
                                      ),
                        IF(IdTipoBaja<>'',(
                                        SELECT 
                                              CONCAT('BAJA POR ',descripcion) 
                                        FROM 
                                              tipobaja 
                                        WHERE 
                                              IdTipoBaja=h.IdTipoBaja
                                        ), 
                                        (
                                        SELECT 
                                                descripcion 
                                        FROM 
                                                estadoplaza 
                                        WHERE 
                                                IdEstadoPlaza=h.IdEstadoPlaza))
                   ) AS tipomov, 

                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=2 AND LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),2) LIMIT 1) AS sede,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1) AS organo,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 AND LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),6) LIMIT 1) AS gerencia,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 AND LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),8) LIMIT 1) AS dep2,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 AND LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),10) LIMIT 1) AS ofi, 

                  IdEstructura,
                  (SELECT Descripcion FROM cargo WHERE IdCargo=h.IdCargo) AS cargo,
                  DocRef,
                  IF(Observacion IS NULL,'',Observacion) AS Observacion,
                  DATE_FORMAT(FechaMov,'%d/%m/%y') AS fm,
                  DATE_FORMAT(FechaDocRef,'%d/%m/%y') AS fd,
                  FileAdjunto
              FROM 
                historiamovimiento h 
              WHERE 
                NroPlaza='$plz' 
              ORDER BY FechaMov DESC
          ");

         return Response::json($data);    
       }             
    }

   
public function GetmovporDni(Request $request){ 
    if($request->ajax()){      
      $dni    =  $request->input("txtdnifichamov"); 
      $data = DB::select("
        SELECT 
                  IdHistoria,
                  IF((SELECT CONCAT(Dni,' ', ApellidoPat,' ',ApellidoMat,' ', Nombres) FROM persona WHERE IdPersona=h.IdPersona ) IS NULL,'---',(SELECT CONCAT(Dni,' | ', ApellidoPat,' ',ApellidoMat,' ', Nombres) FROM persona WHERE IdPersona=h.IdPersona )) AS Persona,
                  IF(h.IdTipoMov<>'',(
                                        SELECT 
                                              CASE 
                                                  WHEN 
                                                      IdTipoMov IN ('12','13','14','15','16','17','18','19','20') 
                                                  THEN 
                                                      CONCAT('MOV. POR ',descripcion)  
                                                  ELSE 
                                                      CONCAT('MOV. POR ',descripcion) 
                                              END AS ss 
                                        FROM 
                                              tipomovimiento 
                                        WHERE 
                                              IdTipoMov=h.IdTipoMov
                                      ),
                        IF(IdTipoBaja<>'',(
                                        SELECT 
                                              CONCAT('BAJA POR ',descripcion) 
                                        FROM 
                                              tipobaja 
                                        WHERE 
                                              IdTipoBaja=h.IdTipoBaja
                                        ), 
                                        (
                                        SELECT 
                                                descripcion 
                                        FROM 
                                                estadoplaza 
                                        WHERE 
                                                IdEstadoPlaza=h.IdEstadoPlaza))
                   ) AS tipomov, 

                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=2 AND LEFT(IdEstructura,2)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),2) LIMIT 1) AS sede,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1) AS organo,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=6 AND LEFT(IdEstructura,6)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),6) LIMIT 1) AS gerencia,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=8 AND LEFT(IdEstructura,8)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),8) LIMIT 1) AS dep2,
                  (SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=10 AND LEFT(IdEstructura,10)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=h.IdEstructura),10) LIMIT 1) AS ofi, 

                  IdEstructura,
                  (SELECT Descripcion FROM cargo WHERE IdCargo=h.IdCargo) AS cargo,
                  DocRef,
                  IF(Observacion IS NULL,'',Observacion) AS Observacion,
                  DATE_FORMAT(FechaMov,'%d/%m/%y') AS fm,
                  DATE_FORMAT(FechaDocRef,'%d/%m/%y') AS fd,
                  FileAdjunto
              FROM 
                historiamovimiento h 
              WHERE 
                IdPersona='$dni' 
              ORDER BY IdHistoria DESC
        ");   

           return  Response::json($data);  
    }       
}



}