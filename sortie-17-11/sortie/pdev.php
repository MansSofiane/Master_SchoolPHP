<?php 
session_start();
if ($_SESSION['loginsal']){
//authentification acceptee !!!

}
else {
header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}
require_once("../../../data/conn7.php");
include("convert.php");
include("entete.php");

$a1 = new chiffreEnLettre();
$errone = false;


if (isset($_REQUEST['individuel'])) {
$row = $row = substr($_REQUEST['individuel'],10);
}

//Preparation du PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
//Les requetes *****************


//Requete Souscripteur
$query_sous = $bdd->prepare("SELECT s.*, d.*,p.lib_pays,p.cod_zone,o.cod_opt,o.lib_opt  FROM `souscripteurw` as s, `devisw` as d, `pays` as p, `option` as o WHERE s.cod_sous=d.cod_sous and d.cod_pays=p.cod_pays  and d.cod_opt=o.cod_opt and d.cod_dev='".$row."';");
$query_sous->execute();


$pdf->SetFont('Arial','B',50);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0, 0, 0);

while($row_sous=$query_sous->fetch()) {

    $pdf->Cell(190, 8, "Devis Gratuit", '0', '0', 'C');

    $pdf->Ln(20);

// Le Souscripteur
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(190, 5, 'Souscripteur ', '1', '1', 'C', '1');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 5, 'Nom et Prénom/ R.Sociale', '1', '0', 'L', '1');
    if ($row_sous['civ_sous'] == 0) {
        $pdf->Cell(150, 5, "" . $row_sous['nom_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
    } else {
        $pdf->Cell(150, 5, "" . $row_sous['nom_sous'] . " " . $row_sous['pnom_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
    }
    $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1');
    $pdf->Cell(150, 5, "" . $row_sous['adr_sous'] . "", '1', '0', 'C');
    $pdf->Ln();
    $pdf->Cell(40, 5, 'Téléphone', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . $row_sous['tel_sous'] . "", '1', '0', 'C');
    $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . $row_sous['mail_sous'] . "", '1', '0', 'C');
    $pdf->Ln(15);

// L'assuré
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(190, 5, 'Assuré ', '1', '1', 'C', '1');
    $pdf->SetFont('Arial', 'B', 8);
// la condition sur le souscripteur est l'assure
    if ($row_sous['rp_sous'] == '1') {
        $pdf->Cell(40, 5, 'Nom et Prénom', '1', '0', 'L', '1');
        $pdf->Cell(150, 5, "" . $row_sous['nom_sous'] . " " . $row_sous['pnom_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1');
        $pdf->Cell(150, 5, "" . $row_sous['adr_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'Téléphone', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_sous['tel_sous'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_sous['mail_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'D.Naissance', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['dnais_sous'])) . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'N° Passeport', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_sous['passport'] . "", '1', '0', 'C');
        $pdf->Ln();
    }
    else {
        $query_assu = $bdd->prepare("SELECT * FROM `souscripteurw` WHERE cod_par='" . $row_sous['cod_sous'] . "';");
        $query_assu->execute();
        while ($row_assu = $query_assu->fetch()) {
            $pdf->Cell(40, 5, 'Nom et Prénom', '1', '0', 'L', '1');
            $pdf->Cell(150, 5, "" . $row_assu['nom_sous'] . " " . $row_assu['pnom_sous'] . "", '1', '0', 'C');
            $pdf->Ln();
            $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1');
            $pdf->Cell(150, 5, "" . $row_assu['adr_sous'] . "", '1', '0', 'C');
            $pdf->Ln();
            $pdf->Cell(40, 5, 'Téléphone', '1', '0', 'L', '1');
            $pdf->Cell(55, 5, "" . $row_assu['tel_sous'] . "", '1', '0', 'C');
            $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');
            $pdf->Cell(55, 5, "" . $row_assu['mail_sous'] . "", '1', '0', 'C');
            $pdf->Ln();
            $pdf->Cell(40, 5, 'D.Naissance', '1', '0', 'L', '1');
            $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_assu['dnais_sous'])) . "", '1', '0', 'C');
            $pdf->Cell(40, 5, 'N° Passeport', '1', '0', 'L', '1');
            $pdf->Cell(55, 5, "" . $row_assu['passport'] . "", '1', '0', 'C');
            $pdf->Ln();

        }
    }



// Voyage
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 5, 'Option', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . $row_sous['lib_opt'] . "", '1', '0', 'C');
    $pdf->Cell(40, 5, 'Formule', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "Individuelle", '1', '0', 'C');
    $pdf->Ln();
    $pdf->Cell(40, 5, 'Effet le', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['dat_eff'])) . "", '1', '0', 'C');
    $pdf->Cell(40, 5, 'Echéance le', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['dat_ech'])) . "", '1', '0', 'C');
    $pdf->Ln();
    $pdf->Cell(40, 5, 'Zone de Couverture', '1', '0', 'L', '1');
    $pdf->Cell(150, 5, "" . $row_sous['lib_pays'] . "", '1', '0', 'C');


    $pdf->Ln(25);

// Le Tarif !!!!!

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(45, 5, ' Prime Nette ', '1', '0', 'C', '1');
    $pdf->Cell(45, 5, ' Cout de Police ', '1', '0', 'C', '1');
    $pdf->Cell(50, 5, ' Droit de timbre ', '1', '0', 'C', '1');
    $pdf->Cell(50, 5, ' Prime Totale (DZD) ', '1', '0', 'C', '1');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 8);

    $pdf->Cell(45, 5, "" . number_format($row_sous['pn'], 2, ',', ' ') . "", '1', '0', 'C');
    if ($row_sous['cod_cpl'] == 2) {

        $pdf->Cell(45, 5, "" . number_format('250', 2, ',', ' ') . "", '1', '0', 'C');
    }
    if ($row_sous['cod_cpl'] == 3) {
        $pdf->Cell(45, 5, "" . number_format('500', 2, ',', ' ') . "", '1', '0', 'C');
    }
    $pdf->Cell(50, 5, "" . number_format('40', 2, ',', ' ') . "", '1', '0', 'C');
    $pdf->Cell(50, 5, "" . number_format($row_sous['pt'], 2, ',', ' ') . "", '1', '0', 'C');
    $pdf->Ln(50 );

    $pdf->SetFont('Arial', 'B', 50);
    $pdf->Cell(0, 6, "Devis - Gratuit", 0, 0, 'C');

}
$pdf->Output();	

				

?>








