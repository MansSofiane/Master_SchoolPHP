<?php
 session_start();
require_once("../../../../../../data/conn7.php");
 if ($_SESSION['loginsal']){
}
else {
header("Location:../../../../../index.html?erreur=login"); // redirection en cas d'echec
}
$datesys=date("Y.m.d-H");

$id_user=$_SESSION['id_usersal'];
$i = 0;
require('Upload.php');
$result="";
	if(isset($_POST['submit'])) {

		//$str = getcwd();

		//$strn=str_replace("\\","/",$str);
		$upload = new Upload('/Intranet-Salama/produit/voyage/groupe/file/documents', $_FILES['file']);
		$i =  $_FILES['file']['tmp_name'];
		echo "<script type="."'text/JavaScript'"."> alert("."'$i'".");  </script>"; 
		//$upload = new Upload($strn, $_FILES['file']);
		$name=$_SESSION['agencesal'];
		$name=$name.'-'.$datesys;
		$upload->set_name($name, true);
		$upload->set_allowed_extensions(array('xls', 'xlsx'));
		$result = $upload->upload();
		$chemin=str_replace('.','-',$name);
		$rqt=$bdd->prepare("INSERT INTO `document`( `chemin`, `dat_doc`, `id_user`) VALUES ('$chemin','$datesys','$id_user')");
		$rqt->execute();

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
		<h1><b><big>Fichier Excel</big></b></h1>
	</div>
	<br />
	<br />
<form method="post" enctype="multipart/form-data">
	<input type="file" name="file"/>
	<input type="submit" name="submit"/>	
</form>
</body>
</html>

