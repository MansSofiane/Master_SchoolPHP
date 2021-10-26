<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libprof']) && isset($_REQUEST['codcls']) && isset($_REQUEST['code']) ){
	$libprof = $_REQUEST['libprof'];
    $codcls = $_REQUEST['codcls'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `profession` SET `lib_prof`='$libprof',`cod_cls`='$codcls' WHERE `cod_prof`='$code'");
$rqtc->execute();

}

?>