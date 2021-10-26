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
$rqtu=$bdd->prepare("select * from utilisateurs where  id_user ='".$_SESSION['id_usersal']."'");
$rqtu->execute();
$pdf->SetFont('Arial','B',12);
//Requete generale
$rqtg=$bdd->prepare("SELECT d.*,t.`mtt_dt`,c.`mtt_cpl`,o.`lib_opt`,p.`code_prod`, s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age`, b.`nom_benef`, b.`ag_benef`,b.`tel_benef`,b.`adr_benef`  FROM `policew` as d, `dtimbre` as t , `cpolice` as c,`option` as o,`produit` as p,`souscripteurw` as s,`beneficiaire` as b  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_opt`=o.`cod_opt` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND b.`cod_sous`=s.`cod_sous` AND d.`cod_pol`='$row'");
$rqtg->execute();

while ($row_g=$rqtg->fetch()){
//$pdf->Ln(2);
$pdf->SetFillColor(205,205,205);
$pdf->Cell(190,8,'Assurance Décès Emprunteur','0','0','C');$pdf->Ln();
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
$pdf->Ln(3);
// L'assuré
$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,'Assuré ','1','1','C','1');
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(221,221,221);
$pdf->SetFont('Arial','B',8);
// la condition sur le souscripteur et l'assure
if($row_g['rp_sous']==1){
$pdf->Cell(40,5,'Nom et Prénom','1','0','L','1');$pdf->Cell(150,5,"".$row_g['nom_sous']." ".$row_g['pnom_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(150,5,"".$row_g['adr_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_g['tel_sous']."",'1','0','C');
$pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_g['mail_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'D.Naissance','1','0','L','1');$pdf->Cell(55,5,"".date("d/m/Y",strtotime($row_g['dnais_sous']))."",'1','0','C');
$pdf->Cell(40,5,'Age','1','0','L','1');$pdf->Cell(55,5,"".$row_g['age']."",'1','0','C');$pdf->Ln();
}else{
// le souscripteur n'est pas l'assuré
$rowa=$row_g['cod_sous'];
$rqta=$bdd->prepare("SELECT s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age`  FROM `souscripteurw` as s  WHERE  s.`cod_par`='$rowa'");
$rqta->execute();
while ($row_a=$rqta->fetch()){
$pdf->Cell(40,5,'Nom et Prénom','1','0','L','1');$pdf->Cell(150,5,"".$row_a['nom_sous']." ".$row_a['pnom_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(150,5,"".$row_a['adr_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_a['tel_sous']."",'1','0','C');
$pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_a['mail_sous']."",'1','0','C');$pdf->Ln();
$pdf->Cell(40,5,'D.Naissance','1','0','L','1');$pdf->Cell(55,5,"".date("d/m/Y",strtotime($row_a['dnais_sous']))."",'1','0','C');
$pdf->Cell(40,5,'Age','1','0','L','1');$pdf->Cell(55,5,"".$row_a['age']."",'1','0','C');$pdf->Ln();
}
//fin de la condition
}

// Contrat
$pdf->Ln(3);
$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,' Contrat ','1','0','C','1');$pdf->Ln();
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,'Effet le','1','0','L','1');$pdf->Cell(45,5,"".date("d/m/Y", strtotime($row_g['ndat_eff']))."",'1','0','C');
$pdf->Cell(50,5,'Echéance le','1','0','L','1');$pdf->Cell(45,5,"".date("d/m/Y", strtotime($row_g['ndat_ech']))."",'1','0','C');$pdf->Ln();
$pdf->Ln(3);
$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,' Garanties et Capital assuré','1','0','C','1');$pdf->Ln();
$pdf->SetFillColor(221,221,221);$pdf->SetTextColor(0,0,0);
$pdf->Cell(90,5,'Garanties','1','0','L','1');$pdf->Cell(100,5,'Décès et Invalidité Absolue et Définitive','1','0','C');$pdf->Ln();
$pdf->Cell(90,5,'Capital Assuré','1','0','L','1');$pdf->Cell(100,5,"".number_format($row_g['cap1'], 2, ',', ' ')." DZD",'1','0','C');$pdf->Ln();
// Beneficiaire (Organisme preteur)
$pdf->Ln(3);
$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,' Bénéficiaires','1','0','C','1');$pdf->Ln();
$pdf->SetFillColor(221,221,221);$pdf->SetTextColor(0,0,0);
$pdf->Cell(35,5,'Organisme préteur','1','0','L','1');$pdf->Cell(155,5,"".$row_g['nom_benef']."",'1','0','L');$pdf->Ln();
$pdf->Cell(35,5,'Code agence','1','0','L','1');$pdf->Cell(155,5,"".$row_g['ag_benef']."",'1','0','L');$pdf->Ln();
$pdf->Cell(35,5,'Téléphone','1','0','L','1');$pdf->Cell(155,5,"".$row_g['tel_benef']."",'1','0','L');$pdf->Ln();
$pdf->Cell(35,5,'Adresse','1','0','L','1');$pdf->Cell(155,5,"".$row_g['adr_benef']."",'1','0','L');$pdf->Ln();


