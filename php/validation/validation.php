<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['code']) && isset($_REQUEST['mode'])){
	$code = $_REQUEST['code'];
	$mode = $_REQUEST['mode'];
	$libmpay="--";$dateop="2099-12-31";
	$datesys=date("y-m-d H:i:s");
	if($_REQUEST['dateop']!= NULL ){$dateop=$_REQUEST['dateop'];}
	if($_REQUEST['libmpay']!= NULL ){$libmpay=$_REQUEST['libmpay'];}
//$rqtc=$bdd->prepare("UPDATE `devisw` SET `etat`= '3' WHERE `cod_dev`='$code'");
//$rqtc->execute();

//echo "code= ".$code."Mode= ".$mode."Date-op= ".$dateop."Lib-Mpay= ".$libmpay;
//On r�cupere les infos du devis

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
//On r�cupere la sequence du produit
$rqts=$bdd->prepare("SELECT sequence FROM `produit` WHERE `cod_prod`='$prod'");
$rqts->execute();
while ($row_ress=$rqts->fetch()){
$seq=$row_ress['sequence'];
}
$seq++;
//on insere dans la table policew
$rqtip=$bdd->prepare("INSERT INTO `policew` VALUES ('', '$datesys', '$tar', '$prod', '$per', '$opt', '$zone','DZ', '$formul', '$dt', '$cpl', '$deff', '$dech','$cap1', '$cap2', '$cap3', '$p1', '$p2', '$p3', '$pn', '$pt', '$deff','$dech', '$mode','$dateop','$libmpay','$seq', '0', '$codesous','0','0','0','0')");

$rqtip->execute();
//on supprime de devis
$rqtc=$bdd->prepare("UPDATE `devisw` SET `etat`= '3' WHERE `cod_dev`='$code'");
$rqtc->execute();
//On incremente la sequence
$rqtc=$bdd->prepare("UPDATE `produit` SET `sequence`= '$seq' WHERE `cod_prod`='$prod'");
$rqtc->execute();
$rqtip = $bdd->prepare("INSERT INTO `quittance`( `cod_quit`, `mois`, `date_quit`, `agence`, `cod_ref`,cod_sous, `mtt_quit`, `solde_pol`, `cod_dt`, `cod_cpl`, `id_user`,`type_quit`) VALUES ('$seq_quit','$mois','$datesys','$agence_seq','$max_pol',$codesous,'$pt','$pt','$dt','$cpl','$id_user','0')");
$rqtip->execute();

}

}
?>