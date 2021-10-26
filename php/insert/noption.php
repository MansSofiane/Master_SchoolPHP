<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libopt']) && isset($_REQUEST['effopte']) && isset($_REQUEST['echopte']) && isset($_REQUEST['user']) ){
	$libopt = $_REQUEST['libopt'];
    $effopte = $_REQUEST['effopte'];
	$echopte = $_REQUEST['echopte'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `option` VALUES ('','$libopt','$effopte','$echopte','$user')");
$rqtc->execute();

}

?>