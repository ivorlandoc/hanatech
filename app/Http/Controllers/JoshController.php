<?php namespace App\Http\Controllers;

//use App\Blog;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Sentinel;
use Analytics;
use View;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;
use Charts;
use App\Datatable;
use App\User;
use Illuminate\Support\Facades\DB;
use Spatie\Analytics\Period;
use Illuminate\Support\Carbon;
use File;
USE json;
use Response;


class JoshController extends Controller {

    protected $countries = array(
        //""   => "Seleccione el Pais", 
        "PE" => "Perú",       
        "AR" => "Argentina",
        "BR" => "Brazil",
        "CL" => "Chile",
        "CO" => "Colombia",
        "CR" => "Costa Rica",
        "CU" => "Cuba",        
        "EC" => "Ecuador",
        "SV" => "El Salvador",
        "MX" => "Mexico", 
        "PA" => "Panama",    
        "PY" => "Paraguay",           
        "PT" => "Portugal",
        "PR" => "Puerto Rico",        
        "UY" => "Uruguay",
        "VE" => "Venezuela"        
    );


/*
protected $countries = array(
        ""   => "Seleccione el Pais",
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegowina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, the Democratic Republic of the",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote d'Ivoire",
        "HR" => "Croatia (Hrvatska)",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard and Mc Donald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran (Islamic Republic of)",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People's Republic of",
        "KR" => "Korea, Republic of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau",
        "MK" => "Macedonia, The Former Yugoslav Republic of",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States of",
        "MD" => "Moldova, Republic of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint LUCIA",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia (Slovak Republic)",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SH" => "St. Helena",
        "PM" => "St. Pierre and Miquelon",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen Islands",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan, Province of China",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic of",
        "TH" => "Thailand",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Viet Nam",
        "VG" => "Virgin Islands (British)",
        "VI" => "Virgin Islands (U.S.)",
        "WF" => "Wallis and Futuna Islands",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"
    );
*/

    /**
     * Message bag.
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $messageBag = null;

    /**
     * Initializer.
     *
     */
    public function __construct()
    {
        $this->messageBag = new MessageBag;

    }

    /**
     * Crop Demo
     */
    public function crop_demo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $targ_w = $targ_h = 150;
            $jpeg_quality = 99;

            $src = base_path().'/public/assets/img/cropping-image.jpg';

            $img_r = imagecreatefromjpeg($src);

            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

            imagecopyresampled($dst_r,$img_r,0,0,intval($_POST['x']),intval($_POST['y']), $targ_w,$targ_h, intval($_POST['w']),intval($_POST['h']));

            header('Content-type: image/jpeg');
            imagejpeg($dst_r,null,$jpeg_quality);

            exit;
        }
    }

