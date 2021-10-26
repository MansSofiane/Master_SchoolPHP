<?php
session_start();
require_once("../../../../data/conn7.php");
//on recupere le code du pays
if ( isset($_REQUEST['libcap']) && isset($_REQUEST['mttcap']) && isset($_REQUEST['code']) ){
	$libcap = $_REQUEST['libcap'];
    $mttcap = $_REQUEST['mttcap'];
	$code = $_REQUEST['code'];

$rqtc=$bdd->prepare("UPDATE `capital` SET `lib_cap`='$libcap',`mtt_cap`='$mttcap' WHERE `cod_cap`='$code'");
$rqtc->execute();

}

?>