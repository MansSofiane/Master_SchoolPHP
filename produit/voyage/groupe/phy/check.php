<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
    $id_user=$_SESSION['id_usersal'];
}
else {
    header("Location:login.php");
}

$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
$folder = "documents/";

$codsous = $_POST['id_demande'];
//$codsous = $_POST["id_demande"];
//echo "<script type="."'text/JavaScript'"."> alert("."'$codsous'".");  </script>"; 
// recup�ration du code du dernier souscripteur de l'agence
$rqtdoc=$bdd->prepare("SELECT count(*) as existefile FROM `document` where id_demande =:id_demande");
$rqtdoc->bindValue(':id_demande', $codsous, PDO::PARAM_STR);
$rqtdoc->execute();
$count = $rqtdoc->fetchColumn();

if($count > 0){
    $cc = 1;
 }else
 {
    $cc = 0;
 }
 echo $cc;
exit;

?>



