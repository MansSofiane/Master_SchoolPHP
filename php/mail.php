<?php
require_once("../../../data/conn7.php");
if ( isset($_REQUEST['user']) && isset($_REQUEST['mail'])){
$mail=addslashes($_REQUEST['mail']);
$user=addslashes($_REQUEST['user']);
$i=0;
$reponse = $bdd->prepare("SELECT * FROM utilisateurs WHERE login=? AND mail_user=?");
$reponse->execute(array($user, $mail));
while ($utilisateur = $reponse->fetch())
{
$i++;
$rqtma=$bdd->prepare("UPDATE `utilisateurs` SET `pass`=sha1('Aglic2019Pass')  WHERE `login`='$user' and `mail_user`='$mail'");
$rqtma->execute();
//Fin de la boucle 
}


if($i>0){
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) 
{  $passage_ligne = "\r\n";}else{$passage_ligne = "\n";}

$message_html = "<html><head></head><body><b>Bonjour Votre nouveau PassWord est</b>, Aglic2019Pass</body></html>";
$boundary = "-----=".md5(rand());
$sujet = "Reinitialisation Mot de Passe";
$header = "From: \"AGLIC-SPA\"<admin@aglic.dz>".$passage_ligne;
$header.= "Reply-to: \"AGLIC-SPA\" <admin@aglic.dz>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
$message = $passage_ligne."--".$boundary.$passage_ligne;
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
$message.= $passage_ligne."--".$boundary.$passage_ligne;
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
mail($mail,$sujet,$message,$header);


}else{
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) 
{  $passage_ligne = "\r\n";}else{$passage_ligne = "\n";}

$message_html = "<html><head></head><body><b>Bonjour, Les informations relatives au compte sont incorrectes !</b>, Veuillez contacter la DG-AGLIC.</body></html>";
$boundary = "-----=".md5(rand());
$sujet = "Reinitialisation Mot de Passe";
$header = "From: \"AGLIC-SPA\"<admin@aglic.dz>".$passage_ligne;
$header.= "Reply-to: \"AGLIC-SPA\" <admin@aglic.dz>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
$message = $passage_ligne."--".$boundary.$passage_ligne;
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
$message.= $passage_ligne."--".$boundary.$passage_ligne;
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
mail($mail,$sujet,$message,$header);
}

//Fin

}

?>