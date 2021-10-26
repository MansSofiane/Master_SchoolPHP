<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['age']) && isset($_REQUEST['dure']) && isset($_REQUEST['capital']) ){

    $age= $_REQUEST['age'];
    $dure = $_REQUEST['dure'];
	$capital = $_REQUEST['capital'];
$rqtu=$bdd->prepare("SELECT `pe` FROM `tarif` WHERE `cod_prod`='4' AND `cod_seg`='5' AND `cod_cls`='1' AND `cod_zone`='1' AND `cod_formul`='1' AND `cod_opt`='3' AND `cod_per`='$dure' AND `agemin`<='$age' AND `agemax`>='$age'");
$rqtu->execute();

$i=0;$tpu=0;
while ($row_pu=$rqtu->fetch()){
$tpu=$row_pu['pe'];
$i++;
}

$primeu=($capital*$tpu);
$tpuf=$tpu*(1+$tpu);

$primeuf=($capital*$tpuf);
$capitalf=$capital+$primeuf;

}
 ?><head>
<title>Intranet</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../../css/bootstrap.min.css" />
<link rel="stylesheet" href="../../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../../css/fullcalendar.css" />
<link rel="stylesheet" href="../../css/matrix-style.css" />
<link rel="stylesheet" href="../../css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="../../css/jquery.gritter.css" />
<link rel="stylesheet" href="../../css/datepicker.css" />
<link rel="stylesheet" href="../../css/uniform.css" />
<link rel="stylesheet" href="../../css/select2.css" />
<link rel="stylesheet" href="../../css/bootstrap-wysihtml5.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../../css/colorpicker.css" />
</head> 

<div id="content-header">
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>ADE-Consommation</a> <a class="current">Simulateur-Tarifs</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Resultat-Simulation</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
		   <div class="control-group">
			
             <label class="control-label">Informations Credit :</label>
              <div class="controls">
                <input type="text" id="cap" class="span5" value="Capital Demande : <?php echo number_format($capital, 2, ',', ' '); ?> DA" disabled="disabled" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="cap" class="span5" value="Age Emprunteur : <?php echo $age; ?> " disabled="disabled" />
              </div>
			  </div>
			  <div class="control-group">
              <div class="controls">
                <input type="text" id="cap" class="span5" value="Taux Prime Unique : <?php echo number_format($tpu, 4, ',', ' '); ?> %" disabled="disabled" />
              </div>
			  </div>
            <div class="control-group">
              <label class="control-label">Resultat du Calcul : </label>
              <div class="controls">
                <input type="text" id="cap" class="span5" value="Prime-Unique : <?php echo number_format($primeu, 2, ',', ' '); ?> DA" disabled="disabled"/>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="cap" class="span5" value="Capital-Finance : <?php echo number_format($capitalf, 2, ',', ' '); ?> DA" disabled="disabled"/>
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label"></label>
              <div class="controls">
                <input type="text" id="cap" class="span5" value="Prime-Unique-Financee : <?php echo number_format($primeuf, 2, ',', ' '); ?> DA" disabled="disabled"/>
              </div>
            </div>			
            <div class="form-actions" align="right">
			 <input  type="button" class="btn btn-success" onClick="" value="Imprimer" />
			  <input  type="button" class="btn btn-danger"  onClick="fermer()" value="Fermer" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function fermer() {
   this.close();
}	
</script>	