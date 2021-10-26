<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");




if (isset($_REQUEST['nomag']) && isset($_REQUEST['nomrep']) && isset($_REQUEST['prenomrep']) && isset($_REQUEST['adr'])&& isset($_REQUEST['mail'])&& isset($_REQUEST['tel'])
    ) {
    $datesys=date("Y.m.d");
    $nomag = ($_REQUEST['nomag']);
    $nomrep = ($_REQUEST['nomrep']);
    $prenomrep = ($_REQUEST['prenomrep']);
    $adr = ($_REQUEST['adr']);
    $tel = ($_REQUEST['tel']);
    $mail = ($_REQUEST['mail']);
    $rqt = $bdd->prepare(" INSERT INTO `agence` (`cod_agence`, `lib_agence`, `nom_rep`, `prenom_rep`, `mail_agence`, `adr_agence`, `tel_agence`, `date`, `id_user`)  VALUES ('','$nomag','$nomrep','$prenomrep','$mail','$adr','$tel','$datesys','$id_user')");
    $rqt->execute();
}

?>