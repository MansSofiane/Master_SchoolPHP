<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['age']) && isset($_REQUEST['opt'])){

    $age= $_REQUEST['age'];
    $opt = $_REQUEST['opt'];
$rqtu=$bdd->prepare("SELECT t.`pe`,d.`mtt_dt`,c.`mtt_cpl` FROM `tarif` as t,`dtimbre` as d,`cpolice` as c WHERE t.`cod_prod`='5' AND t.`cod_seg`='5' AND t.`cod_cls`='1' AND t.`cod_zone`='1' AND t.`cod_formul`='1' AND t.`cod_dt`=d.`cod_dt` AND t.`cod_cpl`=c.`cod_cpl` AND t.`cod_opt`='$opt' AND t.`cod_per`='20' AND t.`agemin`<='$age' AND t.`agemax`>='$age'");
$rqtu->execute();

$i=0;$tpu=0;
while ($row_pu=$rqtu->fetch()){
$capital=$row_pu['pe']+$row_pu['mtt_dt']+$row_pu['mtt_cpl'];
$i++;
}
if($i>0){
echo "La prime est de: ". number_format($capital, 2, ',', ' ')." DA";

}else{
echo "Cas non suporte !";

}

}