<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){$user=$_SESSION['id_usersal'];}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}

if (isset($_REQUEST['d1']) && isset($_REQUEST['p'])&& isset($_REQUEST['u']) && isset($_REQUEST['d2'])) {
    $date1 = $_REQUEST['d1'];
    $prod = $_REQUEST['p'];
   // $dre=	$_REQUEST['v'];
    $agence = $_REQUEST['u'];//ID_USER
    $date2 = $_REQUEST['d2'];
    $datesys = date("Y/m/d");
    include("convert.php");
    include("entete2.php");
  date_default_timezone_set('UTC');


    //
    $rqtag=$bdd->prepare("select agence,type_user from utilisateurs where id_user='$agence'");
    $rqtag->execute();
    while($rowag=$rqtag->fetch())
    {
        $cas_par_agence=$rowag['agence'];
        $typ_usr=$rowag['type_user'];

    }

// Instanciation de la classe derivee
    $pdf = new PDF('L');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial','B',15);
    //requete
    if( $agence=='0') {


// production globale par produit
        $rqtv = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (
select p.sequence as cod_doc, p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech, p.pn as prime_nette, c.mtt_cpl as cout_police,p.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, p.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(p.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and p.cod_dt=d.cod_dt and p.cod_cpl=c.cod_cpl and p.cod_prod=pr.cod_prod
and p.cod_sous=s.cod_sous and s.id_user=u.id_user

union

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and v.cod_pol= p.cod_pol ) as table1
group by table1.cod_prod,table1.agence
order by table1.cod_prod

");
        $rqtv->execute();
    }
    else {
        if ($typ_usr == 'dr')
        {
            //dre<>0 et agence ==0.

// production globale par produit
            $rqtv = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (
select p.sequence as cod_doc, p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech, p.pn as prime_nette, c.mtt_cpl as cout_police,p.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, p.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(p.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and p.cod_dt=d.cod_dt and p.cod_cpl=c.cod_cpl and p.cod_prod=pr.cod_prod
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.id_par='$agence'

union

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod
and p.cod_sous=s.cod_sous and s.id_user=u.id_user  and u.id_par='$agence' and v.cod_pol= p.cod_pol ) as table1
group by table1.cod_prod,table1.agence
order by table1.cod_prod

");
            $rqtv->execute();


        }
        else
        {//dre==0 et agence <>0



// production globale par produit
            $rqtv = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (
select p.sequence as cod_doc, p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech, p.pn as prime_nette, c.mtt_cpl as cout_police,p.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, p.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(p.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and p.cod_dt=d.cod_dt and p.cod_cpl=c.cod_cpl and p.cod_prod=pr.cod_prod
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.agence='$cas_par_agence'

union

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.agence='$cas_par_agence' and v.cod_pol= p.cod_pol ) as table1
group by table1.cod_prod

");
            $rqtv->execute();

        }
    }



// Instanciation de la classe derivee
    $pdf->Cell(280,10,'Bordereau de production globale du '.date("d/m/Y", strtotime($date1)).' au '.date("d/m/Y", strtotime($date2)).'  --Document généré le-- '.date("d/m/Y", strtotime($datesys)) ,'1','1','L','1');
    $pdf->Cell(100,10,'AgenceN°: '.'Direction Générale','1','0','C');$pdf->Cell(90,10,'Produit: Tous les produits ','1','0','C');$pdf->Cell(90,10,'Code produit: ','1','1','C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(50,10,'Produit','1','0','C');$pdf->Cell(20,10,'Agence','1','0','C'); $pdf->Cell(20,10,'Nombre','1','0','C');$pdf->Cell(40,10,'P.Nette','1','0','C');$pdf->Cell(40,10,'C.Police','1','0','C');$pdf->Cell(40,10,'P.Commer','1','0','C');$pdf->Cell(30,10,'D.Timbre','1','0','C');$pdf->Cell(40,10,'P.Total','1','0','C');
    $pdf->Ln();
//Boucle police
    $totalg=0;$totalnette=0;$totalcom=0;$totaltimbre=0;$totalepolice=0;$nbg=0;$nb=0;

    $sous_totalg=0;$sous_totalnette=0;$sous_totalcom=0;$sous_totaltimbre=0;$sous_totalepolice=0;$sous_nbg=0;$sous_nb=0;
    $agencei="";
    $produiti="";
//Reporting Polices
    while ($row_resv=$rqtv->fetch()){

        //
        if($nbg==0)
        {
            $produiti= $row_resv['produits'];
        }
        if($produiti!=$row_resv['produits'])
        {

            $pdf->SetTextColor(7, 27, 181);
            $pdf->SetFont('Arial','IB',12);
            $pdf->Cell(70,10,''.'Sous Total :'.$produiti,'1','0','C');
            $pdf->Cell(20,10,''.$sous_nbg,'1','0','C');
            $pdf->Cell(40,10,''.number_format($sous_totalnette, 2,',',' ').'','1','0','C');
            $pdf->Cell(40,10,''.number_format($sous_totalepolice, 2,',',' ').'','1','0','C');
            $pdf->Cell(40,10,''.number_format($sous_totalcom, 2,',',' ').'','1','0','C');
            $pdf->Cell(30,10,''.number_format($sous_totaltimbre, 2,',',' ').'','1','0','C');
            $pdf->Cell(40,10,''.number_format($sous_totalg, 2,',',' ').'','1','0','R');
            $sous_totalnette=0;$sous_totalepolice=0;$sous_totalcom=0;$sous_totaltimbre=0;$sous_totalg=0;$sous_nbg=0;
            $produiti=$row_resv['produits'];
            $pdf->Ln(10);
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Arial','',12);

        $prime_nettev=$row_resv['prime_nette'];
        $cout_policev=$row_resv['cout_police'];
        $prime_comv=$row_resv['prime_com'];
        $droit_timbrev=$row_resv['droit_timbre'];
        $prime_totalev=$row_resv['prime_totale'];
        $produits=$row_resv['produits'];
        $nb=$row_resv['nb'];
        $agencei=$row_resv['agence'];


        $totalg=$totalg+$prime_totalev;
        $totalnette=$totalnette+$prime_nettev;
        $totalcom=$totalcom+$prime_comv;
        $totaltimbre=$totaltimbre+$droit_timbrev;
        $totalepolice=$totalepolice+$cout_policev;
        $nbg=$nbg+$nb;

        $sous_totalg=$sous_totalg+$prime_totalev;
        $sous_totalnette=$sous_totalnette+$prime_nettev;
        $sous_totalcom=$sous_totalcom+$prime_comv;
        $sous_totaltimbre=$sous_totaltimbre+$droit_timbrev;
        $sous_totalepolice=$sous_totalepolice+$cout_policev;
        $sous_nbg=$sous_nbg+$nb;

        $pdf->Cell(50,10,''.$produits,'1','0','C');
        $pdf->Cell(20,10,''.$agencei,'1','0','C');
        $pdf->Cell(20,10,''.$nb,'1','0','C');
        $pdf->Cell(40,10,''.number_format($prime_nettev, 2,',',' ').'','1','0','C');
        $pdf->Cell(40,10,''.number_format($cout_policev, 2,',',' ').'','1','0','C');
        $pdf->Cell(40,10,''.number_format($prime_comv, 2,',',' ').'','1','0','C');
        $pdf->Cell(30,10,''.number_format($droit_timbrev, 2,',',' ').'','1','0','C');
        $pdf->Cell(40,10,''.number_format($prime_totalev, 2,',',' ').'','1','0','R');$pdf->Ln(10);
    }
    //La dernière iteration
    if($nbg>0)
    {
        $pdf->SetTextColor(7, 27, 181);
        $pdf->SetFont('Arial','IB',12);
        $pdf->Cell(70,10,''.'Sous Total :'.$produiti,'1','0','C');
        $pdf->Cell(20,10,''.$sous_nbg,'1','0','C');
        $pdf->Cell(40,10,''.number_format($sous_totalnette, 2,',',' ').'','1','0','C');
        $pdf->Cell(40,10,''.number_format($sous_totalepolice, 2,',',' ').'','1','0','C');
        $pdf->Cell(40,10,''.number_format($sous_totalcom, 2,',',' ').'','1','0','C');
        $pdf->Cell(30,10,''.number_format($sous_totaltimbre, 2,',',' ').'','1','0','C');
        $pdf->Cell(40,10,''.number_format($sous_totalg, 2,',',' ').'','1','0','R');
        $sous_totalnette=0;$sous_totalepolice=0;$sous_totalcom=0;$sous_totaltimbre=0;$sous_totalg=0;$sous_nbg=0;
        $produiti=$row_resv['produits'];
        $pdf->Ln(10);
    }
    //total general
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(70,10,''.'Total général','1','0','C');
    $pdf->Cell(20,10,''.$nbg,'1','0','C');
    $pdf->Cell(40,10,''.number_format($totalnette, 2,',',' ').'','1','0','C');
    $pdf->Cell(40,10,''.number_format($totalepolice, 2,',',' ').'','1','0','C');
    $pdf->Cell(40,10,''.number_format($totalcom, 2,',',' ').'','1','0','C');
    $pdf->Cell(30,10,''.number_format($totaltimbre, 2,',',' ').'','1','0','C');
    $pdf->Cell(40,10,''.number_format($totalg, 2,',',' ').'','1','0','R');$pdf->Ln();

    $pdf->Output();

}
?>