$pdf->Ln(5);


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
//$pdf->Cell(0,6,"Le Souscripteur reconnait que les présentes Conditions Particulières ont été établies conformément aux renseignements qu'il a donné lors de la souscription du Contrat.",0,0,'C');$pdf->Ln(2);
//$pdf->Cell(0,6,"Le Souscripteur reconnait également avoir été informé du contenu des Conditions Particulières et des Conditions Générales et avoir été informé du montant de la prime et des garanties dûes.",0,0,'C');
$pdf->Ln(7);
$somme=$a1->ConvNumberLetter("".$row_g['pt']."",1,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,"Le montant à payer en lettres",'0','0','L');$pdf->Ln();
$pdf->SetFont('Arial','B',12);$pdf->SetFillColor(255,255,255);
$pdf->MultiCell(190,12,"".$somme."",1,'C',true);

$pdf->Ln(7);


$pdf->Cell(185,5,"".$adr." le ".date("d/m/Y", strtotime($row_g['dat_val']))."",'0','0','R');$pdf->Ln();
$pdf->Ln(2);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,5,"Le souscripteur",'0','0','C');$pdf->Cell(120,5,"L'assureur",'0','0','R');$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60,5,"Précedé de la mention «Lu et approuvé»",'0','0','C');$pdf->Ln();
$pdf->Ln(35);$pdf->SetFont('Arial','B',6);
//$pdf->Cell(0,6,"Pour toute modification du contrat, le souscripteur est tenu d'aviser l'assureur avant la date de prise d'effet de son contrat, ou du dernier avenant",0,0,'C');$pdf->Ln(2);$pdf->Ln(2);
$pdf->SetFont('Arial','',100);
//$pdf->RotatedText(60,240,'Devis-Gratuit',60);

// Fin du traitement de la requete generale
}


//Conditions générales la dernière page
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(205,205,205);
//$pdf->Ln(2);Notice d'information
//$pdf->Image('../img/Notice_information.png',0,0,210,297);

