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

// xhr.open("GET", "produit/voyage/cpl/phy/new_assu.php?codsous=" + codsous + "&mail=" + mail2 + "&tel=" + tel2 + "&adr=" + adr2 + "&civ=" + civilite2 + "&nom=" + nom2 + "&prenom=" + prenom2 + "&age=" + age2 + "&dnais=" + date21 + "&numpass=" + numpass2 + "&datepass=" + date23 + "&repense=" + reponse);


if ( isset($_REQUEST['codsous']) && isset($_REQUEST['repense']))

{
    $codsous = $_REQUEST['codsous'];

    $civ1 = $_REQUEST['civ'];
    $nom1 = $_REQUEST['nom'];
    $nomi1 = addslashes($_REQUEST['nom']);
    $prenom1 = $_REQUEST['prenom'];
    $prenomi1 = addslashes($_REQUEST['prenom']);
    $age1 = $_REQUEST['age'];
    $dnais1 = $_REQUEST['dnais'];
    $numpass1 = $_REQUEST['numpass'];
    $datepass1 = $_REQUEST['datepass'];

    $mail1 = $_REQUEST['mail'];
    $tel1 = $_REQUEST['tel'];
    $adr1 = $_REQUEST['adr'];
    $adri1 = addslashes($_REQUEST['adr']);

    $reponse= $_REQUEST['repense'];

    $bdd->beginTransaction();
    if($reponse==1) //LE SOUSCRIPTEUR EST L'ASSURE
    {
        //selection le max cod_sous from souscripteurw
        $rqtsous4 = $bdd->prepare("INSERT INTO `souscripteurw`(`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`)
                                                        VALUES ('', '' ,'$nomi1','','$prenomi1','$numpass1','$datepass1','$datepass1','$mail1','$tel1','$adri1','$dnais1','$age1','$civ1','$reponse','0','$codsous','$id_user','','','','')");
        $rqtsous4->execute();
    }
    else
    {
        $rqtsous3 = $bdd->prepare("INSERT INTO `souscripteurw`(`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`)
                                                       VALUES ('', '' ,'$nomi1','','$prenomi1','$numpass1','$datepass1','$datepass1','$mail1','$tel1','$adri1','$dnais1','$age1','$civ1','$reponse','0','$codsous','$id_user','','','','')");
        $rqtsous3->execute();
    }
    $bdd->commit();

}


?>