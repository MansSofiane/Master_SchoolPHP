<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libdtmb']) && isset($_REQUEST['coudtmb']) && isset($_REQUEST['user']) ){
	$libdtmb = $_REQUEST['libdtmb'];
    $coudtmb = $_REQUEST['coudtmb'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `dtimbre` VALUES ('','$libdtmb','$coudtmb','$user')");
$rqtc->execute();

}

?>