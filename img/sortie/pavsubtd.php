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
$pdf->SetFont('Arial','B',12);
//Requete generale
$rqtg=$bdd->prepare("SELECT d.*,t.`mtt_dt`,c.`mtt_cpl`,o.`lib_opt`,p.`code_prod`, s.`cod_sous`, s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age`,z.sequence as seq2, z.dat_val as datev  ,b.`nom_benef`, b.`ag_benef`,b.`tel_benef`,b.`adr_benef`
FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`option` as o,`produit` as p,`souscripteurw` as s, `beneficiaire` as b
WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_opt`=o.`cod_opt` AND d.`cod_prod`=p.`cod_prod` AND s.`cod_sous`=b.`cod_sous`
AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND d.`cod_av`='$row'");
$rqtg->execute();

while ($row_g=$rqtg->fetch()){
//$pdf->Ln(2);
    $pdf->SetFillColor(205,205,205);
    $pdf->Cell(190,6,'Assurance Temporaire Au Décès','0','0','C');$pdf->Ln();
    while ($row_user=$rqtu->fetch()){
        $pdf->Cell(190,6,"Avenant de subrogation",'0','0','L');$pdf->Ln();
        $pdf->Cell(190,6,'Avenant N° '.$row_user['agence'].'.'.substr($row_g['dat_val'],0,4).'.'.$row_g['lib_mpay'].'.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','0','0','L');$pdf->Ln();
        $pdf->Cell(190,6,'Police N° '.$row_user['agence'].'.'.substr($row_g['datev'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['seq2'],'5',"0",STR_PAD_LEFT).'','0','0','L');$pdf->Ln();
        $pdf->SetFont('Arial','I',6);
        $pdf->MultiCell(190,3,"Le présente avenant est régi tant par l’ordonnance N° 75-58 du 26 septembre 1975 portant code civil modifiée et complétée et par l’ordonnance N° 95-07 du 25 janvier 1995 relative aux assurances modifiée et complétée par la loi N° 06-04 du 20 février 2006 que par le décret exécutif N° 02-293 du 10 septembre 2002 modifiant et complétant le décret exécutif N° 95-338 du 30 octobre 1995 relatif à l’établissement et à la codification des opérations d’assurance",0,'J',false);$pdf->Ln(2);
        //$pdf->Cell(190,8,'Devis Gratuit','0','0','C');$pdf->Ln();$pdf->Ln();
        $pdf->SetFont('Arial','B',14);
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
        $pdf->Cell(40,4,'Code','1','0','L','1');$pdf->Cell(55,4,"".$row_user['agence']."",'1','0','C');
        $pdf->Cell(40,4,'Adresse','1','0','L','1');$pdf->Cell(55,4,"".$row_user['adr_user']."",'1','0','C');$pdf->Ln();
        $pdf->Cell(40,4,'Téléphone','1','0','L','1');$pdf->Cell(55,4,"".$row_user['tel_user']."",'1','0','C');
        $pdf->Cell(40,4,'E-mail','1','0','L','1');$pdf->Cell(55,4,"".$row_user['mail_user']."",'1','0','C');$pdf->Ln();
    }
// debut du traitement de la requete generale
// Le Souscripteur
    $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln(3);
    $pdf->Cell(190,5,'Souscripteur ','1','1','C','1');
    $pdf->SetFillColor(221,221,221);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(40,4,'Nom et Prénom','1','0','L','1');
    $pdf->Cell(150,4,"".$row_g['nom_sous']." ".$row_g['pnom_sous']."",'1','0','C');$pdf->Ln();
    $pdf->Cell(40,4,'Adresse','1','0','L','1');$pdf->Cell(150,4,"".$row_g['adr_sous']."",'1','0','C');$pdf->Ln();
    $pdf->Cell(40,4,'Téléphone','1','0','L','1');$pdf->Cell(55,4,"".$row_g['tel_sous']."",'1','0','C');
    $pdf->Cell(40,4,'E-mail','1','0','L','1');$pdf->Cell(55,4,"".$row_g['mail_sous']."",'1','0','C');$pdf->Ln();
    $pdf->Ln(2);
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
        $pdf->Cell(40,4,'Nom et Prénom','1','0','L','1');$pdf->Cell(150,4,"".$row_g['nom_sous']." ".$row_g['pnom_sous']."",'1','0','C');$pdf->Ln();
        $pdf->Cell(40,4,'Adresse','1','0','L','1');$pdf->Cell(150,4,"".$row_g['adr_sous']."",'1','0','C');$pdf->Ln();
        $pdf->Cell(40,4,'Téléphone','1','0','L','1');$pdf->Cell(55,4,"".$row_g['tel_sous']."",'1','0','C');
        $pdf->Cell(40,4,'E-mail','1','0','L','1');$pdf->Cell(55,4,"".$row_g['mail_sous']."",'1','0','C');$pdf->Ln();

    }else{
// le souscripteur n'est pas l'assuré
        $rowa=$row_g['cod_sous'];
        $rqta=$bdd->prepare("SELECT s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age`  FROM `souscripteurw` as s  WHERE  s.`cod_par`='$rowa'");
        $rqta->execute();
        while ($row_a=$rqta->fetch()){
            $pdf->Cell(40,4,'Nom et Prénom','1','0','L','1');$pdf->Cell(150,4,"".$row_a['nom_sous']." ".$row_a['pnom_sous']."",'1','0','C');$pdf->Ln();
            $pdf->Cell(40,4,'Adresse','1','0','L','1');$pdf->Cell(150,4,"".$row_a['adr_sous']."",'1','0','C');$pdf->Ln();
            $pdf->Cell(40,4,'Téléphone','1','0','L','1');$pdf->Cell(55,4,"".$row_a['tel_sous']."",'1','0','C');
            $pdf->Cell(40,4,'E-mail','1','0','L','1');$pdf->Cell(55,4,"".$row_a['mail_sous']."",'1','0','C');$pdf->Ln();
        }
//fin de la condition
    }
    $pdf->Ln();
    //CONTRAT
    $pdf->SetFillColor(7,27,81);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(190,5,' Avenant de subrogation','1','0','C','1');$pdf->Ln();
    $pdf->SetFillColor(221,221,221);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(40,4,"Branche",'1','0','L','1');$pdf->Cell(55,4,"Décès",'1','0','C');
    $pdf->Cell(40,4,'Nature du risque assuré','1','0','L','1');$pdf->Cell(55,4,"Décès et Invalidité Absolue et Définitive",'1','0','C');$pdf->Ln();
    $pdf->Cell(40,4,'Montant de crédit en chiffre','1','0','L','1');$pdf->Cell(150,4,"".number_format($row_g['cap1'], 2, ',', ' ')." DZD",'1','0','L');$pdf->Ln();
    $montant=$a1->ConvNumberLetter("".$row_g['cap1']."",1,0);
    $pdf->Cell(40,4,'Montant de crédit en lettre','1','0','L','1');$pdf->Cell(150,4,"".$montant."",'1','0','L');$pdf->Ln();
    $pdf->Cell(40,4,"Date d'effet de l'avenant",'1','0','L','1');$pdf->Cell(55,4,"".date("d/m/Y", strtotime($row_g['dat_val']))."",'1','0','C');
    $pdf->Cell(40,4,'Expire le','1','0','L','1');$pdf->Cell(55,4,"".date("d/m/Y", strtotime($row_g['ndat_ech']))."",'1','0','C');$pdf->Ln();
    $pdf->Ln(3);
