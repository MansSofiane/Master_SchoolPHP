<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libcls']) && isset($_REQUEST['txcls']) && isset($_REQUEST['user']) ){
	$libcls = $_REQUEST['libcls'];
    $txcls = $_REQUEST['txcls'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `classe` VALUES ('','$libcls','$txcls','$user')");
$rqtc->execute();

}

?>