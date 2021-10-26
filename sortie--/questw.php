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
if (isset($_REQUEST['warda'])) {$row = substr($_REQUEST['warda'],10);}
class PDF extends FPDF
{
// En-t?te
function Header()
{
 $this->SetFont('Arial','B',10);
    $this->Image('../img/entete_bna.png',6,4,190);
	 $this->Cell(150,5,'','O','0','L');
	 $this->SetFont('Arial','B',12);
	// $this->Cell(60,5,'MAPFRE | Assistance','O','0','L');
      $this->SetFont('Arial','B',10);
	  $this->Ln(8);
}

function Footer()
{
    // Positionnement ? 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',6);
    // Num?ro de page
    $this->Cell(0,8,'Page '.$this->PageNo().'/{nb}',0,0,'C');$this->Ln(3);
	$this->Cell(0,8,"Algerian Gulf Life Insurance Company, SPA au capital social de 1.000.000.000 de dinars algériens, 01 Rue Tripoli, Hussein Dey Alger,  ",0,0,'C');
	$this->Ln(2);
	$this->Cell(0,8,"RC : 16/00-1009727 B 15   NIF : 001516100972762-NIS :0015160900296000",0,0,'C');
	$this->Ln(2);
	$this->Cell(0,8,"Tel : +213 (0) 21 77 30 12/14/15 Fax : +213 (0) 21 77 29 56 Site Web : www.aglic.dz  ",0,0,'C');
	}
function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}	
		
}
//Preparation du PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Requete Agence 
$rqtr=$bdd->prepare("select * from reponse where  cod_sous ='$row'");
$rqtr->execute();
$pdf->SetFont('Arial','B',12);
//$pdf->Ln(2);
$pdf->SetFillColor(205,205,205);
$pdf->Cell(190,8,'Réponse au Questionnaire-Assurance Cancer du Sein','0','0','C');$pdf->Ln();


while ($row_r=$rqtr->fetch()){
$pdf->Cell(190,8,'Informations-IMC','0','0','L');$pdf->Ln();
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(221,221,221);
$pdf->Cell(40,5,'Taille','1','0','L','1');$pdf->Cell(150,5,"".$row_r['taille']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Poids','1','0','L','1');$pdf->Cell(150,5,"".$row_r['poid']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'IMC','1','0','L','1');$pdf->Cell(150,5,"".$row_r['imc']."",'1','0','C');
$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(205,205,205);
$pdf->Cell(190,8,'Réponses-Questionnaire','0','0','L');$pdf->Ln();
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(221,221,221);
$pdf->Cell(40,5,'Réponse-1','1','0','L','1');$pdf->Cell(150,5,"".$row_r['r1']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Réponse-2','1','0','L','1');$pdf->Cell(150,5,"".$row_r['r2']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Réponse-3','1','0','L','1');$pdf->Cell(150,5,"".$row_r['r3']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Réponse-4','1','0','L','1');$pdf->Cell(150,5,"".$row_r['r4']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Réponse-5','1','0','L','1');$pdf->Cell(150,5,"".$row_r['r5']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Réponse-6','1','0','L','1');$pdf->Cell(150,5,"".$row_r['r6']."",'1','0','C');$pdf->Ln();
}
$pdf->Output();

?>