// Beneficiaire (Organisme preteur)

    $pdf->SetFillColor(7,27,81);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(190,5,' Etablissement préteur','1','0','C','1');$pdf->Ln();
    $pdf->SetFillColor(221,221,221);$pdf->SetTextColor(0,0,0);
    $pdf->Cell(35,4,'Organisme préteur','1','0','L','1');$pdf->Cell(155,4,"".$row_g['nom_benef']."",'1','0','L');$pdf->Ln();
    $pdf->Cell(35,4,'Code agence','1','0','L','1');$pdf->Cell(155,4,"".$row_g['ag_benef']."",'1','0','L');$pdf->Ln();
    $pdf->Cell(35,4,'Téléphone','1','0','L','1');$pdf->Cell(155,4,"".$row_g['tel_benef']."",'1','0','L');$pdf->Ln();
    $pdf->Cell(35,4,'Adresse','1','0','L','1');$pdf->Cell(155,4,"".$row_g['adr_benef']."",'1','0','L');$pdf->Ln();
    $pdf->Ln(4);
    $pdf->SetFont('Arial','',8);
    $pdf->MultiCell(190,4,"A la demande de l’assuré, il est convenu d’un commun accord entre les parties au contrat d’assurance, qu’aucune somme ne sera versée au titre de l’indemnité résultant d’un  risque  assuré par la  police d’assurance susmentionnée  sans l’intervention et qu’entre les mains de l’établissement ci-dessus désigné en tant que créancier.
Cette renonciation à l’indemnité est consentie par l’assuré emprunteur en vue de favoriser le crédit de ce dernier et elle ne saurait lui profiter personnellement.Par conséquent, l’établissement prêteur est subrogé dans les droits de l’assuré emprunteur, pour percevoir l’indemnité d’assurance en tant que bénéficiaire de celle-ci, l’indemnité sera réglée au créancier susmentionné qui ne peut faire valoir ses droits que sur l’indemnité fixée par AGLIC.
En cas de décès de l’emprunteur, l’assureur versera à l’établissement prêteur le reliquat du crédit impayé par l’emprunteur. Le versement est forfaitaire et se fait donc en une seule fois.Si l’emprunteur est atteint d’invalidité le régime d’indemnisation est le même qu’en matière de décès et le remboursement se fera également sous la forme d’un versement forfaitaire. 
Nonobstant cette renonciation consentie, le créancier susmentionné n’aura droit à aucune indemnité, si AGLIC établissait que celui-ci a eu connaissance, avant le sinistre, des circonstances aggravantes ou que ce dernier avait causé intentionnellement le sinistre ou facilité sa survenance.Le droit pour AGLIC de résilier le contrat, lors de toutes infractions constatées, demeure entier.  
Il appartient au créancier d’établir l’ordre et le rang de l’attribution de sa créance et ce, conformément à la législation en vigueur.Il n’est rien changé aux autres clauses et conditions tant générales que particulières de la police d’assurance à laquelle le présent avenant est annexé pour en faire partie intégrante.",0,'J',false);

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,4,'Décompte de la prime ','0','0','L'); $pdf->Ln(3);
    $pdf->Ln(3);

    $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(45,4,' Prime Nette ','1','0','C','1');$pdf->Cell(45,4,' Cout de Police ','1','0','C','1');
    $pdf->Cell(50,4,' Droit de timbre ','1','0','C','1');$pdf->Cell(50,4,' Prime Totale (DZD) ','1','0','C','1');
    $pdf->Ln();$pdf->SetFont('Arial','B',8);
    $pdf->Cell(45,4,"".number_format($row_g['pn'], 2, ',', ' ')."",'1','0','C');
    $pdf->Cell(45,4,"".number_format($row_g['mtt_cpl'], 2, ',', ' ')."",'1','0','C');
    $pdf->Cell(50,4,"".number_format($row_g['mtt_dt'], 2, ',', ' ')."",'1','0','C');
    $pdf->Cell(50,4,"".number_format($row_g['pt'], 2, ',', ' ')."",'1','0','C');$pdf->Ln();
    $pdf->Ln(2);
    $pdf->SetFont('Arial','I',5);
    $pdf->MultiCell(190,3,"J’atteste de l'exactitude des informations communiquées et reconnais avoir été informé des conséquences qui pourraient résulter d'une omission ou d'une déclaration erronée tel que prévues par l'article 19 de l'Ordonnance N° 95/07 du 25 Janvier 1995 relative aux assurances modifiée et complétée par la loi N° 06/04 du 20 Février 2006.",0,'J',false);
//$pdf->Cell(0,6,"Le Souscripteur reconnait également avoir été informé du contenu des Conditions Particulières et des Conditions Générales et avoir été informé du montant de la prime et des garanties dûes.",0,0,'C');



    $pdf->Cell(185,4,"".$adr." le ".date("d/m/Y", strtotime($row_g['dat_val']))."",'0','0','R');$pdf->Ln();

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60,4,"L'assuré",'0','0','L');$pdf->Cell(60,4,"Le bénéficiaire",'0','0','C');$pdf->Cell(60,4,"L'assureur",'0','0','R');$pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(60,4,"Précedé de la mention «Bon pour subrogation»",'0','0','L');$pdf->Ln();

}



$pdf->Output();



?>