$pdf->Cell(190,8,"Assurance Décès Emprunteur",'0','0','C');$pdf->Ln();
$pdf->Cell(190,8,"CONDITIONS GENERALES",'0','0','C');$pdf->Ln();
$pdf->Ln(5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,3,"Base juridique",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(190,3,"Les presentes conditions generales sont regies tant par I'ordonnance N° 15-58 du 26 septembre 1915 portant code civile rnodifiee et cornpletee et par I'ordonnance N° 95-01 du 25 janvier 1995 relative aux assurances rnodlfiee et cornpletee par la loi N° 06-04 du
20 fevrier 2006 que par Ie decret executif N° 02-293 du 10 septembre 2002 modifiant et cornpletant Ie decret executlf N° 95-338 du 30 octobre 1995 relatif a l'etabllssement et a la codification des operations d'assurance.",0,"J",false);$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,"ARTICLE 1 : OBJET DU CONTRAT",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90,3,"Le présent contrat a pour objet de garantir au prêteur, durant la période de validité des garanties, le règlement du capital restant dû en cas de Décès ou de Perte Totale et Irréversible d’autonomie (PTIA) de l’assuré emprunteur.",0,"J",false);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,"ARTICLE 2 : DEFINITIONS ",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,3,"Assureur:",0,0,"J");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(80,3,"       Par « Assureur », on entend, la compagnie ",0,"J",false);
$pdf->MultiCell(90,3,"d’assurances de personnes « Algerian Gulf Life Insurance Company » par abréviation « AGLIC » dont le nom commercial est “L’ALGERIENNE VIE détenant un capital social de 1 000 000 000 DA, sise Centre des affaires El QODS -Esplanade - 4ème Etage Chéraga – Alger",0,"J",false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,3,"Souscripteur : ",0,0,"J");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(80,3,"                 Par  “Souscripteur”, on entend, la personne ",0,"J",false);
$pdf->MultiCell(90,3,"désignée sous ce nom aux conditions particulières, ou toute personne qui lui serait substituée par accord des parties, qui souscrit le contrat pour le compte de l’assuré. ",0,"J",false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,3,"Beneficiaire Du Contrat :",0,0,"J");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(80,3,"                               Le bénéficiaire est toute personne ",0,"J",false);
$pdf->MultiCell(90,3,"à qui les prestations sont dues en vertu du contrat. C'est la personne à laquelle revient tout ou partie du capital en cas de décès de la tête (personne) assurée.",0,"J",false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,3,"Sinistres:",0,0,"J");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(80,3,"      C’est la survenance de l’événement, s’il est assuré,",0,"J",false);
$pdf->MultiCell(90,3,"qui déclenche la garantie de l’assureur.",0,"J",false);



$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,3,"Provision mathématique:",0,0,"J");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(80,3,"                               Ceux sont les réserves constituées",0,"J",false);
$pdf->MultiCell(90,3,"par l’assureur afin de garantir le paiement des prestations durant toute la vie du contrat.",0,"J",false);

$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,"ARTICLE 3 : GARANTIES",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,3,"a) Décès (code : 20.2)",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90,3,"Sauf exclusion formelle, l’Assureur couvre le remboursement du montant de capital emprunté restant dû suite au décès de l’assuré.",0,"J",false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,3,"b)Perte Totale et Irréversible d’Autonomie (PTIA)(code:20.2)",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90,3,"Sauf exclusion formelle, l’Assureur couvre le remboursement du montant de capital emprunté restant dû en cas de perte totale et irréversible d’autonomie (PTIA) de l’assuré, en cours de validité du présent contrat, quelle qu’en soit la cause.",0,"J",false);
$pdf->MultiCell(90,3,"Définition de la «  Perte Totale et Irréversible d’Autonomie (PTIA) » :Un Assuré est considéré atteint de Perte Totale et Irréversible d’Autonomie lorsqu’à la suite d’un accident ou d’une maladie, il est dans l’impossibilité présente et future de se livrer à une occupation quelconque lui procurant gain ou profit et est dans l’obligation absolue et présumée définitive d’avoir recours à l’assistance d’une tierce personne pour effectuer les actes ordinaires de la vie.",0,"J",false);
$pdf->MultiCell(90,3,"La Perte Totale et Irréversible d’Autonomie est réputée consolidée :",0,"J",false);
$pdf->MultiCell(90,3,"- si elle est consécutive à un accident : à la date à partir de laquelle l’état de santé de l’Assuré correspondant à la Perte Totale et Irréversible  d’Autonomie est reconnu, compte tenu des connaissances scientifiques et médicales, comme ne pouvant plus être amélioré.",0,"J",false);
$pdf->MultiCell(90,3,"- si elle est consécutive à une maladie : à l’expiration d’un délai de deux ans de durée continue de l’état de Perte Totale et Irréversible d’Autonomie.
La réalisation de la Perte Totale et Irréversible d’Autonomie doit être établie avant le dernier jour du mois au cours duquel l’Assuré atteint son 60ème anniversaire de naissance. Le risque PTIA étant assimilé au décès, l’Assureur versera par anticipation le montant du capital prévu en cas de décès, l’Assuré cessant alors de bénéficier de toutes les autres garanties.",0,"J",false);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,"ARTICLE 4 : TERRITORIALITE",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90,3,"L'Assureur couvre tous les risques de décès et de  PTIA monde entier et quelle qu'en soit la cause, sous réserves des exclusions ci-après :.",0,"J",false);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,"ARTICLE 5 : EXCLUSION",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90,3,"a) Exclusions relatives au risque \"Décès\"",0,"J",false);


