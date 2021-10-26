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
    require('fpdf.php');

    class PDF extends FPDF
    {
// En-t?te
        function Header()
        {
            $this->SetFont('Arial', 'B', 10);
            $this->Image('../img/entete_bna.png',6,4,390);
            $this->Cell(150, 5, '', 'O', '0', 'L');
            $this->SetFont('Arial', 'B', 12);
            // $this->Cell(60,5,'MAPFRE | Assistance','O','0','L');
            $this->SetFont('Arial', 'B', 10);
            $this->Ln(30);
        }

// Pied de page
        function Footer()
        {
            // Positionnement ? 1,5 cm du bas
            $this->SetY(-15);
            // Police Arial italique 8
            $this->SetFont('Arial', 'I', 6);
            // Num?ro de page
            $this->Cell(0, 8, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
            $this->Ln(3);
            $this->Cell(0, 8, "Algerian Gulf Life Insurance Company, SPA au capital social de 1.000.000.000 de dinars algériens, 01 Rue Tripoli, hussein Dey Alger,  ", 0, 0, 'C');
            $this->Ln(2);
            $this->Cell(0, 8, "RC : 16/00-1009727 B 15   NIF : 001516100972762-NIS :0015160900296000", 0, 0, 'C');
            $this->Ln(2);
            $this->Cell(0, 8, "Tel : +213 (0) 21 77 30 12/14/15 Fax : +213 (0) 21 77 29 56 Site Web : www.aglic.dz  ", 0, 0, 'C');
        }
    }

    $pdf = new PDF('L','mm','A3');//330
    //$pdf = new PDF('L');//330
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(255,255,255);

    $rqtp = $bdd->prepare("SELECT a.`agence` FROM `utilisateurs` as a WHERE  a.id_user='$user'");
    $rqtp->execute();
    while ($row_p=$rqtp->fetch()){ $agenceDR=$row_p['agence'];}

    $pdf->Ln(30);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(199,139,85);
    $pdf->SetFont('Arial','B',35);
// Instanciation de la classe derivee
    $pdf->Cell(390,10,'Production ' ,'','1','C');
    $pdf->Ln(15);
    $pdf->SetFont('Arial','B',15);
    if ($agence == 0) {
        $pdf->Cell(330, 10, 'DR N°: ' . $agenceDR, '', '0', 'L');
    }else
    {
        $pdf->Cell(330, 10, 'Agence N°: ' . $agence, '', '0', 'L');
    }
    $pdf->Ln(15);
    $pdf->Cell(190,10,'Du '.date("d/m/Y", strtotime($date1)).' au '.date("d/m/Y", strtotime($date2)) ,'','1','L');    $pdf->Cell(390,10,'Document généré le-- '.date("d/m/Y", strtotime($datesys)) ,'','1','R');
    $pdf->Ln(10);


    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(75,10,'Produit','1','0','C','1'); $pdf->Cell(20,10,'Nombre','1','0','C','1');$pdf->Cell(50,10,'P.Nette','1','0','C','1');$pdf->Cell(40,10,'Accessoire','1','0','C','1');$pdf->Cell(50,10,'Ristourne','1','0','C','1');$pdf->Cell(50,10,'P.Com','1','0','C','1');$pdf->Cell(30,10,'D.Timbre','1','0','C','1');$pdf->Cell(75,10,'P.Totale','1','0','C','1');
//Boucle police
    $p_n=0;$nb_acte=0;$acc=0;$d_timbre=0;$rist=0;$p_com=0;$ttc=0;
    $pdf->SetFillColor(221,221,221);
    $pdf->Ln();
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial','',12);
//Reporting Polices
    //LISTE PRODUITS
    $rqtprod=$bdd->prepare("select * from produit WHERE cod_prod not in (3,4)");
    $rqtprod->execute();
    // production positive
    while ($rowprod=$rqtprod->fetch()) {

        $cod_prod = $rowprod['cod_prod'];
        $lib_prod = $rowprod['lib_prod'];
        if ($agence == 0) {
            $rqt = $bdd->prepare("
select sum(table1.code) as nb, sum(table1.prime_nette) as prime_nette, sum(table1.cout_police) as cout_police,sum(table1.ristourne)as ristourne,sum(table1.prime_nette)+sum(table1.cout_police)+sum(table1.ristourne) as prime_commerciale, sum(table1.droit_timbre) as droit_timbre, sum(table1.prime_nette)+sum(table1.cout_police)+sum(table1.ristourne)+ sum(table1.droit_timbre) as prime_totale
from
(


SELECT p1.cod_pol as n,p1.sequence as sequence,1 as code,p1.pn as prime_nette,c1.mtt_cpl as cout_police,d1.mtt_dt as droit_timbre,0 as ristourne

FROM `policew` as p1 ,cpolice as c1 ,dtimbre as d1,souscripteurw as s1,utilisateurs as u1

WHERE p1.cod_cpl=c1.cod_cpl and p1.cod_dt=d1.cod_dt
      and DATE_FORMAT(p1.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'
      and p1.cod_sous=s1.cod_sous and s1.id_user=u1.id_user and u1.id_par='$user' and p1.cod_prod='$cod_prod'


UNION



SELECT  av.cod_av as n,av.sequence as sequence,0 as code,av.`pn` as prime_nette,c2.`mtt_cpl` as cout_police,t2.`mtt_dt` as droit_timbre,0 as ristourne

 FROM `avenantw` as av,`policew` as z, `dtimbre` as t2 , `cpolice` as c2,`souscripteurw` as s2,`utilisateurs` as u2

 WHERE av.`cod_dt`=t2.`cod_dt` AND av.`cod_cpl`=c2.`cod_cpl`  AND av.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s2.`cod_sous`
 AND s2.`id_user`=u2.`id_user` AND av.`cod_prod`='$cod_prod' AND DATE_FORMAT(av.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'
 AND u2.`id_par`='$user' AND av.`lib_mpay` not in('30')



UNION

SELECT  av3.cod_av as n,av3.sequence as sequence,0 as code,0 as prime_nette,c3.`mtt_cpl` as cout_police,t3.`mtt_dt` as droit_timbre,av3.`pn` as ristourne

 FROM `avenantw` as av3,`policew` as z3, `dtimbre` as t3 , `cpolice` as c3,`souscripteurw` as s3,`utilisateurs` as u3

 WHERE av3.`cod_dt`=t3.`cod_dt` AND av3.`cod_cpl`=c3.`cod_cpl`  AND av3.`cod_pol`=z3.`cod_pol` AND z3.`cod_sous`=s3.`cod_sous`
 AND s3.`id_user`=u3.`id_user` AND av3.`cod_prod`='$cod_prod' AND DATE_FORMAT(av3.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'
 AND u3.`id_par`='$user' AND av3.`lib_mpay` in('30')


) AS table1

");


        }
        else{

        $rqt = $bdd->prepare("
select sum(table1.code) as nb, sum(table1.prime_nette) as prime_nette, sum(table1.cout_police) as cout_police,sum(table1.ristourne)as ristourne,sum(table1.prime_nette)+sum(table1.cout_police)+sum(table1.ristourne) as prime_commerciale, sum(table1.droit_timbre) as droit_timbre, sum(table1.prime_nette)+sum(table1.cout_police)+sum(table1.ristourne)+ sum(table1.droit_timbre) as prime_totale
from
(


SELECT p1.cod_pol as n,p1.sequence as sequence,1 as code,p1.pn as prime_nette,c1.mtt_cpl as cout_police,d1.mtt_dt as droit_timbre,0 as ristourne

FROM `policew` as p1 ,cpolice as c1 ,dtimbre as d1,souscripteurw as s1,utilisateurs as u1

WHERE p1.cod_cpl=c1.cod_cpl and p1.cod_dt=d1.cod_dt
      and DATE_FORMAT(p1.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'
      and p1.cod_sous=s1.cod_sous and s1.id_user=u1.id_user and u1.agence='$agence' and p1.cod_prod='$cod_prod'


UNION



SELECT  av.cod_av as n,av.sequence as sequence,0 as code,av.`pn` as prime_nette,c2.`mtt_cpl` as cout_police,t2.`mtt_dt` as droit_timbre,0 as ristourne

 FROM `avenantw` as av,`policew` as z, `dtimbre` as t2 , `cpolice` as c2,`souscripteurw` as s2,`utilisateurs` as u2

 WHERE av.`cod_dt`=t2.`cod_dt` AND av.`cod_cpl`=c2.`cod_cpl`  AND av.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s2.`cod_sous`
 AND s2.`id_user`=u2.`id_user` AND av.`cod_prod`='$cod_prod' AND DATE_FORMAT(av.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'
 AND u2.`agence`='$agence' AND av.`lib_mpay` not in('30')



UNION

SELECT  av3.cod_av as n,av3.sequence as sequence,0 as code,0 as prime_nette,c3.`mtt_cpl` as cout_police,t3.`mtt_dt` as droit_timbre,av3.`pn` as ristourne

 FROM `avenantw` as av3,`policew` as z3, `dtimbre` as t3 , `cpolice` as c3,`souscripteurw` as s3,`utilisateurs` as u3

 WHERE av3.`cod_dt`=t3.`cod_dt` AND av3.`cod_cpl`=c3.`cod_cpl`  AND av3.`cod_pol`=z3.`cod_pol` AND z3.`cod_sous`=s3.`cod_sous`
 AND s3.`id_user`=u3.`id_user` AND av3.`cod_prod`='$cod_prod' AND DATE_FORMAT(av3.`dat_val`,'%Y-%m-%d') between '$date1' and '$date2'
 AND u3.`agence`='$agence' AND av3.`lib_mpay` in('30')


) AS table1

");
    }
        $rqt->execute();
        $p_n_pr=0;$nb_acte_pr=0;$acc_pr=0;$d_timbre_pr=0;$rist_pr=0;$p_com_pr=0;$ttc_pr=0;
        while ($rwp=$rqt->fetch())
        {
            //sum(table1.code) as nb, sum(table1.prime_nette) as prime_nette, sum(table1.cout_police) as cout_police,sum(table1.ristourne)as ristourne,sum(table1.prime_nette)+sum(table1.cout_police)+sum(table1.ristourne) as prime_commerciale, sum(table1.droit_timbre) as droit_timbre, sum(table1.prime_nette)+sum(table1.cout_police)+sum(table1.ristourne)+ sum(table1.droit_timbre) as prime_totale
            $p_n_pr=$rwp['prime_nette'];
            $nb_acte_pr=$rwp['nb'];
            $acc_pr=$rwp['cout_police'];
            $d_timbre_pr=$rwp['droit_timbre'];
            $rist_pr=$rwp['ristourne'];
            $p_com_pr=$rwp['prime_commerciale'];
            $ttc_pr=$rwp['prime_totale'];

        }
        $p_n+=$p_n_pr;$nb_acte+=$nb_acte_pr;$acc+=$acc_pr;$d_timbre+=$d_timbre_pr;$rist+=$rist_pr;$p_com+=$p_com_pr;$ttc+=$ttc_pr;


        $pdf->Cell(75,10,''.$lib_prod,'1','0','C');
        $pdf->Cell(20,10,''.number_format($nb_acte_pr, 2,',',' '),'1','0','C');
        $pdf->Cell(50,10,''.number_format($p_n_pr, 2,',',' '),'1','0','C');
        $pdf->Cell(40,10,''.number_format($acc_pr, 2,',',' '),'1','0','C');
        $pdf->Cell(50,10,''.number_format($rist_pr, 2,',',' '),'1','0','C');
        $pdf->Cell(50,10,''.number_format($p_com_pr, 2,',',' '),'1','0','C');
        $pdf->Cell(30,10,''.number_format($d_timbre_pr, 2,',',' '),'1','0','C');
        $pdf->Cell(75,10,''.number_format($ttc_pr, 2,',',' '),'1','0','C');
        $pdf->Ln();


    }
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(75,10,'Total','1','0','C');
    $pdf->Cell(20,10,''.number_format($nb_acte, 2,',',' '),'1','0','C');
    $pdf->Cell(50,10,''.number_format($p_n, 2,',',' '),'1','0','C');
    $pdf->Cell(40,10,''.number_format($acc, 2,',',' '),'1','0','C');
    $pdf->Cell(50,10,''.number_format($rist, 2,',',' '),'1','0','C');
    $pdf->Cell(50,10,''.number_format($p_com, 2,',',' '),'1','0','C');
    $pdf->Cell(30,10,''.number_format($d_timbre, 2,',',' '),'1','0','C');
    $pdf->Cell(75,10,''.number_format($ttc, 2,',',' '),'1','0','C');
    $pdf->Ln(25);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(370,10,'Cachet et signature','','0','R');
    $pdf->Output();
}
?>