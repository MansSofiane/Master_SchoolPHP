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
$pdf->Ln(2);
$pdf->SetFillColor(205,205,205);
$pdf->Cell(190,8,'Assurance Voyage et assistance','0','0','C');$pdf->Ln();
$pdf->Ln(5);
$pdf->Cell(95,8,'Devis N°: ','0','0','R');$pdf->Cell(50,8,$row,'0','0','L');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',14);

$pdf->SetFillColor(7,27,81);
$pdf->SetTextColor(255,255,255);



//Requete generale
$rqtg=$bdd->prepare("SELECT d.*,t.`mtt_dt`,c.`mtt_cpl`,o.`lib_opt`,p.`code_prod`,s.`id_emprunteur`, s.`nom_sous`, s.`pnom_sous`,
s.`mail_sous`, s.`tel_sous`, s.`adr_sous`, s.`rp_sous`,s.`dnais_sous`,s.`age` ,s.`nom_jfille`,r.`lib_per` FROM `devisw` as d,
`dtimbre` as t , `cpolice` as c,`option` as o,`produit` as p,`souscripteurw` as s ,`periode` as r  WHERE d.`cod_dt`=t.`cod_dt`
 AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_opt`=o.`cod_opt` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous`
 AND d.`cod_per`=r.`cod_per` AND d.`cod_dev`='$row'");
$rqtg->execute();

while ($row_g=$rqtg->fetch()){
// debut du traitement de la requete generale

    //Le Réseau
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(190,5,"Agence",'1','1','C','1');
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(221,221,221);
    while ($row_user=$rqtu->fetch())
    {
        $adr=$row_user['adr_user'];
        $pdf->Cell(40,5,'Code','1','0','L','1');$pdf->Cell(55,5,"".$row_user['agence']."",'1','0','C');
        $pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(55,5,"".$row_user['adr_user']."",'1','0','C');$pdf->Ln();
        $pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_user['tel_user']."",'1','0','C');
        $pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_user['mail_user']."",'1','0','C');$pdf->Ln();
    }
// Le Souscripteur
    $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln(3);
    $pdf->Cell(190,5,'Souscripteur ','1','1','C','1');
    $pdf->SetFillColor(221,221,221);
    $pdf->SetFont('Arial','B',8);


    $pdf->Cell(40,5,'Nom et Prénom','1','0','L','1');
    $pdf->Cell(150,5,"".$row_g['nom_sous']." ".$row_g['pnom_sous']."",'1','0','L');$pdf->Ln();
    $pdf->Cell(40,5,'D.Naissance','1','0','L','1');$pdf->Cell(55,5,"".date("d/m/Y",strtotime($row_g['dnais_sous']))."",'1','0','L');
    $pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(55,5,"".$row_g['adr_sous']."",'1','0','L');$pdf->Ln();
    $pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_g['tel_sous']."",'1','0','L');
    $pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_g['mail_sous']."",'1','0','L');$pdf->Ln();

    $pdf->Ln(3);
// L'assuré

