<!--form method="post"  enctype="multipart/form-data" id= "uploadfile" hidden>
									<input type="file" name="file" Required/>
									<input type="submit" name="submit"/>	
</form-->

<?php
session_start();
require_once("../../../../../data/conn7.php");
$_SESSION['testfile'] = 'test file upload';
 
 if ($_SESSION['loginsal']){
}
else {
header("Location:../../../index.html?erreur=login"); // redirection en cas d'echec
}
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y.m.d-H");


if (isset($_REQUEST['code'])) {
    $codepol = $_REQUEST['code'];

}
//
//$codepol = $_GET['code'];


$id_user=$_SESSION['id_usersal'];
$i = 0;
//require('Upload.php');
$Id_Demande = 0;

$rqt=$bdd->prepare("SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'demande';");
$rqt->execute();

while ($row_res = $rqt->fetch()) {
	$Id_Demande=$row_res['auto_increment'];
}
//$Id_Demande = $Id_Demande +1; 

$result="";
	if(isset($_POST['submit'])) {
		$name=$_SESSION['agencesal'];
		$name=$codepol.'-'.$Id_Demande.'-'.$name.'-'.$datesys;
        $m = "file/documents/".$name;
        $exten = $pieces = explode(".", $_FILES['file']['name']);
        $chemin =  $m.".".$exten[sizeof($exten) - 1];
		$namecomp = $name.'.'.$exten[sizeof($exten) - 1];
		
        move_uploaded_file($_FILES['file']['tmp_name'],$chemin);
        $rqtdoc=$bdd->prepare("select count(*) as exist from `document` where id_demande =  $Id_Demande");
		$rqtdoc->execute();
		$existe = 0;
		while ($rowdoc = $rqtdoc->fetch()) 
			{
				$existe = $rowdoc['exist'];
			}
		if ($existe == 0)
		{
			$rqt=$bdd->prepare("INSERT INTO `document`( `chemin`, `dat_doc`, `id_user`, `id_demande`) VALUES ('$namecomp','$datesys','$id_user', '$Id_Demande')");
			$rqt->execute();
        	echo "<script type="."'text/JavaScript'"."> alert("."'fichier telecharge avec succes !'".");  </script>"; 
        	echo "<script type="."'text/JavaScript'"."> window.close();</script>";
		}else
		{
			$rqt=$bdd->prepare("update `document` set `chemin` = '$namecomp', `dat_doc` = '$datesys', `id_user` = '$id_user' where `id_demande`= '$Id_Demande' ");
			$rqt->execute();
        	echo "<script type="."'text/JavaScript'"."> alert("."'fichier telecharge avec succes !'".");  </script>"; 
        	echo "<script type="."'text/JavaScript'"."> window.close();</script>";
		}
        
	}
	
?>

<?php if(is_array($result)) { ?>
	<h3>Erreur</h3>
	<ol>
		<?php foreach($result AS $k => $error) { ?>
		<li><?php echo $error; ?></li>
		<?php } ?>
	</ol>
<?php } else if($result === true) { 
echo "<script type="."'text/JavaScript'"."> alert("."'fichier telecharge avec succes !'".");  </script>"; 
echo "<script type="."'text/JavaScript'"."> window.close();</script>"; 
 }  ?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Intranet</title>
<link rel="stylesheet" href="../../css/screen.css" type="text/css" media="screen" title="default" />

</head>
<body>
<div id="content">
<br />
<div id="page-heading">
		<h1><b><big>Justificatif .....</big></b></h1>
	</div>
	<br />
	<br />
<form method="post" enctype="multipart/form-data">
	<input type="file" name="file" />
	<input type="submit" name="submit"/>	
</form>
</body>
</html>






