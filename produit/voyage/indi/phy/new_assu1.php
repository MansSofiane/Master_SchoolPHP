<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}

$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");



if (  isset($_REQUEST['codsous']) && isset($_REQUEST['civ']) && isset($_REQUEST['nom']) && isset($_REQUEST['prenom']) && isset($_REQUEST['adr'])
    && isset($_REQUEST['age'])  && isset($_REQUEST['dnais']) &&  isset($_REQUEST['mail']) && isset($_REQUEST['numpass'])
    && isset($_REQUEST['datepass'])) {

    $cod = $_REQUEST['codsous'];
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
    $mail = $_REQUEST['mail'];
    $numpass = $_REQUEST['numpass'];
    $datepass = $_REQUEST['datepass'];
    $raison = null ;

    $rqtsous = $bdd->prepare("INSERT INTO  `souscripteurw` VALUES ('', 'null' ,'$nomi','null','$prenomi','$numpass','$datepass',
                                                         '$datepass','$mail','$tel','$adri','$dnais','$age','$civ','1','2','$cod','$id_user','NULL','','','','0')");

    $rqtsous->execute();

}
?>