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
       $_string         = "";
         if(empty($request->input("stri_search"))) {$_string='NOEXISTEREGISTRO';} else  {$_string=$request->input("stri_search");}
            
                $DataM = DB::select("SELECT h.IdPersona AS persona, 
                (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),2) LIMIT 1) AS sede,
                (SELECT descripcion FROM estructura WHERE IdEstructura=h.IdEstructura LIMIT 1) AS dependencia,
                IdNivel, c.Descripcion AS cargo,IF(NroPlaza IS NULL, '',NroPlaza) AS NroPlaza,CONCAT(ApellidoPat, ' ', ApellidoMat,' ', Nombres ) AS nom,Dni as dni          
                FROM  cuadronominativo AS h INNER JOIN cargo c ON c.IdCargo=h.IdCargo 
                RIGHT JOIN persona AS p ON p.IdPersona =h.IdPersona                
                HAVING (nom LIKE '$_string%' OR dni LIKE '$_string%' OR NroPlaza LIKE '$_string%') LIMIT 10");

      return view('admin.rpteplazas.index',compact('DataM')); 
    }


    public function GetHistoriaMov($id){  
                $where_1  =   "";
                $where_2  = "";
                $Plaza  =   "";
                $dni    =   "";               
                    if(strlen($id)==16) {
                          $Plaza  =   substr($id,0,8);
                          $dni    =   substr($id,8,8);  

                          $where_1  =   " where NroPlaza='$Plaza'";
                          $where_2  =   " where NroPlaza='$Plaza' and dni='$dni'";
                    }else {
                          $dni    =   substr($id,0);
                          $where_1  =   " WHERE (SELECT Dni FROM persona WHERE IdPersona=h.IdPersona)='$dni'";
                          $where_2  =   " where  dni='$dni'";
                    } 
               $DataM = DB::select("SELECT persona,sede,centro,dep,dep2,dependencia,IdNivel,cargo,NroPlaza,CONCAT(ApellidoPat, ' ', ApellidoMat,' ', Nombres) AS nom,dni, TipoMov,FechaMov,fechaDoc,DocRef,FileAdjunto,Observacion FROM (
                  SELECT IdPersona AS persona, 
                  (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),2) LIMIT 1) AS sede,
                  (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1) AS centro,
                  (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),7) LIMIT 1) AS dep,
                  (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,11)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),11) LIMIT 1) AS dep2,
                  (SELECT descripcion FROM estructura WHERE IdEstructura=h.IdEstructura LIMIT 1) AS dependencia,
                  IdNivel, c.Descripcion as cargo,NroPlaza,(SELECT Descripcion FROM tipomovimiento WHERE IdTipoMov=h.IdTipoMov) AS TipoMov,
                  FechaMov,FechaDocRef AS fechaDoc,DocRef,FileAdjunto,Observacion
                  FROM  historiamovimiento AS h INNER JOIN cargo c ON c.IdCargo=h.IdCargo ". $where_1.") xc INNER JOIN persona p ON xc.persona=p.IdPersona". $where_2);
               return  $DataM;

                //return "Cadena-->".$id."--leng-->".strlen($id)."-Plaza->".$Plaza."-Dni->".$dni;//$DataM;            
    }

     public function GetDetalleGeneralPlaza($id){ 
        if(strlen($id)==16) {  
              $Plaza  =   substr($id,0,8); 
                $DataM = DB::select("SELECT persona,sede,organo,gerencia,dep2,dependencia,tipo,IdNivel,nivel,cargo,NroPlaza,dni,CONCAT(ApellidoPat, ' ', ApellidoMat,' ', Nombres) AS nom,DATE_FORMAT(FechaNac, '%d/%m/%Y')  AS FechaNac,  DATE_FORMAT(FechaIngreso, '%d/%m/%Y')  AS fingreso,(SELECT Descripcion FROM regimen WHERE IdRegimen=p.IdRegimen) AS regimen,Direccion,Genero  FROM (
                                      SELECT IdPersona AS persona,
                                      (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),2) LIMIT 1) AS sede,
                                      (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),4) LIMIT 1) AS organo,
                                      (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),7) LIMIT 1) AS gerencia,
                                      (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,11)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),11) LIMIT 1) AS dep2,
                                      (SELECT descripcion FROM estructura WHERE IdEstructura=cu.IdEstructura LIMIT 1) AS dependencia,
                                      IdNivel, c.Descripcion AS cargo,NroPlaza,
                                      (SELECT Descripcion FROM tipocargo WHERE IdTipo=c.IdTipo) AS tipo,
                                      (SELECT Descripcion FROM nivel WHERE IdNivel=c.IdNivel) AS nivel
                                      FROM  cuadronominativo AS cu INNER JOIN cargo c ON c.IdCargo=cu.IdCargo
                                      WHERE NroPlaza= '$Plaza'
                                    ) xc INNER JOIN persona p ON xc.persona=p.IdPersona
                                    WHERE NroPlaza= '$Plaza'");  
                }else{
                                $DataM = DB::select("SELECT persona,sede,organo,gerencia,dep2,dependencia,tipo,IdNivel,nivel,cargo,NroPlaza,dni,CONCAT(ApellidoPat, ' ', ApellidoMat,' ', Nombres) AS nom,DATE_FORMAT(FechaNac, '%d/%m/%Y')  AS FechaNac,  DATE_FORMAT(FechaIngreso, '%d/%m/%Y')  AS fingreso,(SELECT Descripcion FROM regimen WHERE IdRegimen=p.IdRegimen) AS regimen,Direccion,Genero  FROM (
                                    SELECT IdPersona AS persona,
                                    (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),2) LIMIT 1) AS sede,
                                    (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),4) LIMIT 1) AS organo,
                                    (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),7) LIMIT 1) AS gerencia,
                                    (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,11)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=cu.IdEstructura),11) LIMIT 1) AS dep2,
                                    (SELECT descripcion FROM estructura WHERE IdEstructura=cu.IdEstructura LIMIT 1) AS dependencia,
                                    '' as IdNivel, '' AS cargo,'' AS NroPlaza,
                                    '' AS tipo,
                                    '' AS nivel
                                    FROM  historiamovimiento AS cu INNER JOIN cargo c ON c.IdCargo=cu.IdCargo                                      
                                    WHERE   cu.IdPersona= (SELECT IdPersona FROM persona WHERE dni='$id') 
                                  ) xc INNER JOIN persona p ON p.IdPersona = xc.Persona 
                                  WHERE dni= '$id'"); 
                }

                return $DataM;            
    }

        public function GetEstadoDePlazas($id){      
                $DataM = DB::select(" SELECT  c.IdPersona, c.NroPlaza, c.IdEstructura,
                  (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,2)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),2) LIMIT 1) AS sede,
                  (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS organo,
                  (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),7) LIMIT 1) AS dep,
                  (SELECT descripcion FROM estructura WHERE LEFT(IdEstructura,11)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=c.IdEstructura),11) LIMIT 1) AS dep2,
                  e.Descripcion AS descripcion,
                      car.IdNivel,(SELECT descripcion FROM nivel WHERE IdNivel=car.IdNivel) AS Nivel,car.Descripcion AS cargo,IF(p.ApellidoPat IS NULL,'-',p.ApellidoPat)  AS ApellidoPat,
                      IF(p.ApellidoMat IS NULL,'-',p.ApellidoMat) AS ApellidoMat,IF(p.Nombres IS NULL,'-',p.Nombres) AS Nombres,
                      (SELECT descripcion FROM estadoplaza WHERE IdEstadoPlaza=c.IdEstadoPlaza) AS estado
                      FROM cuadronominativo  c  LEFT JOIN persona p ON p.IdPersona=c.IdPersona
                        INNER JOIN cargo car ON car.IdCargo=c.IdCargo   INNER JOIN estructura e ON e.IdEstructura=c.IdEstructura
                         WHERE  c.NroPlaza = '$id'"); 
                return $DataM;            
        }

        public function GetEstadoDePlazasMov($id){ 
                $data = DB::select("  SELECT IF((SELECT CONCAT(Dni,' ', ApellidoPat,' ',ApellidoMat,' ', Nombres) FROM persona WHERE IdPersona=h.IdPersona ) IS NULL,'---',(SELECT CONCAT(Dni,' | ', ApellidoPat,' ',ApellidoMat,' ', Nombres) FROM persona WHERE IdPersona=h.IdPersona )) AS Persona,
                  IF(h.IdTipoMov<>'',(SELECT CASE WHEN IdTipoMov IN ('12','13','14','15','16','17','18','19','20') THEN CONCAT('MOV. POR ',descripcion)  ELSE CONCAT('MOV. POR ',descripcion) END AS ss FROM tipomovimiento WHERE IdTipoMov=h.IdTipoMov),
                    IF(IdTipoBaja<>'',(SELECT CONCAT('BAJA POR ',descripcion) FROM tipobaja WHERE IdTipoBaja=h.IdTipoBaja),
                    (SELECT descripcion FROM estadoplaza WHERE IdEstadoPlaza=h.IdEstadoPlaza))) AS tipomov, 
                  (SELECT Descripcion FROM Estructura WHERE LEFT(IdEstructura,4)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),4) LIMIT 1) AS organo,
                  (SELECT Descripcion FROM Estructura WHERE LEFT(IdEstructura,7)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),7) LIMIT 1) AS dep,
                  (SELECT Descripcion FROM Estructura WHERE LEFT(IdEstructura,11)=LEFT((SELECT NewCodigo FROM estructura WHERE IdEstructura=h.IdEstructura),11) LIMIT 1) AS dep2,     
                  IdEstructura,(SELECT Descripcion FROM cargo WHERE IdCargo=h.IdCargo) AS cargo,DocRef,IF(Observacion IS NULL,'',Observacion) AS Observacion,DATE_FORMAT(FechaMov,'%d/%m/%y') AS fm,DATE_FORMAT(FechaDocRef,'%d/%m/%y') AS fd
                  FROM historiamovimiento h WHERE NroPlaza='$id'");
                 return Response::json($data);                 
        }

   
}