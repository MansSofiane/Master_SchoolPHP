<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['code'])){
	$code = $_REQUEST['code'];
$rqtc=$bdd->prepare("UPDATE `devisw` SET `etat`= '3' WHERE `cod_dev`='$code'");
$rqtc->execute();
}

?>