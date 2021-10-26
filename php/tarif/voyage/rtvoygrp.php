<?php session_start();
error_reporting(0);
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}

$errone = false;


if (isset($_REQUEST['row']) && isset($_REQUEST['row1']) && isset($_REQUEST['row2']) && isset($_REQUEST['row3']) && isset($_REQUEST['row4'])&& isset($_REQUEST['tsous']))
{
    $jour = $_REQUEST['row'];
    $nbr = $_REQUEST['row1'];
    $opt = $_REQUEST['row2'];
    $zone = $_REQUEST['row3'];
    $age = $_REQUEST['row4'];
    $tsous=$_REQUEST['tsous'];


    if($opt<30){
        if($nbr>=10 && $nbr <=25){ $rabg=0.95;}
        if($nbr>=26 && $nbr <=100){ $rabg=0.9;}
        if($nbr>=101 && $nbr <=200){ $rabg=0.85;}
        if($nbr>200){ $rabg=0.75;}
    }else
    {
        $rabg=1;
    }


    $rqt =$bdd->prepare( "SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='".$opt."' and agemin <= '".$age."' and agemax >='".$age."' and cod_per ='".$jour."'  and b.cod_pays='".$zone."'  and b.cod_zone=a.cod_zone AND `cod_cpl`='".$tsous."'");
    $rqt->execute();


     $i=0;
        while ($row_opt=$rqt->fetch())
        {

            $nb++;
            $pe1 = $row_opt['pe'];
            $pa1 = $row_opt['pa'];
            $maj_pa1 = $row_opt['maj_pa'];
            $maj_pe1 = $row_opt['maj_pe'];
            $rab_pa1 = $row_opt['rab_pa'];
            $rab_pe1 = $row_opt['rab_pe'];
            $i++;

        }
    if ($i!=0)
    {

        $paf1 = $pa1 + (($pa1 * $maj_pa1) / 100) - (($pa1 * $rab_pa1) / 100);
        $pef1 = $pe1 + (($pe1 * $maj_pe1) / 100) - (($pe1 * $rab_pe1) / 100);

        $pn=($paf1*$rabg +$pef1)*$nbr;
        if($tsous==2) {
            $pt = $pn + 40 + 250;//+ TIMBRE + COUT DE LA POLCIE
        }else
        {
            $pt = $pn + 40 + 500;//+ TIMBRE + COUT DE LA POLCIE
        }
        $ptf=number_format($pt, 2, ',', ' ');
// les variable à envoyé a JS
        echo "La prime  nette est de: ".number_format($pn, 2, ',', ' ');;
        echo "\n";
        echo "\n";
        echo " la prime a payer est de :".$ptf;
    }
    else
    {
        echo "Cas non supporte!verifiez les parametres introduits ";

    }






}

?>