<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){$user=$_SESSION['id_usersal'];}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}

if (isset($_REQUEST['d1']) && isset($_REQUEST['p']) && isset($_REQUEST['d2'])) {
    $date1 = $_REQUEST['d1'];
    $prod = $_REQUEST['p'];
    $date2 = $_REQUEST['d2'];
    $datesys = date("Y/m/d");
    include("convert.php");
    include("entete3.php");

date_default_timezone_set('UTC');


// Instanciation de la classe derivee
    $pdf = new PDF('L');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial','B',15);
    //requete

    $rqtp = $bdd->prepare("SELECT a.`agence` FROM `utilisateurs` as a WHERE  a.id_user='$user'");
    $rqtp->execute();
    while ($row_p=$rqtp->fetch()){ $agence=$row_p['agence'];}


// production globale par produit
    $rqtv=$bdd->prepare("
select count(cod_doc) as nb,sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from
(

select p.sequence as cod_doc, p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech, p.pn as prime_nette, c.mtt_cpl as cout_police,p.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, p.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(p.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and p.cod_dt=d.cod_dt and p.cod_cpl=c.cod_cpl and p.cod_prod=pr.cod_prod
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.agence='$agence'

union

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits

from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr

where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod  and v.lib_mpay not in ('30','50')
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and v.cod_pol= p.cod_pol and u.agence='$agence') as table1
group by table1.agence,table1.cod_prod

");
    $rqtv->execute();


// Instanciation de la classe derivee
    $pdf->Cell(280,10,'Bordereau de production globale positive du '.date("d/m/Y", strtotime($date1)).' au '.date("d/m/Y", strtotime($date2)).'  --Document généré le-- '.date("d/m/Y", strtotime($datesys)) ,'1','1','L','1');
    $pdf->Cell(100,10,'AgenceN°: '.$agence,'1','0','C');$pdf->Cell(90,10,'Produit: Tous les produits ','1','0','C');$pdf->Cell(90,10,'Code produit: ','1','1','C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(45,10,'Produit','1','0','C'); $pdf->Cell(20,10,'Nombre','1','0','C');$pdf->Cell(50,10,'P.Nette','1','0','C');$pdf->Cell(40,10,'C.Police','1','0','C');$pdf->Cell(50,10,'P.Commer','1','0','C');$pdf->Cell(30,10,'D.Timbre','1','0','C');$pdf->Cell(45,10,'P.Total','1','0','C');
//Boucle police
    $totalg=0;$totalnette=0;$totalcom=0;$totaltimbre=0;$totalepolice=0;$nbg=0;$nb=0;
    $pdf->SetFillColor(221,221,221);
    $pdf->Ln();
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial','',12);
//Reporting Polices
    while ($row_resv=$rqtv->fetch()){
        $prime_nettev=$row_resv['prime_nette'];
        $cout_policev=$row_resv['cout_police'];
        $prime_comv=$row_resv['prime_com'];
        $droit_timbrev=$row_resv['droit_timbre'];
        $prime_totalev=$row_resv['prime_totale'];
        $produits=$row_resv['produits'];
        $nb=$row_resv['nb'];


        $totalg=$totalg+$prime_totalev;
        $totalnette=$totalnette+$prime_nettev;
        $totalcom=$totalcom+$prime_comv;
        $totaltimbre=$totaltimbre+$droit_timbrev;
        $totalepolice=$totalepolice+$cout_policev;
        $nbg=$nbg+$nb;

        $pdf->Cell(45,10,''.$produits,'1','0','C');
        $pdf->Cell(20,10,''.$nb,'1','0','C');
        $pdf->Cell(50,10,''.number_format($prime_nettev, 2,',',' ').'','1','0','C');
        $pdf->Cell(40,10,''.number_format($cout_policev, 2,',',' ').'','1','0','C');
        $pdf->Cell(50,10,''.number_format($prime_comv, 2,',',' ').'','1','0','C');
        $pdf->Cell(30,10,''.number_format($droit_timbrev, 2,',',' ').'','1','0','C');
        $pdf->Cell(45,10,''.number_format($prime_totalev, 2,',',' ').'','1','0','R');$pdf->Ln(10);
    }
    $pdf->SetFillColor(221,221,221);
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(45,10,''.'Total général','1','0','C');
    $pdf->Cell(20,10,''.$nbg,'1','0','C');
    $pdf->Cell(50,10,''.number_format($totalnette, 2,',',' ').'','1','0','C');
    $pdf->Cell(40,10,''.number_format($totalepolice, 2,',',' ').'','1','0','C');
    $pdf->Cell(50,10,''.number_format($totalcom, 2,',',' ').'','1','0','C');
    $pdf->Cell(30,10,''.number_format($totaltimbre, 2,',',' ').'','1','0','C');
    $pdf->Cell(45,10,''.number_format($totalg, 2,',',' ').'','1','0','R');$pdf->Ln();

    $pdf->Output();

}
?>