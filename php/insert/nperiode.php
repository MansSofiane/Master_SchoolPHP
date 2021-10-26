<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libper']) && isset($_REQUEST['jminper']) && isset($_REQUEST['jmaxper']) && isset($_REQUEST['codopt']) && isset($_REQUEST['user']) ){
	$libper = $_REQUEST['libper'];
    $jminper = $_REQUEST['jminper'];
	 $jmaxper = $_REQUEST['jmaxper'];
	 $codopt = $_REQUEST['codopt'];
	 $user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `periode` VALUES ('','$libper','$jminper','$jmaxper','$codopt','$user')");
$rqtc->execute();

}

?>