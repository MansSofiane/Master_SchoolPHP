<?php 
session_start();
ini_set("display_errors",0);error_reporting(0);
$i = 0;
include_once( __DIR__ . '/Classes/PHPExcel.php' );
require_once("../../../../data/test3.php"); 
$errone = false;
$connection = new Base_mysql();
$connection->connecter();
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
$objPHPExcel = PHPExcel_IOFactory::load( "documents/".$row."" );
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
	$nom="";$pnom="";$pass="";$datedpass="";$datenai="";$mail="";$tel="";$adr="";$age="";$sexe="";$date1="";$date2="";
	 

         for ($colone = 0;$colone <= 9 ; $colone++)  
              {
                 $nom=$feuille->getCellByColumnAndRow( 0 , $ligne )->getValue();
				 $pnom=$feuille->getCellByColumnAndRow( 1 , $ligne )->getValue();	 
				 $date2= $feuille->getCellByColumnAndRow( 2, $ligne )->getValue();
				 $datenai= date('Y-m-d', ($date2 - 25569)*24*60*60 );
				 $pass=$feuille->getCellByColumnAndRow( 3 , $ligne )->getValue();
				 $date1= $feuille->getCellByColumnAndRow( 4, $ligne )->getValue(); 
				 $datedpass= date('Y-m-d', ($date1 - 25569)*24*60*60 );
				 $mail= $feuille->getCellByColumnAndRow( 5, $ligne )->getValue(); 
				 $tel= $feuille->getCellByColumnAndRow( 6, $ligne )->getValue();
				 $adr=$feuille->getCellByColumnAndRow( 7 , $ligne )->getValue();
		 }		
if(isset($nom) && isset($pnom) && isset($pass) && isset($datedpass) && isset($datenai) && isset($mail) && isset($tel) && isset($adr)){			  	
$rqt="INSERT INTO `assure` VALUES ('','".$nom."','".$pnom."','".$pass."','".$datedpass."','".$datenai."','".$mail."','".$tel."','".$adr."','0','1','".$codsous."')";
$res_rqt=mysql_query($rqt) or die ($rqt . "-----" . mysql_error());		 
$cpt++;
    }
    
      }
	

      echo "<script type="."'text/JavaScript'"."> alert("."'".$cpt."  Assures telecharges!'".");  </script>"; 
      $fichier = "documents/".$row."";

      if( file_exists ( $fichier))
      
	    copy($fichier,"archives/".$row."");
	    unlink( $fichier ) ;

        Alternative: 

        @unlink( $fichier ) ;
echo "<script type="."'text/JavaScript'"."> window.close();</script>";
?>

