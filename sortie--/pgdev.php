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
$a1 = new chiffreEnLettre();
$errone = false;
require('fpdf.php');

if (isset($_REQUEST['groupe'])) {
    $row = substr($_REQUEST['groupe'],10);
}
class PDF extends FPDF
{
// En-t?te
    function Header()
    {
        $this->SetFont('Arial','B',10);
        //$this->Image('../img/entete_bna.png',6,4,190);
        $this->Cell(150,5,'','O','0','L');
        $this->SetFont('Arial','B',12);
        // $this->Cell(60,5,'MAPFRE | Assistance','O','0','L');
        $this->SetFont('Arial','B',10);
        $this->Ln(14);
    }


    function RotatedText($x,$y,$txt,$angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
        $this->Rotate(0);
    }

}
//Les requetes *****************

//Requete Souscripteur
$query_sous =$bdd->prepare("SELECT s.*, d.*,p.lib_pays,p.cod_zone, o.lib_opt  FROM `souscripteurw` as s, `devisw` as d, `pays` as p, `option` as o WHERE s.cod_sous=d.cod_sous and d.cod_pays=p.cod_pays and d.cod_opt=o.cod_opt  and d.cod_dev='".$row."';");
$query_sous->execute();

// Instanciation de la classe derivee
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',50);
//$pdf->Ln(2);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);

while($row_sous=$query_sous->fetch()) {

$pdf->Cell(190,8,'Devis Gratuit','0','0','C');$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','B',14);

        $pdf->Ln(20);
// Le Souscripteur
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, 'Souscripteur ', '1', '1', 'C', '1');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, 'Nom et Pr?nom/ R.Sociale', '1', '0', 'L', '1');
        if($row_sous['civ_sous']==0)
        {
            $pdf->Cell(150,5,"".$row_sous['nom_sous']."",'1','0','C');$pdf->Ln();
        }
        else
        {
            $pdf->Cell(150,5,"".$row_sous['nom_sous']." ".$row_sous['pnom_sous']."",'1','0','C');$pdf->Ln();
        }
        $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1'); $pdf->Cell(150, 5, "" . $row_sous['adr_sous'] . "", '1', '0', 'C');$pdf->Ln();
        $pdf->Cell(40, 5, 'T?l?phone', '1', '0', 'L', '1');$pdf->Cell(55, 5, "" . $row_sous['tel_sous'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');$pdf->Cell(55, 5, "" . $row_sous['mail_sous'] . "", '1', '0', 'C');$pdf->Ln();
        $pdf->Ln(15);
// L'assur?
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, 'Voyage', '1', '1', 'C', '1');
        $pdf->SetFont('Arial', 'B', 8);
// Voyage
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, 'Option', '1', '0', 'L', '1');$pdf->Cell(55, 5, "" . $row_sous['lib_opt'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'Formule', '1', '0', 'L', '1');$pdf->Cell(55, 5, "Groupe", '1', '0', 'C');$pdf->Ln();
        $pdf->Cell(40, 5, 'Effet le', '1', '0', 'L', '1');$pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['dat_eff'])) . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'Ech?ance le', '1', '0', 'L', '1');$pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['dat_ech'])) . "", '1', '0', 'C');$pdf->Ln();
        $pdf->Cell(40, 5, 'Zone de Couverture', '1', '0', 'L', '1');$pdf->Cell(150, 5, "" . $row_sous['lib_pays'] . "", '1', '0', 'C');$pdf->Ln(3);

        $pdf->Ln(25);
// Le Tarif !!!!!

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 5, ' Prime Nette ', '1', '0', 'C', '1');$pdf->Cell(45, 5, ' Cout de Police ', '1', '0', 'C', '1');
        $pdf->Cell(50, 5, ' Droit de timbre ', '1', '0', 'C', '1');
  $pdf->Cell(50, 5, ' Prime Totale (DZD) ', '1', '0', 'C', '1');$pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
       // $pn1 = $pn - 250;

    if($row_sous['cod_cpl']==2){
            $pdf->Cell(45, 5, "" . number_format($row_sous['pn'], 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(45, 5, "" . number_format('250', 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(50, 5, "" . number_format('40', 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(50, 5, "" . number_format($row_sous['pt'], 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Ln();
        }
       else {
            $pdf->Cell(45, 5, "" . number_format($pn, 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(45, 5, "" . number_format('500', 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(50, 5, "" . number_format('40', 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(50, 5, "" . number_format($row_sous['pt'], 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Ln();
        }

        $pdf->Ln(50);
        $pdf->SetFont('Arial', 'B', 50);
        $pdf->Cell(0, 6, "Devis - Gratuit", 0, 0, 'C');

}
$pdf->Output();	

?>








