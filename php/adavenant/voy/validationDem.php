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
	//echo "<script type="."'text/JavaScript'"."> alert("."'$type_annul'".");  </script>"; 
	
}
?>