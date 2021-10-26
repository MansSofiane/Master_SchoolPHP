<?php
session_start();
if ($_SESSION['login']){
//authentification acceptee !!!

}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}
require_once("../../../data/conn7.php");
include("convert.php");
$a1 = new chiffreEnLettre();
$errone = false;
require('tfpdf.php');
if (isset($_REQUEST['warda'])) {
    $row = substr($_REQUEST['warda'],10);
    //echo "<script type="."'text/JavaScript'"."> alert("."'$row'".");  </script>"; 
}
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
        $this->Ln(14);
    }

    /* function Footer()
     {
         // Positionnement ? 1,5 cm du bas
         $this->SetY(-15);

         // Police Arial italique 8
         $this->SetFont('Arial','I',6);
         // Num?ro de page
         $this->Cell(0,8,'Page '.$this->PageNo().'/{nb}',0,0,'C');$this->Ln(3);
         $this->Cell(0,8,"Algerian Gulf Life Insurance Company, SPA au capital social de 1.000.000.000 de dinars alg�riens, 01 Rue Tripoli, Hussein Dey Alger,  ",0,0,'C');
         $this->Ln(2);
         $this->Cell(0,8,"RC : 16/00-1009727 B 15   NIF : 001516100972762-NIS :0015160900296000",0,0,'C');
         $this->Ln(2);
         $this->Cell(0,8,"Tel : +213 (0) 21 77 30 12/14/15 Fax : +213 (0) 21 77 29 56 Site Web : www.aglic.dz  ",0,0,'C');
         }*/
    function RotatedText($x,$y,$txt,$angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
        $this->Rotate(0);
    }

}
// Instanciation de la classe derivee
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

//Requete police ou avenant
$rqttype=$bdd->prepare("select type_avis ,cod_ref,cod_av from avis_recette where id_avis='$row'");
$rqttype->execute();
$type_avis="0";
$cod_pol="";
$cod_av="";
//echo "<script type="."'text/JavaScript'"."> alert("."'$row'".");  </script>"; 

while($result=$rqttype->fetch())
{

    $type_avis=$result['type_avis'];
    $cod_pol=$result['cod_ref'];
    $cod_av=$result['cod_av'];
}

if($type_avis=="0")
    $query_sous =$bdd->prepare("SELECT a.cod_avis,a.sens_avis,a.dat_avis,a.cod_mpay,a.lib_mpay  as libele,a.mtt_avis,s.nom_sous,s.pnom_sous,q.agence,m.lib_mpay,a.id_user ,u.adr_user,u.tel_user,u.mail_user,a.mtt_solde,p.dat_val,p.sequence,p.pt,pr.code_prod,p.pt-(a.mtt_avis+a.mtt_solde) as ancien_encaiss FROM `avis_recette` as a,policew as p,souscripteurw as s,quittance as q,mpay as m ,utilisateurs as u,produit as pr WHERE a.id_avis='$row' and p.cod_pol=a.cod_ref and p.cod_sous=s.cod_sous and q.id_quit=a.cod_quit and a.cod_mpay=m.cod_mpay and a.id_user=u.id_user and p.cod_prod=pr.cod_prod;");
