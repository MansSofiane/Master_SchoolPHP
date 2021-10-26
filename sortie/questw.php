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








