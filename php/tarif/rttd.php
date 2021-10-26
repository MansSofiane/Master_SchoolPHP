<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['age']) && isset($_REQUEST['cap']) && isset($_REQUEST['classe'])){
    $age= $_REQUEST['age'];
    $cap = $_REQUEST['cap'];
	$classe = $_REQUEST['classe'];
	
// Tarif de la Garantie DC
	
$rqt=$bdd->prepare("SELECT t.`pe`,t.`pa`,d.`mtt_dt`,c.`mtt_cpl` FROM `tarif` as t, dtimbre as d, cpolice as c WHERE t.`cod_prod`='6' AND t.`cod_seg`='1' AND t.`cod_cls`='$classe' AND t.`cod_zone`='1' AND t.`cod_formul`='1'  AND t.`cod_per`='20'  AND t.`cod_dt`=d.`cod_dt` AND t.`cod_cpl`=c.`cod_cpl` AND t.cod_opt='16' AND t.`agemin`<='$age' AND t.`agemax`>='$age'");
$rqt->execute();


$i=0;$pe=0;$pa=0;$dt=0;$cp=0;$pt=0;
while ($row_res=$rqt->fetch()){
$i++;
$pe=$row_res['pe'];
$dt=$row_res['mtt_dt'];$cp=$row_res['mtt_cpl'];
}
$pt=($cap*$pe)+$dt+$cp;

if($i>0){
echo "La prime est de: ". number_format($pt, 2, ',', ' ')." DA";

}else{
echo "Cas non suporte !";

}

}
 ?>