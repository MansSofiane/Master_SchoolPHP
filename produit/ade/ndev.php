<?php
session_start();
require_once("../../../../data/conn7.php");
//on insere l'assure
if ( isset($_REQUEST['sous']) &&isset($_REQUEST['tar']) && isset($_REQUEST['cap']) && isset($_REQUEST['per']) && isset($_REQUEST['pt']) && isset($_REQUEST['d1']) && isset($_REQUEST['d2']) && isset($_REQUEST['bool']) && isset($_REQUEST['tok'])){
 
    $sous = $_REQUEST['sous'];
    $tar = $_REQUEST['tar'];
    $cap = $_REQUEST['cap'];
    $per = $_REQUEST['per'];
    $pt = $_REQUEST['pt'];
    $d1= $_REQUEST['d1'];
    $d2 = $_REQUEST['d2'];
    $bool = $_REQUEST['bool'];
	$token = $_REQUEST['tok'];
    $datesys=date("y-m-d H:i:s");
 $cod_prod=0;$cod_per=0;$cod_opt=0;$cod_zone=0;$cod_formul=0;$cod_dt=0;$cod_cpl=0;$tx=0;$pn=0;
    $rqt=$bdd->prepare("SELECT `cod_prod`,`cod_per`,`cod_opt`,`cod_zone`,`cod_formul`,`cod_dt`,`cod_cpl`,`pe` FROM `tarif`  WHERE `cod_tar`='$tar'");
    $rqt->execute();
    while ($res=$rqt->fetch()){
        $cod_prod=$res['cod_prod'];
        $cod_per=$res['cod_per'];
        $cod_opt=$res['cod_opt'];
        $cod_zone=$res['cod_zone'];
        $cod_formul=$res['cod_formul'];
        $cod_dt=$res['cod_dt'];
        $cod_cpl=$res['cod_cpl'];
        $tx=$res['pe'];
    }
	$pn=$tx*$cap;
    $rqtidade=$bdd->prepare("INSERT INTO `devisw` VALUES ('', '$datesys', '$tar', '$cod_prod', '$cod_per', '$cod_opt', '$cod_zone','DZ', '$cod_formul', '$cod_dt', '$cod_cpl', '$d1', '$d2','$cap', '0', '0','0', '0', '0', '$pn', '$pt', '$bool', '0', '$sous','0','0')");
    $rqtidade->execute();
	

}

?>