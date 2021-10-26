<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}

$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");



if (  isset($_REQUEST['civ1']) && isset($_REQUEST['nom1']) && isset($_REQUEST['prenom1']) && isset($_REQUEST['adr1'])
    && isset($_REQUEST['age1'])  && isset($_REQUEST['dnais1']) &&  isset($_REQUEST['mail1']) && isset($_REQUEST['numpass1'])
    && isset($_REQUEST['datepass1'])&& isset($_REQUEST['reponse'])) {

    $reponse=$_REQUEST['reponse'];;

    $civ1 = $_REQUEST['civ1'];
    $nom1 = $_REQUEST['nom1'];
    $nomi1 = addslashes($_REQUEST['nom1']);
    $prenom1 = $_REQUEST['prenom1'];
    $prenomi1 = addslashes($_REQUEST['prenom1']);
    $adr1 = $_REQUEST['adr1'];
    $adri1 = addslashes($_REQUEST['adr1']);
    $mail1 = $_REQUEST['mail1'];
    $tel1 = $_REQUEST['tel1'];
    $age1 = $_REQUEST['age1'];
    $dnais1 = $_REQUEST['dnais1'];
    $mail1 = $_REQUEST['mail1'];
    $numpass1 = $_REQUEST['numpass1'];
    $datepass1 = $_REQUEST['datepass1'];
    $raison1 = null ;
    if($reponse==1) {
        $nbassur = 1;
    }else
    {
        $nbassur=2;
    }

    $rqtsous3 = $bdd->prepare("INSERT INTO `souscripteurw`(`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`) VALUES ('', '' ,'$nomi1','','$prenomi1','$numpass1','$datepass1',
                                                         '$datepass1','$mail1','$tel1','$adri1','$dnais1','$age1','$civ1','$reponse','$nbassur','','$id_user','','','','')");
    $rqtsous3->execute();

}
?>