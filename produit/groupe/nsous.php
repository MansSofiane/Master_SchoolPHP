<?php
session_start();
$user=$_SESSION['id_user'];
require_once("../../../../data/conn7.php");
//on insere l'assure
if ( isset($_REQUEST['noms']) && isset($_REQUEST['adrs']) && isset($_REQUEST['mails']) && isset($_REQUEST['tok'])){
	$nom = addslashes($_REQUEST['noms']);
	
	$adr = addslashes($_REQUEST['adrs']);
	$mail = addslashes($_REQUEST['mails']);
	$tel = addslashes($_REQUEST['tels']);
	$civ = $_REQUEST['civ'];	
	$token = $_REQUEST['tok'];
	$nbassur = $_REQUEST['nbassur'];
	$raison = $civ ;
    $raison=$civ." ".$nom;
    $datesys=date("y-m-d H:i:s");
     $d1 = $_REQUEST['d1'];
    $d2 = $_REQUEST['d2'];
    $primeN1 =$_REQUEST['primeN1'];
    $coutP1 = $_REQUEST['coutP1'];
     $droit1 = $_REQUEST['droit1'];
    $interloc = $_REQUEST['int'];


  $c=0;

//   step to verify  droit timbre IF EXIST USE CODE DTIMBRE ELSE INSERT NEW ONE 
$rqt=$bdd->prepare("SELECT cod_dt FROM `dtimbre` WHERE `mtt_dt`='$droit1'");
echo "SELECT cod_dt FROM `dtimbre` WHERE `mtt_dt`='$droit1'";
$rqt->execute();
$nbe = $rqt->rowCount();
echo "$nbe";
echo "------------------------";
if ($nbe>0) { echo "hna if ";
$codroit=0;
 while ($row_res=$rqt->fetch()){ 
       $codroit=$row_res['cod_dt']; 
} }  

else 	{ echo "hna else ";
 $rqt2=$bdd->prepare("SELECT  max(cod_dt)  as max FROM `dtimbre`");
                 $rqt2->execute();
               while ($row_res=$rqt2->fetch()){ 
       $c=$row_res['max']; 
}

	$codroit=$c+1;

 $rqt2=$bdd->prepare("INSERT INTO  dtimbre  VALUES  ('$codroit', 'DT-General', '$droit1', '$user')");
            $rqt2->execute();
echo "INSERT INTO  dtimbre  VALUES ('$codroit', 'DT-General', '$droit1', '$user')"; 
}     
//END VERIFICATION CODE POLICE 

//  step to verify  CODE POLICE  IF EXIST USE CODE POLICE  ELSE INSERT NEW ONE 
$rqt4=$bdd->prepare("SELECT * FROM `cpolice` WHERE `mtt_cpl`='$coutP1'");
echo "SELECT * FROM `cpolice` WHERE `mtt_cpl`='$coutP1'";
$rqt4->execute();
$nbe1 = $rqt4->rowCount();
if ($nbe1>0) {
$codpolice=0;
 while ($row_res=$rqt4->fetch()){ 
       $codpolice=$row_res['cod_cpl']; 
} }  

else 	{  $rqt2=$bdd->prepare("SELECT  max(cod_cpl)  as max FROM `cpolice`");
                 $rqt2->execute();
               while ($row_res=$rqt2->fetch()){ 
       $c=$row_res['max']; 
}

	$codpolice=$c+1;

 $rqt2=$bdd->prepare("INSERT INTO  cpolice  VALUES  ('$codpolice', 'P-Morale-N', '$coutP1', '$user')");
            $rqt2->execute();
echo "INSERT INTO  cpolice  VALUES  ('$codpolice', 'P-Morale-N', '$coutP1', '$user')";
}     
//END VERIFICATION DROIT TIMBRE 



    

$rqtis=$bdd->prepare("INSERT INTO `souscripteurw` (`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`, `sel`)
 VALUES ('', 'null','$raison','$interloc','','','','','$mail','$tel','$adr','$datesys','','','',$nbassur,'0','$user','null','','','','0')");

$rqtis->execute();
      
$codsous=0;
// recupération du code du dernier souscripteur de l'agence	
$rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$user'");

$rqtms->execute();

while ($row_res=$rqtms->fetch()){ 
$codsous=$row_res['maxsous']; 
}

$pt  =  $primeN1+ $coutP1+ $droit1;	     
$rqtidade=$bdd->prepare("INSERT INTO `devisw` (`cod_dev`, `dat_dev`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`, `cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `bool`, `etat`, `cod_sous`, `taux_int`, `diff_pay`)
 VALUES ('', '$datesys', '0', '9', '20', '1', '1','DZ', '1', '$codroit',$codpolice ,'$d1', '$d2','0', '0', '0','0', '0', '0', '$primeN1', '$pt', '0', '0', '$codsous','0','0')");

    $rqtidade->execute();

}
echo "INSERT INTO `devisw` (`cod_dev`, `dat_dev`, `cod_tar`, `cod_prod`, `cod_per`, `cod_opt`, `cod_zone`, `cod_pays`, `cod_formul`, `cod_dt`, `cod_cpl`, `dat_eff`, `dat_ech`, `cap1`, `cap2`, `cap3`, `p1`, `p2`, `p3`, `pn`, `pt`, `bool`, `etat`, `cod_sous`, `taux_int`, `diff_pay`)
 VALUES ('', '$datesys', '0', '9', '20', '1', '1','DZ', '1', '$codroit', '1','$d1', '$d2','0', '0', '0','0', '0', '0', '$primeN1', '$pt', '0', '0', '$codsous','0','0')"
?>