<?php
session_start();
$user=$_SESSION['id_user'];
require_once("../../../../data/conn7.php");

//on insere l'assure
//  xhr.open("GET", "produit/PTA/nsous.php?&noms=" + nom + "&nbassur=" + nbassur + "&primeN=" + primeN + "&civ=" + civ  + "&tok=" + tok, false);
if ( isset($_REQUEST['noms']) ){
	$nom = addslashes($_REQUEST['noms']);
	$civ = $_REQUEST['civ'];
	$token = $_REQUEST['tok'];
	$nbassur = $_REQUEST['nbassur'];
    $d1=$_REQUEST['dateff'];
  //  echo "date1.0=".$d1;
   $civ_code=0;
    if($civ=="Affaire-Directe")
        $civ_code=1;//affaire directe
        else
            $civ_code=2;//via courtier
    $raison=$nom .'-'.$civ;
    $datesys=date("y-m-d H:i:s");
    //$dateDeb = $d1 -> format('01/m/Y');
    $d2 =  date("y-m-t", strtotime($d1));
    // echo "date2=".$d2;
    $primeN =$_REQUEST['primeN'];

    $rqtis=$bdd->prepare("INSERT INTO `souscripteurw` (`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`, `sel`)
          VALUES ('', 'null','$raison','','','','','','','','','$datesys','','$civ_code','',$nbassur,'0','$user','null','','','','0')");
    $rqtis->execute();
    $codsous=0;
    // recupération du code du dernier souscripteur de l'agence
    $rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$user'");
    $rqtms->execute();
    while ($row_res=$rqtms->fetch()){
    $codsous=$row_res['maxsous'];
    }
   
    $pt  =  $primeN;
    $rqtidade=$bdd->prepare("INSERT INTO `devisw` VALUES ('', '$datesys', '0', '10', '20', '1', '1','DZ', '1', '1','1' ,'$d1', '$d2','0', '0', '0','0', '0', '0', '$primeN', '$pt', '0', '0', '$codsous','0','0')");
    $rqtidade->execute();
}
?>