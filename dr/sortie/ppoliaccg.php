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
$rqtu=$bdd->prepare("select * from utilisateurs where  id_user ='".$_SESSION['id_usersal']."'");
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
$pdf->Cell(185,5,"".$adr." le ".date("d/m/Y", strtotime($row_g['dat_val']))."",'0','0','R');$pdf->Ln();
$pdf->Ln(2);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,5,"Le souscripteur",'0','0','C');$pdf->Cell(120,5,"L'assureur",'0','0','R');$pdf->Ln();
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
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,5,"Assurance Individuelle Accident code 1.1",0,0,"C");
$pdf->Ln(8);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,"Conditions Générales",0,0,"C");

$pdf->Ln(7);

$pdf->SetFont('Arial','',7);
$pdf->MultiCell(90,4,"Les présentes conditions générales sont régies tant par l?ordonnance N° 75-58 du 26 septembre 1975 portant code civil modifiée et complétée et par l?ordonnance N° 95-07 du 25 janvier 1995 relative aux assurances modifiée et complétée par la loi N° 06-04 du 20 février ",0,"J");
$pdf->SetFont('Arial','',7);
$pdf->SetXY(108,48);
$pdf->MultiCell(80,4,"2006 que par le décret exécutif N° 02-293 du 10 septembre 2002 modifiant et complétant le décret exécutif N° 95-338 du 30 octobre 1995 relatif à l?établissement et à la codification des opérations d?assurance.",0,"J");

$pdf->Ln(4);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,5,"CHAPITRE I : DISPOSITIONS GENERALES",0,0,"C");
$pdf->Ln(7);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(90,4,"ARTICLE 01 : OBJET DU CONTRAT ",0,"J");
$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(90,4,"Le présent contrat a pour objet de garantir, dans les limites stipulées au contrat, le paiement des indemnités fixées par les parties contractantes aux Conditions Particulières, dans le cas où l?Assuré serait victime d?accident corporel tant au cours de sa vie professionnelle qu?en dehors de celle-ci.",0,"J");
$pdf->Ln(1);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(90,4,"ARTICLE 02 : DEFINITIONS",0,"J");
$pdf->Ln(1);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(13,4,"Assureur :",0,0,"J");
$pdf->SetFont('Arial','',7);
$pdf->Cell(80,4,"Par «Assureur»,on entend,la compagnie d?assurances de personnes",0,0,"L");$pdf->Ln();
$pdf->MultiCell(90,4,"« Algerian Gulf Life Insurance Company » par abréviation « AGLIC » dont le nom commercial est ?L?ALGERIENNE VIE? détenant un capital social de 1 000 000 000 DA, sise Centre des affaires El QODS -Esplanade - 4ème Etage Chéraga ? Alger",0,"J");
$pdf->Ln(1);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(17,4,"Souscripteur :",0,0,"J");
$pdf->SetFont('Arial','',7);
$pdf->Cell(80,4," Par ?Souscripteur?, on entend, la personne   désignée  sous  ce",0,0,"L");$pdf->Ln();
$pdf->MultiCell(90,4,"nom aux conditions particulières, ou toute personne qui lui serait substituée par accord des parties. , qui souscrit le contrat pour le compte de l?assuré.",0,"J");
$pdf->Ln(1);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(14,4,"Accident :",0,0,"J");
$pdf->SetFont('Arial','',7);
$pdf->Cell(80,4," Par « accident », il faut   entendre  tout   événement   soudain   et",0,0,"L");$pdf->Ln();
$pdf->MultiCell(90,4,"imprévisible provenant exclusivement et directement de l?action d?une cause extérieure ayant pour conséquence une atteinte corporelle non intentionnelle de la part de l?Assuré.",0,"J");
$pdf->Ln(1);


$pdf->SetFont('Arial','B',7);
$pdf->Cell(17,4,"Bénéficiaires :",0,0,"J");
$pdf->SetFont('Arial','',7);
$pdf->Cell(80,4," La ou les personne (s) désigné (s) par l?assuré pour bénéficier",0,0,"L");$pdf->Ln();
$pdf->MultiCell(90,4,"  du capital garanti.",0,"J");
$pdf->Ln(1);









