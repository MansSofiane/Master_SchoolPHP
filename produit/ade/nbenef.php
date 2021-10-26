<?php
session_start();
require_once("../../../../data/conn7.php");
//on insere l'assure
if ( isset($_REQUEST['nom']) && isset($_REQUEST['adr']) && isset($_REQUEST['tel'])  && isset($_REQUEST['agence']) && isset($_REQUEST['sous']) && isset($_REQUEST['tok']) ){
	
	$nom = addslashes($_REQUEST['nom']);
	$agence = addslashes($_REQUEST['agence']);
	$adr = addslashes($_REQUEST['adr']);
	$tel = addslashes($_REQUEST['tel']);
	$sous = $_REQUEST['sous'];
	$token = $_REQUEST['tok'];
$rqtib=$bdd->prepare("INSERT INTO `beneficiaire` VALUES ('', '$nom', '$agence', '$adr', '$tel','$sous')");
$rqtib->execute();
   

}

?>