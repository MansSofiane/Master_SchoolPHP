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
$datesys=date("d/m/Y");
$a1 = new chiffreEnLettre();
$errone = false;
require('tfpdf.php');
if (isset($_REQUEST['warda'])) {$row = substr($_REQUEST['warda'],10);}
class PDF extends TFPDF
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
$rqtu=$bdd->prepare("select * from utilisateurs where  id_user = (select id_user from souscripteurw where cod_sous=(select cod_sous from policew where cod_pol='".$row."'));");
$rqtu->execute();
//Requete generale
$rqtg=$bdd->prepare("SELECT d.*,t.`mtt_dt`,c.`mtt_cpl`,o.`lib_opt`,p.`code_prod`, s.`cod_sous`, s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age`  FROM `policew` as d, `dtimbre` as t , `cpolice` as c,`option` as o,`produit` as p,`souscripteurw` as s  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_opt`=o.`cod_opt` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND d.`cod_pol`='$row'");
$rqtg->execute();
$pdf->SetFont('Arial','B',12);
//$pdf->Ln(2);
$pdf->SetFillColor(205,205,205);
while ($row_g=$rqtg->fetch()){
$pdf->Cell(190,8,'Assurance Individuelle Accident','0','0','C');$pdf->Ln();
while ($row_user=$rqtu->fetch()){
$pdf->Cell(190,8,'Police N° '.$row_user['agence'].'.'.substr($row_g['dat_val'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','0','0','C');$pdf->Ln();
$pdf->SetFont('Arial','I',6);
$pdf->Cell(0,6,"Le présent contrat est régi tant par les dispositions de l’ordonnance 95/07 du 25 janvier 1995 modifiée et complétée par la loi N° 06-04 du 20 Février 2006 que part les conditions",0,0,'C');$pdf->Ln(2);
$pdf->Cell(0,6,"générales et les conditions particulières. En cas d’incompatibilité entre les conditions générales et particulières, les conditions particulières prévalent toujours sur les conditions générales. ",0,0,'C');
$pdf->Ln(4);
//$pdf->Cell(190,8,'Devis Gratuit','0','0','C');$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','B',14);
//$pdf->Ln(2);
$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);
//Le Réseau
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,"Agence",'1','1','C','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(221,221,221);
$adr=$row_user['adr_user'];
$pdf->Cell(40,5,'Code','1','0','L','1');$pdf->Cell(55,5,"".$row_user['agence']."",'1','0','C');
$pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(55,5,"".$row_user['adr_user']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_user['tel_user']."",'1','0','C');
$pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_user['mail_user']."",'1','0','C');$pdf->Ln();
}
// debut du traitement de la requete generale
$codsous=$row_g['cod_sous'];
// Le Souscripteur
$pdf->SetFillColor(199,139,85);
$pdf->SetFont('Arial','B',10);
$pdf->Ln(3);
$pdf->Cell(190,5,'Souscripteur ','1','1','C','1');
$pdf->SetFillColor(221,221,221);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Nom et Prénom','1','0','L','1');
$pdf->Cell(150,5,"".$row_g['nom_sous']." ".$row_g['pnom_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(150,5,"".$row_g['adr_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_g['tel_sous']."",'1','0','C');
$pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_g['mail_sous']."",'1','0','C');$pdf->Ln();
$pdf->Ln(2);
// Contrat
$pdf->Ln(3);
$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,' Contrat ','1','0','C','1');$pdf->Ln();
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,'Effet le','1','0','L','1');$pdf->Cell(45,5,"".date("d/m/Y", strtotime($row_g['dat_eff']))."",'1','0','C');
$pdf->Cell(50,5,'Echéance le','1','0','L','1');$pdf->Cell(45,5,"".date("d/m/Y", strtotime($row_g['dat_ech']))."",'1','0','C');$pdf->Ln();
$pdf->Ln(3);
$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,' Garanties ','1','0','C','1');$pdf->Ln();
$pdf->SetFillColor(221,221,221);$pdf->SetTextColor(0,0,0);
$pdf->Cell(80,5,'Décès Accidentel','1','0','L','1');$pdf->Cell(110,5,"".number_format($row_g['cap1'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
$pdf->Cell(80,5,'Incapacité Permanente Partielle','1','0','L','1');$pdf->Cell(110,5,"".number_format($row_g['cap2'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
$pdf->Cell(80,5,'Frais Médicaux et Pharmaceutiques','1','0','L','1');$pdf->Cell(110,5,"".number_format($row_g['cap3'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
$pdf->Ln(7);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,5,'Décompte de la prime ','0','0','L','0');
$pdf->Ln(7);
$pdf->SetFillColor(199,139,85);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,5,' Prime Nette ','1','0','C','1');$pdf->Cell(45,5,' Cout de Police ','1','0','C','1');
$pdf->Cell(50,5,' Droit de timbre ','1','0','C','1');$pdf->Cell(50,5,' Prime Totale (DZD) ','1','0','C','1');
$pdf->Ln();$pdf->SetFont('Arial','B',8);
$pdf->Cell(45,5,"".number_format($row_g['pn'], 2, ',', ' ')."",'1','0','C');
$pdf->Cell(45,5,"".number_format($row_g['mtt_cpl'], 2, ',', ' ')."",'1','0','C');
$pdf->Cell(50,5,"".number_format($row_g['mtt_dt'], 2, ',', ' ')."",'1','0','C');
$pdf->Cell(50,5,"".number_format($row_g['pt'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
$pdf->Ln(2);
$pdf->SetFont('Arial','I',6);
$pdf->Cell(0,6,"Le Souscripteur reconnait que les présentes Conditions Particulières ont été établies conformément aux renseignements qu'il a donné lors de la souscription du Contrat.",0,0,'C');$pdf->Ln(2);
$pdf->Cell(0,6,"Le Souscripteur reconnait également avoir été informé du contenu des Conditions Particulières et des Conditions Générales et avoir été informé du montant de la prime et des garanties dûes.",0,0,'C');
$pdf->Ln(9);
$somme=$a1->ConvNumberLetter("".$row_g['pt']."",1,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,"Le montant à payer en lettres",'0','0','L');$pdf->Ln();
$pdf->SetFont('Arial','B',12);$pdf->SetFillColor(255,255,255);
$pdf->MultiCell(190,12,"".$somme."",1,'C',true);

$pdf->Ln(9);
$pdf->Cell(185,5,"Généré le ".date("d/m/Y", strtotime($row_g['dat_val']))."",'0','0','R');
$pdf->Ln(10);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,5,"Le souscripteur",'0','0','C');$pdf->Cell(120,5,"L'assureur",'0','0','R');$pdf->Ln();
$pdf->Ln(15);
     $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(60, 5, "", '0', '0', 'C');
    $pdf->Cell(120, 5, "Édité le " . $datesys ."" , '0', '0', 'R');
    $pdf->Ln(20);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60,5,"Précedé de la mention «Lu et approuvé»",'0','0','C');$pdf->Ln();
$pdf->Ln(35);$pdf->SetFont('Arial','B',6);
//$pdf->Cell(0,6,"Pour toute modification du contrat, le souscripteur est tenu d'aviser l'assureur avant la date de prise d'effet de son contrat, ou du dernier avenant",0,0,'C');$pdf->Ln(2);$pdf->Ln(2);


// Fin du traitement de la requete generale
}

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
//$pdf->Ln(2);
$pdf->SetFillColor(205,205,205);
$pdf->Cell(190,8,'Liste des assurés','0','0','C');$pdf->Ln();$pdf->Ln(4);
// L'assuré
$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'Assuré ','1','1','C','1');
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(221,221,221);
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

//fin de la condition
//conditions générales
$pdf->AddPage();
$pdf->Ln(15);
$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,5,"Assurance Individuelle Accident code 1.1",0,0,"C");

$pdf->Ln(15);
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(90,3,"Les présentes conditions générales sont régies tant par l’ordonnance N° 75-58 du 26 septembre 1975 portant code civil modifiée et complétée et par l’ordonnance N° 95-07 du 25 janvier 1995 relative aux assurances modifiée et complétée par la loi N° 06-04 du 20 février ",0,"J");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(110,48);
$pdf->MultiCell(90,3,"2006 que par le décret exécutif N° 02-293 du 10 septembre 2002 modifiant et complétant le décret exécutif N° 95-338 du 30 octobre 1995 relatif à l’établissement et à la codification des opérations d’assurance.",0,"J");


$pdf->Output();	

				

?>