$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(90,4,"ARTICLE 03 : ETENDUE TERRITORIALE DE LA GARANTIE ",0,"J");
$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(90,4,"La garantie est étendue au monde entier pour les indemnités dues en cas de mort, d?incapacité permanente, d?hospitalisation, d?incapacité temporaire, des frais médicaux et pharmaceutiques dans la mesure où ces prestations sont prévues aux conditions particulières.

Toutefois, pour les séjours à l?étranger, la garantie n?est acquise que pour les séjours n?excédant pas trois mois.

Au-delà de ce délai, l?Assuré est tenu d?aviser l?Assureur qui pourra subordonner le maintien de la garantie au paiement d?une surprime.

Dans tous les cas, les indemnités sont toujours payées en Algérie et en Dinars algériens. ",0,"J");
$pdf->Ln(1);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(90,4,"ARTICLE 04 : RISQUES GARANTIS",0,"J");
$pdf->Ln(1);
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(90,4,"Sont toujours garantis dans le cadre de cette assurance, les accidents survenant dans les circonstances suivantes :
Ceux résultant de la pratique des sports en qualité d?amateur : Chasse (sauf de bêtes fauves), pêche (sauf sous-marine), natation canotage, athlétisme, gymnastique, escrime, judo, tennis, golf, patinage, Hockey (sauf sur glace), football (sauf à titre professionnel), tir, camping, boules, basket-ball, water-polo, y compris la participation aux matchs et concours afférents à ces sports, équitation non comprise.",0,"J");


$pdf->SetFont('Arial','',7);
$pdf->SetXY(108,75);
$pdf->MultiCell(80,4,"Les accidents survenus à la suite d?attentat dont l?assuré serait victime, d?asphyxie involontaire, par immersion, par dégagement de gaz ou de vapeur ou par électrocution.
Ceux survenant en cas de légitime défense ou tentative de sauvetage de personnes ou de biens.
La noyade non intentionnelle.

Les accidents causés par les brûlures ou la foudre.

L?infection du sang provenant directement d?un accident garanti.

L?empoisonnement ou les brûlures, causées soit par des produits vénéneux ou corrosifs absorbés par erreur ; soit dus à l?action criminelle d?un tiers, à l?exclusion de tout autre cas d?infection ou d?empoisonnement.

Les accidents causés par des inoculations infectieuses dues à des piqûres anatomiques ou septiques, les cas de rage ou de charbon consécutifs à des morsures ou piqûres d?insectes et d?animaux.
Les conséquences d?actes médicaux ou chirurgicaux, consécutifs à un accident garanti.
",0,"J");
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(111,162);
$pdf->MultiCell(80,3,"ARTICLE 05 : EXTENTIONS DE GARANTIES ",0,"J");

$pdf->SetFont('Arial','',7);
$pdf->SetXY(108,167);
$pdf->MultiCell(80,4,"Ne sont garantis que si mention expresse en est faite aux Conditions Particulières et perception d'une prime spéciale tous les accidents résultant :
De la pratique de tous les sports à titre professionnel :

Equitation, polo, football, rugby, boxe, judo, ski nautique, yachting, pêche en mer, luge, ski. - Hockey sur glace, alpinisme (ascensions de glaciers ou hauts sommets avec guides autorisés).

Bobsleigh, Skelton, kayak, canotage en périssoire, canoë ou embarcation de même nature sur eaux douces ou marines.

Explorations souterraines, exploration et pêche sous-marine.

Rallyes à bord de véhicules automobiles, ou motocyclettes, vélomoteurs, scooters quelle qu?en soit la cylindrée ou paris, courses, matchs ou compétitions et à leurs essais préparatoires.

De l?usage, comme conducteur ou passager de véhicules à moteur à deux roues ou trois roues d?une cylindrée supérieure à 50 cm3.
De la pratique à titre amateur : De l?alpinisme, la spéléologie, les sports aériens et de l?aviation de tourisme, excursion en montagne.

L?exercice du métier de navigant (marin, aviateur, hôtesse de l?air etc...).",0,"J");




$pdf->Output();	

				

?>








