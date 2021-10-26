<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){$user=$_SESSION['id_usersal'];}
else {
header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}

if (isset($_REQUEST['d1']) && isset($_REQUEST['p']) && isset($_REQUEST['u']) && isset($_REQUEST['d2'])) {
$date1 = $_REQUEST['d1'];
$prod = $_REQUEST['p'];
$agence = $_REQUEST['u'];//CODE AGENCE
$date2 = $_REQUEST['d2'];
$datesys=date("Y/m/d");
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

$tpn=0;$tcp=0;$tpc=0;$tdt=0;$tpt=0;
//Parametres

$rqtp=$bdd->prepare("SELECT  p.`lib_prod`,p.`code_prod` FROM `produit` as p WHERE p.cod_prod='$prod' ");
$rqtp->execute();


//Requete général


//Requete Direction Régionales
if($agence=='0'){
//requete pour les contrats
$rqtg=$bdd->prepare("SELECT d.`dat_val`,d.`sequence`,d.`pn`,d.`pt`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod` ,s.`nom_sous`, s.`pnom_sous`,m.`lib_mpay`,u.`agence` FROM `policew` as d, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s, `mpay` as m, `utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND d.`mode`=m.`cod_mpay` AND s.`id_user`=u.`id_user` AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.id_par='$user' ORDER BY u.`agence`");
$rqtg->execute();
//requete pour les avenants POSITIFS
	$rqtvp=$bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`=u.`id_user` AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.id_par='$user' and d.`lib_mpay` not in ('30','50') order by u.`agence`, d.`lib_mpay`");
	$rqtvp->execute();

	//requete pour les avenants SANS RISTOURNE
	$rqtvsr=$bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`=u.`id_user` AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.id_par='$user' and d.`lib_mpay`  in ('50') order by u.`agence`, d.`lib_mpay`");
	$rqtvsr->execute();

	//requete pour les avenants AVEC RISTOURNE
	$rqtvar=$bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`=u.`id_user` AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2' AND u.id_par='$user' and d.`lib_mpay`  in ('30') order by u.`agence`, d.`lib_mpay`");
	$rqtvar->execute();
}else{
//Requete Agence
//requete pour les contrats
$rqtg=$bdd->prepare("SELECT d.`dat_val`,d.`sequence`,d.`pn`,d.`pt`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod` ,s.`nom_sous`, s.`pnom_sous`,m.`lib_mpay`,u.`agence` FROM `policew` as d, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s, `mpay` as m, `utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_sous`=s.`cod_sous` AND d.`mode`=m.`cod_mpay` AND s.`id_user`=u.`id_user` AND u.`agence`='$agence' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2'  ORDER BY u.`agence`");
$rqtg->execute();
//requete pour les avenants positifs.
$rqtvp=$bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`=u.`id_user` AND u.`agence`='$agence' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2'  and d.`lib_mpay` not in ('30','50') order by u.`agence`,d.`lib_mpay`");
$rqtvp->execute();

	//requete pour les avenants sans ristourne
	$rqtvsr=$bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`=u.`id_user` AND u.`agence`='$agence' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2'  and d.`lib_mpay`  in ('50') order by u.`agence`,d.`lib_mpay`");
	$rqtvsr->execute();


	//requete pour les avenants avec ristourne
	$rqtvar=$bdd->prepare("SELECT d.`dat_val`,d.`pn`,d.`pn`,d.`pt`,d.`lib_mpay`,d.`sequence`,t.`mtt_dt`,c.`mtt_cpl`,p.`code_prod`,p.`lib_prod`, s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,z.sequence as seq2, z.dat_val as datev,u.`agence`  FROM `avenantw` as d,`policew` as z, `dtimbre` as t , `cpolice` as c,`produit` as p,`souscripteurw` as s,`utilisateurs` as u  WHERE d.`cod_dt`=t.`cod_dt` AND d.`cod_cpl`=c.`cod_cpl` AND d.`cod_prod`=p.`cod_prod` AND d.`cod_pol`=z.`cod_pol` AND z.`cod_sous`=s.`cod_sous` AND s.`id_user`=u.`id_user` AND u.`agence`='$agence' AND d.`cod_prod`='$prod' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')>='$date1' AND DATE_FORMAT(d.`dat_val`,'%Y-%m-%d')<='$date2'  and d.`lib_mpay`  in ('30') order by u.`agence`,d.`lib_mpay`");
	$rqtvar->execute();


}




$pdf->Cell(280,10,'Bordereau de production  du '.date("d/m/Y", strtotime($date1)).' au '.date("d/m/Y", strtotime($date2)).'  --Document généré le-- '.date("d/m/Y", strtotime($datesys)) ,'1','1','L','1');
while ($row_p=$rqtp->fetch()){
$pdf->Cell(100,10,'Direction Régionale','1','0','C');$pdf->Cell(90,10,'Produit: '.$row_p['lib_prod'],'1','0','C');$pdf->Cell(90,10,'Code produit: '.$row_p['code_prod'],'1','1','C');
}
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,5,'Police N°','1','0','C');$pdf->Cell(50,5,'Avenant N°','1','0','C');$pdf->Cell(60,5,'Nom&Prénom-R.Sociale','1','0','C');$pdf->Cell(24,5,'P.Nette','1','0','C');$pdf->Cell(24,5,'C.Police','1','0','C');$pdf->Cell(24,5,'P.Commerciale','1','0','C');$pdf->Cell(24,5,'D.Timbre','1','0','C');$pdf->Cell(24,5,'P.Total','1','0','C');
	$pdf->Ln();
