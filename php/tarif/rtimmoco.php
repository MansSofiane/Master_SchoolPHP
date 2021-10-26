<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['age']) && isset($_REQUEST['dure']) && isset($_REQUEST['capital']) && isset($_REQUEST['age2']) && isset($_REQUEST['sal1']) && isset($_REQUEST['sal2']) ){

    $age= $_REQUEST['age'];
	$age2= $_REQUEST['age2'];
	$sal1= $_REQUEST['sal1'];
	$sal2= $_REQUEST['sal2'];
    $dure = $_REQUEST['dure'];
	$capital = $_REQUEST['capital'];
	$q1=$sal1/($sal1+$sal2);
	$q2=$sal2/($sal1+$sal2);
	$capital1=$capital*$q1;
	$capital2=$capital*$q2;
	
$rqtu1=$bdd->prepare("SELECT `pe` FROM `tarif` WHERE `cod_prod`='3' AND `cod_seg`='5' AND `cod_cls`='1' AND `cod_zone`='1' AND `cod_formul`='1' AND `cod_opt`='3' AND `cod_per`='$dure' AND `agemin`<='$age' AND `agemax`>='$age'");
$rqtu1->execute();
$rqtm1=$bdd->prepare("SELECT `pe` FROM `tarif` WHERE `cod_prod`='3' AND `cod_seg`='5' AND `cod_cls`='1' AND `cod_zone`='1' AND `cod_formul`='1' AND `cod_opt`='4' AND `cod_per`='$dure' AND `agemin`<='$age' AND `agemax`>='$age' ");
$rqtm1->execute();
$i=0;$j=0;$tpm1=0;$tpu1=0;
while ($row_pu1=$rqtu1->fetch()){
$tpu1=$row_pu1['pe'];
$i++;
}

while ($row_pm1=$rqtm1->fetch()){
$tpm1=$row_pm1['pe'];
$j++;
}
$primeu1=($capital1*$tpu1)/100;
$tpu11=$tpu1/100;
$tpuf1=$tpu11*(1+$tpu11);

$primeuf1=($capital1*$tpuf1);
$capitalf1=$capital1+$primeuf1;
$primem1=($capital1*$tpm1)/100;

$rqtu2=$bdd->prepare("SELECT `pe` FROM `tarif` WHERE `cod_prod`='3' AND `cod_seg`='5' AND `cod_cls`='1' AND `cod_zone`='1' AND `cod_formul`='1' AND `cod_opt`='3' AND `cod_per`='$dure' AND `agemin`<='$age2' AND `agemax`>='$age2'");
$rqtu2->execute();
$rqtm2=$bdd->prepare("SELECT `pe` FROM `tarif` WHERE `cod_prod`='3' AND `cod_seg`='5' AND `cod_cls`='1' AND `cod_zone`='1' AND `cod_formul`='1' AND `cod_opt`='4' AND `cod_per`='$dure' AND `agemin`<='$age2' AND `agemax`>='$age2' ");
$rqtm2->execute();
$k=0;$l=0;$tpm2=0;$tpu2=0;
while ($row_pu2=$rqtu2->fetch()){
$tpu2=$row_pu2['pe'];
$k++;
}

while ($row_pm2=$rqtm2->fetch()){
$tpm2=$row_pm2['pe'];
$l++;
}
$primeu2=($capital2*$tpu2)/100;
$tpu22=$tpu2/100;
$tpuf2=$tpu22*(1+$tpu22);

$primeuf2=($capital2*$tpuf2);
$capitalf2=$capital2+$primeuf2;
$primem2=($capital2*$tpm2)/100;

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
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>ADE-Immobilier</a> <a class="current">Simulateur-Tarifs</a> </div>
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
				<input type="text" id="cap" class="span5" value="Age Emprunteur : <?php echo $age; ?>   Age Co-Emprunteur : <?php echo $age2; ?>" disabled="disabled" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="cap" class="span5" value="Capital Emprunteur : <?php echo number_format($capital1, 2, ',', ' '); ?> DA  Co-Emprunteur : <?php echo number_format($capital2, 2, ',', ' '); ?> DA" disabled="disabled" />
              </div>
			  </div>
            <div class="control-group">
              <label class="control-label">Resultat-Emprunteur : </label>
              <div class="controls">
                <input type="text" id="cap" class="span5" value="Prime-Unique (Emprunteur) : <?php echo number_format($primeu1, 2, ',', ' '); ?> DA" disabled="disabled"/>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="cap" class="span5" value="Capital-Finance (Emprunteur) : <?php echo number_format($capitalf1, 2, ',', ' '); ?> DA" disabled="disabled"/>
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label"></label>
              <div class="controls">
                <input type="text" id="cap" class="span5" value="Prime-Unique-Financee (Emprunteur) : <?php echo number_format($primeuf1, 2, ',', ' '); ?> DA" disabled="disabled"/>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="cap" class="span5" value="Prime-Mensuelle (Emprunteur) : <?php echo number_format($primem1, 2, ',', ' '); ?>" disabled="disabled" />
              </div>
            </div>	
			 <div class="control-group">
              <label class="control-label">Resultat-Co-Emprunteur : </label>
              <div class="controls">
                <input type="text" id="cap" class="span5" value="Prime-Unique (Emprunteur) : <?php echo number_format($primeu2, 2, ',', ' '); ?> DA" disabled="disabled"/>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="cap" class="span5" value="Capital-Finance (Emprunteur) : <?php echo number_format($capitalf2, 2, ',', ' '); ?> DA" disabled="disabled"/>
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label"></label>
              <div class="controls">
                <input type="text" id="cap" class="span5" value="Prime-Unique-Financee (Emprunteur) : <?php echo number_format($primeuf2, 2, ',', ' '); ?> DA" disabled="disabled"/>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="cap" class="span5" value="Prime-Mensuelle (Emprunteur) : <?php echo number_format($primem2, 2, ',', ' '); ?>" disabled="disabled" />
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