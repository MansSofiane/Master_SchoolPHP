<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libzon']) && isset($_REQUEST['comzon']) && isset($_REQUEST['user']) ){
	$libzon = $_REQUEST['libzon'];
    $comzon = $_REQUEST['comzon'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `zone` VALUES ('','$libzon','$comzon','$user')");
$rqtc->execute();

}

?>