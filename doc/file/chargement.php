<?php 
session_start();
$i = 0;
include_once( __DIR__ . '/Classes/PHPExcel.php' );
require_once("../../../../data/conn7.php");
$user=$_SESSION['id_usersal'];
if (isset($_REQUEST['row']) && isset($_REQUEST['row1'])) {
$row = $_REQUEST['row'];
$codsous = $_REQUEST['row1'];
}
function phpexcel_autoload( $nomClasse ) {
    
    $nomClasse = str_replace( '_', '/', $nomClasse );
    $fichier = __DIR__ . '/Classes/' . $nomClasse . '.class.php';
    
    if ( file_exists( $fichier ) ) {
    
        require_once( $fichier );
    }
}

function complet($chaine,$taille ) {
    
    $cpt=$taille-strlen($chaine);
	for($i=0;$i<$cpt;$i++){
	$chaine="0".$chaine;
	}
	return $chaine;
}


spl_autoload_register( 'phpexcel_autoload' );
$objPHPExcel = PHPExcel_IOFactory::load( "../indacc/documents/".$row."" );
$feuille = $objPHPExcel->getActiveSheet();

$numeroLigneMax = $feuille->getHighestRow();
$libelleColonneMax = $feuille->getHighestColumn();
foreach ( $feuille->getRowIterator() as $ligne ) {
   
    $iterateurCellule = $ligne->getCellIterator();
    $iterateurCellule->setIterateOnlyExistingCells( false );
    foreach ( $iterateurCellule as $cellule ) {
 
    }
    
}


$cpt=0;

  for ($ligne=2 ; $ligne <=$numeroLigneMax; $ligne++)
     {
	for ($colone = 0;$colone <= 5 ; $colone++)
              {
                 $nom=addslashes($feuille->getCellByColumnAndRow( 0 , $ligne )->getValue());
				 $pnom=addslashes($feuille->getCellByColumnAndRow( 1 , $ligne )->getValue());
				 $date2= $feuille->getCellByColumnAndRow( 2, $ligne )->getValue();	 
				 $datenai= date('Y-m-d', ($date2 - 25569)*24*60*60 );
				 $adr=addslashes($feuille->getCellByColumnAndRow( 3 , $ligne )->getValue());
                  $autre_prof=addslashes($feuille->getCellByColumnAndRow( 4 , $ligne )->getValue());
                  $cls=$feuille->getCellByColumnAndRow( 5 , $ligne )->getValue();
                  //Classe-1;Classe-2;Classe-3;Risques-Speciaux
                  switch($cls)
                  {
                      case "Classe-1":
                      {
                          $classe=2;
                          break;
                      }
                      case "Classe-2":
                      {
                          $classe=3;
                          break;
                      }
                      case "Classe-3":
                      {
                          $classe=4;
                          break;
                      }
                      case "Risques-Speciaux":
                      {
                          $classe=5;
                          break;
                      }

                  }
              }
	 

         		
if(isset($nom) && isset($pnom) && isset($datenai) && isset($adr)&& isset($classe)){
for ($colone = 0;$colone <= 5 ; $colone++)
              {
                 $nom=addslashes($feuille->getCellByColumnAndRow( 0 , $ligne )->getValue());
				 $pnom=addslashes($feuille->getCellByColumnAndRow( 1 , $ligne )->getValue());
				 $date2= addslashes($feuille->getCellByColumnAndRow( 2, $ligne )->getValue());	 
				 $datenai= date('Y-m-d', ($date2 - 25569)*24*60*60 );
				 $adr=addslashes($feuille->getCellByColumnAndRow( 3 , $ligne )->getValue());
                  $autre_prof=$feuille->getCellByColumnAndRow( 4 , $ligne )->getValue();
                  $cls=$feuille->getCellByColumnAndRow( 5 , $ligne )->getValue();
                  //Classe-1;Classe-2;Classe-3;Risques-Speciaux
                  switch($cls)
                  {
                      case "Classe-1":
                      {
                          $classe=2;
                          break;
                      }
                      case "Classe-2":
                      {
                          $classe=3;
                          break;
                      }
                      case "Classe-3":
                      {
                          $classe=4;
                          break;
                      }
                      case "Risques-Speciaux":
                      {
                          $classe=5;
                          break;
                      }

                  }
              }		  	
//Insertion du souscripteur
//INSERT INTO `souscripteurw`(`cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`,
// `datefpass`, `mail_sous`, `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`,
// `id_user`, `cod_prof`, `cod_postal`, `autre_prof`, `quot_sous`, `sel`) VALUES (

$rqtis=$bdd->prepare("INSERT INTO `souscripteurw` (`cod_sous`,`nom_sous`,`pnom_sous`,`mail_sous`, `tel_sous`,`adr_sous`, `dnais_sous`,`age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`,`id_user`,`cod_prof`,`autre_prof`,`quot_sous`) VALUES ('','$nom','$pnom','','','$adr','$datenai','0','1','2','0','$codsous','$user','44','$autre_prof','$classe')");
$rqtis->execute();	 
$cpt++;
    }
    
      }
	

      echo "<script type="."'text/JavaScript'"."> alert("."'".$cpt."  Assures telecharges!'".");  </script>"; 
      $fichier = "../indacc/documents/".$row."";

      if( file_exists ( $fichier))
	    copy($fichier,"../indacc/archives/".$row."");
	    unlink( $fichier ) ;
        Alternative: 
        @unlink( $fichier ) ;
echo "<script type="."'text/JavaScript'"."> window.close();</script>";
?>

