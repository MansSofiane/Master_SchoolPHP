<?php
session_start();
require_once("../../../data/conn7.php");

if ($_SESSION['loginsal']){
    $id_user=$_SESSION['id_usersal'];
    

}
else {
    header("Location:login.php");
}
$id = 0;
$tomail="";

//  $("#content").load("adm/surprime.php?id="+id+"&page="+page+"&cod_dev=" + codedev + "&prime=" + pn  );


if ( isset($_REQUEST['id_demande'])) {

    $id_demande = $_REQUEST['id_demande'];
    $page = $_REQUEST['page'];
    $codpol = $_REQUEST['codpol'];
    $rqcpl=$bdd->prepare("update demande set etat_dem = 1 where id_demande = $id_demande ");
    $rqcpl->execute();

    //envoi du mail
    $rqdem=$bdd->prepare("select * from demande  where id_demande = $id_demande ");
    $rqdem->execute();
    
    while ($rowdem = $rqdem -> fetch())
    {
        $id = $rowdem['id_user'];
    }

	$rquser=$bdd->prepare("select * from utilisateurs  where id_user = $id");
    $rquser->execute();
    
    while ($rowuser = $rquser -> fetch())
    {
        $tomail = $rowuser['mail_user'];
    }


    $rqtpol=$bdd->prepare("select * from policew where cod_pol = $codpol");
	$rqtpol->execute();
	$sequence = 0;
	$date1 = 0;
	$date2 = 0;
	while ($row_pol = $rqtpol -> fetch())
	{
		$sequence = $row_pol['sequence'];
		$date1 = $row_pol['ndat_eff'];
		$date2 = $row_pol['ndat_ech'];
	}
    if ($sequence !=0)
	{
		$to = $tomail;
		$subject = "Accord pou la demande d anulation";        
		$message = "
Bonjour,
La demande que vous avez creer pour le contrat numero $sequence est accorde";
		$headers = "From: aglic-It@gmail.com  MIME-Version: 1.0  Content-type: text/html; charset=utf-8";
		$headers .= "Cc: ";
		//echo "<script type="."'text/JavaScript'"."> alert("."'$to'".");  </script>"; 
        if (mail($to, $subject, $message, $headers))
		{
		    echo "mail envoyer";
		}else // Non envoyé
		{
            echo "erreur denvoi";
		}
	} 
    echo "<script type="."'text/JavaScript'"."> alert("."'La demande a ete validee avec succes !'".");  </script>"; 


}
?>

