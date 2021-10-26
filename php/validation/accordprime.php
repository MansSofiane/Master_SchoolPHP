<?php
session_start();
require_once("../../../../data/conn7.php");
if ( isset($_REQUEST['code']) && isset($_REQUEST['prime']) && isset($_REQUEST['primet'])){
    $code = $_REQUEST['code'];
    $prime=$_REQUEST['prime'];
    $primet=$_REQUEST['primet'];
    $rqtc=$bdd->prepare("UPDATE `devisw` SET `bool`= '0',`pn`='$prime',`pt`='$primet' WHERE `cod_dev`='$code'");
    $rqtc->execute();
}
?>
