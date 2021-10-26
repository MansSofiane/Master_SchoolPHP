<?php
session_start();
$user=$_SESSION['id_usersal'];
require_once("../../../../data/conn7.php");
//on insere l'assure
if ( isset($_REQUEST['code']) && isset($_REQUEST['datesin']) && isset($_REQUEST['comm'])){
	
	$code = $_REQUEST['code'];
    $date = $_REQUEST['datesin'];
	$comm = addslashes($_REQUEST['comm']);

$rqtis=$bdd->prepare("INSERT INTO `sinistre` VALUES ('','$date','$comm','0','','','','0','$code')");
$rqtis->execute();

}

?>