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

$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',50);
$pdf->Ln(15);
$pdf->Cell(190,8,'Devis - Gratuit','0','0','C');$pdf->Ln();
$pdf->SetFont('Arial','B',14);

//Requete generale
$rqtg=$bdd->prepare("SELECT d.*,t.`mtt_dt`,c.`mtt_cpl`,o.`lib_opt`,p.`code_prod`, s.`cod_sous`, s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age`  FROM `devisw` as d, `dtimbre` as t , `cpolice` as c,`option` as o,`produit` as p,`souscripteurw` as s  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_opt`=o.`cod_opt` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND d.`cod_dev`='$row'");
$rqtg->execute();

while ($row_g=$rqtg->fetch()){
// debut du traitement de la requete generale
$codsous=$row_g['cod_sous'];
    $pdf->Ln(20);
// Le Souscripteur
$pdf->SetFont('Arial','B',10);
$pdf->Ln(3);
$pdf->Cell(190,5,'Souscripteur ','1','1','C','1');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Nom et Prénom','1','0','L','1');
$pdf->Cell(150,5,"".$row_g['nom_sous']." ".$row_g['pnom_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(150,5,"".$row_g['adr_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_g['tel_sous']."",'1','0','C');
$pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_g['mail_sous']."",'1','0','C');$pdf->Ln();
$pdf->Ln(15);
// Contrat
$pdf->Ln(3);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,' Contrat ','1','0','C','1');$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,'Effet le','1','0','L','1');$pdf->Cell(45,5,"".date("d/m/Y", strtotime($row_g['dat_eff']))."",'1','0','C');
$pdf->Cell(50,5,'Echéance le','1','0','L','1');$pdf->Cell(45,5,"".date("d/m/Y", strtotime($row_g['dat_ech']))."",'1','0','C');$pdf->Ln();
$pdf->Ln(3);
$pdf->SetFont('Arial','B',10);
    $pdf->Ln(15);
$pdf->Cell(190,5,' Garanties ','1','0','C','1');$pdf->Ln();
$pdf->Cell(80,5,'Décès Accidentel','1','0','L','1');$pdf->Cell(110,5,"".number_format($row_g['cap1'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
$pdf->Cell(80,5,'Incapacité Permanente Partielle','1','0','L','1');$pdf->Cell(110,5,"".number_format($row_g['cap2'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
$pdf->Cell(80,5,'Frais Médicaux et Pharmaceutiques','1','0','L','1');$pdf->Cell(110,5,"".number_format($row_g['cap3'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
$pdf->Ln(20);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,5,' Prime Nette ','1','0','C','1');$pdf->Cell(45,5,' Cout de Police ','1','0','C','1');
$pdf->Cell(50,5,' Droit de timbre ','1','0','C','1');$pdf->Cell(50,5,' Prime Totale (DZD) ','1','0','C','1');
$pdf->Ln();$pdf->SetFont('Arial','B',8);
$pdf->Cell(45,5,"".number_format($row_g['pn'], 2, ',', ' ')."",'1','0','C');
$pdf->Cell(45,5,"".number_format($row_g['mtt_cpl'], 2, ',', ' ')."",'1','0','C');
$pdf->Cell(50,5,"".number_format($row_g['mtt_dt'], 2, ',', ' ')."",'1','0','C');
$pdf->Cell(50,5,"".number_format($row_g['pt'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
    $pdf->Ln(50);
$pdf->SetFont('Arial','B',50);
$pdf->Cell(0,6,"Devis - Gratuit",0,0,'C');$pdf->Ln(2);$pdf->Ln(2);

// Fin du traitement de la requete generale
}

$pdf->AddPage();
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',50);
$pdf->Ln(15);
$pdf->Cell(0,6,"Devis - Gratuit",0,0,'C');$pdf->Ln(2);$pdf->Ln(2);
$pdf->Ln(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,8,'Liste des assurés','0','0','C');$pdf->Ln();$pdf->Ln(4);
// L'assuré
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'Assuré ','1','1','C','1');
$pdf->SetFont('Arial','B',8);

// le souscripteur n'est pas l'assuré
$rqta=$bdd->prepare("SELECT s.`nom_sous`, s.`pnom_sous`,s.`dnais_sous`,s.`autre_prof`,s.`quot_sous` FROM `souscripteurw` as s  WHERE  s.`cod_par`='$codsous'");
$rqta->execute();
$pdf->Cell(110,5,'Nom et Prénom','1','0','C','1');$pdf->Cell(20,5,'D.Naissance','1','0','C','1');$pdf->Cell(40,5,'Profession','1','0','C','1');$pdf->Cell(20,5,'Classe-risque','1','0','C','1');$pdf->Ln();
while ($row_a=$rqta->fetch()){
$pdf->Cell(110,5,"".$row_a['nom_sous']." ".$row_a['pnom_sous']."",'1','0','C');
$pdf->Cell(20,5,"".date("d/m/Y",strtotime($row_a['dnais_sous']))."",'1','0','C');
    $pdf->Cell(40,5,"".$row_a['autre_prof']."",'1','0','C');
    $class_rsq=$row_a['quot_sous'];
    if($class_rsq==2) {
        $pdf->Cell(20, 5, "Classe-1", '1', '0', 'C');
    }
    if($class_rsq==3) {
        $pdf->Cell(20, 5, "Classe-2", '1', '0', 'C');
    }
    if($class_rsq==4) {
        $pdf->Cell(20, 5, "Classe-3", '1', '0', 'C');
    }
    if($class_rsq==5) {
        $pdf->Cell(20, 5, "Risques-Spéciaux", '1', '0', 'C');
    }
    $pdf->Ln();


}

$pdf->Ln(50);
$pdf->SetFont('Arial','B',50);
$pdf->Cell(0,6,"Devis - Gratuit",0,0,'C');$pdf->Ln(2);$pdf->Ln(2);
$pdf->Output();	

				

?>








