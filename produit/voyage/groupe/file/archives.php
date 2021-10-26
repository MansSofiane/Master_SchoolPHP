<?php session_start();
$i = 0;

$folder = "archives/";
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
<div id="page-heading">
		<h1><b><big>Fichiers Archives</big></b></h1>
	</div>
<div>
<br />
<div> <p>Cliquer sur le fichier pour le telecharger</p></div>
<ul>
<br />
<?php for($index=0;$index<$i; $index++){  
      $test = substr($row_file[$index],0,5);
       if($test==$_SESSION['agencesal']){
?>
          
			 <li> <a href="grp/file/archives/<?php echo $row_file[$index]?>"><?php echo $row_file[$index]?></a></li>
<?php }

 } ?>
</ul>
</div>
</body>
</html>