<?php
session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){
//authentification acceptee !!!


//header("Location: http://www.monsite.com");
}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}
include("convert.php");
$a1 = new chiffreEnLettre();
$errone = false;


require('fpdf.php');

if (isset($_REQUEST['avenant'])) {
    $row = $row = substr($_REQUEST['avenant'],10);


}
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
   /* function RotatedText($x,$y,$txt,$angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
        $this->Rotate(0);
    }*/

}
// Instanciation de la classe derivee
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
// Requete Agence 


$query_ann = $bdd->prepare("select * from utilisateurs where  id_user ='".$_SESSION['id_usersal']."';");
$query_ann->execute();
//$row_user = $connection->enr_actuel();

//Requete Souscripteur

$query_sous =$bdd->prepare("SELECT s.*,v.*,o.lib_opt, p.lib_pays,d.sequence as sequence2,d.dat_val as dat_valp FROM `souscripteurw` as s, `policew` as d,`avenantw` as v, `option` as o, `pays` as p WHERE s.cod_sous=d.cod_sous and d.cod_pol=v.cod_pol and v.cod_opt=o.cod_opt and p.cod_pays=v.cod_pays and v.cod_av='".$row."';");
$query_sous->execute();

//$pdf->Ln(2);
$pdf->SetFillColor(205,205,205);
//$pdf->Ln(2);
$pdf->SetFillColor(205,205,205);
while ($row_sous=$query_sous->fetch()) {
    if ($row_sous['cod_opt'] < 30) {
        $pdf->Cell(190, 8, 'Assurance Voyage et Assistance', '0', '0', 'C');
        $pdf->Ln();
    } else {
        $pdf->Cell(190, 8, 'Assurance Voyage HADJ-OMRA', '0', '0', 'C');
        $pdf->Ln();
    }
    while ($row_user = $query_ann->fetch()) {
        $pdf->Cell(190, 8, "Avenant de précision", '0', '0', 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 8, 'Police N° ' . $row_user['agence'] . '.' . substr($row_sous['dat_valp'], 0, 4) . '.10.18.2.1.' . str_pad((int)$row_sous['sequence2'], '5', "0", STR_PAD_LEFT) . '', '0', '0', 'L');
        $pdf->Ln();
        $pdf->Cell(190, 8, 'Avenant N° ' . $row_user['agence'] . '.' . substr($row_sous['dat_val'], 0, 4) . '.' . $row_sous['lib_mpay'] . '.18.2.1.' . str_pad((int)$row_sous['sequence'], '5', "0", STR_PAD_LEFT) . '', '0', '0', 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'I', 9);


        $pdf->SetFont('Arial', 'B', 14);
//$pdf->Ln(2);
        $pdf->SetFillColor(7, 27, 81);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Ln();
        $pdf->Ln();
//Le Réseau
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, "" . $row_user['reseau'] . "", '1', '1', 'C', '1');
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(221, 221, 221);
        $pdf->Cell(40, 5, 'Agence', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_user['agence'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_user['adr_user'] . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'Téléphone', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_user['tel_user'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_user['mail_user'] . "", '1', '0', 'C');
        $pdf->Ln();

        $pdf->Ln(3);


// Le Souscripteur
        $pdf->SetFillColor(199, 139, 85);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, 'Souscripteur ', '1', '1', 'C', '1');
        $pdf->SetFillColor(221, 221, 221);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, 'Nom et Prénom/ R.Sociale', '1', '0', 'L', '1');
        if ($row_sous['rp_sous'] == 0) {
            $pdf->Cell(150, 5, "" . $row_sous['nom_sous'] . "", '1', '0', 'C');
            $pdf->Ln();
        } else {
            $pdf->Cell(150, 5, "" . $row_sous['nom_sous'] . " " . $row_sous['pnom_sous'] . "", '1', '0', 'C');
            $pdf->Ln();
        }
        $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1');
        $pdf->Cell(150, 5, "" . $row_sous['adr_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'Téléphone', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_sous['tel_sous'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_sous['mail_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Ln(3);
// L'assuré
        $pdf->SetFillColor(7, 27, 81);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, 'Voyage', '1', '1', 'C', '1');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(221, 221, 221);
        $pdf->SetFont('Arial', 'B', 8);
// Voyage
        $pdf->SetFillColor(221, 221, 221);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 5, 'Option', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_sous['lib_opt'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'Formule', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "Couple", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'Effet le', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['ndat_eff'])) . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'Echéance le', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['ndat_ech'])) . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'Zone de Couverture', '1', '0', 'L', '1');
        $pdf->Cell(150, 5, "" . $row_sous['lib_pays'] . "", '1', '0', 'C');
        $pdf->Ln(3);
        $pdf->Ln(9);
        $pdf->Ln(3);
        $pdf->Ln(9);

