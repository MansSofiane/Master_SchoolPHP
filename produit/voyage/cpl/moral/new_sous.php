<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");


if (  isset($_REQUEST['raison']) &&isset($_REQUEST['adresse']) && isset($_REQUEST['tel'])   ) {
    $raison = $_REQUEST['raison'];
    $adresse = $_REQUEST['adresse'];
    $adressei = addslashes($_REQUEST['adresse']);
    $tel = $_REQUEST['tel'];
// INSERT INTO `souscripteurw`(`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `
//dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`)

    $rqtsous = $bdd->prepare(" INSERT INTO `souscripteurw`(`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`)  VALUES ('','NULL','$raison','NULL','NULL','NULL','NULL','NULL','NULL','$tel','$adressei',
 'NULL','null','0','0','2','NULL','$id_user','','','','')");

    $rqtsous->execute();

}
?>