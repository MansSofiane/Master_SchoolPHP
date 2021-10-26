<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if (isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}

$rqtc=$bdd->prepare("UPDATE `pays` SET `sel_pays`='0' WHERE `cod_pays`='$code'");
$rqtc->execute();



?>