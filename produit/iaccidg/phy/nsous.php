<?php
session_start();
$user=$_SESSION['id_usersal'];
require_once("../../../../../data/conn7.php");
//on insere l'assure
if ( isset($_REQUEST['noms']) && isset($_REQUEST['prenoms']) && isset($_REQUEST['adrs']) && isset($_REQUEST['civs']) && isset($_REQUEST['dnaiss']) && isset($_REQUEST['ages'])){
	$nom = addslashes($_REQUEST['noms']);
	$prenom = addslashes($_REQUEST['prenoms']);
	$adr = addslashes($_REQUEST['adrs']);
	$mail = addslashes($_REQUEST['mails']);
	$tel = addslashes($_REQUEST['tels']);
	$dnais = $_REQUEST['dnaiss'];
    $age = $_REQUEST['ages'];
	$civ = $_REQUEST['civs'];
	$rp = $_REQUEST['rps'];

$rqtis=$bdd->prepare("INSERT INTO `souscripteurw` VALUES ('', 'null','$nom', 'null','$prenom','','','','$mail','$tel','$adr','$dnais','$age','$civ','$rp','0','0','$user','null','','','','0')");
$rqtis->execute();
}

?>