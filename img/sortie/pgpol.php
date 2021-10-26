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

if (isset($_REQUEST['groupe'])) {
    $row = substr($_REQUEST['groupe'],10);
}

//Les requetes *****************
// Requete Agence 
$query_ann =$bdd->prepare("select * from utilisateurs where  id_user ='".$_SESSION['id_usersal']."';");
$query_ann->execute();
//$row_user = $connection->enr_actuel();

//Requete Souscripteur
$query_sous =$bdd->prepare("SELECT s.*, d.*,p.lib_pays,p.cod_zone, o.lib_opt  FROM `souscripteurw` as s, `policew` as d, `pays` as p, `option` as o WHERE s.cod_sous=d.cod_sous and d.cod_pays=p.cod_pays and d.cod_opt=o.cod_opt  and d.cod_pol='".$row."';");
$query_sous->execute();
//$row_sous = $connection->enr_actuel();
// Instanciation de la classe derivee
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
//$pdf->Ln(2);
$pdf->SetFillColor(205,205,205);
while ($row_sous =$query_sous->fetch()) {
    if ($row_sous['cod_opt'] < 30) {
        $pdf->Cell(190, 8, 'Assurance Voyage et Assistance', '0', '0', 'C');
        $pdf->Ln();
    } else {
        $pdf->Cell(190, 8, 'Assurance Voyage HADJ-OMRA', '0', '0', 'C');
        $pdf->Ln();
    }
    while ($row_user = $query_ann->fetch()) {
        $pdf->Cell(190, 8, 'Police N� ' . $row_user['agence'] . '.' . substr($row_sous['dat_val'], 0, 4) . '.10.18.2.1.' . str_pad((int)$row_sous['sequence'], '5', "0", STR_PAD_LEFT) . '', '0', '0', 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->Cell(0, 6, "Contrat r�gi par l'ordonnance 95/07 du 25-O1-1995 relative aux assurances modifi�e et compl�t�e par la loi 06/04du 20-02-2006.", 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(0, 6, "Que par l'ordonnance 75/58 du 26 septembre 1975 du code civil aux conditions g�n�rales qui pr�cedent et celles particuli�res qui", 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(0, 6, "suivent, l'Alg�rienne Vie garantit:", 0, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 14);
//$pdf->Ln(2);
        $pdf->SetFillColor(7, 27, 81);
        $pdf->SetTextColor(255, 255, 255);

//Le R�seau
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 5, "Agence", '1', '1', 'C', '1');
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(221, 221, 221);
        $pdf->Cell(40, 5, 'Agence', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_user['agence'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'Adresse', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_user['adr_user'] . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'T�l�phone', '1', '0', 'L', '1');
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
        $pdf->Cell(40, 5, 'Nom et Pr�nom/ R.Sociale', '1', '0', 'L', '1');
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
        $pdf->Cell(40, 5, 'T�l�phone', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_sous['tel_sous'] . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'E-mail', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . $row_sous['mail_sous'] . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Ln(3);
// L'assur�
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
        $pdf->Cell(55, 5, "Groupe", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'Effet le', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['dat_eff'])) . "", '1', '0', 'C');
        $pdf->Cell(40, 5, 'Ech�ance le', '1', '0', 'L', '1');
        $pdf->Cell(55, 5, "" . date("d/m/Y", strtotime($row_sous['dat_ech'])) . "", '1', '0', 'C');
        $pdf->Ln();
        $pdf->Cell(40, 5, 'Zone de Couverture', '1', '0', 'L', '1');
        $pdf->Cell(150, 5, "" . $row_sous['lib_pays'] . "", '1', '0', 'C');
        $pdf->Ln(3);
        $pdf->Ln(9);
// Garanties
        $pdf->SetFillColor(7, 27, 81);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 5, ' Garanties ', '1', '0', 'C', '1');
        $pdf->Cell(70, 5, ' Capitaux-Limites ', '1', '0', 'C', '1');
        $pdf->Cell(70, 5, ' Prime Nette (DA) ', '1', '0', 'C', '1');

        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);
        $pn = $row_sous['pn'];
        if ($row_sous['cod_opt'] ==30 || $row_sous['cod_opt']==31) {
            $pdf->Cell(50, 5, 'D�c�s/IP (Accidentel)', '1', '0', 'C');
            $pdf->Cell(70, 5, "150 000.00 DA", '1', '0', 'C');
            $pdf->Cell(70, 5, "" . number_format($row_sous['p2'], 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Ln();}
        else{
            $pdf->Cell(50, 5, 'D�c�s/IP (Accidentel', '1', '0', 'C');
            $pdf->Cell(70, 5, "200 000.00 DA", '1', '0', 'C');
            $pdf->Cell(70, 5, "" . number_format($row_sous['p2'], 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Ln();
            if ($row_sous['cod_opt'] <23) {
                if ($row_sous['cod_zone'] == 2) {
                    $pdf->Cell(50, 5, 'Assistance', '1', '0', 'C');
                    $pdf->Cell(70, 5, "30 000.00 EU", '1', '0', 'C');
                    $pdf->Cell(70, 5, "" . number_format($row_sous['p1'], 2, ',', ' ') . "", '1', '0', 'C');
                    $pdf->Ln();
                }
                if ($row_sous['cod_zone'] == 3) {
                    $pdf->Cell(50, 5, 'Assistance', '1', '0', 'C');
                    $pdf->Cell(70, 5, "50 000.00 EU", '1', '0', 'C');
                    $pdf->Cell(70, 5, "" . number_format($row_sous['p1'], 2, ',', ' ') . "", '1', '0', 'C');
                    $pdf->Ln();
                }
            } else {
                $pdf->Cell(50, 5, 'Assistance', '1', '0', 'C');
                $pdf->Cell(70, 5, "10 000.00 EU", '1', '0', 'C');
                $pdf->Cell(70, 5, "" . number_format($row_sous['p1'], 2, ',', ' ') . "", '1', '0', 'C');
                $pdf->Ln();
            }
        }
        $pdf->Ln(9);
// Le Tarif !!!!!

        $pdf->SetFillColor(199, 139, 85);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 5, ' Prime Nette ', '1', '0', 'C', '1');
        $pdf->Cell(45, 5, ' Cout de Police ', '1', '0', 'C', '1');
        $pdf->Cell(50, 5, ' Droit de timbre ', '1', '0', 'C', '1');
        $pdf->Cell(50, 5, ' Montant � Payer (DA) ', '1', '0', 'C', '1');
        $pdf->Ln();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 8);


        if ($row_sous['cod_cpl'] == 2) {
            $pdf->Cell(45, 5, "" . number_format($pn, 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(45, 5, "" . number_format('250', 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(50, 5, "" . number_format('40', 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(50, 5, "" . number_format($row_sous['pt'], 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Ln();
        } else {
            $pdf->Cell(45, 5, "" . number_format($pn, 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(45, 5, "" . number_format('500', 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(50, 5, "" . number_format('40', 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Cell(50, 5, "" . number_format($row_sous['pt'], 2, ',', ' ') . "", '1', '0', 'C');
            $pdf->Ln();
        }


        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'I', 6);
        $pdf->Cell(0, 6, "Le Souscripteur reconnait que les pr�sentes Conditions Particuli�res ont �t� �tablies conform�ment aux renseignements qu'il a donn� lors de la souscription du Contrat.", 0, 0, 'C');
        $pdf->Ln(2);
        $pdf->Cell(0, 6, "Le Souscripteur reconnait �galement avoir �t� inform� du contenu des Conditions Particuli�res et des Conditions G�n�rales et avoir �t� inform� du montant de la prime et des garanties d�es.", 0, 0, 'C');
        $pdf->Ln(9);
        $somme = $a1->ConvNumberLetter("" . $row_sous['pt'] . "", 1, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 5, "Le montant � payer en lettres", '0', '0', 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(190, 12, "" . $somme . "", 0, 'C', true);
        $pdf->Cell(185, 5, "" . $row_user['adr_user'] . " le " . date("d/m/Y", strtotime($row_sous['dat_val'])) . "", '0', '0', 'R');
        $pdf->Ln();
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 5, "Le souscripteur", '0', '0', 'C');
        $pdf->Cell(120, 5, "L'assureur", '0', '0', 'R');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 5, "Pr�ced� de la mention �Lu et approuv�", '0', '0', 'C');
        $pdf->Ln();
        $pdf->Ln(19);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(0, 6, "Pour toute modification du contrat, le souscripteur est tenu d'aviser l'assureur 48 heures avant la date de prise d'effet de son contrat, ou du dernier avenant", 0, 0, 'C');
        $pdf->Ln(2);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 100);
       // $pdf->RotatedText(60, 240, 'Plateforme-Test', 60);
// Annexe pour la liste des assur� Famille
        $pdf->AliasNbPages();
        $pdf->AddPage();
// **********************************************
        $pdf->Ln();
        $pdf->Ln(3);
        $pdf->SetFillColor(7, 27, 81);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Ln(8);
        $pdf->Cell(190, 10, 'Liste des Assur�s ', '1', '1', 'C', '1');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(221, 221, 221);
        $pdf->SetFont('Arial', 'B', 8);
        $query_assu = $bdd->prepare("SELECT * FROM `souscripteurw` WHERE cod_par='" . $row_sous['cod_sous'] . "';");
        $query_assu->execute();
        $i = 0;
//$row_assu = $connection->enr_actuel();
        $pdf->Cell(10, 5, 'N�', '1', '0', 'C', '1');
        $pdf->Cell(90, 5, 'Nom et Pr�nom', '1', '0', 'C', '1');
        $pdf->Cell(45, 5, 'Passport N�', '1', '0', 'C', '1');
        $pdf->Cell(45, 5, 'Date-Naissance', '1', '0', 'C', '1');
        $pdf->Ln();
        while ($row_assu = $query_assu->fetch()) {
            $i++;
            $pdf->Cell(10, 5, '' . $i . '', '1', '0', 'C', '1');
            $pdf->Cell(90, 5, "" . $row_assu['nom_sous'] . " " . $row_assu['pnom_sous'] . "", '1', '0', 'C');
            $pdf->Cell(45, 5, "" . $row_assu['passport'] . "", '1', '0', 'C');
            $pdf->Cell(45, 5, "" . date("d/m/Y", strtotime($row_assu['dnais_sous'])) . "", '1', '0', 'C');
            $pdf->Ln();
        }

        $pdf->SetFillColor(255, 255, 255);
//Deuxi�me page -- Notice d'information
        if ($row_sous['cod_opt'] < 30) {
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Ln(10);
            $pdf->Cell(190, 8, "NOTICE D'INFORMATION", '0', '0', 'C');
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(120, 7, "Garanties", '1', '0', 'C');
            $pdf->Cell(70, 7, "Limites/Capital-(Franchises)", '1', '0', 'C');
            $pdf->Ln();
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->Cell(190, 6, "Assurance", '1', '0', 'C');
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 7);
//Premiere Partie
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->MultiCell(120, 6, "D�c�s Accidentel (pour les personnes ag�es de plus de 13 ans) \n Incapacit� Permanente Accidentelle", 1, 'L', true);
            $pdf->SetXY($x, $y);
            $pdf->SetXY($x + 120, $y);
            $pdf->MultiCell(70, 6, "200 000 DZD \n 200 000 DZD  ", 1, 'C', true);
//Deuxieme partie
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->Cell(190, 6, "Assistance", '1', '0', 'C');
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 7);
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            if ($row_sous['cod_opt'] <23) {
                $pdf->MultiCell(120, 5, "Transport sanitaire   \n  Prise en charge des frais m�dicaux, pharmaceutiques, d'hospitalisation et chirurgicaux \n Prise en charge des soins dentaires d'urgence \n Prolongation de s�jour \n Frais de secours et sauvetage \n Visite d'un proche parent \n Rapatriement de corps en cas de d�c�s \n Retour pr�matur� du B�n�ficiaire \n Rapatriement des autres B�n�ficiaires \n Retard de vol et de livraison de bagages \n Perte de bagage \n Assistance juridique \n Avance de caution p�nale \n Transmission de messages urgents \n Manquement de correspondance \n Annulation de voyage \n Informations", 1, 'L', true);
                $pdf->SetXY($x, $y);
                $pdf->SetXY($x + 120, $y);
                $pdf->MultiCell(70, 5, "Frais r�els  \n Zone 1 : 30 000 EU (40 EU) / Zone 2 : 50 000 EU (40 EU) \n 1 000.00 EU (30 EU) \n 100 EU /Jour (8 Jours Max) \n 1500 EU /b�n�ficiaire/�v�nement \n 100 EU /jour (4 jours Max) \n Frais r�els \n 1 000.00 EU \n Frais r�els \n 1 80 EU \n 20 EU /Kg, 40Kg Max \n 4 000.00 EU \n 10 000.00 EU \n Illimit� \n 100 EU \n Frais de voyage non r�cup�rables \n  Illimit�", 1, 'C', true);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(190, 6, "NOTE AUX CLIENTS", '1', '0', 'C');
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->MultiCell(190, 5, "  -Les souscriptions des contrats assurance voyage ou des avenants � distance � de l'�tranger � sont formellement interdites. \n  -En cas de sinistre, l'assur� ou un membre de sa famille doit imp�rativement contacter au pr�alable l'Assisteur avant d'engager toute d�penses, dans le cas �ch�ant, il ne pourra pr�tendre � aucun remboursement. \n -Le remboursement des contrats assurance voyage se fait uniquement dans les  cas suivants: \n   +Le refus de VISA; \n   +Le d�c�s d?un proche ; ascendant, descendant, conjoint ; \n   +Incapacit� de l?assur� � voyager pour cause d'�tat de sant� ; \n -Le souscripteur est tenu de constituer le dossier suivant : \n   + L'original du contrat  \n   + Justificatifs sus-cit�s \n   + Copie des cinq premi�res pages du passeport  \n  + Refus de visa", 1, 'L', true);
                $pdf->Ln();
            } else {
// Option Tunisie ici ***************************
                $pdf->MultiCell(120, 5, "Transport sanitaire   \n  Frais m�dicaux d'urgence \n Prolongation de s�jour pour convalescence \n D�fense et recours \n Avance de caution p�nale \n Rapatriement de corps en cas de d�c�s \n Exp�dition de m�dicament \n Transmission de messages urgents \n Conseil m�dical par t�l�phone  \n Informations", 1, 'L', true);
                $pdf->SetXY($x, $y);
                $pdf->SetXY($x + 120, $y);
                $pdf->MultiCell(70, 5, "Frais r�els  \n Plafond de 10000 EU (20 EU) \n 100 EU /Jour (5 Jours Max) \n 1000 EU \n 1000 EU  \n Cercueil minimum + transport au lieu d'inhumation \n Frais r�els \n Illimit� \n Illimit�  \n  Illimit�", 1, 'C', true);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(190, 6, "NOTE AUX CLIENTS", '1', '0', 'C');
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->MultiCell(190, 5, "  -Les souscriptions des contrats assurance voyage ou des avenants � distance � de l'�tranger � sont formellement interdites. \n  -En cas de sinistre, l'assur� ou un membre de sa famille doit imp�rativement contacter au pr�alable l'Assisteur avant d'engager toute d�penses, dans le cas �ch�ant, il ne pourra pr�tendre � aucun remboursement. \n -Le remboursement des contrats assurance voyage se fait uniquement dans les  cas suivants: \n   +Le d�c�s d'un proche ; ascendant, descendant, conjoint ; \n   +Incapacit� de l'assur� � voyager pour cause d'�tat de sant� ; \n -Le souscripteur est tenu de constituer le dossier suivant : \n   + L'original du contrat  \n   + Justificatifs sus-cit�s \n   + Copie des cinq premi�res pages du passeport  \n  + Refus de visa ", 1, 'L', true);
                $pdf->Ln();
//***********************************************
            }
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->MultiCell(190, 5, "  -Contact: \n  + France : Tel : + 33 4 37 37 28 58 -Fax : +33 4 37 37 28 57 \n  + Monde entier:  Tel : + 213 21 98 60 50 -Fax : + 213 21 29 86 35 \n  + Mail : algcosiam@mapfre.com ", 1, 'L', true);
            $pdf->Ln();
        }
    }
}
$pdf->Output();	
?>








