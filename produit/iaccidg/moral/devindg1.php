<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
if ( isset($_REQUEST['civ']) && isset($_REQUEST['nom']) && isset($_REQUEST['prenom']) && isset($_REQUEST['adr']) && isset($_REQUEST['age'])  && isset($_REQUEST['dnais']) && isset($_REQUEST['rp'])){

    $civ= $_REQUEST['civ'];
	$nom = $_REQUEST['nom'];
    $nomi = addslashes($_REQUEST['nom']);
	$prenom =$_REQUEST['prenom'];
	$prenomi = addslashes($_REQUEST['prenom']);
	$adr = $_REQUEST['adr'];
	$adri = addslashes($_REQUEST['adr']);
	$mail = $_REQUEST['mail'];
	$tel = $_REQUEST['tel'];
	$age = $_REQUEST['age'];
    $dnais = $_REQUEST['dnais'];
	$rp = $_REQUEST['rp'];
	
//Insertion du souscripteur
$rqtis=$bdd->prepare("INSERT INTO `souscripteurw` VALUES ('', 'null','$nomi','null','$prenomi','','','','$mail','$tel','$adri','$dnais','$age','$civ','$rp','0','0','$id_user','null','','','','0')");
$rqtis->execute();
// recupération du code du dernier souscripteur de l'agence	
$rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$id_user'");
$rqtms->execute();
$codsous=0;
while ($row_res=$rqtms->fetch()){ 
$codsous=$row_res['maxsous']; 
}	
// recupération du code du dernier souscripteur de l'agence	
$rqtu=$bdd->prepare("SELECT agence  FROM `utilisateurs` WHERE id_user='$id_user'");
$rqtu->execute();
$agence=0;
while ($rowu=$rqtu->fetch()){ 
$agence=$rowu['agence']; 
}	
$i = 0;
$folder = "../../doc/indacc/documents/";
$dossier = opendir($folder);
while (false !== ($Fichier = readdir($dossier))) {
     if ($Fichier != "." && $Fichier != "..") {
	 
		$row_file[$i] = $Fichier;	
		$i++;
	 }
closedir($dossier);
}
	
}

?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a>Individuelle-Accident</a><a>Formule-Groupe</a><a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Assure (F-Excel)</a><a>Capital</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
           
			 <div class="control-group">
              <div class="controls">
                <input type="text" id="nsous" class="span5" value="Nom: <?php echo $folder; ?>" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="psous" class="span5" value="Prenom: <?php echo $prenom; ?>" disabled="disabled" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
                <input type="text" id="mailsous" class="span5" value="E-mail: <?php echo $mail; ?>" disabled="disabled" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="telsous" class="span5" value="Phone: <?php echo $tel; ?>" disabled="disabled" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
                <input type="text" id="adrsous" class="span5" value="Adresse: <?php echo $adr; ?>" disabled="disabled" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" class="span5"   id="dnaissous" value="D-Naissance: <?php echo date("d/m/Y",strtotime($dnais)); ?>" disabled="disabled"/>
              </div>
            </div>
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="capitalwar('<?php echo $codsous; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assiaccgrp.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function capitalwar(codsous){

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	
	$("#content").load("produit/iaccid/moral/devind3.php?sous="+codsous);
	
	}	
			
</script>	