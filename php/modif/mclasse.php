<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libcls']) && isset($_REQUEST['txcls']) && isset($_REQUEST['code']) ){
	$libcls = $_REQUEST['libcls'];
    $txcls = $_REQUEST['txcls'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `classe` SET `lib_cls`='$libcls',`taux_cls`='$txcls' WHERE `cod_cls`='$code'");
$rqtc->execute();

}

?>