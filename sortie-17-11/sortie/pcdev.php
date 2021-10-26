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
if (isset($_REQUEST['warda'])) {$row = substr($_REQUEST['warda'],10);}
//Preparation du PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
//Requete generale
$rqtg=$bdd->prepare("SELECT s.*, d.*,p.lib_pays,p.cod_zone, o.lib_opt  FROM `souscripteurw` as s, `devisw` as d, `pays` as p, `option` as o WHERE s.cod_sous=d.cod_sous and d.cod_pays=p.cod_pays and d.cod_opt=o.cod_opt  and d.cod_dev='$row'");
$rqtg->execute();

while ($row_g=$rqtg->fetch()) {
    $pdf->SetFont('Arial', 'B', 50);
//$pdf->Ln(2);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(190, 8, 'Devis Gratuit ', '0', '0', 'C');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(0, 0, 0);


// debut du traitement de la requete generale

    $pdf->Ln(20);
// Le Souscripteur
    // $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(190, 5, 'Souscripteur ', '1', '1', 'C', '1');
    //$pdf->SetFillColor(221,221,221);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 5, 'Nom et Prénom/ R.Sociale', '1', '0', 'L', '1');
    if ($row_g['civ_sous'] == 0) {
        $pdf->Cell(150, 5, "" . $row_g['nom_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
    } else {
        $pdf->Cell(150, 5, "" . $row_g['nom_sous'] . " " . $row_g['pnom_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
    }
    $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1');
    $pdf->Cell(150, 5, "" . $row_g['adr_sous'] . "", '1', '0', 'C');
    $pdf->Ln();
    $pdf->Cell(40, 5, 'Téléphone', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . $row_g['tel_sous'] . "", '1', '0', 'C');
    $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . $row_g['mail_sous'] . "", '1', '0', 'C');
    $pdf->Ln();
    $pdf->Ln(15);
// L'assuré
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(190, 5, 'Voyage', '1', '1', 'C', '1');
    $pdf->SetFont('Arial', 'B', 8);
// Voyage
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 5, 'Option', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . $row_g['lib_opt'] . "", '1', '0', 'C');
    $pdf->Cell(40, 5, 'Formule', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "Couple", '1', '0', 'C');
    $pdf->Ln();
    $pdf->Cell(40, 5, 'Effet le', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_g['dat_eff'])) . "", '1', '0', 'C');
    $pdf->Cell(40, 5, 'Echéance le', '1', '0', 'L', '1');
    $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_g['dat_ech'])) . "", '1', '0', 'C');
    $pdf->Ln();

    $pdf->Cell(40, 5, 'Zone de Couverture', '1', '0', 'L', '1');
    $pdf->Cell(150, 5, "" . $row_g['lib_pays'] . "", '1', '0', 'C');
    $pdf->Ln(25);
// Le Tarif !!!!!


    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(45, 5, ' Prime Nette ', '1', '0', 'C', '1');
    $pdf->Cell(45, 5, ' Cout de Police ', '1', '0', 'C', '1');
    $pdf->Cell(50, 5, ' Droit de timbre ', '1', '0', 'C', '1');
    $pdf->Cell(50, 5, ' Prime Totale (DZD) ', '1', '0', 'C', '1');
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 8);


    $pdf->Cell(45, 5, "" . number_format($row_g['pn'], 2, ',', ' ') . "", '1', '0', 'C');
    if ($row_g['cod_cpl'] == 2) {//PHYSIQUE
        $pdf->Cell(45, 5, "" . number_format('250', 2, ',', ' ') . "", '1', '0', 'C');
    } else {
        $pdf->Cell(45, 5, "" . number_format('500', 2, ',', ' ') . "", '1', '0', 'C');
    }
    $pdf->Cell(50, 5, "" . number_format('40', 2, ',', ' ') . "", '1', '0', 'C');
    $pdf->Cell(50, 5, "" . number_format($row_g['pt'], 2, ',', ' ') . "", '1', '0', 'C');



    $pdf->Ln(50);
    $pdf->SetFont('Arial', 'B', 50);
    $pdf->Cell(0, 6, "Devis - Gratuit", 0, 0, 'C');


    $pdf->Output();

}

?>








