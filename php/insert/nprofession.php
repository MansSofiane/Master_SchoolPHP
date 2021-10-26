<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libprof']) && isset($_REQUEST['codcls']) && isset($_REQUEST['user']) ){
	$libprof = $_REQUEST['libprof'];
    $codcls = $_REQUEST['codcls'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `profession` VALUES ('','$libprof','$codcls','$user')");
$rqtc->execute();

}

?>