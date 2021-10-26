<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['user']) && isset($_REQUEST['nom']) && isset($_REQUEST['pnom']) && isset($_REQUEST['adr']) && isset($_REQUEST['pass']) && isset($_REQUEST['tok'])){
    $user = $_REQUEST['user'];
	$token = $_REQUEST['tok'];
    $nom = addslashes($_REQUEST['nom']);
    $pnom= addslashes($_REQUEST['pnom']);
	$adr = addslashes($_REQUEST['adr']);
	$tel = addslashes($_REQUEST['tel']);
	$mail = addslashes($_REQUEST['mail']);
	$pass = addslashes($_REQUEST['pass']);
//if (verifier_token(3200, 'https://localhost/CASH/Espace.html', 'muser', $token)) {

$rqtma=$bdd->prepare("UPDATE `utilisateurs` SET `nom`='$nom',`prenom`='$pnom',`adr_user`='$adr',`tel_user`='$tel',`mail_user`='$mail',`pass`=sha1('$pass')  WHERE `id_user`='$user'");
$rqtma->execute();
//}
}

?>