else
    $query_sous =$bdd->prepare("SELECT a.cod_avis,a.sens_avis,a.dat_avis,a.cod_mpay,a.lib_mpay  as libele,a.mtt_avis,s.nom_sous,s.pnom_sous,q.agence,m.lib_mpay,a.id_user ,u.adr_user,u.tel_user,u.mail_user,a.mtt_solde,v.dat_val,v.sequence,v.pt,v.lib_mpay as type_av,pr.code_prod

,v.pt-(a.mtt_avis+a.mtt_solde) as ancien_encaiss

FROM `avis_recette` as a,policew as p,souscripteurw as s,quittance as q,mpay as m ,utilisateurs as u,produit as pr ,avenantw as v


WHERE a.id_avis='$row' and p.cod_pol=a.cod_ref and p.cod_sous=s.cod_sous and q.id_quit=a.cod_quit and a.cod_mpay=m.cod_mpay and a.id_user=u.id_user and p.cod_prod=pr.cod_prod
 and p.cod_pol=v.cod_pol and a.cod_av=v.cod_av;");

$query_sous->execute();
//$row_sous = $connection->enr_actuel();
while ($rowav=$query_sous->fetch()) {


    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(20, 5, 'AGENCE    ', '0', '0', 'L');
    $pdf->SetFillColor(231, 229, 231);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 5, ' : ' . $rowav['agence'], '0', '0', 'L');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 5, 'ADRESSE ', '0', '0', 'L');
    $pdf->SetFillColor(231, 229, 231);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(150, 5, ' : ' . utf8_decode( $rowav['adr_user']), '0', '0', 'L');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 5, 'TEL ', '0', '0', 'L');
    $pdf->SetFillColor(231, 229, 231);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(100, 5, ' : ' . $rowav['tel_user'], '0', '0', 'L');
    $pdf->Ln();
