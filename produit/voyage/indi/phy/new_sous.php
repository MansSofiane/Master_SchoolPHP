<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}

$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");



if (  isset($_REQUEST['civ']) && isset($_REQUEST['nom']) && isset($_REQUEST['prenom']) && isset($_REQUEST['adr'])
    && isset($_REQUEST['age'])  && isset($_REQUEST['dnais']) &&  isset($_REQUEST['mail']) && isset($_REQUEST['numpass'])
    && isset($_REQUEST['datepass'])) {

    $civ = $_REQUEST['civ'];
    $nom = $_REQUEST['nom'];
    $nomi = addslashes($_REQUEST['nom']);
    $prenom = $_REQUEST['prenom'];
    $prenomi = addslashes($_REQUEST['prenom']);
    $adr = $_REQUEST['adr'];
    $adri = addslashes($_REQUEST['adr']);
    $mail = $_REQUEST['mail'];
    $tel = $_REQUEST['tel'];
    $age = $_REQUEST['age'];
    $dnais = $_REQUEST['dnais'];
    $numpass = $_REQUEST['numpass'];
    $datepass = $_REQUEST['datepass'];
try {


    $rqtsous = $bdd->prepare("INSERT INTO `souscripteurw`(`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`, `sel`) VALUES ('', 'null' ,'$nomi','null','$prenomi','$numpass','$datepass',
                                                         '$datepass','$mail','$tel','$adri','$dnais','$age','$civ','1','1','','$id_user','null','','','','0')");
    $rqtsous->execute();
    echo "1";
}
catch (Exception $ex)
{
    echo "2";
}

}
?>