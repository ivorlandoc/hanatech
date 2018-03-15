<?php
$mysqli = new mysqli('localhost', 'root', '', 'gpessalud');
$mysqli->set_charset("utf8");
?>
<HEAD>
<?php 
header ("Content-Type: application/octet-stream");
?>
<link rel="stylesheet" href="assets/css/pdf.css" media="screen" />
<title>  <?php "IVOC301178".date("dmYhis"); ?></title>
 
        <style type="text/css">
          body {
            position: relative;
            color: #001028;
            background: #FFFFFF; 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            font-family: Arial;    
            margin: 5mm 5mm 5mm 20mm;
            /*margin: 10mm 20mm 3mm 20mm;*/
        }
        </style>

        </HEAD>
<body>

   <header class="header" style="text-align:center" > 

    <?php $ides=""; $desc=""; ?>
    @foreach($data as $key)<?php  $ides=$key->IdEstructura; $desc=$key->Descripcion;?> @endforeach   

        <h2>BANCO DE ESTRUCTURAS - <?php echo $desc;?> </h2> 
      </header>
  <body>
<?php

$result1=$mysqli->query("SELECT LEFT(IdEstructura,4) AS newcod,Descripcion AS denominaci,codigo AS codigo FROM estructura WHERE  LENGTH(NewCodigo)='4' ORDER BY 1");

$html='<table class="table table-hover">
  <tr class="filters">
    <th width="1">CODIGO</th>
    <th colspan="3" style="text-align:left">DENOMINACIÓN</th>    
  </tr>';
  $x=0;
 while($rs =$result1->fetch_assoc()){$x++;
  $result2=$mysqli->query("SELECT LEFT(IdEstructura,7) AS newcod,Descripcion AS denominaci,codigo AS codigo,LEFT(IdEstructura,7) AS pr FROM estructura WHERE  LENGTH(NewCodigo)=7  AND IdEstructura LIKE '$rs[newcod]%' ORDER BY 1");
    $html.='<tr><td style="width:1px"><b>'.$rs["newcod"].'</b></td><td colspan="3"><b>'.$rs["denominaci"].'</b></td></tr>';
    //  =================Segundo nivel=================
    $i=0;
     while($rs2 =$result2->fetch_assoc()){$i++;   
            $result3=$mysqli->query("SELECT LEFT(IdEstructura,11) AS newcod,Descripcion AS denominaci,codigo AS codigo FROM estructura WHERE  LENGTH(NewCodigo)=11 AND IdEstructura LIKE '$rs2[pr]%' ORDER BY 1 ");
       $html.='<tr><td><b>'.$rs2["newcod"].'<b>'.str_pad($i, 3, "0", STR_PAD_LEFT).'</b>'.'</b></td><td style="width:1px"></td><td colspan="2"><b>'.$rs2["denominaci"].'</td></b></tr>';
         //=================Tercer nivel=================
         /*
        $j=0;
        while($rs3 =$result3->fetch_assoc()){$j++;  
           $html.='<tr><td>'.$rs3["newcod"].''.str_pad($i, 3, "0", STR_PAD_LEFT).''.str_pad($j, 3, "0", STR_PAD_LEFT).''.'</td>
            <td></td><td style="width:1px"></td><td>'.$rs3["denominaci"].'</td></tr>';
        }*/
          
     }
}

 echo $html;
?>
</body>
    <footer> 
          <div id="notices" style="text-align:left;font-style: italic;">
              
            </div>                                
    </footer>

</body>