//Boucle police
	$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;//1
	$ppn=0;$ppt=0;$pcpol=0;$pccom=0;$pdtim=0;//1
	$pagencei='0';$pprod=0;//2
	while ($row_g=$rqtg->fetch()){
//

		if($pagencei=='0')
		{
			$pagencei=$row_g['agence'];
		}
		$pprod=1;// pour afficher le sous total en cas d'existance d'une seule agence en production
		//test si $agencei!=agencei++  si oui affichier les sous totaux
		if($pagencei!=$row_g['agence'])
		{
			/*SOUS TOTAL AGENCE*/
			$pdf->SetTextColor(7, 27, 181);
			$pdf->SetFont('Arial','IB',8);
			$pdf->Cell(50,5,'TOTAUX, POLICES AGENCE '.$pagencei,'1','0','L');
			$pdf->SetFont('Arial','IB',10);
			$pdf->Cell(50,5,'--','1','0','C');
			$pdf->Cell(60,5,"--",'1','0','C');
			$pdf->Cell(24,5,''.number_format($ppn_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($pccom_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($ppn_ag+$pccom_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($pdtim_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($ppt_ag, 2,',',' ').'','1','0','C');
			$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;
			$pagencei=$row_g['agence'];
			$pdf->Ln();
		}

		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',9);
//Reporting Polices
		$pdf->Cell(50,5,''.$row_g['agence'].'.'.substr($row_g['dat_val'],0,4).'.10.'.$row_g['code_prod'].'.'.str_pad((int) $row_g['sequence'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(50,5,'--','1','0','C');
		$pdf->Cell(60,5,"".$row_g['nom_sous'].' '.$row_g['pnom_sous']."",'1','0','C');
		$pdf->Cell(24,5,''.number_format($row_g['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_g['pn'];/* SOUS TOTAL*/$ppn_ag=$ppn_ag+$row_g['pn'];/* TOTAL police prod  positive*/$ppn=$ppn+$row_g['pn'];
		$pdf->Cell(24,5,''.number_format($row_g['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_g['mtt_cpl'];/* SOUS TOTAL*/
		$pdf->Cell(24,5,''.number_format($row_g['pn']+$row_g['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_g['pn']+$row_g['mtt_cpl']);/* SOUS TOTAL*/$pccom_ag=$pccom_ag+$row_g['mtt_cpl'];/* TOTAL police prod  positive*/$pccom=$pccom+$row_g['mtt_cpl'];
		$pdf->Cell(24,5,''.number_format($row_g['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_g['mtt_dt'];/* SOUS TOTAL*/$pdtim_ag=$pdtim_ag+$row_g['mtt_dt'];/* TOTAL police prod  positive*/$pdtim=$pdtim+$row_g['mtt_dt'];
		$pdf->Cell(24,5,''.number_format($row_g['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_g['pt'];/* SOUS TOTAL*/$ppt_ag=$ppt_ag+$row_g['pt'];/* TOTAL police prod  positive*/$ppt=$ppt+$row_g['pt'];
		$pdf->Ln();
	}
	if($pprod>0)
	{

		$pdf->SetTextColor(7, 27, 181);
		$pdf->SetFont('Arial','IB',8);
		$pdf->Cell(50,5,'TOTAUX, POLICES AGENCE '.$pagencei,'1','0','L');
		$pdf->SetFont('Arial','IB',10);
		$pdf->Cell(50,5,'--','1','0','C');
		$pdf->Cell(60,5,"--",'1','0','C');
		$pdf->Cell(24,5,''.number_format($ppn_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($pccom_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($ppn_ag+$pccom_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($pdtim_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($ppt_ag, 2,',',' ').'','1','0','C');
		$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;

		$pdf->Ln();
		/* TOTAL police prod  positive*/


		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('Arial','IB',10);
		$pdf->SetFillColor(192,195,198);
		$pdf->Cell(100,5,'TOTAUX, POLICES  ','1','0','L','1');

		$pdf->Cell(60,5,"--",'1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppn, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pccom, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppn+$pccom, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pdtim, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppt, 2,',',' ').'','1','0','C','1');
		//$ppn=0;$ppt=0;$pcpol=0;$pccom=0;$pdtim=0;
		$pdf->Ln();
	}
//fin polices.
//boucle Avenants positifs

	$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;//1
	$ppn_av=0;$ppt_av=0;$pcpol_av=0;$pccom_av=0;$pdtim_av=0;//1
	$ppn_avp=0;$ppt_avp=0;$pcpol_avp=0;$pccom_avp=0;$pdtim_avp=0;//1
	$pagencei='0';$pprod=0; $typ_avenant=0;//2
	while ($row_vp=$rqtvp->fetch()){
		$typ_avenant=1;
		//afficher le sous total de de type d'avenant i de l agence i

		if($pagencei=='0' )
		{

			$pagencei=$row_vp['agence'];
		}
		if($pagencei!=$row_vp['agence'] )//total avenants de l agence i
		{
			$pdf->SetTextColor(7, 27, 181);
			$pdf->SetFont('Arial','IB',8);
			$pdf->SetFillColor(128,126,125);
			$pdf->Cell(160,5,'TOTAUX, AVENANTS POSITIFS AGENCE '.$pagencei.'','1','0','L');
			$pdf->SetFont('Arial','IB',10);
			$pdf->Cell(24,5,''.number_format($ppn_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($pccom_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($ppn_ag+$pccom_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($pdtim_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($ppt_ag, 2,',',' ').'','1','0','C');
			$pagencei=$row_vp['agence'];
			//reinitialiser les variables agence
			$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;
			$pdf->Ln();
		}



		$pdf->SetTextColor(0, 0,0);

		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',9);
//Reporting Polices
		$pdf->Cell(50,5,''.$row_vp['agence'].'.'.substr($row_vp['datev'],0,4).'.10.'.$row_vp['code_prod'].'.'.str_pad((int) $row_vp['seq2'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(50,5,''.$row_vp['agence'].'.'.substr($row_vp['dat_val'],0,4).'.'.$row_vp['lib_mpay'].'.'.$row_vp['code_prod'].'.'.str_pad((int) $row_vp['sequence'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(60,5,"".$row_vp['nom_sous'].' '.$row_vp['pnom_sous']."",'1','0','C');
		$pdf->Cell(24,5,''.number_format($row_vp['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_vp['pn'];/*total agence*/$ppn_ag=$ppn_ag+$row_vp['pn'];/*total agence avenant positifs*/$ppn_avp=$ppn_avp+$row_vp['pn'];
		$pdf->Cell(24,5,''.number_format($row_vp['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_vp['mtt_cpl'];/*total agence*/
		$pdf->Cell(24,5,''.number_format($row_vp['pn']+$row_vp['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_vp['pn']+$row_vp['mtt_cpl']);/*total agence*/$pccom_ag=$pccom_ag+$row_vp['mtt_cpl'];/*total agence avenant positifs*/$pccom_avp=$pccom_avp+$row_vp['mtt_cpl'];
		$pdf->Cell(24,5,''.number_format($row_vp['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_vp['mtt_dt'];/*total agence*/$pdtim_ag=$pdtim_ag+$row_vp['mtt_dt'];/*total agence avenant positifs*/$pdtim_avp=$pdtim_avp+$row_vp['mtt_dt'];
		$pdf->Cell(24,5,''.number_format($row_vp['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_vp['pt'];/*total agence*/$ppt_ag=$ppt_ag+$row_vp['pt'];/*total agences avenant positifs*/$ppt_avp=$ppt_avp+$row_vp['pt'];
		$pdf->Ln();
	}

	if($typ_avenant>0)
	{
		$pdf->SetTextColor(7, 27, 181);
		$pdf->SetFont('Arial','IB',8);
		$pdf->Cell(160,5,'TOTAUX, AVENANTS POSITIFS AGENCE '.$pagencei.'','1','0','L');
		$pdf->SetFont('Arial','IB',10);
		$pdf->Cell(24,5,''.number_format($ppn_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($pccom_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($ppn_ag+$pccom_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($pdtim_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($ppt_ag, 2,',',' ').'','1','0','C');
		$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;
		$pdf->Ln();
		//total general des avenants positifs
		$pdf->SetFillColor(192,195,198);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(160,5,'TOTAUX, AVENANTS POSITIFS ','1','0','L','1');

		$pdf->Cell(24,5,''.number_format($ppn_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pccom_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppn_avp+$pccom_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pdtim_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppt_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Ln();
		$pdf->SetFillColor(163,202,231);
		//total general  positifs
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('Arial','IB',13);
		$pdf->Cell(160,5,'TOTAUX PRODUCTION POSITIVE','1','0','L','1');

		$pdf->Cell(24,5,''.number_format($ppn_avp+$ppn, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pccom_avp+$pccom, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppn_avp+$pccom_avp+$ppn+$pccom, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pdtim_avp+$pdtim, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppt_avp+$ppt, 2,',',' ').'','1','0','C','1');//egale tatal police + total avenants positifs.
		$pdf->Ln();
	}

	// AVENANT SANS RISTOURNE


	$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;//1
	$ppn_av=0;$ppt_av=0;$pcpol_av=0;$pccom_av=0;$pdtim_av=0;//1
	$ppn_avp=0;$ppt_avp=0;$pcpol_avp=0;$pccom_avp=0;$pdtim_avp=0;//1
	$pagencei='0';$pprod=0; $typ_avenant=0;//2
	while ($row_vp=$rqtvsr->fetch()){
		$typ_avenant=1;
		//afficher le sous total de de type d'avenant i de l agence i

		if($pagencei=='0' )
		{

			$pagencei=$row_vp['agence'];
		}
		if($pagencei!=$row_vp['agence'] )//total avenants de l agence i
		{
			$pdf->SetTextColor(7, 27, 181);
			$pdf->SetFont('Arial','IB',8);
			$pdf->SetFillColor(128,126,125);
			$pdf->Cell(160,5,'TOTAUX, AVENANTS SANS RISTOURNE AGENCE '.$pagencei.'','1','0','L');
			$pdf->SetFont('Arial','IB',10);
			$pdf->Cell(24,5,''.number_format($ppn_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($pccom_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($ppn_ag+$pccom_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($pdtim_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($ppt_ag, 2,',',' ').'','1','0','C');
			$pagencei=$row_vp['agence'];
			//reinitialiser les variables agence
			$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;
			$pdf->Ln();
		}



		$pdf->SetTextColor(0, 0,0);

		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',9);
//Reporting Polices
		$pdf->Cell(50,5,''.$row_vp['agence'].'.'.substr($row_vp['datev'],0,4).'.10.'.$row_vp['code_prod'].'.'.str_pad((int) $row_vp['seq2'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(50,5,''.$row_vp['agence'].'.'.substr($row_vp['dat_val'],0,4).'.'.$row_vp['lib_mpay'].'.'.$row_vp['code_prod'].'.'.str_pad((int) $row_vp['sequence'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(60,5,"".$row_vp['nom_sous'].' '.$row_vp['pnom_sous']."",'1','0','C');
		$pdf->Cell(24,5,''.number_format($row_vp['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_vp['pn'];/*total agence*/$ppn_ag=$ppn_ag+$row_vp['pn'];/*total agence avenant positifs*/$ppn_avp=$ppn_avp+$row_vp['pn'];
		$pdf->Cell(24,5,''.number_format($row_vp['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_vp['mtt_cpl'];/*total agence*/
		$pdf->Cell(24,5,''.number_format($row_vp['pn']+$row_vp['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_vp['pn']+$row_vp['mtt_cpl']);/*total agence*/$pccom_ag=$pccom_ag+$row_vp['mtt_cpl'];/*total agence avenant positifs*/$pccom_avp=$pccom_avp+$row_vp['mtt_cpl'];
		$pdf->Cell(24,5,''.number_format($row_vp['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_vp['mtt_dt'];/*total agence*/$pdtim_ag=$pdtim_ag+$row_vp['mtt_dt'];/*total agence avenant positifs*/$pdtim_avp=$pdtim_avp+$row_vp['mtt_dt'];
		$pdf->Cell(24,5,''.number_format($row_vp['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_vp['pt'];/*total agence*/$ppt_ag=$ppt_ag+$row_vp['pt'];/*total agences avenant positifs*/$ppt_avp=$ppt_avp+$row_vp['pt'];
		$pdf->Ln();
	}

	if($typ_avenant>0)
	{

		$pdf->SetTextColor(7, 27, 181);
		$pdf->SetFont('Arial','IB',8);
		$pdf->Cell(160,5,'TOTAUX, AVENANTS SANS RISTOURNE AGENCE '.$pagencei.'','1','0','L');
		$pdf->SetFont('Arial','IB',10);
		$pdf->Cell(24,5,''.number_format($ppn_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($pccom_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($ppn_ag+$pccom_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($pdtim_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($ppt_ag, 2,',',' ').'','1','0','C');
		$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;
		$pdf->Ln();
		//total general des avenants positifs

		$pdf->SetFillColor(176,153,170);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('Arial','IB',13);
		$pdf->Cell(160,5,'TOTAUX, AVENANTS SANS RISTOURNE  ','1','0','L','1');

		$pdf->Cell(24,5,''.number_format($ppn_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pccom_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppn_avp+$pccom_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pdtim_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppt_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Ln();
	}

	//FIN AVENANT SANS RISTOURNE

	//AVENANT AVEC RISTOURNE


	$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;//1
	$ppn_av=0;$ppt_av=0;$pcpol_av=0;$pccom_av=0;$pdtim_av=0;//1
	$ppn_avp=0;$ppt_avp=0;$pcpol_avp=0;$pccom_avp=0;$pdtim_avp=0;//1
	$pagencei='0';$pprod=0; $typ_avenant=0;//2
	while ($row_vp=$rqtvar->fetch()){
		$typ_avenant=1;
		//afficher le sous total de de type d'avenant i de l agence i

		if($pagencei=='0' )
		{

			$pagencei=$row_vp['agence'];
		}
		if($pagencei!=$row_vp['agence'] )//total avenants de l agence i
		{
			$pdf->SetTextColor(7, 27, 181);
			$pdf->SetFont('Arial','IB',8);
			$pdf->SetFillColor(128,126,125);
			$pdf->Cell(160,5,'TOTAUX, AVENANTS AVEC RISTOURNE AGENCE '.$pagencei.'','1','0','L');
			$pdf->SetFont('Arial','IB',10);
			$pdf->Cell(24,5,''.number_format($ppn_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($pccom_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($ppn_ag+$pccom_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($pdtim_ag, 2,',',' ').'','1','0','C');
			$pdf->Cell(24,5,''.number_format($ppt_ag, 2,',',' ').'','1','0','C');
			$pagencei=$row_vp['agence'];
			//reinitialiser les variables agence
			$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;
			$pdf->Ln();
		}



		$pdf->SetTextColor(0, 0,0);

		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',9);
//Reporting Polices
		$pdf->Cell(50,5,''.$row_vp['agence'].'.'.substr($row_vp['datev'],0,4).'.10.'.$row_vp['code_prod'].'.'.str_pad((int) $row_vp['seq2'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(50,5,''.$row_vp['agence'].'.'.substr($row_vp['dat_val'],0,4).'.'.$row_vp['lib_mpay'].'.'.$row_vp['code_prod'].'.'.str_pad((int) $row_vp['sequence'],'5',"0",STR_PAD_LEFT).'','1','0','C');
		$pdf->Cell(60,5,"".$row_vp['nom_sous'].' '.$row_vp['pnom_sous']."",'1','0','C');
		$pdf->Cell(24,5,''.number_format($row_vp['pn'], 2,',',' ').'','1','0','C');$tpn=$tpn+$row_vp['pn'];/*total agence*/$ppn_ag=$ppn_ag+$row_vp['pn'];/*total agence avenant positifs*/$ppn_avp=$ppn_avp+$row_vp['pn'];
		$pdf->Cell(24,5,''.number_format($row_vp['mtt_cpl'], 2,',',' ').'','1','0','C');$tcp=$tcp+$row_vp['mtt_cpl'];/*total agence*/
		$pdf->Cell(24,5,''.number_format($row_vp['pn']+$row_vp['mtt_cpl'], 2,',',' ').'','1','0','C');$tpc=$tpc+($row_vp['pn']+$row_vp['mtt_cpl']);/*total agence*/$pccom_ag=$pccom_ag+$row_vp['mtt_cpl'];/*total agence avenant positifs*/$pccom_avp=$pccom_avp+$row_vp['mtt_cpl'];
		$pdf->Cell(24,5,''.number_format($row_vp['mtt_dt'], 2,',',' ').'','1','0','C');$tdt=$tdt+$row_vp['mtt_dt'];/*total agence*/$pdtim_ag=$pdtim_ag+$row_vp['mtt_dt'];/*total agence avenant positifs*/$pdtim_avp=$pdtim_avp+$row_vp['mtt_dt'];
		$pdf->Cell(24,5,''.number_format($row_vp['pt'], 2,',',' ').'','1','0','C');$tpt=$tpt+$row_vp['pt'];/*total agence*/$ppt_ag=$ppt_ag+$row_vp['pt'];/*total agences avenant positifs*/$ppt_avp=$ppt_avp+$row_vp['pt'];
		$pdf->Ln();
	}

	if($typ_avenant>0)
	{

		$pdf->SetTextColor(7, 27, 181);
		$pdf->SetFont('Arial','IB',8);
		$pdf->Cell(160,5,'TOTAUX, AVENANTS AVEC RISTOURNE AGENCE '.$pagencei.'','1','0','L');
		$pdf->SetFont('Arial','IB',10);
		$pdf->Cell(24,5,''.number_format($ppn_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($pccom_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($ppn_ag+$pccom_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($pdtim_ag, 2,',',' ').'','1','0','C');
		$pdf->Cell(24,5,''.number_format($ppt_ag, 2,',',' ').'','1','0','C');
		$ppn_ag=0;$ppt_ag=0;$pcpol_ag=0;$pccom_ag=0;$pdtim_ag=0;
		$pdf->Ln();
		//total general des avenants positifs
		$pdf->SetFillColor(209,116,104);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('Arial','IB',13);
		$pdf->Cell(160,5,'TOTAUX, AVENANTS AVEC RISTOURNE. ','1','0','L','1');

		$pdf->Cell(24,5,''.number_format($ppn_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pccom_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppn_avp+$pccom_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($pdtim_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Cell(24,5,''.number_format($ppt_avp, 2,',',' ').'','1','0','C','1');
		$pdf->Ln();
	}

	//FIN AVENANT AVEC RISTOURNE
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','B',12);
	$pdf->SetFillColor(180,203,106);
	$pdf->Cell(160,5,'TOTAUX','1','0','L','1');$pdf->Cell(24,5,''.number_format($tpn, 2,',',' ').'','1','0','C','1');$pdf->Cell(24,5,''.number_format($tcp, 2,',',' ').'','1','0','C','1');$pdf->Cell(24,5,''.number_format($tpc, 2,',',' ').'','1','0','C','1');$pdf->Cell(24,5,''.number_format($tdt, 2,',',' ').'','1','0','C','1');$pdf->Cell(24,5,''.number_format($tpt, 2,',',' ').'','1','0','C','1');

	$pdf->Output();
}
?>