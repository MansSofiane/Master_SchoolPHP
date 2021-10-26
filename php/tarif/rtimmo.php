<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['age']) && isset($_REQUEST['dure']) && isset($_REQUEST['capital']) ){

    $age= $_REQUEST['age'];
    $dure = $_REQUEST['dure'];
	$capital = $_REQUEST['capital'];
$rqtu=$bdd->prepare("SELECT t.`pe`, d.`mtt_dt`, c.`mtt_cpl`  FROM `tarif` as t, `dtimbre` as d, `cpolice` as c WHERE t.`cod_prod`='7' AND t.`cod_seg`='5' AND t.`cod_cls`='1' AND t.`cod_zone`='1' AND t.`cod_formul`='1' AND t.`cod_opt`='3' AND t.`cod_per`='$dure' AND t.`agemin`<='$age' AND t.`cod_dt`=d.`cod_dt` AND t.`cod_cpl`=c.`cod_cpl` AND t.`agemax`>='$age'");
$rqtu->execute();
$i=0;$j=0;$tpm=0;$tpu=0;$dt=0;$cp=0;
while ($row_pu=$rqtu->fetch()){
$tpu=$row_pu['pe'];
$dt=$row_pu['mtt_dt'];
$cp=$row_pu['mtt_cpl'];
$i++;
}
$primeu=($capital*$tpu);
$primeu=$primeu+$dt+$cp;
$tpu1=$tpu;
$tpuf=$tpu1*(1+$tpu1);
$primeuf=($capital*$tpuf);
$primeuf=$primeuf+$dt+$cp;

if($i>0){
echo "La prime-Unique est de: ". number_format($primeu, 2, ',', ' ')." DA    ";
echo "\n";
//echo "La prime-Unique-Financee est de: ". number_format($primeuf, 2, ',', ' ')." DA";
}else{
echo "Cas non suporte !";

}

}
 ?>