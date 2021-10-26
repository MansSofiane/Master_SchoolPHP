<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
//$datesys=date("y-m-d H:i:s");

//  codsous=" + codsous + "&mail=" + mail1 + "&tel=" + tel1 + "&adr=" + adr1 + "&civ=" + civilite1 + "&nom=" + nom1 + "&prenom=" + prenom1 + "&age=" + age1 + "&dnais=" + date11 + "&numpass=" + numpass1 + "&datepass=" + date13 );


if (  isset($_REQUEST['codsous']) &&  isset($_REQUEST['mail']) && isset($_REQUEST['tel']) &&isset($_REQUEST['adr'])
    && isset($_REQUEST['civ']) && isset($_REQUEST['nom']) && isset($_REQUEST['prenom']) && isset($_REQUEST['age'])
    && isset($_REQUEST['dnais'])  && isset($_REQUEST['numpass']) && isset($_REQUEST['datepass']))

{
    $codsous = $_REQUEST['codsous'];
    $mail = $_REQUEST['mail'];
    $tel = $_REQUEST['tel'];
    $adr = $_REQUEST['adr'];
    $adri = addslashes($_REQUEST['adr']);
    $civ = $_REQUEST['civ'];
    $nom = $_REQUEST['nom'];
    $nomi = addslashes($_REQUEST['nom']);
    $prenom = $_REQUEST['prenom'];
    $prenomi = addslashes($_REQUEST['prenom']);
    $age = $_REQUEST['age'];
    $dnais = $_REQUEST['dnais'];
    $numpass = $_REQUEST['numpass'];
    $datepass = $_REQUEST['datepass'];


        $rqtsous3 = $bdd->prepare("INSERT INTO `souscripteurw`(`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`)
                                                      VALUES ('', '' ,'$nomi','','$prenomi','$numpass','$datepass','$datepass','$mail','$tel','$adri','$dnais','$age','$civ','2','0','$codsous','$id_user','','','','')");
        $rqtsous3->execute();







}


?>