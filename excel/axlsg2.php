<?php 
session_start();
require_once("../../../data/conn7.php");
ini_set('memory_limit', '1024M');
if ($_SESSION['loginsal']){}
else {
header("Location:../index.html?erreur=login");
}
if (isset($_REQUEST['row']) && isset($_REQUEST['row1']) && isset($_REQUEST['row2'])) {
$user = $_REQUEST['row'];
$dated = $_REQUEST['row1'];
$datef = $_REQUEST['row2'];
$prod = $_REQUEST['row3'];
  date_default_timezone_set('UTC');
}
?>
<link rel="stylesheet" href="css/css1.css" type="text/css" media="screen" title="default" />

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Validation</title>

</head>

<body>
<?php 
$datesys=date("y-m-d H:i:s");
//nom de la recap excel
$excel="Recap-Excel";
//$excel = str_replace('/', '-', $excel);
$excel=$excel.".xls";
//creation du fichier excel
error_reporting(0);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
include "agenerateurg2.php";
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$chemin="../doc/file/excel/".$excel;
$objWriter->save($chemin);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
$i = 0;
$folder = "../doc/file/excel/";
$dossier = opendir($folder);
while (false !== ($Fichier = readdir($dossier))) {
     if ($Fichier != "." && $Fichier != "..") {
	 
		$row_file[$i] = $Fichier;	
		$i++;
	 }
}
closedir($dossier);
if($i>0){
  ?>
<div id="page-heading">
		<h1><b>Récapitulatif Excel</b></h1>
	</div>
<div>
<br />
<div> <p>Veuillez cliquer pour telecharger le fichier!</p></div>
<ul>
<br />
  <?php 
$test = "Recap-Excel.xls";  
for($index=0;$index<$i; $index++){  
      if($test==$row_file[$index]){ 
?>
     <li> <a href="../../../../../doc/file/excel/<?php echo $test?>">Production-Excel</a></li>      
<?php 
}
}
 } ?>
 
</body>
</html>

