<?php
session_start();
require_once("../../../../../data/conn7.php");
//on recupere le code du pays
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");

if ( isset($_REQUEST['code']))
{
    $code = $_REQUEST['code'];
    $nom = addslashes($_REQUEST['nom']);
    $pnom = addslashes($_REQUEST['pnom']);
    $adr = addslashes($_REQUEST['adr']);
    $mail = $_REQUEST['mail'];
    $tel = $_REQUEST['tel'];
    $pass = $_REQUEST['pass'];
    $dpas = $_REQUEST['dpas'];
    $cod_sous = $_REQUEST['cod_sous'];



    try
    {
            $rqtupd=$bdd->prepare("UPDATE `modif` SET `nom_assu`='$nom',`pnom_assu`='$pnom',`passport`='$pass',`datedpass`=' $dpas',`datefpass`='$dpas',`mail_assu`=' $mail',`tel_assu`=' $tel',`adr_assu`='$adr',`modif_sous`='1' WHERE `cod_assu`='$cod_sous' ");
            $rqtupd->execute();


    } catch (Exception $ex) {
        echo 'Erreur : ' . $ex->getMessage() . '<br />';
        echo 'N° : ' . $ex->getCode();
    }

}