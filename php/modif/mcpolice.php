<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libacc']) && isset($_REQUEST['couacc']) && isset($_REQUEST['code']) ){
	$libacc = $_REQUEST['libacc'];
    $couacc= $_REQUEST['couacc'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `cpolice` SET `lib_cpl`='$libacc',`mtt_cpl`='$couacc' WHERE `cod_cpl`='$code'");
$rqtc->execute();

}

?>