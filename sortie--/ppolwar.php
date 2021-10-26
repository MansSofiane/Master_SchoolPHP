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
        $this->Ln(14);
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
$rqtg=$bdd->prepare("SELECT d.*,t.`mtt_dt`,c.`mtt_cpl`,o.`lib_opt`,p.`code_prod`, s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age`  FROM `policew` as d, `dtimbre` as t , `cpolice` as c,`option` as o,`produit` as p,`souscripteurw` as s  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_opt`=o.`cod_opt` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND d.`cod_pol`='$row'");
$rqtg->execute();

while ($row_g=$rqtg->fetch()){
//$pdf->Ln(2);
    $pdf->SetFillColor(205,205,205);
    $pdf->Cell(190,8,'Assurance Cancer du Sein','0','0','C');$pdf->Ln();
    while ($row_user=$rqtu->fetch()){
        $pdf->Cell(190,8,'Police N° '.$row_user['agence'].'.'.substr($row_g['dat_val'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','0','0','C');$pdf->Ln();$pdf->Ln();
        $pdf->Ln(9);
//$pdf->Cell(190,8,'Devis Gratuit','0','0','C');$pdf->Ln();$pdf->Ln();

        $pdf->SetFont('Arial','',9);
        $pdf->MultiCell(190,3,"Le présent Contrat est régi tant par les dispositions de l’ordonnance 95/07 du 25 Janvier 1995 modifiée et complétée par la Loi N° 06 - 04 du 20 Février 2006 que part les Conditions Générales et les Conditions Particulières. En cas d’incompatibilité entre les Conditions Générales et  Particulières,  les Conditions Particulières  Prévalent  toujours  sur   les   Conditions   Générales.  ",0,"J",false);
        $pdf->SetFont('Arial','B',14);
        $pdf->Ln(3);

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
    $pdf->Cell(40,5,'Capital','1','0','L','1');$pdf->Cell(150,5,"".$row_g['lib_opt']."",'1','0','C');$pdf->Ln();
    $pdf->Cell(40,5,'Effet le','1','0','L','1');$pdf->Cell(55,5,"".date("d/m/Y", strtotime($row_g['ndat_eff']))."",'1','0','C');
    $pdf->Cell(40,5,'Echéance le','1','0','L','1');$pdf->Cell(55,5,"".date("d/m/Y", strtotime($row_g['ndat_ech']))."",'1','0','C');$pdf->Ln();
    $pdf->Cell(40,5,'Garantie','1','0','L','1');$pdf->Cell(150,5,"cancer du sein invasif ",'1','0','C');$pdf->Ln();

    $pdf->Ln(7);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(40,5,'Décompte de la prime ','0','0','L','0');
//
    $pdf->Ln(7);
    $pdf->SetFont('Arial','B',8);
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
    $pdf->SetFont('Arial','',100);
//$pdf->RotatedText(60,240,'Devis-Gratuit',60);

// Fin du traitement de la requete generale
}


$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(205,205,205);
//$pdf->Ln(2);Notice d'information
//$pdf->Image('../img/Notice_information.png',0,0,210,297);


$pdf->Cell(190,8,"CONDITION GENERALE",'0','0','C');
$pdf->Ln();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(190,3,"Visa N° 01 du 22 Octore 2017/Direction des assurances DS/MF",'0','0','C');
$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"I. CADRE JURIDIQUE :",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"Les présentes conditions générales sont régies tant par l’ordonnance N° 75-58 du 26 Septembre 1975 portant code civile modifiée et complétée et par l’ordonnance N° 95-07 du 25 janvier 1995 relative aux assurances modifiée et complétée par la loi N° 06-04 du 20 février 2006 que par le décret exécutif N° 02-293 du 10 Septembre 2002 modifiant et complétant le décret exécutif N° 95-338 du 30 Octobre 1995 relatif à l’établissement et à la codification des opérations d’assurance.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"TITRE I : DISPOSITIONS GENERALES ET GARANTIES",0,0,"J");$pdf->Ln();
$pdf->Cell(10,3,"ARTICLE 1 : DEFINITIONS",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"Assurée :",0,0,"J");
$pdf->SetFont('Arial','',6);
$pdf->Cell(80,3," On entend par « Assurée » toute femme algérienne résidente en Algérie,",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3," désignée sous ce nom aux conditions particulières, âgée entre 18 et 60 ans au jour d’entré en couverture et ne dépassant pas 65 ans à la sortie de couverture.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"Assureur :",0,0,"J");
$pdf->SetFont('Arial','',6);
$pdf->Cell(75,3,"Par « Assureur », on entend, la compagnie d’assurances de personnes « Algerian ",0,0,"J");$pdf->Ln();
$pdf->MultiCell(90,3," Gulf Life Insurance Company » dont le nom commercial est “L’ALGERIENNE VIE” détenant un capital social de 1 000 000 000 DA, sise à 01, Rue tripoli Hussein dey – Alger.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(15,3,"Souscripteur : ",0,0,"J");
$pdf->SetFont('Arial','',6);
$pdf->Cell(75,3,"la personne désignée sous ce nom aux conditions particulières, ou toute",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3," personne qui lui serait substituée par accord des parties, qui souscrit le contrat pour le compte de l’assuré.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(15,3,"Bénéficiaires :",0,0,"J");
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(65,3,"l’assurée lui-même.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"Diagnostic : ",0,0,"J");
$pdf->SetFont('Arial','',6);
$pdf->Cell(70,3,"regroupe l'ensemble des examens pratiqués par un professionnel de santé",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3," pour comprendre la pathologie dont souffre un patient.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(20,3,"Période de carence : ",0,0,"J");
$pdf->SetFont('Arial','',6);
$pdf->Cell(70,3,"Période de 90 jours qui suit la date d’effet pendant laquelle l’assuré",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3," n’est pas couvert et qui ne donne pas droit au paiement de tout ou partie du capital.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(17,3,"Durée de survie: ",0,0,"J");
$pdf->SetFont('Arial','',6);
$pdf->Cell(73,3,"la période allant de la date du premier diagnostic du cancer, jusqu’au",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3," 28ème jour. La personne assurée doit être en vie à la fin de cette période et ne doit pas avoir subi la cessation irréversible de toutes les fonctions du cerveau.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"ARTICLE 2 : OBJET DU CONTRAT",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',5);
$pdf->MultiCell(90,3,"Le présent contrat a pour objet de garantir aux assurées, le versement d’un capital forfaitaire, indiqué dans les conditions particulières, en cas de diagnostic d’un cancer du sein avant le terme du contrat. ",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"ARTICLE 3 : GARANTIE",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',5);
$pdf->MultiCell(90,3,"Cancer du sein Toute affection maligne des seins caractérisée par une croissance et une propagation incontrôlées de cellules malignes envahissant un tissu se présentant sous un aspect histologique différent.Le diagnostic  doit être confirmé de manière histologique.Cette définition ne couvre pas e qui suit :
- Cancer in situ ;
- Toutes affections malignes de la peau ;
- Le témoignage de cellules cancéreuses ou matériel génétique de cancer détecter par des investigations (sondes) moléculaires ou biochimiques (incluant mais sans se limiter au protéomique  ou ADN/ ARN, base technique) sans lésions susceptible aux tissus.Par souci de clarification, toute lésion décrite ou classifiée comme suit n'est pas considérée comme un cancer dans le cadre de la définition précitée :
- pré maligne (suivant la déclaration du médecin)
- non invasive (suivant la déclaration du médecin)
Aucune prestation ne sera due lorsque la date d’apparition des symptômes ou la date de survenance ou de diagnostic de la maladie a lieu durant la période de carence. La période de carence se renouvelle après chaque remise en vigueur de la garantie due à une cessation ou non-renouvellement de la police.La souscription est conditionnée par la réponse à un questionnaire médical et soumise éventuellement à une sélection médicale.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"TITRE II : EXCLUSIONS",0,0,"J");$pdf->Ln();
$pdf->Cell(10,3,"ARTICLE 1 : EXCLUSIONS GENERALES",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',5);
$pdf->MultiCell(90,3,"L’assureur ne sera pas responsable et ne versera aucune indemnisation sur le fondement de la présente police en relation directe ou indirecte ou résultant de l’une des circonstances suivantes :
Les suites et conséquences de l'usage de stupéfiants ou de drogues non prescrits médicalement ;
Les conséquences du VIH, HTVL et du SIDA.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"ARTICLE 2 : EXCLUSIONS SPECIFIQUES, AFFECTATIONS PREEXISTANTES",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"Le capital n’est versé que lors du premier diagnostic d’un cancer Le capital n’est pas versé si la première constatation médicale est antérieure à la date de prise d’effet de la garantie et dont l’assuré a eu connaissance.Cette garantie ne couvre pas ce qui suit :
Cancer in situ ;
Toutes affections malignes de la peau ;
Le témoignage de cellules cancéreuses ou matériel génétique de cancer détecté par des investigations (sondes) moléculaires ou biochimiques (incluant mais sans se limiter au protéomique ou ADN/ARN, base technique) sans lésions susceptible aux tissus.Par souci de clarification, toute lésion décrite ou classifiée comme suit n’est pas considérée comme un cancer dans le cadre de la définition précitée :
- pré maligne (suivant la déclaration du médecin)
- non invasive (suivant la déclaration du médecin)
Aucune prestation ne sera due lorsque la date d’apparition des symptômes à la date de survenance ou de diagnostic de la maladie a lieu durant la période de carence.La période de carence se renouvelle après chaque remise en vigueur de la garantie due à une cessation ou non-renouvellement de la police.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3,"TITRE III : FONCTIONNEMENT DES GARANTIES",0,0,"J");$pdf->Ln();
$pdf->Cell(10,3,"ARTICLE 1 : DELAI DE CARENCE",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"Aucune prestation n’est versée si les premiers symptômes   apparaissent ou si la maladie cancer du sein survient ou est diagnostiquée pour la première fois dans les 90 jours suivant la date d’établissement de la couverture ou la date d’une éventuelle remise en vigueur.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"Dans l’éventualité d’une augmentation du montant de la prestation cancer du sein,  le même délai de carence s’applique pour ce qui est du montant accru, sauf mention contraire dans les conditions particulières.",0,"J",false);
//$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(30,3,"ARTICLE 2 : DUREE DE SURVIE",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"Aucune prestation n’est versée en cas de décès dans les 28 jours suivant la date à laquelle l’assuré répond à la définition d’un cancer du sein.  ",0,"J",false);
//$pdf->Ln();
//DEUXIEMME COLONNE
$pdf->SetXY(105,35);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50,3,"ARTICLE 3 : DECLARATION DE RISQUE",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,38);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"La police est rédigée et la prime est fixée exclusivement d'après les déclarations de l’assurée et du souscripteur qui doivent en conséquence, faire connaitre à la compagnie toutes les circonstances connues de l’assurée notamment son l’état de santé et ses antécédents familiaux, qui sont de nature à faire apprécier les risques qu'elle prend à sa charge.Le contrat est incontestable dès qu’il a pris existence, sous réserves des dispositions des articles 21, 75 et 88 de l’ordonnance N° 95-07 du 25 janvier 1995 modifiée et complétée par la loi 06-04 du 20 février 2006.",0,"J",false);
//$pdf->Ln();
$pdf->SetXY(105,59);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(30,3,"ARTICLE 4 : EFFET DU CONTRAT",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->SetXY(105,62);
$pdf->MultiCell(90,3,"Le présent contrat n’a d’existence et d’effet  qu’après sa signature par les parties contractantes.Cependant, il ne produira réellement ses effets qu’aux dates et heures indiqués aux conditions particulières ou le lendemain à midi de la date de paiement de la première prime.Ces mêmes dispositions s’appliqueront à tout avenant intervenant au cours de contrat.
La garantie cesse de plein droit :
- A 0h00 le jour ou l’assuré atteint son soixantaine cinquième (65ème) anniversaire ;
- Au premier diagnostic d’un cancer du sein ;
- Au décès de l’assuré ;
- L’assuré annule la police ;
- A la fin de la période pour laquelle les primes ont été versées pour les prestations couvertes.",0,"J",false);
$pdf->Ln();
$pdf->SetXY(105,92);
$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,3,"ARTICLE 5 : TERRITOARIALITE",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->SetXY(105,94);
$pdf->MultiCell(90,3,"La couverture est valide dans le monde entier à condition que l’assurée ait sa résidence permanente en Algérie.",0,"J",false);
//$pdf->Ln();
$pdf->SetXY(105,100);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50,3,"ARTICLE 6 : PAIEMENT DES PRIMES",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->SetXY(105,103);
$pdf->MultiCell(90,3,"A l’exception de la prime, les primes sont payables au domicile du contractant ou à tout autre lieu convenu. Conformément aux articles 16 et  84 de l’ordonnance n° 95?07 du 25 janvier 1995 relative aux assurances, modifiée et complétée par la loi 06?04 du 20 février 2006, à défaut de paiement d'une prime dans les quinze jours  qui suivent  son échéance  (article 16), la garantie est sus? pendue quarante?cinq jours après l’envoi d'une lettre recommandée de mise en demeure adressée au contractant.Dix (10)  jours  après l’expiration   de ce délai, si la prime et les frais de mise en demeure n’ont pas été acquittés, le contrat sera résilié et les primes payées restent acquises à la compagnie.",0,"J",false);
//$pdf->Ln();
$pdf->SetXY(105,127);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50,3,"ARTICLE 7 : RESILIATION DU CONTRAT",0,0,"J");$pdf->Ln();
$pdf->SetFont('Arial','',6);
$pdf->SetXY(105,130);
$pdf->MultiCell(90,3,"L’assurée a la faculté de de résilier de plein droit son contrat par lettre recommandée avec accusé de réception adressée deux (02) mois avant la date d’échéance du contrat.",0,"J",false);
$pdf->Ln();
$pdf->SetXY(105,136);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50,3,"TITRE IV : REGLEMENT DES SINISTRES",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,139);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50,3,"ARTICLE 1 : DECLARATION DE SINISTRE",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,142);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"L’assurée, ou toute autre personne mandatée par cette dernière  devront aviser par tout moyen écrit l’assureur dès diagnostic du cancer du sein garanti.",0,"J",false);
$pdf->Ln();
$pdf->SetXY(105,147);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50,3,"ARTICLE 2 : DELAI DE DECLARATION",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,149);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"Toute déclaration d’un cancer du sein invasif doit être transmise à l’assureur au maximum trente (30) jours à compter de la date à laquelle l’assuré a été diagnostiqué malade.Les informations nécessaires à la déclaration :
- Date d’apparition de la maladie
- Date de prise de connaissance de l’assuré de la maladie.
- Antécédent familial et l’antécédent médical
- Facteur de risque
- Police avec d’autre compagnie",0,"J",false);
//$pdf->Ln();
$pdf->SetXY(105,173);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(90,3,"ARTICLE 3 : DOSSIER A FOURNIR EN CAS DE DIAGNOSTIC D’UN CANCER DU SEIN",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,175);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"En cas de sinistre, le dossier doit comprendre les pièces suivantes :
- Déclaration du sinistre ;
- L’original du contrat précisant les garanties ;
- Acte de naissance de l’assuré ou pièce d’identité ;
- Rapport du médecin traitant donnant le pronostique ;
- Compte rendu daté et signé de l’examen ayant permis de confirmer le diagnostic ;
- Rapport des examens médicaux ;
- Rapports médicaux complémentaires et toute autre document que l’assureur jugera utile ;
- Ainsi que tous autres documents jugés nécessaire par l’assureur.Il est important de noter que le nom de l’assuré, le prénom et la date d’établissement de l’examen doivent apparaitre sur tous les rapports et comptes rendus médicaux.",0,"J",false);

$pdf->SetXY(105,208);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(50,3,"ARTICLE 4 : PAIEMENT DES GARANTIES",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,210);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(90,3,"Les prestations seront versées lorsque le risque objet de la garantie se réalise, le montant de la prestation est indiqué aux conditions particulières.Le règlement des prestations sera effectué dans un délai de trente (30) jours, à partir de la date de la remise de la dernière pièce justificative nécessaire.",0,"J",false);
//$pdf->Ln();
$pdf->SetXY(105,222);
$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,3,"TITRE V : PRESCRIPTION ET REGLEMENT DE LITIGE",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,224);
$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,3,"ARTICLE 1 : PRESCRIPTION",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,226);
$pdf->SetFont('Arial','',5);
$pdf->MultiCell(90,3,"Conformèrent aux  dispositions de l'article 27 de l’ordonnance n°95?07 du 25 janvier 1995 relative aux assurances, modifiée et complétée par la loi 06?04 du 20 février 2006,le délai de prescription,pour toute action de l'assure ou de l’assureur née du présent contrat d'assurance, est de trois (03) ans, à partir de l’évènement qui lui donne naissance.Toutefois, ce délai cesse de courir en cas de réticence ou de déclaration fausse ou inexacte sur le risque assuré, que du jour ou l’assureur en a eu connaissance.La durée de la prescription  ne peut être  abrégée par accord des deux parties et peut être interrompue  par:
- Les causes ordinaires d’interruption, telles que définies par la loi,
- La désignation d’experts,
- L’envoi d’une lettre recommandée  par L’assureur à l’assure, en matière de paiement de prime,
- L’envoi d’une lettre recommandée par l’'assuré à L’assureur, en ce qui concerne le règlement de l'indemnité.",0,"J",false);

$pdf->SetXY(105,255);
$pdf->SetFont('Arial','B',5);
$pdf->Cell(60,3,"ARTICLE 2 : REGLEMENT DE LITIGE, LOI ET TRIBUNAL COMPETANT",0,0,"J");$pdf->Ln();
$pdf->SetXY(105,257);
$pdf->SetFont('Arial','',5);
$pdf->MultiCell(90,3,"Les litiges entre assuré ou ses ayants droit et assureur seront tranchés par voie aimable.A défaut, le défaut le recours à la voie judiciaire aura lieu conformément à la législation algérienne.La compétence   reviendra au tribunal   de la circonscription  territoriale    duquel la police a été conclue en ce qui concerne   les litiges opposant   les parties autres que ceux concernant  la contestation relative à la fixation et au règlement des indemnités dues.Ceux inhérent à ladite contestation sont de la compétence de tribunal du domicile de l’assuré qui peut assigner l’assureur devant le tribunal du lieu du fait générateur de la prestation .",0,"J",false);

$pdf->Output();

?>








