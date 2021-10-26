<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libdtmb']) && isset($_REQUEST['coudtmb']) && isset($_REQUEST['code']) ){
	$libdt = $_REQUEST['libdtmb'];
    $mttdt = $_REQUEST['coudtmb'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `dtimbre` SET `lib_dt`='$libdt',`mtt_dt`='$mttdt' WHERE `cod_dt`='$code'");
$rqtc->execute();

}

?>