// Deuxiemme colonne
$pdf->SetXY(105,59);
$pdf->MultiCell(90,3,"- Le suicide conscient et volontaire de l’assuré, au cours des deux premières années qui suivent la date d’effet du contrat ou sa remise en vigueur s’il a été interrompu. En cas d’augmentation des garanties, le suicide volontaire et conscient est exclu pour le supplément de garanties pendant les deux premières années suivant la prise d’effet de cette augmentation,",0,"J",false);
$pdf->SetXY(105,81);
$pdf->MultiCell(90,3,"- Le meurtre par le bénéficiaire,",0,"J",false);
$pdf->SetXY(105,84);
$pdf->MultiCell(90,3,"- L’accident aérien survenu au cours de vols acrobatiques ou d’exhibitions, de compétitions ou tentatives de record, de vols d’essai ou de vols sur un appareil autre qu’un avion ou un hélicoptère,",0,"J",false);

$pdf->SetXY(105,96);
$pdf->MultiCell(90,3,"- En cas de guerre étrangère.",0,"J",false);

$pdf->SetXY(105,99);
$pdf->MultiCell(90,3,"b) Autres évènements non garantis",0,"J",false);

$pdf->SetXY(105,102);
$pdf->MultiCell(90,3,"- Fait intentionnel de l’assuré ou du bénéficiaire,",0,"J",false);

$pdf->SetXY(105,105);
$pdf->MultiCell(90,3,"- Ivresse manifeste ou alcoolémie, lorsque le taux d’alcool dans le sang est égal ou supérieur à un gramme par litre de sang,",0,"J",false);


$pdf->SetXY(105,114);
$pdf->MultiCell(90,3,"- Usage par l’assuré de drogues ou de stupéfiants non ordonnés médicalement,",0,"J",false);


$pdf->SetXY(105,120);
$pdf->MultiCell(90,3,"- Guerre civile, émeutes ou mouvements populaires, actes de terrorisme ou de sabotage, participation de l’assuré à un duel ou à une rixe (sauf cas de légitime défense),",0,"J",false);


$pdf->SetXY(105,129);
$pdf->MultiCell(90,3,"- Désintégration du noyau atomique ou radiations ionisantes,",0,"J",false);


$pdf->SetXY(105,132);
$pdf->MultiCell(90,3,"- Accident dû à la participation de l’assuré, en qualité de conducteur ou de passager, à des compétitions de toute nature entre véhicules à moteur, et à leurs essais préparatoires,",0,"J",false);



$pdf->SetXY(105,144);
$pdf->MultiCell(90,3,"- Des vols sur aile volante, ULM, deltaplane, parachute ascensionnel et parapente",0,"J",false);


$pdf->SetXY(105,150);
$pdf->MultiCell(90,3,"- Pratique par l’assuré d’un sport quelconque, à titre professionnel,",0,"J",false);


