<?php
session_start();
if ($_SESSION['loginsal']){
//authentification acceptee !!!

}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}
require_once("../../../data/conn7.php");
//include("convert.php");
include("entete.php");

$datesys=date("d/m/Y");
//$a1 = new chiffreEnLettre();
$errone = false;

if (isset($_REQUEST['avenant'])) {
    $row = substr($_REQUEST['avenant'],10);
}




// Instanciation de la classe derivee
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln();
$pdf->Ln();
//$pdf->image()
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(205,205,205);
$pdf->Output();

?>








