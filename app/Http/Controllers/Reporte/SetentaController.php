<?php namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use DB;
use App\User;
use Sentinel;

class SetentaController extends Controller { 

    public function index(Request $request){  
        $IdUser = Sentinel::findById(Sentinel::getUser()->id);$IdEstrUser=$IdUser->IdEstructura;

/*SELECT c.IdPersona ,Dni,ApellidoPat,ApellidoMat,Nombres,FechaNac,FechaIngreso,IdRegimen,
(YEAR(CURDATE()) - YEAR(FechaNac)) - IF(MONTH(CURDATE())<MONTH(FechaNac),1,IF(MONTH(CURDATE()) = MONTH(FechaNac), 
IF(DAY(CURDATE())<DAY( FechaNac),1,0),0)) AS anios, 
MONTH(CURDATE()) - MONTH(FechaNac) + 12 * IF( MONTH(CURDATE())<MONTH(FechaNac), 1,IF(MONTH(CURDATE())=MONTH(FechaNac),
IF(DAY(CURDATE())<DAY(FechaNac),1,0),0)) - IF(MONTH(CURDATE())<>MONTH(FechaNac),(DAY(CURDATE())<DAY(FechaNac)), IF (DAY(CURDATE())<DAY(FechaIngreso),1,0 ) )AS meses,
(DAY(CURDATE()) - DAY(FechaNac) +30 * (DAY(CURDATE()) < DAY(FechaNac))) AS dias,
(SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS red

 FROM persona AS p INNER JOIN cuadronominativo AS c ON c.IdPersona=p.IdPersona 

 WHERE IdRegimen<>'9' AND  IdRegimen<>'' AND FechaNac NOT IN('0000-00-00','0001-01-01','1000-01-01','1900-01-01')  
 GROUP BY dni
HAVING anios>=69 AND meses>6  ORDER BY anios DESC,meses DESC, dias DESC 
*/
            $data=DB::table('persona as p')
                   ->select(
                    'c.IdPersona',
                    'Dni',
                    'ApellidoPat',
                    'ApellidoMat',
                    'Nombres',
                    DB::raw('DATE_FORMAT(FechaNac,"%d/%m/%Y") AS FechaNac'),
                    'IdRegimen', 
                    DB::raw('(YEAR(CURDATE())-YEAR(FechaNac))-IF(MONTH(CURDATE())<MONTH(FechaNac),1,IF(MONTH(CURDATE()) = MONTH(FechaNac),IF(DAY(CURDATE())<DAY( FechaNac),1,0),0)) AS anios'),
                    DB::raw('MONTH(CURDATE())-MONTH(FechaNac) + 12 * IF(MONTH(CURDATE())<MONTH(FechaNac), 1,IF(MONTH(CURDATE())=MONTH(FechaNac),IF(DAY(CURDATE())<DAY(FechaNac),1,0),0)) - IF(MONTH(CURDATE())<>MONTH(FechaNac),(DAY(CURDATE())<DAY(FechaNac)), IF (DAY(CURDATE())<DAY(FechaIngreso),1,0 ) )AS meses'),
                    DB::raw('(DAY(CURDATE()) - DAY(FechaNac) +30 * (DAY(CURDATE()) < DAY(FechaNac))) AS dias'),                    
                    DB::raw('(SELECT descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) AS red')
                    )
                   ->join('cuadronominativo AS c','c.IdPersona','=','p.IdPersona')     
                   ->where('IdRegimen','<>','9')
                   ->where('IdRegimen','<>','')
                   ->where('FechaNac','<>','0000-00-00')
                   ->where('FechaNac','<>','0001-01-01')
                   ->where('FechaNac','<>','1000-01-01')
                   ->where('FechaNac','<>','1900-01-01')
                   ->where('IdEstructura','like',$IdEstrUser.'%')
                   //->groupBy('dni')
                   ->having('anios', '>=',69)
                   ->having('meses', '>',6)
                   ->orderby('anios','desc')
                   ->orderby('meses','desc')
                   ->orderby('dias','desc')
                   ->get();
               
       return view('reportes.setenta.index',compact('data','IdEstrUser','i')); 
    }

  }