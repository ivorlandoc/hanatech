<?php namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use DB;
use App\User;
use Sentinel;

class Cap2Controller extends Controller { 

    public function index(Request $request){  
        $IdUser = Sentinel::findById(Sentinel::getUser()->id);$IdEstrUser=$IdUser->IdEstructura;

       $getDosDig=DB::table('estructura')->select('IdEstructura','Descripcion')->where(DB::raw('LENGTH(IdEstructura)'), '=', "4")
       ->where('IdEstructura', 'like', $IdEstrUser."%")
       ->get();
       return view('reportes.cap2.index',compact('getDosDig','IdEstrUser')); 
    }

 public function getshowCap2(Request $request){
        if($request->ajax()) {  
            $string=$request->input("id");
            $data= DB::select('SELECT  
                    c.NroPlaza, 
                    c.IdEstructura,
                    car.IdNivel,
                    IF(LEFT(car.IdNivel,1)="A",CONCAT("Z",RIGHT(car.IdNivel,1)),car.IdNivel) AS niv_orden,
                    car.Descripcion AS cargo,
                    IF(ApellidoPat IS NULL, "--",ApellidoPat) AS ApellidoPat,
                    IF(ApellidoMat IS NULL, "--",ApellidoMat) AS ApellidoMat,
                    IF(Nombres IS NULL, "--",Nombres) AS Nombres,
                    c.IdPersona
                    FROM cuadronominativo  c  LEFT JOIN persona p ON P.IdPersona=c.IdPersona
                    INNER JOIN cargo car ON car.IdCargo=c.IdCargo 
                    WHERE  c.IdEstructura LIKE  "'.$string.'%" and c.NroPlaza not like "9______9%" ORDER BY niv_orden');

              return $data;
            }
        }
    
  }