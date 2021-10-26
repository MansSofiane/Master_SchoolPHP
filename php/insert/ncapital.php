<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libcap']) && isset($_REQUEST['mttcap']) && isset($_REQUEST['user']) ){
	$libcap = $_REQUEST['libcap'];
    $mttcap = $_REQUEST['mttcap'];
	$user = $_REQUEST['user'];

$rqtc=$bdd->prepare("INSERT INTO `capital` VALUES ('','$libcap','$mttcap','$user')");
$rqtc->execute();

}

?>