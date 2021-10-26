<?php
session_start();
require_once("../../../../../data/conn7.php");
//on insere l'assure
if ( isset($_REQUEST['sous']) &&isset($_REQUEST['p1']) && isset($_REQUEST['p2']) && isset($_REQUEST['p3'])
    && isset($_REQUEST['pt'])  && isset($_REQUEST['d1']) && isset($_REQUEST['d2'])&& isset($_REQUEST['per']) && isset($_REQUEST['tar']) && isset($_REQUEST['cap1']) && isset($_REQUEST['cap2']) && isset($_REQUEST['bool']) && isset($_REQUEST['tok'])){

                $sous= $_REQUEST['sous'];
                $p1 = $_REQUEST['p1'];
                $p2 = $_REQUEST['p2'];
                $p3 = $_REQUEST['p3'];
				$cap1 = $_REQUEST['cap1'];
                $cap2 = $_REQUEST['cap2'];
                $pt = $_REQUEST['pt'];
                $d1= $_REQUEST['d1'];
                $d2=$_REQUEST['d2'];
                $cod_per=$_REQUEST['per'];
				$tar=$_REQUEST['tar'];
				$bool=$_REQUEST['bool'];
				$token = $_REQUEST['tok'];
                $datesys=date("y-m-d H:i:s");
				
$cod_prod=0;$cod_opt=0;$cod_zone=0;$cod_formul=0;$cod_dt=0;$cod_cpl=0;$pn=$p1+$p2+$p3;

$rqt=$bdd->prepare("SELECT `cod_prod`,`cod_per`,`cod_opt`,`cod_zone`,`cod_formul`,`cod_dt`,`cod_cpl`,`pe` FROM `tarif`  WHERE `cod_tar`='$tar'");
$rqt->execute();
while ($res=$rqt->fetch()){ 
$cod_prod=$res['cod_prod']; 
$cod_opt=$res['cod_opt']; 
$cod_zone=$res['cod_zone']; 
$cod_formul=$res['cod_formul']; 
$cod_dt=$res['cod_dt']; 
$cod_cpl=$res['cod_cpl'];
}
$rqtidiacc=$bdd->prepare("INSERT INTO `devisw` VALUES ('', '$datesys', '$tar', '$cod_prod', '$cod_per', '$cod_opt', '$cod_zone','DZ', '$cod_formul', '$cod_dt', '$cod_cpl', '$d1', '$d2','$cap1', '$cap1', '$cap2','$p1', '$p2', '$p3', '$pn', '$pt', '$bool', '0', '$sous','','')");
$rqtidiacc->execute();

}

?>