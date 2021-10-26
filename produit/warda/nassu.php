<?php
session_start();
require_once("../../../../data/conn7.php");
//on insere l'assure
if ( isset($_REQUEST['prenoma']) && isset($_REQUEST['adra']) && isset($_REQUEST['civilitea']) && isset($_REQUEST['datnaisa']) && isset($_REQUEST['agea']) && isset($_REQUEST['sous']) && isset($_REQUEST['user']) && isset($_REQUEST['tok'])){
	
	$nom = addslashes($_REQUEST['noma']);
	$prenom = addslashes($_REQUEST['prenoma']);
	$adr = addslashes($_REQUEST['adra']);
	$dnais = $_REQUEST['datnaisa'];
    $age = $_REQUEST['agea'];
	$civ = $_REQUEST['civilitea'];
	$sous = $_REQUEST['sous'];
	$user = $_REQUEST['user'];
	$token = $_REQUEST['tok'];
$rqtis=$bdd->prepare("INSERT INTO `souscripteurw` VALUES ('', 'null','$nom','null','$prenom','','','','','','$adr','$dnais','$age','$civ','1','0','$sous','$user','null','','','','0')");
$rqtis->execute();
}

?>