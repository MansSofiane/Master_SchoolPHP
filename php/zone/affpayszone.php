<?php
session_start();
require_once("../../../../data/conn7.php");
if (isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
//on accède à tous les pays selectionnés
$rqts=$bdd->prepare("SELECT * FROM  `pays`  WHERE `sel_pays`='1'");
$rqts->execute();
while ($row_res=$rqts->fetch()){
//on parcours la liste des pays selectionnes
$codp=$row_res['cod_pays'];

//On verifi si le pays n'est pas deja affecter
$rqtv=$bdd->prepare("SELECT * FROM  `zonepays`  WHERE `cod_pays`='$codp' AND `cod_zone`='$code'");
$rqtv->execute();
$i=0;
while ($row_resv=$rqtv->fetch()){
$i++;
}
//On affecte le pays à la zone
if($i==0){               
$rqtc=$bdd->prepare("INSERT INTO `zonepays`(`cod_zp`, `cod_zone`, `cod_pays`) VALUES ('','$code','$codp')");
$rqtc->execute();
}
} 
//on reinitialise la selection
$rqtr=$bdd->prepare("UPDATE `pays` SET `sel_pays`='0' WHERE 1");
$rqtr->execute();


?>