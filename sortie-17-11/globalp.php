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
$datesys=date("Y/m/d");
include("convert.php");
include("entete.php");
  date_default_timezone_set('UTC');

// Instanciation de la classe derivee
$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage(); 
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(199,139,85);
$pdf->SetFont('Arial','B',15);

$tpn=0;$tcp=0;$tpc=0;$tdt=0;$tpt=0;
//Parametres
$rqtp=$bdd->prepare("SELECT a.`agence`, p.`lib_prod`,p.`code_prod` FROM `utilisateurs` as a,`produit` as p WHERE p.cod_prod='$prod' and a.id_user='$user'");
$rqtp->execute();
//requete pour les contrats
$rqtg=$bdd->prepare("SELECT d.`dat_val`,d.`dat_eff`,d.`dat_ech`,d.`sequence`,d.`pn`,d.`pt`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod` ,s.`nom_sous`, s.`pnom_sous`,m.`lib_mpay`,u.`agence` FROM `policew` as d, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s, `mpay` as m, `utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND d.`mode`=m.`cod_mpay` AND s.`id_user`='$user' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.`id_user`='$user'");
$rqtg->execute();
//requete pour les avenants
$rqtv=$bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`='$user' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.`id_user`='$user' AND d.`lib_mpay` not in ('30','50')");
$rqtv->execute();
$pdf->Cell(280,10,'Bordereau de production positif du '.date("d/m/Y", strtotime($date1)).' au '.date("d/m/Y", strtotime($date2)).'  --Document généré le-- '.date("d/m/Y", strtotime($datesys)) ,'1','1','L','1');
while ($row_p=$rqtp->fetch()){
$pdf->Cell(100,10,'AgenceN°: '.$row_p['agence'],'1','0','C');$pdf->Cell(90,10,'Produit: '.$row_p['lib_prod'],'1','0','C');$pdf->Cell(90,10,'Code produit: '.$row_p['code_prod'],'1','1','C');
}
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,5,'Police N°','1','0','C');$pdf->Cell(40,5,'Avenant N°','1','0','C');$pdf->Cell(50,5,'Nom&Prénom-R.Sociale','1','0','C');
$pdf->Cell(18,5,'Emmision','1','0','C');$pdf->Cell(16,5,'Effet','1','0','C');$pdf->Cell(16,5,'Echéance','1','0','C');

$pdf->Cell(20,5,'P.Nette','1','0','C');$pdf->Cell(20,5,'C.Police','1','0','C');$pdf->Cell(20,5,'P.Commer','1','0','C');$pdf->Cell(20,5,'D.Timbre','1','0','C');$pdf->Cell(20,5,'P.Total','1','0','C');
//Boucle police
while ($row_g=$rqtg->fetch()){
$pdf->SetFillColor(221,221,221);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
//Reporting Polices
$pdf->Cell(40,5,''.$row_g['agence'].'.'.substr($row_g['dat_val'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','1','0','C');
$pdf->Cell(40,5,'--','1','0','C');
$pdf->Cell(50,5,"".$row_g['nom_sous'].' '.$row_g['pnom_sous']."",'1','0','C');
$pdf->Cell(18,5,''.date("d/m/Y", strtotime($row_g['dat_val'])).'','1','0','C');$pdf->Cell(16,5,''.date("d/m/Y", strtotime($row_g['dat_eff'])).'','1','0','C');$pdf->Cell(16,5,''.date("d/m/Y", strtotime($row_g['dat_ech'])).'','1','0','C');

$pdf->Cell(20,5,''.number_format($row_g['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_g['pn'];
$pdf->Cell(20,5,''.number_format($row_g['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_g['mtt_cpl'];
$pdf->Cell(20,5,''.number_format($row_g['pn']+$row_g['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_g['pn']+$row_g['mtt_cpl']);
$pdf->Cell(20,5,''.number_format($row_g['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_g['mtt_dt'];
$pdf->Cell(20,5,''.number_format($row_g['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_g['pt'];
}
//boucle Avenants
while ($row_v=$rqtv->fetch()){
$pdf->SetFillColor(221,221,221);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
//Reporting Polices
$pdf->Cell(40,5,''.$row_v['agence'].'.'.substr($row_v['datev'],0,4).'.10.'.$row_v['code_prod'].'.'.str_pad((int) $row_v['seq2'],'5',"0",STR_PAD_LEFT).'','1','0','C');
$pdf->Cell(40,5,''.$row_v['agence'].'.'.substr($row_v['dat_val'],0,4).'.'.$row_v['lib_mpay'].'.'.$row_v['code_prod'].'.'.str_pad((int) $row_v['sequence'],'5',"0",STR_PAD_LEFT).'','1','0','C');
$pdf->Cell(50,5,"".$row_v['nom_sous'].' '.$row_v['pnom_sous']."",'1','0','C');
$pdf->Cell(18,5,''.date("d/m/Y", strtotime($row_v['dat_val'])).'','1','0','C');$pdf->Cell(16,5,'----','1','0','C');$pdf->Cell(16,5,'----','1','0','C');

$pdf->Cell(20,5,''.number_format($row_v['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_v['pn'];
$pdf->Cell(20,5,''.number_format($row_v['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_v['mtt_cpl'];
$pdf->Cell(20,5,''.number_format($row_v['pn']+$row_v['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_v['pn']+$row_v['mtt_cpl']);
$pdf->Cell(20,5,''.number_format($row_v['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_v['mtt_dt'];
$pdf->Cell(20,5,''.number_format($row_v['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_v['pt'];
}
$pdf->Ln();

$pdf->Cell(180,5,'TOTAUX','1','0','C');$pdf->Cell(20,5,''.number_format($tpn, 2,',',' ').'','1','0','C');$pdf->Cell(20,5,''.number_format($tcp, 2,',',' ').'','1','0','C');$pdf->Cell(20,5,''.number_format($tpc, 2,',',' ').'','1','0','C');$pdf->Cell(20,5,''.number_format($tdt, 2,',',' ').'','1','0','C');$pdf->Cell(20,5,''.number_format($tpt, 2,',',' ').'','1','0','C');

$pdf->Output();


















}
?>