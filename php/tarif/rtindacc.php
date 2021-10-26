<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['age']) && isset($_REQUEST['dure']) && isset($_REQUEST['cap1']) && isset($_REQUEST['cap2']) && isset($_REQUEST['classe'])){

    $age= $_REQUEST['age'];
	$dure= $_REQUEST['dure'];
    $cap1 = $_REQUEST['cap1'];
	$cap2 = $_REQUEST['cap2'];
	$classe = $_REQUEST['classe'];
	$typsous=$_REQUEST['typsous'];
	$dt=0;$cp=0;
	if ($typsous==1){
		$typs=2;
	}else {
		$typs=3;
	}
// Tarif de la Garantie DC	
$rqt1=$bdd->prepare("SELECT t.`pe`,t.`pa`,d.`mtt_dt`,c.`mtt_cpl` FROM `tarif` as t, dtimbre as d, cpolice as c WHERE t.`cod_prod`='2' AND t.`cod_seg`='1' AND t.`cod_cls`='$classe' AND t.`cod_zone`='1' AND t.`cod_formul`='1'  AND t.`cod_per`='$dure'  AND t.`cod_dt`=d.`cod_dt` AND t.`cod_cpl`=c.`cod_cpl` AND t.`agemin`<='$age' AND t.`agemax`>='$age' AND t.`cod_cpl`='$typs'");
$rqt1->execute();
$i=0;$pe1=0;$pa1=0;$pt1=0;$pt=0;
while ($row_res=$rqt1->fetch()){
$i++;
$pe1=$row_res['pe'];$pa1=$row_res['pa'];
$dt=$row_res['mtt_dt'];$cp=$row_res['mtt_cpl'];
}
$pt1=($cap1*$pe1*$pa1)/100;
// Tarif de la Garantie IPP	
$rqt2=$bdd->prepare("SELECT t.`pe`,t.`pa`,d.`mtt_dt`,c.`mtt_cpl` FROM `tarif` as t, dtimbre as d, cpolice as c WHERE t.`cod_prod`='2' AND t.`cod_seg`='1' AND t.`cod_cls`='$classe' AND t.`cod_zone`='1' AND t.`cod_formul`='2'  AND t.`cod_per`='$dure'  AND t.`cod_dt`=d.`cod_dt` AND t.`cod_cpl`=c.`cod_cpl` AND t.`agemin`<='$age' AND t.`agemax`>='$age' AND t.`cod_cpl`='$typs'");
$rqt2->execute();
$pe2=0;$pa2=0;$pt2=0;
while ($row_res2=$rqt2->fetch()){
$i++;
$pe2=$row_res2['pe'];$pa2=$row_res2['pa'];
}
$pt2=($cap1*$pe2*$pa2)/100;
// Tarif de la Garantie FMP
$rqt3=$bdd->prepare("SELECT t.`pe`,t.`pa`,d.`mtt_dt`,c.`mtt_cpl` FROM `tarif` as t, dtimbre as d, cpolice as c WHERE t.`cod_prod`='2' AND t.`cod_seg`='1' AND t.`cod_cls`='$classe' AND t.`cod_zone`='1' AND t.`cod_formul`='3'  AND t.`cod_per`='$dure'  AND t.`cod_dt`=d.`cod_dt` AND t.`cod_cpl`=c.`cod_cpl` AND t.`agemin`<='$age' AND t.`agemax`>='$age' AND t.`cod_cpl`='$typs'");
$rqt3->execute();
$pe3=0;$pa3=0;$pt3=0;
while ($row_res3=$rqt3->fetch()){
$i++;
$pe3=$row_res3['pe'];$pa3=$row_res3['pa'];
}
$pt3=($cap2*$pe3*$pa3);
$pt=$pt1+$pt2+$pt3+$dt+$cp;


if($i>0){
echo "La prime est de: ". number_format($pt, 2, ',', ' ')." DA";

}else{
echo "Cas non suporte !";

}




}
?>