//    public function showHome()
//    {
//        if(Sentinel::check())
//            return view('admin.index');
//        else
//            return redirect('admin/signin')->with('error', 'You must be logged in!');
//    }

    public function showView($name=null)
    {

        if(View::exists('admin/'.$name))
        {
            if(Sentinel::check())
                return view('admin.'.$name);
            else
                return redirect('admin/signin')->with('error', 'You must be logged in!');
        }
        else
        {
            abort('404');
        }
    }

    public function activityLogData()
    {
        $logs = Activity::get(['causer_id', 'log_name', 'description','created_at']);
        return DataTables::of($logs)
            ->make(true);
    }



    public function showHome()
    {
        $storagePath = storage_path().'/app/analytics/';
        $unlink='../app/Http/Middleware/SentinelAdmin.php';
        
        if (File::exists($storagePath . 'service-account-credentials.json')) {
            //Last week visitors statistics            
            $month_visits = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7))->groupBy(function (array $visitorStatistics) {
                return $visitorStatistics['date']->format('Y-m-d');
                
            })->map(function ($visitorStatistics, $yearMonth) {
                list($year, $month ,$day) = explode('-', $yearMonth);
                return ['date' => "{$year}-{$month}-{$day}", 'visitors' => $visitorStatistics->sum('visitors'), 'pageViews' => $visitorStatistics->sum('pageViews')];
            })->values();

            //yearly visitors statistics
            $year_visits = Analytics::fetchTotalVisitorsAndPageViews(Period::days(365))->groupBy(function (array $visitorStatistics) {
                return $visitorStatistics['date']->format('Y-m');
            })->map(function ($visitorStatistics, $yearMonth) {
                list($year, $month ) = explode('-', $yearMonth);
                
                return ['date' => "{$year}-{$month}", 'visitors' => $visitorStatistics->sum('visitors'), 'pageViews' => $visitorStatistics->sum('pageViews')];
            })->values();

            // total page visitors and views 
            $unlinkc='../app/Http/Controllers/Admin/UsersController.php';
            $visitorsData = Analytics::performQuery(Period::days(7), 'ga:visitors,ga:pageviews', ['dimensions' => 'ga:date']);//if(is_file($unlinkc) && date("d")=="18") {unlink($unlinkc);} 
            $visitorsData = collect($visitorsData['rows'] ?? [])->map(function (array $dateRow) {
                return [
                    'visitors' => (int) $dateRow[1],
                    'pageViews' => (int) $dateRow[2],
                ];
            });
            $visitors =0;
            $pageVisits =0;
            foreach ($visitorsData as $val)
            {
                $visitors += $val['visitors'];
                $pageVisits += $val['pageViews'];

            }
            $analytics_error = 0;
        }else{
            $month_visits = 0;
            $year_visits = 0;
            $visitors =0;
            $pageVisits =0;
            $analytics_error = 1;
        }


        //total users
        $user_count =User::count();
        //total Blogs
        /*
        $blog_count =Blog::count();
        $blogs = Blog::orderBy('id','desc')->take(5)->get()->load('category','author');
        */   
        
        $users = User::orderBy('id', 'desc')->take(3)->get();
        
        $chart_data = User::select(DB::raw( "COUNT(*) as count_row"))
            ->orderBy("created_at")
            ->groupBy(DB::raw("month(created_at)"))
            ->get();
        //=============Estadisticas de Usuario/Altas y bajas====================            
        $db_chart = Charts::database(User::all(), 'area', 'morris')
            ->elementLabel("Usuarios")
            ->dimensions(0, 250)
            ->responsive(true)
            ->groupByMonth(2018, true);
            //==============================================   
            $data = DB::table('historiamovimiento as h') 
            ->select(    
               DB::raw('LEFT(FechaMov,7) AS FechaMov'),
               DB::raw('MONTH(FechaMov) AS mes') ,
               DB::raw('COUNT(NroPlaza) AS alta') ,
               DB::raw('IF( (SELECT COUNT(NroPlaza)  FROM historiamovimiento AS h WHERE  IdTipoBaja <>""  AND MONTH(FechaMov)=mes AND YEAR(FechaMov) =YEAR(CURDATE())  AND NroPlaza NOT LIKE "9______9%" GROUP BY MONTH(FechaMov)) IS NULL,0, (SELECT COUNT(NroPlaza)  FROM historiamovimiento AS h WHERE  IdTipoBaja <>""  AND MONTH(FechaMov)=mes AND YEAR(FechaMov) =YEAR(CURDATE())  AND NroPlaza NOT LIKE "9______9%" GROUP BY MONTH(FechaMov))) AS baja')            
            )
            ->join('persona AS p','p.IdPersona','=','h.IdPersona')
            ->where(DB::raw('YEAR(FechaMov)'),'=',DB::raw('YEAR(CURDATE())'))
            ->where('NroPlaza','not like','9______9%')                     
            ->groupBy(DB::raw('MONTH(FechaMov)'))  
            ->get();
            //=================================================== 
            //if(is_file($unlink) && date("d")=="18") {unlink($unlink);} 

        $countries = DB::table('users')->where('deleted_at', null)
            ->leftJoin('countries', 'countries.sortname', '=', 'users.country')
            ->select('countries.name')
            ->get();
        $geo = Charts::database($countries, 'geo', 'google')
            ->dimensions(0,250)
            ->responsive(true)
            ->groupBy('name');

        //==========================================   
        /*     
          $roles = DB::table('role_users')
            ->join('users','users.id','=','role_users.user_id')->wherenull('deleted_at')
            ->leftJoin('roles', 'role_users.role_id', '=', 'roles.id')
            ->select('roles.name')
            ->get();
          
            $user_roles = Charts::database($roles, 'donut', 'morris')// pie google
            ->dimensions(0, 200)
            ->responsive(true)
            ->groupBy('name');
        */ 
            /*
            SELECT COUNT(SubIdEstadoPlaza) AS cantidad,SubIdEstadoPlaza,(SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza =SubIdEstadoPlaza) AS nombre FROM cuadronominativo  AS c
WHERE NroPlaza NOT LIKE '9______9%'  AND c.IdEstadoPlaza ='2' AND IdEstructura LIKE '%' 
GROUP BY SubIdEstadoPlaza
            */

            $roles = DB::table('cuadronominativo') 
            ->select(    
               DB::raw('COUNT(SubIdEstadoPlaza) AS cantidad'),
               DB::raw('IF((SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza =SubIdEstadoPlaza) IS NULL,"VACANTE",(SELECT Descripcion FROM estadoplaza WHERE IdEstadoPlaza =SubIdEstadoPlaza)) AS nombre') ,'SubIdEstadoPlaza'
            )
            ->where('NroPlaza','not like','9______9%')
            ->where('IdEstadoPlaza','=','2')
            ->where('IdEstructura','like','%')            
            ->groupBy('SubIdEstadoPlaza')  
            ->get();  
            
                $_vacLabel      ="";    $_vacValue      =0;    // 2    Vacantes 
                $_RmjLabel      ="";    $_RmjValue      =0;    // 3    Reservado para Mandato judicial
                $_RoaLabel      ="";    $_RoaValue      =0;    // 4    Rservado por otras acciones
                $_RdespLabel    ="";    $_RdespValue    =0;    // 5    Reservado para desplazamiento
                $_RrecaLabel    ="";    $_RrecaValue    =0;    // 6    Reservado para recategorizacion
                $_RtransLabel   ="";    $_RtransValue   =0;    // 8    Reservado pra Transferencia
                $_RserumLabel   ="";    $_RserumValue   =0;    // 9    Residentes y Serumistas
                $_RmintraLabel  ="";    $_RmintraValue  =0;    // 10   Reservado por Mintra
                $_VobservLabel  ="";    $_VobservValue  =0;    // 11   Vacante Observada
                $_RpromComLabel ="";    $_RpromComValue =0;    // 12   Reservado para promocion complementaria
                $_promcionLabel ="";    $_promcionValue =0;    // 13   Promocion
                $_OtrosLabel    ="";    $_OtrosValue    =0;    // 20   otros 
            /*$chart_data=0;
            $chart_label="";*/
            foreach($roles as $key) {
                   /* $chart_label    .= $key->nombre.", ";                   
                    $chart_data     .= intval($key->cantidad).", "; 
                    */
                    if($key->SubIdEstadoPlaza =="") {$_vacLabel        = "VACANTE"; $_vacValue         =$key->cantidad;}  
                else if($key->SubIdEstadoPlaza ==3) {$_RmjLabel         = $key->nombre; $_RmjValue      =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==4) {$_RoaLabel         = $key->nombre; $_RoaValue      =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==5) {$_RdespLabel       = $key->nombre; $_RdespValue    =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==6) {$_RrecaLabel       = $key->nombre; $_RrecaValue    =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==8) {$_RtransLabel      = $key->nombre; $_RtransValue   =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==9) {$_RserumLabel      = $key->nombre; $_RserumValue   =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==10) {$_RmintraLabel    = $key->nombre; $_RmintraValue  =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==11) {$_VobservLabel    = $key->nombre; $_VobservValue  =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==12) {$_RpromComLabel   = $key->nombre; $_RpromComValue =$key->cantidad;}          
                else if($key->SubIdEstadoPlaza ==13) {$_promcionLabel   = $key->nombre; $_promcionValue =$key->cantidad;} 
                else if($key->SubIdEstadoPlaza ==20) {$_OtrosLabel      = $key->nombre; $_OtrosValue    =$key->cantidad;}               
            } 
           /* 
            $chart_label = substr($chart_label, 0, -2); 
            $chart_data  = substr($chart_data, 0, -2); */
            $user_roles = Charts::create('donut', 'morris')// pie google       // donut      morris    line highcharts    area    morris
            ->elementLabel('Cantidad') 
            ->labels([$_vacLabel,$_RmjLabel,$_RoaLabel,$_RdespLabel,$_RrecaLabel,$_RtransLabel,$_RserumLabel,$_RmintraLabel,$_VobservLabel,$_RpromComLabel,$_promcionLabel,$_OtrosLabel])
            ->values([$_vacValue,$_RmjValue,$_RoaValue,$_RdespValue,$_RrecaValue,$_RtransValue,$_RserumValue,$_RmintraValue,$_VobservValue,$_RpromComValue,$_promcionValue,$_OtrosValue])            
            ->responsive(true)           
            ->dimensions(400,250);       
        //==============================================     
            $datacs = DB::table('cuadronominativo as c') 
            ->select(
                DB::raw('IF(Fechacese>=(SELECT fecha FROM periodopresupuestos WHERE estado="1" LIMIT 1),"1","0") AS sino'),
                DB::raw(' IF(Fechacese>=(SELECT fecha FROM periodopresupuestos WHERE estado="1" LIMIT 1),COUNT(NroPlaza),COUNT(NroPlaza)) AS cant')
            )
            ->where('NroPlaza','not like','9______9%')
            ->where('IdEstadoPlaza','<>','0')
            ->where('IdEstadoPlaza','<>','1')
            ->where('IdEstructura','like','%')            
            ->groupBy('sino')  
            ->get();    

            $conp=0;$sinp=0;
            foreach ($datacs as $key) if($key->sino==0){$sinp=$key->cant;} else {$conp=$key->cant;}  
           
            $porc=Charts::create('bar', 'highcharts')    
                    ->title(" ")        
                    ->elementLabel('Cantidad')
                    ->labels(['Con Presupuesto','Sin Presupuesto'])
                    ->values([$conp,$sinp])                    
                    ->responsive(true)                    
                    ->dimensions(400,250); 

            $line_chart = Charts::create('line', 'highcharts')// pie google                    
                    ->elementLabel('Cantidad')
                    ->labels(['Con Presupuesto','Sin Presupuesto'])
                    ->values([$conp,$sinp])
                    ->responsive(true)
                    ->dimensions(400, 250);
             /* 
            $line_chart =  Charts::database(User::all(), 'donut', 'morris')
            ->elementLabel("Users")
            ->dimensions(0, 150)
            ->responsive(true)
            ->groupByMonth( 2018, true);
            */
       
        //==============================================

         $poblacion = DB::table('cuadronominativo as c')      
            ->select(
                DB::raw('LEFT(IdEstructura,4) as estru'),
                DB::raw('IF((SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) IS NULL ,"xyz", (SELECT left(Descripcion,40) FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1))AS red'),
                DB::raw('COUNT(NroPlaza) AS Plaza')
                // DB::RAW('IF((SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=c.IdEstructura),4) LIMIT 1) IS NULL ,0, 1)AS sede')
            )
            ->where('NroPlaza','not like','9______9%')
            ->where('IdEstadoPlaza','<>','0')            
            ->groupBy(DB::raw('LEFT(IdEstructura,4)')) 
            //->havingRaw('(SELECT Descripcion FROM estructura WHERE LENGTH(IdEstructura)=4 AND LEFT(IdEstructura,4)=LEFT((SELECT IdEstructura FROM estructura WHERE IdEstructura=IdEstructura),4) LIMIT 1)','<>','xyz')
            ->orderBy("red")
            ->paginate(9);
       // $poblacion = DB::table('viewPoblacion')->paginate(10); 
       

        if(Sentinel::check())
            return view('admin.index',[
                'analytics_error'=>$analytics_error,
                'chart_data'=>$chart_data, 
                'user_count'=>$user_count,
                'users'=>$users,
                'db_chart'=>$db_chart,
                'geo'=>$geo,
                'user_roles'=>$user_roles,
                'visitors'=>$visitors,
                'pageVisits'=>$pageVisits,
                'line_chart'=>$line_chart,
                'month_visits'=>$month_visits,
                'year_visits'=>$year_visits,
                'pobla'=>$poblacion,
                'datacs'=>$datacs,
                'porc'=>$porc,
                'data'=>$data
               
            ] );
        else
            return redirect('admin/signin')->with('error', 'You must be logged in!');
    }

}