// Le Tarif !!!!!

        $pdf->SetFillColor(199, 139, 85);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 5, ' Prime Nette ', '1', '0', 'C', '1');
        $pdf->Cell(45, 5, " Cout d'avenant ", '1', '0', 'C', '1');
        $pdf->Cell(50, 5, ' Droit de timbre ', '1', '0', 'C', '1');
        $pdf->Cell(50, 5, ' Montant à Payer (DA) ', '1', '0', 'C', '1');
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(45, 5, "" . number_format('0', 2, ',', ' ') . "", '1', '0', 'C');
        $pdf->Cell(45, 5, "" . number_format('100', 2, ',', ' ') . "", '1', '0', 'C');
        $pdf->Cell(50, 5, "" . number_format('40', 2, ',', ' ') . "", '1', '0', 'C');
        $pdf->Cell(50, 5, "" . number_format($row_sous['pt'], 2, ',', ' ') . "", '1', '0', 'C');
        $pdf->Ln();


        $pdf->Ln(10);
        $somme = $a1->ConvNumberLetter("" . $row_sous['pt'] . "", 1, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 5, "La Montant à payer en lettres", '0', '0', 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(190, 12, "" . $somme . "", 1, 'C', true);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(0, 6, "Il n'est pas autrement dérogé aux autres clauses et conditions de la police de base à laquelle le présent avenant sera annexé pour en faire partie intégrante.", 0, 0, 'C');
        $pdf->Ln(2);
        $pdf->Ln(2);
        $pdf->Ln(5);
        $pdf->Cell(185, 5, "" . $row_user['adr_user'] . " le " . date("d/m/Y", strtotime($row_sous['dat_val'])) . "", '0', '0', 'R');
        $pdf->Ln();
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(60, 5, "Le souscripteur", '0', '0', 'C');
        $pdf->Cell(120, 5, "L'assureur", '0', '0', 'R');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 5, "Précedée de la mention «Lu et approuvé»", '0', '0', 'C');
        $pdf->Ln();
        $pdf->Ln(20);


// Annexe pour la liste des assuré Famille
        $pdf->AliasNbPages();
        $pdf->AddPage();
// **********************************************
        $pdf->Ln();
        $pdf->Ln(3);
        $pdf->SetFillColor(7, 27, 81);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(190, 10, 'Précision ', '1', '1', 'C', '1');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(221, 221, 221);
        $pdf->SetFont('Arial', 'B', 8);
        $query_assu = $bdd->prepare("SELECT * FROM `assure` WHERE cod_av='" . $row . "' AND modif_sous='1';");
        $query_assu->execute();
        while($row_assu=$query_assu->fetch()) {
            $pdf->Cell(40, 5, 'Nom et Prénom', '1', '0', 'L', '1');
            $pdf->Cell(150, 5, "" . $row_assu['nom_assu'] . " " . $row_assu['pnom_assu'] . "", '1', '0', 'C');
            $pdf->Ln();
            $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1');
            $pdf->Cell(150, 5, "" . $row_assu['adr_assu'] . "", '1', '0', 'C');
            $pdf->Ln();
            $pdf->Cell(40, 5, 'Téléphone', '1', '0', 'L', '1');
            $pdf->Cell(55, 5, "" . $row_assu['tel_assu'] . "", '1', '0', 'C');
            $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');
            $pdf->Cell(55, 5, "" . $row_assu['mail_assu'] . "", '1', '0', 'C');
            $pdf->Ln();
            $pdf->Cell(40, 5, 'N.Passport', '1', '0', 'L', '1');
            $pdf->Cell(55, 5, "" . $row_assu['passport'] . "", '1', '0', 'C');
            $pdf->Cell(40, 5, 'Delevre le:', '1', '0', 'L', '1');
            $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_assu['datedpass'])) . "", '1', '0', 'C');
            $pdf->Ln();

        }


    }
}
//*******
//Deuxième page -- Notice d'information



$pdf->Output();



?>