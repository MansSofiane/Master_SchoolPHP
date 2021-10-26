<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libzon']) && isset($_REQUEST['comzon']) && isset($_REQUEST['code']) ){
	$libzon = $_REQUEST['libzon'];
    $comzon= $_REQUEST['comzon'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `zone` SET `lib_zone`='$libzon',`com_zone`='$comzon' WHERE `cod_zone`='$code'");
$rqtc->execute();

}

?>