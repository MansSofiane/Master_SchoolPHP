<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if (isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
$i=0;$codpol="";
$rqtv=$bdd->prepare("select count(cod_pol) as cpt from  `policew` WHERE  `sel`='1' ");
$rqtv->execute();
while($row_res=$rqtv->fetch()){
$i=$row_res['cpt'];
}
echo $i;
?>