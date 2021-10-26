<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['code'])){
	$code = $_REQUEST['code'];
$rqtc=$bdd->prepare("DELETE FROM `sinistre` WHERE `cod_sin`='$code'");
$rqtc->execute();
}

?>