<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libper']) && isset($_REQUEST['jminper']) && isset($_REQUEST['jmaxper']) && isset($_REQUEST['codopt']) && isset($_REQUEST['code']) ){
	$libper = $_REQUEST['libper'];
    $jminper = $_REQUEST['jminper'];
	$jmaxper = $_REQUEST['jmaxper'];
	$codopt = $_REQUEST['codopt'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `periode` SET `lib_per`='$libper',`min_jour`='$jminper' ,`max_jour`='$jmaxper' , `cod_opt`='$codopt' WHERE `cod_per`='$code'");
$rqtc->execute();

}

?>