if($rowav['sens_avis']==0)
    $sens='AVIS DE RECETTE N:      ';
    else
        $sens='AVIS DE DEPENSE N�:      ';
    $pdf->Cell(190,5,'Le:   '.date("d/m/Y", strtotime($rowav['dat_avis'])),'0','0','R');$pdf->Ln(10);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(190,20,$sens.$rowav['agence'].'/'.substr($rowav['dat_avis'],0,4).'/'.str_pad((int) $rowav['cod_avis'],'5',"0",STR_PAD_LEFT),'B','0','C',1);$pdf->Ln(30);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY( $pdf->GetX()+100, $pdf->GetY());
    $pdf->Cell(30, 10, 'MONTANT: ', '1', '0', 'R'); $pdf->Cell(60, 10, number_format(abs($rowav['mtt_avis']), 2, ',', ' ')." DA", '1', '0', 'R');;$pdf->Ln(12);


    $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial','B',10);

   // $pdf->SetFillColor(7,27,81);
    $pdf->SetFillColor(221,221,221);
    $pdf->SetFont('Arial','B',8);

    setlocale(LC_CTYPE, 'cs_CZ');
    $test=iconv('UTF-8', 'ASCII//TRANSLIT', $rowav['libele']);
    $pdf->Cell(60,10,'MODE DE PAIEMENT ','1','0','L','1');
    $pdf->Cell(130,10,"".$rowav['lib_mpay'],'1','0','L');$pdf->Ln();
    if($rowav['cod_mpay']!=1)
    {
        $pdf->Cell(60,10,'LIBELLE ','1','0','L','1');
        $pdf->Cell(130,10,"".utf8_decode($rowav['libele']),'1','0','L');$pdf->Ln();
    }
    $pdf->Cell(60,10,'MONTANT DU REGLEMENT (En lettres)','1','0','L','1');  $pdf->Cell(130,10,$a1->ConvNumberLetter("".$rowav['mtt_avis']."",1,0),'1','0','L');$pdf->Ln();
    $pdf->Cell(60,10,'RECU DE','1','0','L','1');$pdf->Cell(130,10,"".utf8_decode($rowav['nom_sous'])." ".utf8_decode($rowav['pnom_sous']),'1','0','L');;$pdf->Ln();
    $pdf->Cell(60,10,'OBSERVATION -1','1','0','L','1');
    $pdf->Cell(100, 10, "R\351glements pr\351c\351dents  de la police " . $rowav['agence'] . '.' . substr($rowav['dat_val'], 0, 4) . '.10.' . $rowav['code_prod'] . '.' . str_pad((int)$rowav['sequence'], '5', "0", STR_PAD_LEFT) . '', 'TLB', '0', 'L');
    // $pdf->Cell(190,8,'Police N� '.$row_user['agence'].'.'.substr($row_g['dat_val'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','0','0','C');$pdf->Ln();
    $pdf->Cell(30, 10, '(' . number_format(abs($rowav['ancien_encaiss']), 2, ',', ' ') . ')', 'TRB', '0', 'R');
    $pdf->Ln();
    $pdf->Cell(60,10,'OBSERVATION -2','1','0','L','1');
    $pdf->Cell(100, 10,  "Reste \340 r\351gler", 'TLB', '0', 'L');
    // $pdf->Cell(190,8,'Police N� '.$row_user['agence'].'.'.substr($row_g['dat_val'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','0','0','C');$pdf->Ln();
    $pdf->Cell(30, 10, '(' . number_format(abs($rowav['mtt_solde']), 2, ',', ' ') . ')', 'TRB', '0', 'R');
    $pdf->Ln();
    $pdf->Cell(60,10,'OBSERVATION -3','1','0','L','1');
    if($type_avis=="0") {
        //ancien_encaiss

        if ($rowav['mtt_solde'] > 0) {
            $pdf->Cell(100, 10, "R\350glement partiel de la police " . $rowav['agence'] . '.' . substr($rowav['dat_val'], 0, 4) . '.10.' . $rowav['code_prod'] . '.' . str_pad((int)$rowav['sequence'], '5', "0", STR_PAD_LEFT) . '', 'TLB', '0', 'L');
            // $pdf->Cell(190,8,'Police N� '.$row_user['agence'].'.'.substr($row_g['dat_val'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','0','0','C');$pdf->Ln();
            $pdf->Cell(30, 10, '(' . number_format(abs($rowav['pt']), 2, ',', ' ') . ')', 'TRB', '0', 'R');;
            $pdf->Ln();
        } else {
            $pdf->Cell(100, 10, "R\350glement d\351finitif de la police " . $rowav['agence'] . '.' . substr($rowav['dat_val'], 0, 4) . '.10.' . $rowav['code_prod'] . '.' . str_pad((int)$rowav['sequence'], '5', "0", STR_PAD_LEFT) . '', 'TLB', '0', 'L');
            $pdf->Cell(30, 10, '(' . number_format(abs($rowav['pt']), 2, ',', ' ') . ' DA)', 'TRB', '0', 'R');;
            $pdf->Ln();
        }
    }else

    {


        if ($rowav['mtt_solde'] <> 0) {//montant negatif ou positif
            $pdf->Cell(100, 10, "R\350glement partiel d'avenant  " . $rowav['agence'] . '.' . substr($rowav['dat_val'], 0, 4) . '.'. $rowav['type_av'] .'.' . $rowav['code_prod'] . '.' . str_pad((int)$rowav['sequence'], '5', "0", STR_PAD_LEFT) . '', 'TLB', '0', 'L');
            // $pdf->Cell(190,8,'Police N� '.$row_user['agence'].'.'.substr($row_g['dat_val'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','0','0','C');$pdf->Ln();
            $pdf->Cell(30, 10, '(' . number_format(abs($rowav['pt']), 2, ',', ' ') . ')', 'TRB', '0', 'R');;
            $pdf->Ln();
        } else {
            $pdf->Cell(100, 10,"R\350glement d\351finitif de l'avenant  " . $rowav['agence'] . '.' . substr($rowav['dat_val'], 0, 4) . '.'. $rowav['type_av'] .'.' . $rowav['code_prod'] . '.' . str_pad((int)$rowav['sequence'], '5', "0", STR_PAD_LEFT) . '', 'TLB', '0', 'L');
            $pdf->Cell(30, 10, '(' . number_format(abs($rowav['pt']), 2, ',', ' ') . ' DA)', 'TRB', '0', 'R');;
            $pdf->Ln();
        }
    }


    ;$pdf->Ln(20);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(140,5,'Souscripteur:','0','0','L'); $pdf->Cell(50,5,'Caissier','0','0','C'); $pdf->Ln();
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(100,5,''.utf8_decode($rowav['nom_sous'])." ".utf8_decode($rowav['pnom_sous']),'0','0','L');$pdf->Ln(10);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(100,5,'P.I/P.C:','0','0','L');
   //$pdf->Cell(55,5,"Reste � regler".$rowav['solde_m']."",'1','0','C');$pdf->Ln();


    $pdf->Ln(3);
}


$pdf->Output();



?>








