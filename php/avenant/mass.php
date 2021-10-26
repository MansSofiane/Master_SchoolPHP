<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['sous']) && isset($_REQUEST['nom']) && isset($_REQUEST['pnom']) && isset($_REQUEST['adr']) ){
    $sous = $_REQUEST['sous'];
    $nom = addslashes($_REQUEST['nom']);
    $pnom= addslashes($_REQUEST['pnom']);
	$adr = addslashes($_REQUEST['adr']);
	$tel = addslashes($_REQUEST['tel']);
	$mail = addslashes($_REQUEST['mail']);

$rqtma=$bdd->prepare("UPDATE `souscripteurw` SET `nom_sous`='$nom',`pnom_sous`='$pnom',`adr_sous`='$adr',`tel_sous`='$tel',`mail_sous`='$mail' WHERE `cod_par`='$sous'");
$rqtma->execute();

}

?>