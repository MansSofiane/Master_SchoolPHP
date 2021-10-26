<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libopt']) && isset($_REQUEST['effopte']) && isset($_REQUEST['echopte']) && isset($_REQUEST['code'])){
	$libopt = $_REQUEST['libopt'];
    $effopte = $_REQUEST['effopte'];
	$echopte = $_REQUEST['echopte'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `option` SET `lib_opt`='$libopt',`dat_eff_opt`='$effopte',`dat_ech_opt`='$echopte' WHERE `cod_opt`='$code'");
$rqtc->execute();

}

?>