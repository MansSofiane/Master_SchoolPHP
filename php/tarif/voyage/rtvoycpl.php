<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['age1']) && isset($_REQUEST['age2']) && isset($_REQUEST['dure']) && isset($_REQUEST['opt']) && isset($_REQUEST['tsous']) && isset($_REQUEST['pays']))
{

    $age1= $_REQUEST['age1'];
	$age2= $_REQUEST['age2'];
    $dure = $_REQUEST['dure'];
	$opt = $_REQUEST['opt'];
	$tsous = $_REQUEST['tsous'];
	$pays = $_REQUEST['pays'];

    $rqt1=$bdd->prepare("SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='$opt'  and agemin <= '$age1' and agemax >='$age1' and cod_per='$dure' and b.cod_pays='$pays'  and b.cod_zone=a.cod_zone and cod_cpl='$tsous'");
$rqt1->execute();

$i=0;$pe1=0;$pa1=0;$maj_pa1=0;$rab_pa1=0;$maj_pe1=0;$rab_pe1=0;$dt=0;$cpl=0;$pt1=0;$pt=0; $paf1=0;$pef1=0;

    $trouve1=0;$trouve2=0;
while ($row_res1=$rqt1->fetch())
{
    $i++;
    $pe1 = $row_res1['pe'];
    $pa1 = $row_res1['pa'];
    $maj_pa1 = $row_res1['maj_pa'];
    $maj_pe1 = $row_res1['maj_pe'];
    $rab_pa1 = $row_res1['rab_pa'];
    $rab_pe1 = $row_res1['rab_pe'];
    $dt = 40;
    if ($tsous == 2) {
        $cpl = 250;
    } else {
        $cpl = 500;
    }
    $paf1 = $pa1 + (($pa1 * $maj_pa1) / 100) - (($pa1 * $rab_pa1) / 100);
    $pef1 = $pe1 + (($pe1 * $maj_pe1) / 100) - (($pe1 * $rab_pe1) / 100);
    $trouve1=1;
//$pt1=$pe1+ $pa1+(($pa1*$maj_pa1)/100)-(($pa1*$rab_pa1)/100);
    // $pt1=$pe1+(($pe1*$maj_pe1)/100)-(($pe1*$rab_pe1)/100)+ $pa1+(($pa1*$maj_pa1)/100)-(($pa1*$rab_pa1)/100);
}
$rqt2=$bdd->prepare("SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='$opt'  and agemin <= '$age2' and agemax >='$age2' and cod_per='$dure' and b.cod_pays='$pays'  and b.cod_zone=a.cod_zone and cod_cpl='$tsous'");
$rqt2->execute();

$J=0;$pe2=0;$pa2=0;$maj_pa2=0;$rab_pa2=0;$maj_pe2=0;$rab_pe2=0;$pt2=0;$paf2=0;$pef2=0;
while ($row_res=$rqt2->fetch())
{
$J++;
$pe2=$row_res['pe'];$pa2=$row_res['pa'];
$maj_pa2=$row_res['maj_pa'];
$maj_pe2=$row_res['maj_pe'];
$rab_pa2=$row_res['rab_pa'];
$rab_pe2=$row_res['rab_pe'];
    $paf2=$pa2+(($pa2*$maj_pa2)/100)-(($pa2*$rab_pa2)/100);
    $pef2=$pe2+(($pe2*$maj_pe2)/100)-(($pe2*$rab_pe2)/100);
    $trouve2=1;
//$pt2=$pe2+ $pa2+(($pa2*$maj_pa2)/100)-(($pa2*$rab_pa2)/100);
   // $pt2=$pe2+(($pe2*$maj_pe2)/100)-(($pe2*$rab_pe2)/100)+ $pa2+(($pa2*$maj_pa2)/100)-(($pa2*$rab_pa2)/100);
}
    if($trouve1==1 && $trouve2==1) {
        $pt = $pef1 + $pef2 + (($paf1 + $paf2)/2) * 1.75 + $dt + $cpl;


        echo " L'age de l'assure1:           " . $age1;
        echo "\n";
        echo "\n";
        echo "\n";
        echo " L'age de l'assure2:           " . $age2;
        echo "\n";
        echo "\n";
        echo "\n";

        echo "Prime a payer :                " . number_format($pt, 2, ',', ' ') . " DA";

    }
    else
    {
        echo "Cas non assure!";
    }





}






 ?>