// la condition sur le souscripteur et l'assure
    if($row_g['rp_sous']==1)
    {
        $pdf->SetFillColor(199,139,85);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetTextColor(255,255,255);

        $pdf->Cell(190,5,'Co-Emprunteur ','1','1','C','1');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(221,221,221);
        $pdf->SetFont('Arial','B',8);
// le souscripteur n'est pas l'assuré
        $rowa=$row_g['cod_sous'];
        $rqta=$bdd->prepare("SELECT s.`id_emprunteur`, s.`nom_sous`, s.`pnom_sous`, s.`mail_sous`, s.`tel_sous`, s.`adr_sous`,
s.`rp_sous`,s.`dnais_sous`,s.`age`,s.`nom_jfille`  FROM `souscripteurw` as s  WHERE  s.`cod_par`='$rowa'");
        $rqta->execute();
        while ($row_a=$rqta->fetch()){
            $pdf->Cell(40,5,'ID Co-emprunteur','1','0','L','1');
            $pdf->Cell(150,5,"".$row_a['id_emprunteur']);$pdf->Ln();
            $pdf->Cell(40,5,'Nom et Prénom','1','0','L','1');$pdf->Cell(150,5,"".$row_a['nom_sous']." ".$row_a['pnom_sous']."",'1','0','L');$pdf->Ln();
            $pdf->Cell(40,5,'Nom jeune fille','1','0','L','1');$pdf->Cell(55,5,"".$row_a['nom_jfille']."",'1','0','L');
            $pdf->Cell(40,5,'D.Naissance','1','0','L','1');$pdf->Cell(55,5,"".date("d/m/Y",strtotime($row_a['dnais_sous']))."",'1','0','L');$pdf->Ln();
            $pdf->Cell(40,5,'Adresse','1','0','L','1');$pdf->Cell(150,5,"".$row_a['adr_sous']."",'1','0','L');$pdf->Ln();
            $pdf->Cell(40,5,'Téléphone','1','0','L','1');$pdf->Cell(55,5,"".$row_a['tel_sous']."",'1','0','L');
            $pdf->Cell(40,5,'E-mail','1','0','L','1');$pdf->Cell(55,5,"".$row_a['mail_sous']."",'1','0','L');$pdf->Ln();
        }
//fin de la condition
    }

// Contrat
    $pdf->Ln(3);
    $pdf->SetFillColor(7,27,81);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(190,5,' Adhésion ','1','0','C','1');$pdf->Ln();
    $pdf->SetFillColor(221,221,221);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(40,5,'Effet le','1','0','L','1');$pdf->Cell(55,5,"".date("d/m/Y", strtotime($row_g['dat_eff']))."",'1','0','L');
    $pdf->Cell(40,5,'Echéance le','1','0','L','1');$pdf->Cell(55,5,"".date("d/m/Y", strtotime($row_g['dat_ech']))."",'1','0','L');$pdf->Ln();
    $pdf->Cell(40,5,'Durée','1','0','L','1');$pdf->Cell(150,5,"".$row_g['lib_per']."",'1','0','L');$pdf->Ln();

    $pdf->Ln(3);
    $pdf->SetFillColor(7,27,81);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(190,5,' Garanties et Capital assuré','1','0','C','1');$pdf->Ln();
    $pdf->SetFillColor(221,221,221);$pdf->SetTextColor(0,0,0);
    $pdf->Cell(95,5,'Garanties Décès /IAD Toutes causes ','1','0','L','1');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(95,5,"".number_format($row_g['cap1'], 2, ',', ' ')." DZD",'1','0','C');$pdf->Ln();
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(95,5,' Prime Totale  ','1','0','L','1');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(95,5,"".number_format($row_g['pt'], 2, ',', ' ')." DZD",'1','0','C');$pdf->Ln();
    $pdf->Ln(7);
    //afficher la prime en lettre.
    $somme=$a1->ConvNumberLetter("".$row_g['pt']."",1,0);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(30,5,"Le montant à payer en lettres",'0','0','L');$pdf->Ln();
    $pdf->SetFont('Arial','B',12);$pdf->SetFillColor(255,255,255);
    $pdf->MultiCell(190,12,"".$somme."",1,'C',true);
    $pdf->Ln(7);
    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(0,6,"- Je souhaite m'assurer contre le risque de décès,Invalidité Absolue et Définitive sur le capital restant dû a l'exclusion des impayés, au profit de BNA.",0,'L',true);
    $pdf->MultiCell(0,6,"- Je déclare avoir pris connaissance de toutes les conditions d'assurance.",0,'L',true);
    $pdf->MultiCell(0,6,"- Je suis informé(e) que conformément a l'ordonnance n°95-07 modifée et compléetée par la loi n° 06-04 du 20 Février 2006. toute réticence ou fausse déclaration intentionnelle entaîne la nullité de l'adhésion à l 'assurance.",0,'L',true);
    $pdf->Ln(2);$pdf->Ln(2);
    $pdf->Ln(2);
    $pdf->Ln(2);


    $pdf->Cell(185,5,"".$adr." le ".date("d/m/Y", strtotime($row_g['dat_dev']))."",'0','0','R');$pdf->Ln();
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(60,5,"Signature de l'Emprunteur",'0','0','L');$pdf->Cell(60,5,"Signature du Co-emprunteur",'0','0','C');;$pdf->Cell(0,5,"Signature et cachet de l 'agence",'0','0','R');$pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(60,5,"Précedé de la mention «Lu et approuvé»",'0','0','L'); $pdf->Cell(60,5,"Précedé de la mention «Lu et approuvé»",'0','0','C');$pdf->Ln();
    $pdf->SetFont('Arial','',100);$pdf->SetFillColor(0,0,255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->RotatedText(60,240,'Devis-Gratuit',60);



// Fin du traitement de la requete generale
}



$pdf->Output();



?>








