<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['segment']) && isset($_REQUEST['formule'])  && isset($_REQUEST['timbre']) && isset($_REQUEST['cpolice']) && isset($_REQUEST['zone']) && isset($_REQUEST['periode']) && isset($_REQUEST['option']) && isset($_REQUEST['agemin']) && isset($_REQUEST['agemax']) && isset($_REQUEST['pe']) && isset($_REQUEST['pa']) && isset($_REQUEST['mpe']) && isset($_REQUEST['rpe']) && isset($_REQUEST['mpa']) && isset($_REQUEST['rpa']) && isset($_REQUEST['user']) ){
	$segment = $_REQUEST['segment'];
    $formule = $_REQUEST['formule'];
	$timbre = $_REQUEST['timbre'];
	$cpolice = $_REQUEST['cpolice'];
    $zone = $_REQUEST['zone'];
	$periode = $_REQUEST['periode'];
	$option = $_REQUEST['option'];
    $agemin = $_REQUEST['agemin'];
	$agemax = $_REQUEST['agemax'];
	$pe = $_REQUEST['pe'];
    $pa = $_REQUEST['pa'];
	$mpe = $_REQUEST['mpe'];
	$rpe = $_REQUEST['rpe'];
    $mpa = $_REQUEST['mpa'];
	$rpa = $_REQUEST['rpa'];	
	$user = $_REQUEST['user'];
$rqtc=$bdd->prepare("INSERT INTO `tarif` VALUES ('','1','$segment','0','$zone','$formule','$option','0','$periode','$timbre','$cpolice','$agemin','$agemax','$mpe','$rpe','$mpa','$rpa','$pe','$pa','$user')");
$rqtc->execute();

}

?>