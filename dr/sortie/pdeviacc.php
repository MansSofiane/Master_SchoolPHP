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


$pdf->SetFont('Arial','B',50);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Ln(15);
$pdf->Cell(190,8,'Devis - Gratuit','0','0','C');$pdf->Ln();

//Requete generale
$rqtg=$bdd->prepare("SELECT d.*,t.`mtt_dt`,c.`mtt_cpl`,o.`lib_opt`,p.`code_prod`, s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age` ,s.autre_prof FROM `devisw` as d, `dtimbre` as t , `cpolice` as c,`option` as o,`produit` as p,`souscripteurw` as s  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_opt`=o.`cod_opt` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND d.`cod_dev`='$row'");
$rqtg->execute();

while ($row_g=$rqtg->fetch()){
// debut du traitement de la requete generale
    $pdf->Ln(10);
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
$pdf->Ln(10);
// L'assuré
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'Assuré ','1','1','C','1');
$pdf->SetFont('Arial','B',8);
// la condition sur le souscripteur et l'assure
if($row_g['rp_sous']==1){
$pdf->Cell(40,5,'Nom et Prénom','1','0','L','1');$pdf->Cell(150,5,"".$row_g['nom_sous']." ".$row_g['pnom_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(150,5,"".$row_g['adr_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_g['tel_sous']."",'1','0','C');
$pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_g['mail_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'D.Naissance','1','0','L','1');$pdf->Cell(25,5,"".date("d/m/Y",strtotime($row_g['dnais_sous']))."",'1','0','C');
$pdf->Cell(10,5,'Age','1','0','L','1');$pdf->Cell(20,5,"".$row_g['age']."",'1','0','C');
$pdf->Cell(40,5,'Profession','1','0','L','1');$pdf->Cell(55,5,"".$row_g['autre_prof']."",'1','0','C');
    $pdf->Ln();
}else{
// le souscripteur n'est pas l'assuré
$rowa=$row_g['cod_sous'];
$rqta=$bdd->prepare("SELECT s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age`,s.autre_prof  FROM `souscripteurw` as s  WHERE  s.`cod_par`='$rowa'");
$rqta->execute();
while ($row_a=$rqta->fetch()){
$pdf->Cell(40,5,'Nom et Prénom','1','0','L','1');$pdf->Cell(150,5,"".$row_a['nom_sous']." ".$row_a['pnom_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(150,5,"".$row_a['adr_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_a['tel_sous']."",'1','0','C');
$pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_a['mail_sous']."",'1','0','C');$pdf->Ln();
    $pdf->Cell(40,5,'D.Naissance','1','0','L','1');$pdf->Cell(25,5,"".date("d/m/Y",strtotime($row_a['dnais_sous']))."",'1','0','C');
    $pdf->Cell(10,5,'Age','1','0','L','1');$pdf->Cell(20,5,"".$row_a['age']."",'1','0','C');
    $pdf->Cell(40,5,'Profession','1','0','L','1');$pdf->Cell(55,5,"".$row_a['autre_prof']."",'1','0','C');

    $pdf->Ln();
}
//fin de la condition
}
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
if($row_g['rp_sous']==1){//le souscripteur est l'assuré
if($row_g['age']>12){
//on affiche le capital DC
$pdf->Cell(80,5,'Décès Accidentel','1','0','L','1');$pdf->Cell(110,5,"".number_format($row_g['cap1'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
}else{
// On affiche 0 pour le capital DC
$pdf->Cell(80,5,'Décès Accidentel','1','0','L','1');$pdf->Cell(110,5,"".number_format(0, 2, ',', ' ')."",'1','0','C');$pdf->Ln();
}

}else{//le souscripteur n'est pas l'assuré
if($row_a['age']>12){
//on affiche le capital DC
$pdf->Cell(80,5,'Décès Accidentel','1','0','L','1');$pdf->Cell(110,5,"".number_format($row_g['cap1'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
}else{
// On affiche 0 pour le capital DC
$pdf->Cell(80,5,'Décès Accidentel','1','0','L','1');$pdf->Cell(110,5,"".number_format(0, 2, ',', ' ')."",'1','0','C');$pdf->Ln();
}
}

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

$pdf->Ln(10);
$pdf->SetFont('Arial','B',50);

    $pdf->Cell(0,6,"Devis - Gratuit",0,0,'C');

}



$pdf->Output();	

				

?>








