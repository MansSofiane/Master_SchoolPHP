<?php session_start();
error_reporting(0);
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}

$errone = false;


if (isset($_REQUEST['row']) && isset($_REQUEST['row1']) && isset($_REQUEST['row2']) && isset($_REQUEST['row3']) && isset($_REQUEST['row4'])&& isset($_REQUEST['tsous'])) {
    $jour = $_REQUEST['row'];
    $nbpf = $_REQUEST['row1'];
    $opt = $_REQUEST['row2'];
    $zone = $_REQUEST['row3'];
    $age = $_REQUEST['row4'];
    $tsous = $_REQUEST['tsous'];

    $tauxfam = 0;
    if ($nbpf == 3) {
        $tauxfam = 2;
    }
    if ($nbpf == 4) {
        $tauxfam = 2.5;
    }
    if ($nbpf == 5) {
        $tauxfam = 3;
    }
    if ($nbpf == 6) {
        $tauxfam = 3.5;
    }
    if ($nbpf >= 7) {
        $tauxfam = 4;
    }

    $rqt = "SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='" . $opt . "' and agemin <= '" . $age . "' and agemax >='" . $age . "' and cod_per ='" . $jour . "'  and b.cod_pays='" . $zone . "'  and b.cod_zone=a.cod_zone AND `cod_cpl`='" . $tsous . "'";
    //SELECT a.* FROM `tarif` as a , pays as b WHERE cod_prod='1' and cod_formul='1' and cod_opt='12' and agemin <= '24' and agemax >='24' and cod_per='20'  and b.cod_pays='ESP'  and b.cod_zone=a.cod_zone AND `cod_cpl`='2';
    $rqt_nb = $bdd->prepare($rqt);
    $rqt_nb->execute();
    // $nb = mysql_num_rows($rqt_nb);
    $pe1 = 0;
    $pa1 = 0;
    $maj_pa1 = 0;
    $maj_pe1 = 0;
    $rab_pa1 = 0;
    $rab_pe1 = 0;
    $nb = 0;
    $pef1 = 0;
    $paf1 = 0;
    $pn = 0;
    $pt = 0;
    $pag = 0;
    $peg = 0;

    while ($row_opt = $rqt_nb->fetch()) {
        $nb++;
        $pe1 = $row_opt['pe'];
        $pa1 = $row_opt['pa'];
        $maj_pa1 = $row_opt['maj_pa'];
        $maj_pe1 = $row_opt['maj_pe'];
        $rab_pa1 = $row_opt['rab_pa'];
        $rab_pe1 = $row_opt['rab_pe'];


    }

    if ($nb != 0) {

        $paf1 = $pa1 + (($pa1 * $maj_pa1) / 100) - (($pa1 * $rab_pa1) / 100);
        $pef1 = $pe1 + (($pe1 * $maj_pe1) / 100) - (($pe1 * $rab_pe1) / 100);
        $pag = $paf1 * 2.5;
        $peg = $pef1 * $nbpf;
        $pn = $pag + $peg;
        if ($tsous == 2) {
            $pt = $pn + 40 + 250;
        } else {
            $pt = $pn + 40 + 500;
        }


        $ptf = number_format($pt, 2, ',', ' ');
// les variable à envoyé a JS
        echo "La prime est de: ";
        echo $ptf;
    } else {
        echo "Cas non supporte!verifiez les parametres introduits ";

    }


}

?>