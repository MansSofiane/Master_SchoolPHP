<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['segment']) && isset($_REQUEST['formule'])  && isset($_REQUEST['nba']) && isset($_REQUEST['ag1']) && isset($_REQUEST['zone']) && isset($_REQUEST['periode']) && isset($_REQUEST['ag2']) && isset($_REQUEST['ag3']) && isset($_REQUEST['ag4']) && isset($_REQUEST['ag5']) && isset($_REQUEST['ag6']) && isset($_REQUEST['ag7']) && isset($_REQUEST['ag8']) && isset($_REQUEST['ag9']) && isset($_REQUEST['user']) ){
	$segment = $_REQUEST['segment'];
    $formule = $_REQUEST['formule'];
	$nba = $_REQUEST['nba'];
	$ag1 = $_REQUEST['ag1'];
    $zone = $_REQUEST['zone'];
	$periode = $_REQUEST['periode'];
	$ag2 = $_REQUEST['ag2'];
    $ag3 = $_REQUEST['ag3'];
	$ag4 = $_REQUEST['ag4'];
	$ag5 = $_REQUEST['ag5'];
    $ag6 = $_REQUEST['ag6'];
	$ag7 = $_REQUEST['ag7'];
	$ag8 = $_REQUEST['ag8'];
    $ag9 = $_REQUEST['ag9'];	
	$user = $_REQUEST['user'];
	$datesys=date("y-m-d");
	$tarif="0";


//Formule Individuelle
if($formule==1){
//Tarif individuel

$rqtti=$bdd->prepare("SELECT t.cod_tar,t.pe,t.pa,t.maj_pa,t.maj_pe,t.rab_pa,t.rab_pe,d.mtt_dt, c.mtt_cpl FROM `tarif` as t, `segment` as s, `zone` as z, `formule` as f, `option` as o, `periode` as p,`dtimbre` as d,`cpolice` as c, `utilisateurs` as u 
WHERE t.cod_seg=s.cod_seg 
AND t.cod_zone=z.cod_zone
AND t.cod_formul=f.cod_formul
AND t.cod_opt=o.cod_opt
AND t.cod_per=p.cod_per
AND t.cod_dt=d.cod_dt
AND t.cod_cpl=c.cod_cpl
AND t.`cod_prod`='1'
AND t.`id_user`=u.`id_user`
AND o.dat_eff_opt<='$datesys'
AND o.dat_ech_opt>='$datesys'
AND t.`cod_seg`='$segment'
AND t.`cod_formul`='$formule'
AND t.`cod_zone`='$zone'
AND t.`cod_per`='$periode'
AND t.`agemin`<='$ag1'
AND t.`agemax`>='$ag1'
AND t.`id_user`='$user'");
$rqtti->execute();
while ($row_res=$rqtti->fetch()){
$pe=$row_res['pe'];
$pa=$row_res['pa'];
$maj_pe=$row_res['maj_pe'];$maj_pa=$row_res['maj_pa'];
$rab_pe=$row_res['rab_pe'];$rab_pa=$row_res['rab_pa'];
$mtt_dt=$row_res['mtt_dt'];
$mtt_cpl=$row_res['mtt_cpl'];
$tarif=$pe+(($maj_pe*$pe)/100)-(($rab_pe*$pe)/100)+$pa+(($maj_pa*$pa)/100)-(($rab_pa*$pa)/100)+$mtt_dt+$mtt_cpl;
}
if($tarif>0){
$tarif=number_format($tarif, 2, ',', ' ');
echo "le Tarif individuel est de : ".$tarif." DZD";
}else{echo "Cas non integre !";}

}


//Formule Couple
if($formule==2){echo "Couple";}

//Formule Famille
if($formule==3){echo "Famille";}


//Formule Groupe
if($formule==4){echo "Groupe";}
}

?>