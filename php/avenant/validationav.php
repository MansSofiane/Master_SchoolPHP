<?php
session_start();
require_once("../../../../data/conn7.php");

$id_user = $_SESSION['id_usersal'];
$datesys=date("y-m-d H:i:s");
//on recupere le code du pays
// xhr.open("GET", "php/avenant/validationav.php?code=" + codedev + "&date1=" + datedeb + "&date2=" + datfin + "&av=" + av+"&mode="+mode+"&datop="+dateop, false);

if ( isset($_REQUEST['code']) && isset($_REQUEST['av'])){
	$code = $_REQUEST['code'];
	$av = $_REQUEST['av'];
if($av<>50) {
	$modeav = $_REQUEST['mode'];
	$datopav = $_REQUEST['datop'];
}
 /* $date1="2099-12-31";$date2="2099-12-31";
	$datesys=date("y-m-d H:i:s");

	if($_REQUEST['date1']!= NULL ){$date1=$_REQUEST['date1'];}
	if($_REQUEST['date2']!= NULL ){$date2=$_REQUEST['date2'];}*/


//echo "code= ".$code."AVenant= ".$av."Date1= ".$date1."Date2= ".$date2;
//On récupere les infos de la police

$rqtd=$bdd->prepare("SELECT * from `policew` WHERE `cod_pol`='$code'");
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
//On récupere la sequence du produit
$rqts=$bdd->prepare("SELECT sequence2 FROM `produit` WHERE `cod_prod`='$prod'");
$rqts->execute();
while ($row_ress=$rqts->fetch()){
$seq=$row_ress['sequence2'];
}
$seq++;
if($av==74){
//Avenant de modification de date
//on insere dans la table policew
$rqtiav=$bdd->prepare("INSERT INTO `avenantw`(`cod_av`, `dat_val`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`, `cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `ndat_eff`, `ndat_ech`, `mode`, `dat_op`, `lib_mpay`, `sequence`, `etat`, `cod_pol`, `cod_mot`)  VALUES ('', '$datesys', '$tar', '$prod', '$per', '$opt', '$zone','DZ', '$formul', '$dt', '6', '$deff', '$dech','$cap1', '$cap2', '$cap3', '0', '0', '0', '0', '140', '$deff','$dech', '1','','$av','$seq', '0', '$code','')");
$rqtiav->execute();
//on supprime de devis
$rqtc=$bdd->prepare("UPDATE `policew` SET `ndat_eff`= '$date1',`ndat_ech`= '$date2' WHERE `cod_pol`='$code'");
$rqtc->execute();
//On incremente la sequence
$rqtc=$bdd->prepare("UPDATE `produit` SET `sequence2`= '$seq' WHERE `cod_prod`='$prod'");
$rqtc->execute();
}
if($av==70){
//Avenant de PRECISION
//on insere dans la table policew
$rqtiav=$bdd->prepare("INSERT INTO `avenantw`(`cod_av`, `dat_val`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`, `cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `ndat_eff`, `ndat_ech`, `mode`, `dat_op`, `lib_mpay`, `sequence`, `etat`, `cod_pol`, `cod_mot`)  VALUES ('', '$datesys', '$tar', '$prod', '$per', '$opt', '$zone','DZ', '$formul', '$dt', '6', '$deff', '$dech','$cap1', '$cap2', '$cap3', '0', '0', '0', '0', '140', '$deff','$dech', '$modeav','$datopav','$av','$seq', '0', '$code','')");
$rqtiav->execute();
//On incremente la sequence
$rqtc=$bdd->prepare("UPDATE `produit` SET `sequence2`= '$seq' WHERE `cod_prod`='$prod'");
$rqtc->execute();
	//recupérer le max cod_av
	$rqtmav=$bdd->prepare("SELECT max(cod_av) as maxav FROM avenantw where cod_pol='$code' and lib_mpay='70' ");
	$rqtmav->execute();
	while ($rowav=$rqtmav->fetch())
	{
		$cod_av=$rowav['maxav'];
	}
//mise a jour assure
	$rqtassur=$bdd->prepare("UPDATE assure set cod_av='$cod_av' where cod_pol='$code' and id_user='$id_user' and cod_av='0'");
	$rqtassur->execute();
	//mise a jour au niveau de souscripteurw
	$rqtsous=$bdd->prepare ("SELECT * FROM assure where cod_pol='$code' and id_user='$id_user' and cod_av='$cod_av'");
	$rqtsous->execute();
	while($rowsous=$rqtsous->fetch())
	{
		$nom_assu=$rowsous['nom_assu'];
		$pnom_assu=$rowsous['pnom_assu'];
		$cod_assu=$rowsous['cod_sous'];
		$adr_assu=$rowsous['adr_assu'];
		$mail_assu=$rowsous['mail_assu'];
		$tel_assu=$rowsous['tel_assu'];
		$rqtma=$bdd->prepare("UPDATE `souscripteurw` SET `nom_sous`='$nom_assu',`pnom_sous`='$pnom_assu',`adr_sous`='$adr_assu',`tel_sous`='$tel_assu',`mail_sous`='$mail_assu' WHERE `cod_sous`='$cod_assu'");
		$rqtma->execute();

	}
}
if($av==73){
//Avenant de subrogation
//on insere dans la table avenant
		$rqtiav=$bdd->prepare("INSERT INTO `avenantw`(`cod_av`, `dat_val`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`, `cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `ndat_eff`, `ndat_ech`, `mode`, `dat_op`, `lib_mpay`, `sequence`, `etat`, `cod_pol`, `cod_mot`)  VALUES ('', '$datesys', '$tar', '$prod', '$per', '$opt', '$zone','DZ', '$formul', '$dt', '6', '$datesys', '$dech','$cap1', '$cap2', '$cap3', '$p1', '$p2', '$p3', '0', '140', '$datesys','$dech', '$modeav','$datopav','$av','$seq', '0', '$code','')");
		$rqtiav->execute();
//On incremente la sequence
		$rqtc=$bdd->prepare("UPDATE `produit` SET `sequence2`= '$seq' WHERE `cod_prod`='$prod'");
		$rqtc->execute();
	}
if($av==30){
//Avenant d'annulation Avec Ristourne
//on insere dans la table policew
$pnn=$pn*(-1);
$ptn=$pnn+140;
$rqtiav=$bdd->prepare("INSERT INTO `avenantw`(`cod_av`, `dat_val`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`, `cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `ndat_eff`, `ndat_ech`, `mode`, `dat_op`, `lib_mpay`, `sequence`, `etat`, `cod_pol`, `cod_mot`)  VALUES ('', '$datesys', '$tar', '$prod', '$per', '$opt', '$zone','DZ', '$formul', '$dt', '6', '$deff', '$dech','$cap1', '$cap2', '$cap3', '$p1', '$p2', '$p3', '$pnn', '$ptn', '$deff','$dech', '1','','$av','$seq', '0', '$code','')");
$rqtiav->execute();
//on supprime de devis
$rqtc=$bdd->prepare("UPDATE `policew` SET `etat`= '2' WHERE `cod_pol`='$code'");
$rqtc->execute();
//On incremente la sequence
$rqtc=$bdd->prepare("UPDATE `produit` SET `sequence2`= '$seq' WHERE `cod_prod`='$prod'");
$rqtc->execute();
}
if($av==50){
//Avenant d'annulation Avec Ristourne
	$cod_cplav=4;
	if ($cpl==3)
	{
		$cod_cplav=5;
	}
//on insere dans la table policew
$ptn=$pt*(-1);$pnn=$pn*(-1);
$rqtiav=$bdd->prepare("INSERT INTO `avenantw`(`cod_av`, `dat_val`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`, `cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `ndat_eff`, `ndat_ech`, `mode`, `dat_op`, `lib_mpay`, `sequence`, `etat`, `cod_pol`, `cod_mot`)  VALUES ('', '$datesys', '$tar', '$prod', '$per', '$opt', '$zone','DZ', '$formul', '4', '$cod_cplav', '$deff', '$dech','$cap1', '$cap2', '$cap3', '$p1', '$p2', '$p3', '$pnn', '$ptn', '$deff','$dech', '1','','$av','$seq', '0', '$code','')");
$rqtiav->execute();
//on supprime de devis
$rqtc=$bdd->prepare("UPDATE `policew` SET `etat`= '3' WHERE `cod_pol`='$code'");
$rqtc->execute();
//On incremente la sequence
$rqtc=$bdd->prepare("UPDATE `produit` SET `sequence2`= '$seq' WHERE `cod_prod`='$prod'");
$rqtc->execute();
}


}

}
?>