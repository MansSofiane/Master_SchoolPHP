<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['lib']) && isset($_REQUEST['plafond']) && isset($_REQUEST['monnaie']) && isset($_REQUEST['code']) ){
	$lib = $_REQUEST['lib'];
    $plafond = $_REQUEST['plafond'];
	$monnaie = $_REQUEST['monnaie'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `garantie` SET `lib_gar`='$lib',`plafond_gar`='$plafond',`monais_gar`='$monnaie' WHERE `cod_gar`='$code'");
$rqtc->execute();

}

?>