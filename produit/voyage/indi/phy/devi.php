<?php
session_start();
require_once("../../../../../../data/conn7.php");

$datesys=date("y-m-d H:i:s");


// xhr.open("GET", "produit/voyage/indi/phy/devi.php?cod=" + codsous + "&option=" + option + "&duree=" + nb_jour + "&pay=" + pay + "&dateffet=" + date + "&datech=" + date2);

if ( isset($_REQUEST['cod']) && isset($_REQUEST['option']) && isset($_REQUEST['duree']) && isset($_REQUEST['pay'])
    && isset($_REQUEST['dateffet']) && isset($_REQUEST['datech']) ) {

    $codsous = $_REQUEST['cod'];
    $option = $_REQUEST['option'];
    $duree = $_REQUEST['duree'];//NBJOUR
    $pay = $_REQUEST['pay'];
    $dateffet = $_REQUEST['dateffet'];
    $datech = $_REQUEST['datech'];

    // RECUPERER CODE PERIODE
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
    $rqt = $bdd->prepare("select * from pays where cod_pays = '$pay' ");
    $rqt-> execute();
    while($row = $rqt->fetch()){
        $code_zone = $row['cod_zone'];
    }
    $rqtaffich = $bdd->prepare("select * from souscripteurw where cod_sous = '$codsous' ");
    $rqtaffich-> execute();
    while($row = $rqtaffich->fetch())
    {
        $age = $row['age'];
    }

    $rqtassur = $bdd->prepare("select * from souscripteurw where cod_par = '$codsous' ");
    $rqtassur-> execute();
    while($rowas = $rqtassur->fetch())
    {
        $age = $rowas['age'];
    }


    $rqtselect = $bdd->prepare("SELECT a.* FROM `tarif` as a , pays as b WHERE a.cod_prod='1' and a.cod_formul='1' and a.cod_opt= '$option'
       and a.agemin <= '$age' and a.agemax >= '$age' and a.cod_per= '$cod_per'  and b.cod_pays= '$pay'
       and b.cod_zone = a.cod_zone and a.cod_cpl ='2' ");

    $rqtselect -> execute();
     $i=0;
    while ($row1=$rqtselect->fetch()) {
        $cod_tar = $row1['cod_tar'];
        $i++;
        $pa=$row1['pa']+(($row1['maj_pa'] * $row1['pa']) / 100) - (($row1['rab_pa'] * $row1['pa']) / 100);
        $pb= $row1['pe'] + (($row1['maj_pe'] * $row1['pe']) / 100) - (($row1['rab_pe'] * $row1['pe']) / 100);

        $pt=$pa+$pb+40+250;
        $pn=$pa+$pb;

        $rqtinsert = $bdd->prepare("INSERT INTO `devisw`(`cod_dev`, `dat_dev`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`,`cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `bool`, `etat`, `cod_sous`, `taux_int`, `diff_pay`) VALUES ('','$datesys','$cod_tar','1','$cod_per','$option ','$code_zone','$pay','2',
        '2','2','$dateffet','$datech','0','0','0','$pa','$pb','0','$pn','$pt','0','0','$codsous','','')");
        $rqtinsert->execute();
		//echo "Tarif trouve et introduit!!!";

    }
    if($i>0)
    {
        echo "1";
    }
    else
    {
        echo "2";
    }
}

?>