<?php
session_start();
require_once("../../../../data/conn7.php");
//on insere l'assure
if ( isset($_REQUEST['pds']) && isset($_REQUEST['tail']) && isset($_REQUEST['bool']) && isset($_REQUEST['sous'])){
	
$r1=0;$r2=0;$r3=0;$r4=0;$r5=0;$r6=0;
	
if($_REQUEST['r1']){$r1 = addslashes($_REQUEST['r1']);}
if($_REQUEST['r2']){$r2 = addslashes($_REQUEST['r2']);}
if($_REQUEST['r3']){$r3 = addslashes($_REQUEST['r3']);}
if($_REQUEST['r4']){$r4 = addslashes($_REQUEST['r4']);}
if($_REQUEST['r5']){$r5 = addslashes($_REQUEST['r5']);}
if($_REQUEST['r6']){$r6 = addslashes($_REQUEST['r6']);}
$bool = $_REQUEST['bool'];
$pds = $_REQUEST['pds'];
$tail = $_REQUEST['tail'];
$codsous = $_REQUEST['sous'];
$imc=$pds/($tail*$tail);
$rqtirs=$bdd->prepare("INSERT INTO `reponse` VALUES (NULL, '$r1', '$r2', '$r3', '$r4', '$r5', '$r6', '0', '0', '0', '0', '0', '$tail', '$pds', '$imc', '$bool', '$codsous')");
$rqtirs->execute();	

}

?>