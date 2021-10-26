<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if (isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}



$rqt=$bdd->prepare("UPDATE `policew` SET `sel`='0' WHERE 1 ");
$rqt->execute();


$rqtc=$bdd->prepare("UPDATE `policew` SET `sel`='1' WHERE `cod_pol`='$code'");
$rqtc->execute();



?>