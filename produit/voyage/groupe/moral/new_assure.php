<?php session_start();
require_once("../../../../../../data/conn7.php");
require_once '../file/Classes/PHPExcel/IOFactory.php';
$folder = "../file/documents/";
$archiv="../file/archives/";
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}

$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");

if (  isset($_REQUEST['codsous']) && isset($_REQUEST['file']) && isset($_REQUEST['id_doc'])   ) {

    $codsous = $_REQUEST['codsous'];
    $file = $_REQUEST['file'];
    $id_doc = $_REQUEST['id_doc'];
    //manipuler le fichier excel file

}
    $objPHPExcel = PHPExcel_IOFactory::load($folder. $file.".xlsx");

    /**
     * récupération de la première feuille du fichier Excel
     * @var PHPExcel_Worksheet $sheet
     */
    $sheet = $objPHPExcel->getSheet(0);
    $numeroLigneMax = $sheet->getHighestRow();
    $libelleColonneMax = $sheet->getHighestColumn();
    $i=0;

    for ($ligne=2 ; $ligne <=$numeroLigneMax; $ligne++)
    {
        // On boucle sur les cellules de la ligne
        $nom="";$pnom="";$pass="";$datedpass="";$datenai="";$mail="";$tel="";$adr="";$age_ass="";$sexe="";$date1="";$date2="";

        $sexe=$sheet-> getCellByColumnAndRow( 0 , $ligne )->getValue();
        $nom=addslashes($sheet-> getCellByColumnAndRow( 1 , $ligne )->getValue());
        $pnom=addslashes($sheet->getCellByColumnAndRow( 2 , $ligne )->getValue());
        $pass=$sheet->getCellByColumnAndRow( 3 , $ligne )->getValue();
        $datedpass=PHPExcel_Style_NumberFormat::toFormattedString($sheet->getCellByColumnAndRow( 4 , $ligne )->getValue(), 'YYYY-MM-DD');
        $datenai=PHPExcel_Style_NumberFormat::toFormattedString($sheet->getCellByColumnAndRow( 5 , $ligne )->getValue(), 'YYYY-MM-DD');
        $adr=addslashes($sheet->getCellByColumnAndRow( 6 , $ligne )->getValue());
        $mail= $sheet->getCellByColumnAndRow( 7, $ligne )->getValue();
        $tel= $sheet->getCellByColumnAndRow( 8, $ligne )->getValue();

//calcule age.
        $age_ass=age($datenai,$datesys);
        //insertion
        try {
            if(isset($sexe) && isset($nom) && isset($pnom) && isset($pass) && isset($datenai)  ) {
                $rqtsous3 = $bdd->prepare("INSERT INTO  `souscripteurw`(`cod_sous`,`nom_sous`, `pnom_sous`, `passport`, `datedpass`, `dnais_sous`,`age`, `civ_sous`,`cod_par`, `id_user`) VALUES ('','$nom','$pnom','$pass','$datedpass','$datenai','$age_ass','$sexe','$codsous','$id_user')");
                $rqtsous3->execute();
            }
        } catch (Exception $ex) {
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
        }
    }

if( file_exists ( $folder. $file.".xlsx"))

    copy($folder. $file.".xlsx",$archiv. $file.".xlsx");
    unlink( $folder. $file.".xlsx" ) ;
    Alternative:
    @unlink( $folder. $file.".xlsx" ) ;


?>