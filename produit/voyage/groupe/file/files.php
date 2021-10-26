<?php session_start();
$i = 0;
if(isset($_REQUEST['row'])){$row=$_REQUEST['row'];}
$folder = "documents/";
$dossier = opendir($folder);
while (false !== ($Fichier = readdir($dossier))) {
     if ($Fichier != "." && $Fichier != "..") {
	 
		$row_file[$i] = $Fichier;	
		$i++;
	 }
}
closedir($dossier);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<div id="content">
<br />
<br />
<?php if($i>1){
?>
<div id="page-heading">
		<h1><b>Fichiers en attente de traitement</b></h1>
	</div>
<div>
<br />
<div> <p>Veuillez cliquer sur le fichier à importer</p></div>
<ul>
<br />

<?php 
for($index=0;$index<$i; $index++){  
      $test = substr($row_file[$index],0,5);
       if($test==$_SESSION['agencesal']){
?>
          
<li> <a href="charger1_excel.php?row=<?php echo $row_file[$index]?>&row1=<?php echo $row ?> " onClick="window.open(this.href, 'Devis', 'height=200, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" >

<?php echo $row_file[$index]?></a></li>
<?php }

 } 
 }else{
 ?>
<div id="page-heading">
		<h1><b>Aucun fichier en attente !</b></h1>
	</div>
<?php } ?>
 
</ul>
</div>
</body>
</html>