<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libfrm']) && isset($_REQUEST['minfrm']) && isset($_REQUEST['maxfrm']) && isset($_REQUEST['code']) ){
	$libfrm = $_REQUEST['libfrm'];
    $minfrm = $_REQUEST['minfrm'];
	$maxfrm = $_REQUEST['maxfrm'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `formule` SET `lib_formul`='$libfrm',`minnb_assu`='$minfrm',`maxnb_assu`='$maxfrm' WHERE `cod_formul`='$code'");
$rqtc->execute();

}

?>