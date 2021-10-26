<?php
session_start();
require_once("../../../../../../data/conn7.php");

$datesys=date("y-m-d H:i:s");


if ( isset($_REQUEST['cod']) && isset($_REQUEST['option']) && isset($_REQUEST['duree']) && isset($_REQUEST['pay'])
    && isset($_REQUEST['iddoc']) && isset($_REQUEST['dateffet'])&& isset($_REQUEST['datech'])) {

    $codsous = $_REQUEST['cod'];
    $option = $_REQUEST['option'];
    $duree = $_REQUEST['duree'];
    $pay = $_REQUEST['pay'];
    $dateffet = $_REQUEST['dateffet'];
    $nb_assur = 0;
    $id_doc=$_REQUEST['iddoc'];
    $datech = $_REQUEST['datech'];
}

$rqtnb=$bdd->prepare("select count(*) as nb from souscripteurw where cod_par='$codsous'");
$rqtnb->execute();
while ($rownb=$rqtnb->fetch())
{
    $nb_assur= $rownb['nb'];

}


if($option<30){
    if($nb_assur >= 10 && $nb_assur <= 25){ $rabg=0.95;}
    if($nb_assur >= 26 && $nb_assur <= 100){ $rabg=0.90;}
    if($nb_assur >= 101 && $nb_assur <= 200){ $rabg=0.85;}
    if($nb_assur >= 201){ $rabg=0.75;}
}else{
    $rabg=1;
}


$rqt = $bdd->prepare("select * from pays where cod_pays = '$pay' ");
$rqt-> execute();
while($row = $rqt->fetch())
{
    $code_zone = $row['cod_zone'];
}
if ($option=='30')
{
    $cod_per='18';
}
elseif ($option=='31')
{
    $cod_per='5';
}else {
    $reqper = $bdd->prepare("SELECT * FROM `periode` WHERE `max_jour`>= '$duree' AND `trt_per`>=1 LIMIT 1 ");
    $reqper->execute();
    $cod_per = 0;
    while ($rowper = $reqper->fetch()) {
        $cod_per = $rowper['cod_per'];
    }
}
//////


$pnga_global=0;
$pngb_global=0;
$prime_nette=0;
$prime_total=0;
$primei=0;
$age=0;
$cod_tar=0;

$rqtaffich = $bdd->prepare("select * from souscripteurw where cod_par = '$codsous' ");
$rqtaffich-> execute();
$cpt=0;
while($row = $rqtaffich->fetch()) {
    $age = $row['age'];

    $primei = 0;
    // pour chaque assuré on calcule la prime qui lui conevient
    $rqtselect = $bdd->prepare("SELECT a.* FROM `tarif` as a , pays as b WHERE a.cod_prod='1' and a.cod_formul='1' and a.cod_opt= '$option'
       and a.agemin <= '$age' and a.agemax >= '$age' and a.cod_per= '$cod_per'  and b.cod_pays= '$pay'
       and b.cod_zone = a.cod_zone and a.cod_cpl ='3' ");
    $rqtselect->execute();

    while ($row1 = $rqtselect->fetch()) {
        $cod_tar = $row1['cod_tar'];
        $pngb_global = $pngb_global + ( $row1['pe'] + (($row1['maj_pe'] * $row1['pe']) / 100) - (($row1['rab_pe'] * $row1['pe']) / 100));
        $pt1 = $row1['pa'] + (($row1['maj_pa'] * $row1['pa']) / 100) - (($row1['rab_pa'] * $row1['pa']) / 100);
        $pnga_global = $pnga_global + $pt1;
        $cpt++;
    }
}

$pnga_global=$pnga_global*$rabg;

$prime_nette=$pnga_global+$pngb_global;
$prime_total=$prime_nette+40+500;
if($nb_assur==$cpt) {
    $rqtinsert = $bdd->prepare("INSERT INTO `devisw`(`cod_dev`, `dat_dev`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`,`cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `bool`, `etat`, `cod_sous`, `taux_int`, `diff_pay`)
                               VALUES ('','$datesys','$cod_tar','1','$cod_per','$option ','$code_zone','$pay','5','2','3','$dateffet','$datech','0','0','0','$pnga_global','$pngb_global','0','$prime_nette','$prime_total','0','0','$codsous','','');");
    $rqtinsert->execute();

    $reqtdoc = $bdd->prepare("DELETE FROM `document` WHERE `id_doc`='$id_doc'");
    $reqtdoc->execute();
    echo "1";
}else
{
    echo"2";
}



?>