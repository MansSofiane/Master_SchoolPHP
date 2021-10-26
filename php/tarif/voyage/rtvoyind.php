<?php 
session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['age']) && isset($_REQUEST['dure']) && isset($_REQUEST['opt']) && isset($_REQUEST['tsous']) && isset($_REQUEST['zone'])){

    $age= $_REQUEST['age'];
    $dure = $_REQUEST['dure'];
	$opt = $_REQUEST['opt'];
	$tsous = $_REQUEST['tsous'];
	$zone = $_REQUEST['zone'];
	
$rqt=$bdd->prepare("SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='$opt'  and agemin <= '$age' and agemax >='$age' and cod_per='$dure' and b.cod_pays='$zone'  and b.cod_zone=a.cod_zone and cod_cpl='$tsous'");
$rqt->execute();

$i=0;$pe=0;$pa=0;$maj_pa=0;$rab_pa=0;$maj_pe=0;$rab_pe=0;$dt=0;$cpl=0;$pt=0;
while ($row_res=$rqt->fetch()){
$i++;
$pe=$row_res['pe'];$pa=$row_res['pa'];
$maj_pa=$row_res['maj_pa'];
$maj_pe=$row_res['maj_pe'];
$rab_pa=$row_res['rab_pa'];
$rab_pe=$row_res['rab_pe'];
    $dt = 40;
    if ($tsous == 2) {
        $cpl = 250;
    } else {
        $cpl = 500;
    }
//$dt=$row_res['mtt_dt'];
//$cpl=$row_res['mtt_cpl'];
$pt=$pe+(($pe*$maj_pe)/100)-(($pe*$rab_pe)/100)+ $pa+(($pa*$maj_pa)/100)-(($pa*$rab_pa)/100) + $dt + $cpl ;

}
if($i > 0){
    echo " l'age de l'assure est:  ".$age;
    echo " \n";echo " \n";echo " \n";echo " \n";
    echo "Prime a payer:     ".number_format($pt, 2, ',', ' ')." DA";
}else{
echo "Cas de Non-Assurance ! Verifiez les parametres introduits !";
}

}