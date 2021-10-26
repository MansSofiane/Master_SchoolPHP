<?php
session_start();
require_once("../../../../../../data/conn7.php");

$datesys=date("y-m-d H:i:s");


if ( isset($_REQUEST['cod']) && isset($_REQUEST['option']) && isset($_REQUEST['duree']) && isset($_REQUEST['pay'])
    && isset($_REQUEST['dateffet']) && isset($_REQUEST['datech']) ) {

    $codsous = $_REQUEST['cod'];
    $option = $_REQUEST['option'];
    $duree = $_REQUEST['duree'];//NBJOUR
    $pay = $_REQUEST['pay'];
    $dateffet = $_REQUEST['dateffet'];
    $datech = $_REQUEST['datech'];

    // RECUPERER CODE PERIODE
    $reqper=$bdd->prepare("SELECT * FROM `periode` WHERE `max_jour`>= '$duree' AND `trt_per`>=1 LIMIT 1 ");
    $reqper->execute();
    $cod_per=0;
    while ($rowper=$reqper->fetch())
    {
        $cod_per=$rowper['cod_per'];
    }

   // recuperer les souscripteurs 1 et 2.
    // si le nombre de lignes egale a un donc le souscripteur cest lui assure
    // si le nombre de lignes egale a deux donc le souscripteur nest pas l assure
    $reqtnb=$bdd->prepare("select * from souscripteurw where cod_par='$codsous'");
    $reqtnb->execute();
    $nbsous= $reqtnb->rowCount();




    // recuperation de l'age des assures. et le code de ouscripteur de chacun.
    $codsous1=0;
    $codsous2=0;
    $age1=0;
    $age2=0;
    if($nbsous==1)
    {
        $codsous1=$codsous;

        $reqt1=$bdd->prepare("select *from souscripteurw where cod_sous='$codsous'");
        $reqt1->execute();

        while ($row1=$reqt1->fetch())
        {
            $age1=$row1['age'];
        }

        $reqt2=$bdd->prepare("select *from souscripteurw where cod_par='$codsous' LIMIT 1");
        $reqt2->execute();

        while ($row2=$reqt2->fetch())
        {
            $codsous2=$row2['cod_sous'];
            $age2=$row2['age'];

        }
    }
    else
    {
        $reqt1=$bdd->prepare("select *from souscripteurw where cod_par='$codsous' LIMIT 1");
        $reqt1->execute();

        while ($row1=$reqt1->fetch())
        {
            $codsous1=$row1['cod_sous'];
            $age1=$row1['age'];

        }
       // SELECT * FROM `souscripteurw` WHERE `cod_par`='8250' LIMIT 1,1
        $reqt2=$bdd->prepare("select *from souscripteurw where cod_par='$codsous' LIMIT 1,1");
        $reqt2->execute();

        while ($row2=$reqt2->fetch())
        {
            $codsous2=$row2['cod_sous'];
            $age2=$row2['age'];

        }

    }

    // selection tarif 1 et tarif2
    // $rqt1 ="SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='".$opt."'  and agemin <= '".$age1."' and agemax >='".$age1."' and nbjmin <='".$jour."' and nbjmax >='".$pays."' and b.cod_pays='".$pays."'  and b.cod_zone=a.cod_zone and b.cod_opt2='2'";
$reqtar1=$bdd->prepare("SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='$option'  and agemin <= '$age1' and agemax >='$age1' and cod_per='$cod_per' and b.cod_pays='$pay'  and b.cod_zone=a.cod_zone and cod_cpl='3'");

    $reqtar1->execute();
   $trouve1=0;
    while($row_a1=$reqtar1->fetch())
    {
        $pa1 = $row_a1['pa'] + (($row_a1['maj_pa'] * $row_a1['pa']) / 100) - (($row_a1['rab_pa'] * $row_a1['pa']) / 100);
        $pg1 = $row_a1['pe'];
        $cod_zone=$row_a1['cod_zone'];
        $trouve1=1;
    }

    $reqtar2=$bdd->prepare("SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='$option'  and agemin <= '$age2' and agemax >='$age2' and cod_per='$cod_per' and b.cod_pays='$pay'  and b.cod_zone=a.cod_zone and cod_cpl='3'");

    $reqtar2->execute();
    $trouve2=0;
    while($row_a2=$reqtar2->fetch())
    {
        $pa2 =$row_a2['pa'] + (($row_a2['maj_pa']*$row_a2['pa'])/100)- (($row_a2['rab_pa']*$row_a2['pa'])/100);
        $pg2= $row_a2['pe'];
        $trouve2=1;
    }

    if($trouve1==1 && $trouve2==1)
    {
        $pg = $pg1 + $pg2;
        $pa = (($pa1 + $pa2)/2) * 1.75;

        $pt = $pg + $pa + 40 + 500;
        $pn = $pg + $pa;


        $reqinsrt = $bdd->prepare("INSERT INTO `devisw`  VALUES ('','$datesys','','1','$cod_per','$option','$cod_zone','$pay','3','2','3','$dateffet','$datech','','','','$pa', '$pg', '', '$pn', '$pt', '0', '0', '$codsous', '', '')");
        $reqinsrt->execute();
        echo "1";
    }
    else
    {
        echo "2";
    }




}

?>