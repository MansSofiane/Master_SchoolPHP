<?php
session_start();
require_once("../../../../../../data/conn7.php");

$datesys=date("y-m-d H:i:s");

if ( isset($_REQUEST['cod']) && isset($_REQUEST['option']) && isset($_REQUEST['duree']) && isset($_REQUEST['pay'])
    && isset($_REQUEST['dateffet']) && isset($_REQUEST['datech']) && isset($_REQUEST['nb_assur'])  ) {

    $codsous = $_REQUEST['cod'];
    $option = $_REQUEST['option'];
    $duree = $_REQUEST['duree'];
    $pay = $_REQUEST['pay'];
    $dateffet = $_REQUEST['dateffet'];
    $nb_assur = $_REQUEST['nb_assur'];
    $datech = $_REQUEST['datech'];

    if($nb_assur == 3 ){ $rabf=(3-2)/3;}
    if($nb_assur == 4){ $rabf=(4-2.5)/4;}
    if($nb_assur == 5){ $rabf=(5-3)/5;}
    if($nb_assur == 6){ $rabf=(6-3.5)/6;}
    if($nb_assur >= 7){ $rabf=($nb_assur-4)/$nb_assur;}


    $rqt = $bdd->prepare("select * from pays where cod_pays = '$pay' ");
    $rqt-> execute();
    while($row = $rqt->fetch())
    {
        $code_zone = $row['cod_zone'];
    }
    $reqper=$bdd->prepare("SELECT * FROM `periode` WHERE `max_jour`>= '$duree' AND `trt_per`>=1 LIMIT 1 ");
    $reqper->execute();
    $cod_per=0;
    while ($rowper=$reqper->fetch())
    {
        $cod_per=$rowper['cod_per'];
    }

$pnga_global=0;
    $pngb_global=0;
    $prime_nette=0;
    $prime_total=0;
    $primei=0;
    $age=0;
    $cod_tar=0;
    $cpt=0;
    $rqtaffich = $bdd->prepare("select * from souscripteurw where cod_par = '$codsous' ");
    $rqtaffich-> execute();
    while($row = $rqtaffich->fetch()) {

        $age = $row['age'];
        $primei = 0;
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
    if ($nb_assur == $cpt) {
        $pnga_global = ($pnga_global/$nb_assur) * 2.5;
        $prime_nette = $pnga_global + $pngb_global;
        $prime_total = $prime_nette + 500+40;

        $rqtinsert = $bdd->prepare("INSERT INTO `devisw`(                                       `cod_dev`, `dat_dev`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`,
 `cod_formul`, `cod_dt`,`cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `bool`, `etat`, `cod_sous`, `taux_int`, `diff_pay`) VALUES ('','$datesys','$cod_tar','1','$duree','$option ','$code_zone','$pay','4',

        '2','3','$dateffet','$datech','0','0','0','$pnga_global','$pngb_global','0','$prime_nette','$prime_total','0','0','$codsous','','')");
        $rqtinsert->execute();
        echo "1";
    } else {
        echo "2";
    }

}
?>