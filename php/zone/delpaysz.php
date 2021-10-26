<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if (isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
if (isset($_REQUEST['codp'])) {
	$codp = $_REQUEST['codp'];
}

$rqtd=$bdd->prepare("DELETE FROM `zonepays`  WHERE `cod_pays`='$codp' AND `cod_zone`='$code'");
$rqtd->execute();



?>