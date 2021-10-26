<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['code'])  && isset($_REQUEST['agence']) ) {
	$code = $_REQUEST['code'];

	$datesys = date("y-m-d H:i:s");
	$agence = $_REQUEST['agence'];

	$cag = $_REQUEST['cag'];
	$comc = $_REQUEST['comc'];
try 
{

	$bdd->beginTransaction();
	$rqtd = $bdd->prepare("SELECT * from `devisw` WHERE `cod_dev`='$code'");
	$rqtd->execute();
	
	while ($row_res = $rqtd->fetch()) 
	{
		echo "test";
		$tar = $row_res['cod_tar'];
		$prod = $row_res['cod_prod'];
		$per = $row_res['cod_per'];
		$opt = $row_res['cod_opt'];
		$zone = $row_res['cod_zone'];
		$formul = $row_res['cod_formul'];
		$dt = $row_res['cod_dt'];
		$cpl = $row_res['cod_cpl'];
		$deff = $row_res['dat_eff'];
		$dech = $row_res['dat_ech'];
		$cap1 = $row_res['cap1'];
		$cap2 = $row_res['cap2'];
		$cap3 = $row_res['cap3'];
		$p1 = $row_res['p1'];
		$p2 = $row_res['p2'];
		$p3 = $row_res['p3'];
		$pn = $row_res['pn'];
		$pt = $row_res['pt'];
		$codesous = $row_res['cod_sous'];
		$cod_pay=$row_res['cod_pays'];

		// if $prod=10 (PTA ) ET AGENCE!=0 ALORS AGENCE= COURTIER pAR DEFAUT=
		$id_user = $_SESSION['id_user'];
		//recuperer code de l'agence.
		$rqtagence = $bdd->prepare("SELECT agence FROM `utilisateurs` WHERE `id_user`='$id_user'");
		$rqtagence->execute();
		while ($row_agence = $rqtagence->fetch()) {
			$agence_seq = $row_agence['agence'];
		}
		//On r�cupere la sequence du produit
		$rqts = $bdd->prepare("SELECT  id_sequence,sequence,sequence_quit FROM `sequence_ag` WHERE `cod_prod`='$prod' and cod_agence='$agence_seq'");
		$rqts->execute();
		while ($row_ress = $rqts->fetch()) 
		{
			$seq = $row_ress['sequence'];
			$id_sequence = $row_ress['id_sequence'];
			$seq_quit = $row_ress['sequence_quit'];
		}
		$seq++;
		$seq_quit++;
		//on insere dans la table policew
		$rqtip = $bdd->prepare("INSERT INTO `policew`( `dat_val`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`, `cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `ndat_eff`, `ndat_ech`, `mode`, `dat_op`, `lib_mpay`, `sequence`, `etat`, `cod_sous`, `taux_int`, `diff_pay`, `cod_agence`, `sel`, `mtt_reg`, `mtt_solde`,`taux_com_agence`,`taux_com_courtier`) VALUES ( '$datesys', '$tar', '$prod', '$per', '$opt', '$zone','$cod_pay', '$formul', '$dt', '$cpl', '$deff', '$dech','$cap1', '$cap2', '$cap3', '$p1', '$p2', '$p3', '$pn', '$pt', '$deff','$dech', '1','','','$seq', '0', '$codesous','0','0','$agence','0','0','$pt','$cag','$comc')");
		$rqtip->execute();
		//recup�rer max cod_police
		$rqtmax = $bdd->prepare("select max(cod_pol) as code from policew");
		$rqtmax->execute();
		$max_pol = "";
		while ($rwx = $rqtmax->fetch()) {
			$max_pol = $rwx['code'];
		}

		//on supprime de devis
		$rqtc = $bdd->prepare("UPDATE `devisw` SET `etat`= '3' WHERE `cod_dev`='$code'");
		$rqtc->execute();

		//On incremente la sequence
		$rqtc = $bdd->prepare("UPDATE `sequence_ag` SET `sequence`= '$seq' WHERE `id_sequence`='$id_sequence'");
		$rqtc->execute();


		//on incrimente la sequence quittance
		$mois=(int)date('m');
		$rqtq = $bdd->prepare("UPDATE `sequence_ag` SET `sequence_quit`= '$seq_quit' WHERE `cod_agence`='$agence_seq'");
		$rqtq->execute();

		//CREER UNE QUITTANCE DE PRIME
		$rqtip = $bdd->prepare("INSERT INTO `quittance`( `cod_quit`, `mois`, `date_quit`, `agence`, `cod_ref`,cod_sous, `mtt_quit`, `solde_pol`, `cod_dt`, `cod_cpl`, `id_user`,`type_quit`) VALUES ('$seq_quit','$mois','$datesys','$agence_seq','$max_pol',$codesous,'$pt','$pt','$dt','$cpl','$id_user','0')");
		$rqtip->execute();

	}
	
	$bdd->commit();
} catch(Exception $e){
	//An exception has occured, which means that one of our database queries
	//failed.
	//Print out the error message.
	echo $e->getMessage();
	//Rollback the transaction.
	$bdd->rollBack();
}
}
?>