<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){$user=$_SESSION['id_usersal'];}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}

if (isset($_REQUEST['d1']) && isset($_REQUEST['p']) && isset($_REQUEST['u']) && isset($_REQUEST['d2'])) {
    $date1 = $_REQUEST['d1'];
    $prod = $_REQUEST['p'];
    $agence = $_REQUEST['u'];
    $date2 = $_REQUEST['d2'];
    $datesys = date("Y/m/d");
    include("convert.php");
    include("entete4.php");
  date_default_timezone_set('UTC');


// Instanciation de la classe derivee
    $pdf = new PDF('L','mm','A3');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial','B',15);
    //requete


    $rqtuser=$bdd->prepare("select * from utilisateurs where id_user='$user'");
    $rqtuser->execute();
    $nom_user="";
    $pnom_user="";
    while($rsu=$rqtuser->fetch())
    {
        $nom_user=$rsu['nom'];
        $pnom_user=$rsu['prenom'];

    }


// Instanciation de la classe derivee
    $pdf->Cell(330,10,'Etat récapitulatif de la production' ,'','1','C');
    $pdf->Cell(330,10,'Période du:       '.date("d/m/Y", strtotime($date1)).'            au:     '.date("d/m/Y", strtotime($date2)) ,'','1','C');
    if ($agence == '0') {

        $rqtagdr=$bdd->prepare("select * from utilisateurs where id_user='$user'");
        $rqtagdr->execute();
        $dre="";
        while($rwu=$rqtagdr->fetch())
        {
            $dre=$rwu['agence'];
        }
        $pdf->Cell(190, 10, 'Etat Global DRE: ' . $dre, '1', '0', 'C');
        $pdf->Cell(170, 10, 'Produit: Tous les produits ', '1', '0', 'C');
        // $pdf->Cell(130, 10, 'Code produit: ', '1', '1', 'C');

    }
    else
    {
        $pdf->Cell(190, 10, 'Agence  N° ' . $agence, '1', '0', 'C');
        $pdf->Cell(170, 10, 'Produit: Tous les produits ', '1', '0', 'C');
        // $pdf->Cell(130, 10, 'Code produit: ', '1', '1', 'C');
    }
    $pdf->Ln(15);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(50,10,'Produits','1','0','C');$pdf->Cell(70,10,'Production','1','0','C'); $pdf->Cell(20,10,'Nombre','1','0','C');$pdf->Cell(50,10,'P.Nette','1','0','C');$pdf->Cell(40,10,'Accessoire','1','0','C');$pdf->Cell(50,10,'P.Commer','1','0','C');$pdf->Cell(30,10,'D.T','1','0','C');$pdf->Cell(50,10,'P.Total','1','0','C');
    $pdf->Ln();

    $pdf->SetFont('Arial','',10);
    $pdf->SetFillColor(199,139,85);

    //declaration des variables
    //production positive
    $prime_nette_positive_pi=0;
    $nb_act_positive_pi=0;
    $Accessoire_positive_pi=0;
    $prime_commerciale_positive_pi=0;
    $dt_positifs_pi=0;
    $prime_total_positive_pi=0;

    //production avec ristourne
    $prime_nette_ar_pi=0;
    $nb_act_ar_pi=0;
    $Accessoire_ar_pi=0;
    $prime_commerciale_ar_pi=0;
    $dt_ar_pi=0;
    $prime_total_ar_pi=0;

    //production sans ristourne.
    $prime_nette_sr_pi=0;
    $nb_act_sr_pi=0;
    $Accessoire_sr_pi=0;
    $prime_commerciale_sr_pi=0;
    $dt_sr_pi=0;
    $prime_total_sr_pi=0;
    //total production produit pi
    $prime_nette_pi=0;
    $nb_act_pi=0;
    $Accessoire_pi=0;
    $prime_commerciale_pi=0;
    $dt_pi=0;
    $prime_total_pi=0;
    //total general
    //total production produit pi
    $prime_nette=0;
    $nb_act=0;
    $Accessoire=0;
    $prime_commerciale=0;
    $dt=0;
    $prime_total=0;

    $rqt_prod=$bdd->prepare("SELECT * FROM `produit` WHERE `cod_prod`  in (1,2,5,6,7); ");

    $rqt_prod->execute();
    $cod_p='';
    while ($rowp= $rqt_prod->fetch()) {
        $cod_p=$rowp['cod_prod'];

        if ($agence == '0')
        {


            $rqtpos = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (
select p.sequence as cod_doc, p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech, p.pn as prime_nette, c.mtt_cpl as cout_police,p.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, p.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(p.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and p.cod_dt=d.cod_dt and p.cod_cpl=c.cod_cpl and p.cod_prod=pr.cod_prod and p.cod_prod='$cod_p'
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.id_par='$user'

union

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod and v.cod_prod='$cod_p'
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.id_par='$user' and v.cod_pol= p.cod_pol
and v.lib_mpay not in ('30','50')
) as table1
group by table1.cod_prod");

            $rqtpos->execute();


            $rqtrist = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod and v.cod_prod='$cod_p'
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.id_par='$user' and v.cod_pol= p.cod_pol
and v.lib_mpay  in ('30')
) as table1
group by table1.cod_prod");
            $rqtrist->execute();

            $rqt_s_rist = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod and v.cod_prod='$cod_p'
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.id_par='$user' and v.cod_pol= p.cod_pol
and v.lib_mpay  in ('50')
) as table1
group by table1.cod_prod");
            $rqt_s_rist->execute();



        }
        else
        {//dre==0 et agence <>0


            $rqtpos = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (
select p.sequence as cod_doc, p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech, p.pn as prime_nette, c.mtt_cpl as cout_police,p.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, p.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(p.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and p.cod_dt=d.cod_dt and p.cod_cpl=c.cod_cpl and p.cod_prod=pr.cod_prod and p.cod_prod='$cod_p'
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.agence='$agence'

union

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod and v.cod_prod='$cod_p'
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.agence='$agence' and v.cod_pol= p.cod_pol
and v.lib_mpay not in ('30','50')
) as table1
group by table1.cod_prod");

            $rqtpos->execute();


            $rqtrist = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod and v.cod_prod='$cod_p'
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.agence='$agence' and v.cod_pol= p.cod_pol
and v.lib_mpay  in ('30')
) as table1
group by table1.cod_prod");
            $rqtrist->execute();

            $rqt_s_rist = $bdd->prepare("select count(cod_doc) as nb, sum(prime_nette) as prime_nette, sum(cout_police) as cout_police,sum(prime_com)as prime_com, sum(droit_timbre) as droit_timbre, sum(prime_totale) as prime_totale,table1.agence as agence,table1.cod_prod,table1.produits as produits
from (

select v.sequence as cod_doc,p.dat_val as dat_val,p.ndat_eff as ndat_eff,p.ndat_ech as ndat_ech,v.pn as prime_nette, c.mtt_cpl as cout_police,v.pn+c.mtt_cpl as prime_com, d.mtt_dt as droit_timbre, v.pt as prime_totale,u.agence as agence,pr.cod_prod as cod_prod,pr.lib_prod as produits
from avenantw as v,policew as p, dtimbre as d,cpolice as c ,souscripteurw as s,utilisateurs as u,produit as pr
where DATE_FORMAT(v.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'  and v.cod_dt=d.cod_dt and v.cod_cpl=c.cod_cpl and v.cod_prod=pr.cod_prod and v.cod_prod='$cod_p'
and p.cod_sous=s.cod_sous and s.id_user=u.id_user and u.agence='$agence' and v.cod_pol= p.cod_pol
and v.lib_mpay  in ('50')
) as table1
group by table1.cod_prod");
            $rqt_s_rist->execute();



        }

        $produits=$rowp['lib_prod'];
        while($rows_p_pi=$rqtpos->fetch())
        {
            $prime_nette_positive_pi=$rows_p_pi['prime_nette'];
            $nb_act_positive_pi=$rows_p_pi['nb'];
            $Accessoire_positive_pi=$rows_p_pi['cout_police'];
            $prime_commerciale_positive_pi=$rows_p_pi['prime_com'];
            $dt_positifs_pi=$rows_p_pi['droit_timbre'];
            $prime_total_positive_pi=$rows_p_pi['prime_totale'];
        }

        while($rows_ar_pi=$rqtrist->fetch())
        {
            $prime_nette_ar_pi=$rows_ar_pi['prime_nette'];
            $nb_act_ar_pi=$rows_ar_pi['nb'];
            $Accessoire_ar_pi=$rows_ar_pi['cout_police'];
            $prime_commerciale_ar_pi=$rows_ar_pi['prime_com'];
            $dt_ar_pi=$rows_ar_pi['droit_timbre'];
            $prime_total_ar_pi=$rows_ar_pi['prime_totale'];
        }

        while($rows_sr_pi=$rqt_s_rist->fetch())
        {
            $prime_nette_sr_pi=$rows_sr_pi['prime_nette'];
            $nb_act_sr_pi=$rows_sr_pi['nb'];
            $Accessoire_sr_pi=$rows_sr_pi['cout_police'];
            $prime_commerciale_sr_pi=$rows_sr_pi['prime_com'];
            $dt_sr_pi=$rows_sr_pi['droit_timbre'];
            $prime_total_sr_pi=$rows_sr_pi['prime_totale'];
        }

        $prime_nette_pi=$prime_nette_positive_pi+$prime_nette_ar_pi+$prime_nette_sr_pi;
        $nb_act_pi=$nb_act_positive_pi+$nb_act_ar_pi+$nb_act_sr_pi;
        $Accessoire_pi=$Accessoire_positive_pi+$Accessoire_ar_pi+$Accessoire_sr_pi;
        $prime_commerciale_pi=$prime_commerciale_positive_pi+$prime_commerciale_ar_pi+$prime_commerciale_sr_pi;
        $dt_pi=$dt_positifs_pi+$dt_ar_pi+$dt_sr_pi;
        $prime_total_pi=$prime_total_positive_pi+$prime_total_ar_pi+$prime_total_sr_pi;

        $prime_nette +=  $prime_nette_pi;
        $nb_act+= $nb_act_pi;
        $Accessoire+=  $Accessoire_pi;
        $prime_commerciale+= $prime_commerciale_pi;
        $dt+=$dt_pi;
        $prime_total+= $prime_total_pi;
        $pdf->SetFont('Arial','',10);
        $pdf->SetFillColor(199,139,85);

        $pdf->Cell(50,28,''.$produits,'1','0','C');
        $pdf->Cell(70,7,'Production (+)','1','0','L');
        $pdf->Cell(20,7,''.$nb_act_positive_pi,'1','0','C');
        $pdf->Cell(50,7,''.number_format($prime_nette_positive_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(40,7,''.number_format($Accessoire_positive_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(50,7,''.number_format($prime_commerciale_positive_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(30,7,''.number_format($dt_positifs_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(50,7,''.number_format($prime_total_positive_pi, 2,',',' ').'','1','0','R');
        $pdf->Ln(7);
        $X=$pdf->GetX();
        $pdf->SetX($X+50);

        // $pdf->Cell(50,10,''.$produits,'1','0','C');
        $pdf->Cell(70,7,'Avenant (-) Avec ristourne','1','0','L');
        $pdf->Cell(20,7,''.$nb_act_ar_pi,'1','0','C');
        $pdf->Cell(50,7,''.number_format($prime_nette_ar_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(40,7,''.number_format($Accessoire_ar_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(50,7,''.number_format($prime_commerciale_ar_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(30,7,''.number_format($dt_ar_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(50,7,''.number_format($prime_total_ar_pi, 2,',',' ').'','1','0','R');

        $pdf->Ln(7);
        $X=$pdf->GetX();
        $pdf->SetX($X+50);
        // $pdf->Cell(50,10,''.$produits,'1','0','C');
        $pdf->Cell(70,7,'Avenant (-) sans ristourne','1','0','L');
        $pdf->Cell(20,7,''.$nb_act_sr_pi,'1','0','C');
        $pdf->Cell(50,7,''.number_format($prime_nette_sr_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(40,7,''.number_format($Accessoire_sr_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(50,7,''.number_format($prime_commerciale_sr_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(30,7,''.number_format($dt_sr_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(50,7,''.number_format($prime_total_sr_pi, 2,',',' ').'','1','0','R');

        $pdf->Ln(7);
        $X=$pdf->GetX();
        $pdf->SetX($X+50);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(199,139,85);
        //  $pdf->Cell(50,10,''.$produits,'1','0','C');
        $pdf->Cell(70,7,'Total','1','0','C');
        $pdf->Cell(20,7,''.$nb_act_pi,'1','0','C');
        $pdf->Cell(50,7,''.number_format($prime_nette_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(40,7,''.number_format($Accessoire_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(50,7,''.number_format($prime_commerciale_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(30,7,''.number_format($dt_pi, 2,',',' ').'','1','0','R');
        $pdf->Cell(50,7,''.number_format($prime_total_pi, 2,',',' ').'','1','0','R');

        $pdf->Ln(7);

        //production positive
        $prime_nette_positive_pi=0;
        $nb_act_positive_pi=0;
        $Accessoire_positive_pi=0;
        $prime_commerciale_positive_pi=0;
        $dt_positifs_pi=0;
        $prime_total_positive_pi=0;

        //production avec ristourne
        $prime_nette_ar_pi=0;
        $nb_act_ar_pi=0;
        $Accessoire_ar_pi=0;
        $prime_commerciale_ar_pi=0;
        $dt_ar_pi=0;
        $prime_total_ar_pi=0;

        //production sans ristourne.
        $prime_nette_sr_pi=0;
        $nb_act_sr_pi=0;
        $Accessoire_sr_pi=0;
        $prime_commerciale_sr_pi=0;
        $dt_sr_pi=0;
        $prime_total_sr_pi=0;
        //total production produit pi
        $prime_nette_pi=0;
        $nb_act_pi=0;
        $Accessoire_pi=0;
        $prime_commerciale_pi=0;
        $dt_pi=0;
        $prime_total_pi=0;

    }
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(199,139,85);
    $pdf->Cell(120,10,'Total','1','0','C');
    $pdf->Cell(20,10,''.$nb_act,'1','0','C');
    $pdf->Cell(50,10,''.number_format($prime_nette, 2,',',' ').'','1','0','R');
    $pdf->Cell(40,10,''.number_format($Accessoire, 2,',',' ').'','1','0','R');
    $pdf->Cell(50,10,''.number_format($prime_commerciale, 2,',',' ').'','1','0','R');
    $pdf->Cell(30,10,''.number_format($dt, 2,',',' ').'','1','0','R');
    $pdf->Cell(50,10,''.number_format($prime_total, 2,',',' ').'','1','0','R');

    $pdf->Ln(20);


    $pdf->SetFont('Arial','B',14);
    $pdf->SetFillColor(199,139,85);
    $pdf->Cell(320,10," DRE Le:    ".date("d/m/Y", strtotime($datesys)) ,'','0','R');  $pdf->Ln(10);
    $pdf->Cell(390,10,"Cachet et signature " ,'','0','R');$pdf->Ln(10);
    $pdf->SetX(290);
    // $pdf->Cell(100,10,"".$nom_user." ".$pnom_user ,'','0','L');


    $pdf->Output();


}
?>