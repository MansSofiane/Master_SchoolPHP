<?php
session_start();
require_once("../../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['code']) && isset($_REQUEST['mode']) && isset($_REQUEST['agence'])  ){
	$code = $_REQUEST['code'];
	$mode = $_REQUEST['mode'];
	$agence = $_REQUEST['agence'];
	$libmpay="--";
	$dateop=$_REQUEST['dateop'];
	$libmpay=$_REQUEST['libmpay'];
	$datesys=date("y-m-d");


//$rqtc=$bdd->prepare("UPDATE `devisw` SET `etat`= '3' WHERE `cod_dev`='$code'");
//$rqtc->execute();

//echo "code= ".$code."Mode= ".$mode."Date-op= ".$dateop."Lib-Mpay= ".$libmpay;
//On récupere les infos du devis"

$rqtd=$bdd->prepare("SELECT * from `devisw` WHERE `cod_dev`='$code'");
$rqtd->execute();
while ($row_res=$rqtd->fetch()){
$tar=$row_res['cod_tar'];
$prod=$row_res['cod_prod'];
$per=$row_res['cod_per'];
$opt=$row_res['cod_opt'];
$zone=$row_res['cod_zone'];
$formul=$row_res['cod_formul'];
$dt=$row_res['cod_dt'];
$cpl=$row_res['cod_cpl'];
$deff=$row_res['dat_eff'];
$dech=$row_res['dat_ech'];
$cap1=$row_res['cap1'];
$cap2=$row_res['cap2'];
$cap3=$row_res['cap3'];
$p1=$row_res['p1'];
$p2=$row_res['p2'];
$p3=$row_res['p3'];
$pn=$row_res['pn'];
$pt=$row_res['pt'];
$codesous=$row_res['cod_sous'];
$taux_int=$row_res['taux_int'];
$diff_pay=$row_res['diff_pay'];
$cod_pay= $row_res['cod_pays'];
$sel="";

//On récupere la sequence du produit
$rqts=$bdd->prepare("SELECT sequence FROM `produit` WHERE `cod_prod`='$prod'");
$rqts->execute();
while ($row_ress=$rqts->fetch()){
$seq=$row_ress['sequence'];
}
$seq++;


//on insere dans la table policew
$rqtip=$bdd->prepare("INSERT INTO `policew` VALUES ('', '$datesys', '$tar', '$prod', '$per', '$opt', '$zone','$cod_pay','$formul', '$dt', '$cpl', '$deff', '$dech','$cap1', '$cap2',
 '$cap3', '$p1', '$p2', '$p3', '$pn', '$pt', '$deff','$dech', '$mode','$dateop','$libmpay','$seq', '0', '$codesous','$taux_int','$diff_pay','$agence','$sel')");
$rqtip->execute();
//on supprime de devis
$rqtc=$bdd->prepare("UPDATE `devisw` SET `etat`= '3' WHERE `cod_dev`='$code'");
$rqtc->execute();
//On incremente la sequence
$rqtc=$bdd->prepare("UPDATE `produit` SET `sequence`= '$seq' WHERE `cod_prod`='$prod'");
$rqtc->execute();

}

}
?>