<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libfrm']) && isset($_REQUEST['minfrm']) && isset($_REQUEST['maxfrm']) && isset($_REQUEST['user']) ){
	$libfrm = $_REQUEST['libfrm'];
    $minfrm = $_REQUEST['minfrm'];
	$maxfrm = $_REQUEST['maxfrm'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `formule` VALUES ('','$libfrm','$minfrm','$maxfrm','$user')");
$rqtc->execute();

}

?>