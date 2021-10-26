<?php
session_start();
require_once("../../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['code'])){
	$code = $_REQUEST['code'];
$rqtc=$bdd->prepare("DELETE FROM `souscripteurw` WHERE `cod_sous`='$code'");
$rqtc->execute();
}

?>