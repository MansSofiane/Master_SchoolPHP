<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libacc']) && isset($_REQUEST['couacc']) && isset($_REQUEST['user']) ){
	$libacc = $_REQUEST['libacc'];
    $couacc = $_REQUEST['couacc'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `cpolice` VALUES ('','$libacc','$couacc','$user')");
$rqtc->execute();

}

?>