$pdf->SetXY(105,156);
$pdf->MultiCell(90,3,"- Les invalidités résultant de grossesse, fausse-couche, de l’accouchement normal ou prématuré ou de ses suites ne seront garanties qu’en cas de complications pathologiques,",0,"J",false);


$pdf->SetXY(105,165);
$pdf->MultiCell(90,3,"Les invalidités résultant d’affections neuro psychiques (sous toutes leurs formes) ne sont garanties qu’après six mois d’arrêt de travail.",0,"J",false);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(105,174);
$pdf->Cell(10,5,"ARTICLE 6 : DELAI DE DECLARATION POUR PTIA ",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetXY(105,179);
$pdf->MultiCell(90,3,"La garantie ne jouera pas, si l’accident ou la maladie ayant causé la Perte Totale et Irréversible d’Autonomie n’est pas déclarée dans un délai de deux (02 mois à compter du jour où elle aura provoqué l’invalidité complète.",0,"J",false);

$pdf->SetXY(105,191);
$pdf->MultiCell(90,3,"Lorsque l’invalidité ne satisfait pas à la définition et aux conditions énoncées précédemment, elle est réputée non avenue et le contrat suit son cours normal.",0,"J",false);



$pdf->SetFont('Arial','B',10);
$pdf->SetXY(105,200);
$pdf->Cell(10,5,"ARTICLE 7 : FONCTIONNEMENT DES GARANTIES",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetXY(105,205);
$pdf->MultiCell(90,3,"1) Date d’effet des garanties ;",0,"J",false);

$pdf->SetXY(105,208);
$pdf->MultiCell(90,3,"Le présent contrat n’a d’existence qu’après sa signature par les parties contractantes.",0,"J",false);


$pdf->SetXY(105,215);
$pdf->MultiCell(90,3,"Cependant, il ne produira réellement ses effets qu’à compter du lendemain à midi du paiement de la première prime et, au plus tôt aux dates et heures indiquées aux Conditions Particulières.
Ces mêmes dispositions s’appliqueront à tout avenant intervenant en cours de contrat.",0,"J",false);


$pdf->SetXY(105,233);
$pdf->MultiCell(90,3,"2) Déclaration de l’assuré et du contractant",0,"J",false);

$pdf->SetXY(105,236);
$pdf->MultiCell(90,3,"La police est rédigée et la prime est fixée exclusivement d’après les déclarations de l’Assuré et du contractant qui doivent en conséquence, faire connaître à la compagnie toutes les circonstances connues d’eux, qui sont de nature à faire apprécier les risques qu’elle prend à sa charge.",0,"J",false);

$pdf->SetXY(105,251);
$pdf->MultiCell(90,3,"Le contrat est incontestable dès qu’il a pris existence, sous réserves des dispositions des articles 21, 75 et 88 de l’ordonnance n° 95-07 du 25 Janvier 1995 modifiée et complétée par la loi 06-04 du 20 février 2006.",0,"J",false);

//3) Expertise 

$pdf->SetXY(105,264);
$pdf->MultiCell(90,3,"3) Expertise ",0,"J",false);
//

$pdf->SetXY(105,267);
$pdf->MultiCell(90,3,"La preuve de Perte Totale et Irréversible d’Autonomie incombe à ",0,"J",false);

$pdf->AddPage();
$pdf->Ln(8);

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90,3,"l’Assuré qui doit faire parvenir à la compagnie les pièces indiquant si l’invalidité est consécutive à une maladie ou à un accident. La compagnie se réserve le droit de faire contrôler l’état de santé de l’Assuré par ses médecins ou par toute autre personne qu’elle désignera.
En cas de contestation d’ordre purement médical, une expertise à frais communs devra intervenir avant tout recours à la voie judiciaire. Chacune des parties désignera un médecin, en cas de désaccord entre eux, ceux-ci s’adjoindront un confrère de leur choix pour les départager, et à défaut d’entente, la désignation en sera faite à la requête de la partie la plus diligente par le président du tribunal du domicile de l’Assuré.",0,"J",false);

$pdf->MultiCell(90,3,"Chaque partie réglera les honoraires de son médecin, ceux du troisième médecin ainsi que les frais relatifs à sa nomination seront supportés en commun accord et par parts égales par les deux parties.",0,"J",false);
$pdf->MultiCell(90,3,"4) Changement dans la situation de l’assuré ",0,"J",false);
$pdf->MultiCell(90,3,"Si l’Assuré change de profession en cours de contrat, il est tenu d’en informer la compagnie immédiatement qui lui donne acte de sa déclaration.",0,"J",false);
$pdf->MultiCell(90,3,"En cas d’aggravation du risque d’invalidité ou de décès la compagnie d’assurance, peut, proposer un nouveau taux de prime. L'assuré est tenu de s'acquitter de la différence de la prime réclamée par l'assureur.
En cas de non-paiement, l'assureur a le droit de résilier le contrat (Article 18 de l’ordonnance n° 95-07 du 25 Janvier 1995 modifiée et complétée par la loi 06-04 du 20 février 2006.)",0,"J",false);
$pdf->MultiCell(90,3,"5) Déclaration en cas de changement de domicile",0,"J",false);
$pdf->MultiCell(90,3,"L’assuré devra informer l’assureur par lettre recommandée de ses changements de domicile. Les lettres adressées au dernier domicile dont la société a eu connaissance produiront tous leurs effets.",0,"J",false);


$pdf->SetFont('Arial','B',10);

$pdf->Cell(10,5,"ARTICLE 8 : PRIME",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90,3,"A l’exception de la première, les primes sont payables au domicile du contractant ou à tout autre lieu convenu.
Conformément aux articles 16 et 84 de l’ordonnance n° 95-07 du 25 janvier 1995 relative aux assurances, modifiée et complétée par la loi 06-04 du 20 février 2006, à défaut de paiement d’une prime dans les quinze jours qui suivent son échéance (article 16), la garantie est suspendue quarante-cinq jours après l’envoi d’une lettre recommandée de mise en demeure adressée au contractant.",0,"J",false);

$pdf->MultiCell(90,3,"Dix jours après l’expiration de ce délai, si la prime et les frais de mise en demeure n’ont pas été acquittés, le contrat sera résilié et les primes payées restent acquises à la compagnie.",0,"J",false);


$pdf->SetFont('Arial','B',10);

$pdf->Cell(10,5,"ARTICLE 9 : PAIEMENT DES SOMMES DUES ",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(90,3,"Le décès de l’Assuré doit être notifié à la compagnie par les ayants droit dans le plus bref délai possible. ",0,"J",false);
$pdf->MultiCell(90,3,"Le paiement des sommes assurées dues est indivisible à l’égard de la compagnie qui règle sur la quittance conjointe au niveau de ses structures habilitées, dans les trente (30) jours qui suivent la remise des pièces justificatives, lesquelles comprennent notamment :",0,"J",false);

$pdf->MultiCell(90,3,"1) En cas de Décès :",0,"J",false);
$pdf->MultiCell(90,3,"En vue du règlement, les pièces à remettre à l’Assureur doivent notamment comprendre : ",0,"J",false);
$pdf->MultiCell(90,3,"- L’acte  de naissance et de décès de l’Assuré,",0,"J",false);
$pdf->MultiCell(90,3,"- Un certificat médical du médecin traitant  apportant les précisions sur la maladie ou l’accident à la suite duquel l’Assuré a succombé,",0,"J",false);
$pdf->MultiCell(90,3,"-Tout document officiel établi à la suite du décès,
- Le tableau d’amortissement ou l’échéancier initial certifié conforme à la date du décès par l’organisme prêteur auprès duquel l’opération financière a été souscrite,
- Un courrier de l’organisme prêteur attestant que l’opération financière avait normalement cours au jour du décès et qu’il n’est intervenu aucun événement juridique de nature à modifier l’engagement initial de l’Assuré.",0,"J",false);
$pdf->MultiCell(90,3,"2) En cas de PTIA",0,"J",false);
$pdf->MultiCell(90,3,"L’Assuré, ou en cas de force majeure son mandataire autorisé, doit apporter la preuve de son état à l’Assureur.
Les pièces à remettre en vue du règlement doivent notamment comprendre :",0,"J",false);
$pdf->MultiCell(90,3,"- Un certificat médical du médecin traitant apportant les précisions nécessaires sur la maladie ou l’accident qui est à l’origine de la perte totale et irréversible d’autonomie, et attestant incapacité de l’assuré d’exercer la moindre activité.
- La date à laquelle s’est déclarée cette invalidité absolue et définitive,",0,"J",false);


// Deuxiemme colonne
$pdf->SetXY(105,26);
$pdf->MultiCell(90,3,"- Le tableau d’amortissement ou l’échéancier certifié conforme par l’organisme prêteur auprès duquel l’opération financière a été souscrite, à la date à laquelle l’Assuré déclare son état de perte totale et irréversible d’autonomie à l’Assureur,
- Un courrier de l’organisme prêteur attestant que l’opération financière avait normalement cours au jour de l’événement et qu’il n’est intervenu aucun fait juridique de nature à modifier l’engagement initial de l’Assuré,
L’Assureur se réserve le droit de demander toute pièce complémentaire qu’il juge nécessaire à l’appréciation de l’état de santé de l’Assuré et de le soumettre à une expertise médicale.
",0,"J",false);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(105,63);
$pdf->Cell(10,5,"ARTICLE 10 : PRESCRIPTION",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetXY(105,68);
$pdf->MultiCell(90,3,"Conformément aux dispositions de l’article 27 de l’ordonnance n°95-07 du 25 janvier 1995 relative aux assurances, modifiée et complétée par la loi 06-04 du 20 février 2006, le délai de prescription, pour toute action de l’assuré ou de l’assureur née du présent contrat d’assurance, est de trois (03) ans, à partir de l’événement qui lui donne naissance.
Toutefois, ce délai cesse de courir en cas de réticence ou de déclaration fausse ou inexacte sur le risque assuré, que du jour où l’assureur en a eu connaissance.
La durée de la prescription ne peut être abrégée par accord des deux parties et peut être interrompue par:
1) les causes ordinaires d’interruption, telles que définies par la loi,
2) la désignation d’experts,
3) l’envoi d’une lettre recommandée par l’assureur à l’assuré, en matière    de paiement de prime,
4) l’envoi d’une lettre recommandée par l’assuré à l’assureur, en ce qui concerne le règlement de l’indemnité.",0,"J",false);


$pdf->SetFont('Arial','B',8);
$pdf->SetXY(105,122);

//

$pdf->Cell(10,5,"ARTICLE 11:REGLEMENT DES LITIGES,LOI ET TRIBUNAL COMPETENT",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetXY(105,127);
$pdf->MultiCell(90,3,"Les litiges entre Assuré ou ses ayants-droit et Assureur, seront tranchés par voie amiable. A défaut, le recours à la voie judiciaire aura lieu conformément à la législation algérienne.
La compétence reviendra au tribunal de la circonscription territoriale duquel la police a été conclue en ce qui concerne les litiges opposant les parties autres que ceux concernant la contestation relative à la fixation et au règlement des indemnités dues.

Ceux inhérents à ladite contestation sont de la compétence du tribunal du domicile de l’Assuré qui peut, toutefois, tout comme les ayants-droit assigner l’Assureur devant le tribunal du lieu du fait générateur de la prestation.
",0,"J",false);

$pdf->Output();

				

?>








