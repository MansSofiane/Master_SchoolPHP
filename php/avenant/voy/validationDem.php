<?php
session_start();
require_once("../../../../../data/conn7.php");
//on recupere le code du pays

$id_user = $_SESSION['id_usersal'];
$datesys=date("y-m-d H:i:s");
$datesysfordoc=date("Y.m.d-H");
if ( isset($_REQUEST['code']))
{
	$code = $_REQUEST['code'];
	if(isset($_REQUEST['type']))
	{
		$type_annul = strval($_REQUEST['type']);
	}
		
	$motif = $_REQUEST['motif'];
	$chemin = $_REQUEST['chemin'];
	$etat = $_REQUEST['etat'];
	$desc = $_REQUEST['desc'];
	$date_annul = $_REQUEST['date'];
	$id_user = $_REQUEST['iduser'];

	$rqts=$bdd->prepare("INSERT INTO `demande`(`cod_pol`, `type_annulation`, `date_annulation`, `motif_annulation`, `chemin_just`, `etat_dem`, `is_avenant`, `Description`, `id_user`)
	 									VALUES ('$code', '$type_annul','$date_annul','$motif','$chemin','$etat',0,'$desc','$id_user') ");
	$rqts->execute();
	if($chemin == "SR")
	{
		$Id_Demande = 0;
		$rqt=$bdd->prepare("select  * from demande ORDER BY id_demande DESC LIMIT 1;");
		$rqt->execute();
		while ($row_res = $rqt->fetch()) 
		{
			$Id_Demande=$row_res['id_demande'];
		} 
		$rqt=$bdd->prepare("INSERT INTO `document`( `chemin`, `dat_doc`, `id_user`, `id_demande`) VALUES ('$namecomp','$datesysfordoc','$id_user', '$Id_Demande')");
		$rqt->execute();
	}
	//envoi du mail
	$rqtpol=$bdd->prepare("select * from policew where cod_pol = $code");
	$rqtpol->execute();
	$sequence = 0;
	$date1 = 0;
	$date2 = 0;
	while ($row_pol = $rqtpol -> fetch())
	{
		$sequence = $row_pol['sequence'];
		$date1 = $row_pol['ndate_eff'];
		$date2 = $row_pol['ndate_ech'];
	}
	if ($sequence !=0)
	{
		if($type_annul== 4){$type = 'Son restourn';}
		if($type_annul== 5){$type = 'avec restourn';}
		$to = 'sofianemansouri900@gmail.com';
		$subject = "Demande d'anulation $type";        
		$message = "Bonjour,
					<br><br>&nbsp; &nbsp; &nbsp; Une demande d'annulation  $type  vient d'être crée pour le contrat numero  $sequence ";
		$headers = 'From: aglic-It@gmail.com' ."\r\n" .
		            'MIME-Version: 1.0' . "\r\n" .
		            'Content-type: text/html; charset=utf-8';
		$headers .= 'Cc: '.$copie."\n";
		if (mail($to, $subject, $message, $headers))
		{
		    echo "Email sent";
		}else // Non envoyé
		{
		    echo "Votre message n a pas pu etre envoye";
		}
	} 
}
?>