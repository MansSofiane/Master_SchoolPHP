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

		$rqtp = $bdd->prepare("SELECT a.`agence`, p.`lib_prod`,p.`code_prod` FROM `utilisateurs` as a,`produit` as p WHERE p.cod_prod='$prod' and a.id_user='$user'");
		$rqtp->execute();
//requete pour les contrats
		$rqtg = $bdd->prepare("SELECT d.`dat_val`,d.`dat_eff`,d.`dat_ech`,d.`sequence`,d.`pn`,d.`pt`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod` ,s.`nom_sous`, s.`pnom_sous`,m.`lib_mpay`,u.`agence` FROM `policew` as d, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s, `mpay` as m, `utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND d.`mode`=m.`cod_mpay` AND s.`id_user`='$user' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.`id_user`='$user'");
		$rqtg->execute();
//requete pour les avenants positifs
		$rqtv = $bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`='$user' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.`id_user`='$user' and d.`lib_mpay` not in ('30','50') order by d.`lib_mpay`");
		$rqtv->execute();

	//requete pour les avenants sans ristourne
	$rqtvsr = $bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`='$user' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.`id_user`='$user' and d.`lib_mpay`  in ('50')");
	$rqtvsr->execute();

	//requete pour les avenants avec ristourne
	$rqtvar = $bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`='$user' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.`id_user`='$user' and d.`lib_mpay`  in ('30')");
	$rqtvar->execute();


	$pdf->Cell(280,10,'Bordereau de production global du '.date("d/m/Y", strtotime($date1)).' au '.date("d/m/Y", strtotime($date2)).'  --Document généré le-- '.date("d/m/Y", strtotime($datesys)) ,'1','1','L','1');
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
	$pdf->Ln();
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','IB',10);
	$pdf->SetFillColor(192,195,198);

	$pdf->Cell(180,5,'TOTAL, POLICES  ','1','0','L','1');

	$pdf->Cell(20,5,''.number_format($tpn, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($tcp, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($tpc, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($tdt, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($tpt, 2,',',' ').'','1','0','C','1');

	$ppn_av=0;$ppt_av=0;$pcpol_av=0;$pccom_av=0;$pdtim_av=0;//1
//boucle Avenants POSITIFS
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

$pdf->Cell(20,5,''.number_format($row_v['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_v['pn'];/* pn avenant */$ppn_av=$ppn_av+$row_v['pn'];
$pdf->Cell(20,5,''.number_format($row_v['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_v['mtt_cpl'];/* cout police avenant*/$pcpol_av=$pcpol_av+$row_v['mtt_cpl'];
$pdf->Cell(20,5,''.number_format($row_v['pn']+$row_v['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_v['pn']+$row_v['mtt_cpl']);/*prime commerciale avenant*/$pccom_av=$pccom_av+($row_v['pn']+$row_v['mtt_cpl']);
$pdf->Cell(20,5,''.number_format($row_v['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_v['mtt_dt'];/*droit timbre avenant*/$pdtim_av=$pdtim_av+$row_v['mtt_dt'];
$pdf->Cell(20,5,''.number_format($row_v['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_v['pt'];/*pt avenant*/$ppt_av=$ppt_av+$row_v['pt'];
}
$pdf->Ln();
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','IB',10);
	$pdf->SetFillColor(192,195,198);


	$pdf->Cell(180,5,'TOTAL, Avenants positifs  ','1','0','L','1');
	$pdf->Cell(20,5,''.number_format($ppn_av, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pcpol_av, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pccom_av, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pdtim_av, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($ppt_av, 2,',',' ').'','1','0','C','1');
	$pdf->Ln();
	$pdf->SetFillColor(128,126,125);
	$pdf->Cell(180,5,'TOTAL, Production positive  ','1','0','L','1');
	$pdf->Cell(20,5,''.number_format($tpn, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($tcp, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($tpc, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($tdt, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($tpt, 2,',',' ').'','1','0','C','1');


//boucle Avenants SANS RISTOURNE
	$ppn_sr=0;$ppt_sr=0;$pcpol_sr=0;$pccom_sr=0;$pdtim_sr=0;//1
	//boucle Avenants sans ristourne
	while ($row_vsr=$rqtvsr->fetch()){
		$pdf->SetFillColor(221,221,221);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',8);
//Reporting Polices
		$pdf->Cell(40,5,''.$row_vsr['agence'].'.'.substr($row_vsr['datev'],0,4).'.10.'.$row_vsr['code_prod'].'.'.str_pad((int) $row_vsr['seq2'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(40,5,''.$row_vsr['agence'].'.'.substr($row_vsr['dat_val'],0,4).'.'.$row_vsr['lib_mpay'].'.'.$row_vsr['code_prod'].'.'.str_pad((int) $row_vsr['sequence'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(50,5,"".$row_vsr['nom_sous'].' '.$row_vsr['pnom_sous']."",'1','0','C');
		$pdf->Cell(18,5,''.date("d/m/Y", strtotime($row_vsr['dat_val'])).'','1','0','C');$pdf->Cell(16,5,'----','1','0','C');$pdf->Cell(16,5,'----','1','0','C');

		$pdf->Cell(20,5,''.number_format($row_vsr['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_vsr['pn'];/* pn avenant */$ppn_sr=$ppn_sr+$row_vsr['pn'];
		$pdf->Cell(20,5,''.number_format($row_vsr['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_vsr['mtt_cpl'];/* cout police avenant*/$pcpol_sr=$pcpol_sr+$row_vsr['mtt_cpl'];
		$pdf->Cell(20,5,''.number_format($row_vsr['pn']+$row_vsr['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_vsr['pn']+$row_vsr['mtt_cpl']);/*prime commerciale avenant*/$pccom_sr=$pccom_sr+($row_vsr['pn']+$row_vsr['mtt_cpl']);
		$pdf->Cell(20,5,''.number_format($row_vsr['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_vsr['mtt_dt'];/*droit timbre avenant*/$pdtim_sr=$pdtim_sr+$row_vsr['mtt_dt'];
		$pdf->Cell(20,5,''.number_format($row_vsr['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_vsr['pt'];/*pt avenant*/$ppt_sr=$ppt_sr+$row_vsr['pt'];
	}
	$pdf->Ln();
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','IB',10);
	$pdf->SetFillColor(128,126,125);

	$pdf->Cell(180,5,'TOTAL, Avenants sans ristourne  ','1','0','L','1');

	$pdf->Cell(20,5,''.number_format($ppn_sr, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pcpol_sr, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pccom_sr, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pdtim_sr, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($ppt_sr, 2,',',' ').'','1','0','C','1');

//boucle Avenants AVEC RISTOURNE
	$ppn_ar=0;$ppt_ar=0;$pcpol_ar=0;$pccom_ar=0;$pdtim_ar=0;//1
	//boucle Avenants sans ristourne
	while ($row_var=$rqtvar->fetch()){
		$pdf->SetFillColor(221,221,221);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',8);
//Reporting Polices
		$pdf->Cell(40,5,''.$row_var['agence'].'.'.substr($row_var['datev'],0,4).'.10.'.$row_var['code_prod'].'.'.str_pad((int) $row_var['seq2'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(40,5,''.$row_var['agence'].'.'.substr($row_var['dat_val'],0,4).'.'.$row_var['lib_mpay'].'.'.$row_var['code_prod'].'.'.str_pad((int) $row_var['sequence'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(50,5,"".$row_var['nom_sous'].' '.$row_var['pnom_sous']."",'1','0','C');
		$pdf->Cell(18,5,''.date("d/m/Y", strtotime($row_var['dat_val'])).'','1','0','C');$pdf->Cell(16,5,'----','1','0','C');$pdf->Cell(16,5,'----','1','0','C');

		$pdf->Cell(20,5,''.number_format($row_var['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_var['pn'];/* pn avenant */$ppn_ar=$ppn_ar+$row_var['pn'];
		$pdf->Cell(20,5,''.number_format($row_var['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_var['mtt_cpl'];/* cout police avenant*/$pcpol_ar=$pcpol_ar+$row_var['mtt_cpl'];
		$pdf->Cell(20,5,''.number_format($row_var['pn']+$row_var['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_var['pn']+$row_var['mtt_cpl']);/*prime commerciale avenant*/$pccom_ar=$pccom_ar+($row_var['pn']+$row_var['mtt_cpl']);
		$pdf->Cell(20,5,''.number_format($row_var['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_var['mtt_dt'];/*droit timbre avenant*/$pdtim_ar=$pdtim_ar+$row_var['mtt_dt'];
		$pdf->Cell(20,5,''.number_format($row_var['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_var['pt'];/*pt avenant*/$ppt_ar=$ppt_ar+$row_var['pt'];
	}
	$pdf->Ln();
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','IB',10);
	$pdf->SetFillColor(128,126,125);


	$pdf->Cell(180,5,'TOTAL, Avenants Avec ristourne  ','1','0','L','1');

	$pdf->Cell(20,5,''.number_format($ppn_ar, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pcpol_ar, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pccom_ar, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($pdtim_ar, 2,',',' ').'','1','0','C','1');
	$pdf->Cell(20,5,''.number_format($ppt_ar, 2,',',' ').'','1','0','C','1');
	$pdf->Ln();
	$pdf->SetFillColor(180,203,106);
$pdf->Cell(180,5,'TOTAL GENERAL','1','0','C','1');$pdf->Cell(20,5,''.number_format($tpn, 2,',',' ').'','1','0','C','1');$pdf->Cell(20,5,''.number_format($tcp, 2,',',' ').'','1','0','C','1');$pdf->Cell(20,5,''.number_format($tpc, 2,',',' ').'','1','0','C','1');$pdf->Cell(20,5,''.number_format($tdt, 2,',',' ').'','1','0','C','1');$pdf->Cell(20,5,''.number_format($tpt, 2,',',' ').'','1','0','C','1');

$pdf->Output();

}
?>