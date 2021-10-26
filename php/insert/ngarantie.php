<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['lib']) && isset($_REQUEST['plafond']) && isset($_REQUEST['monnaie']) && isset($_REQUEST['user']) ){
	$lib = $_REQUEST['lib'];
    $plafond = $_REQUEST['plafond'];
	$monnaie = $_REQUEST['monnaie'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `garantie` VALUES ('','$lib','$plafond','$monnaie','0','$user')");
$rqtc->execute();

}

?>