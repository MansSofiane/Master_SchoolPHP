<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){}
else {header("Location:login.php");}

$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");

if (isset($_REQUEST['assure'])) {
	$row = substr($_REQUEST['assure'],10);
}
$rqtsous=$bdd->prepare("select cod_sous from devisw where cod_dev='".$row."'");

$rqtsous->execute();
while ($rowsous=$rqtsous->fetch())
{
	$codsous=$rowsous['cod_sous'];
}
$rqtnb=$bdd->prepare("select count(*) as nb from souscripteurw where cod_sous='".$codsous."'");
$rqtnb->execute();
while ($rownb=$rqtnb->fetch())
{
	$nb=$rownb['nb'];
}



$rqt ="SELECT * FROM `souscripteurw` WHERE cod_par ='".$codsous."'";
$rqtassur=$bdd->prepare($rqt);
$rqtassur->execute();


if ($nb!=0){
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Intranet</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen" title="default" />
</head>
<body> 
<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">

	<!-- start logo -->
	<div id="logo">
	<p><strong>Liste des assures du groupe</strong></p>
	</div>
	<!-- end logo -->
	

 <div class="clear"></div>
 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<div id="content">
	<table class="table table-bordered data-table" id="tassur">
<!--<table border="0" width="100%" cellpadding="0" cellspacing="0">-->
	<td>
		<table class="table table-bordered data-table" id="id-form">
		<!--<table border="0" cellpadding="0" cellspacing="0"  id="id-form">-->
		<tr>&nbsp;</tr>
		        <tr>
					<th class="table-header-repeat line-left minwidth-1" align="center"><a href="">Nom</a></th>
					<th class="table-header-repeat line-left minwidth-1" align="center"><a href="">Prenom</a></th>
					<th class="table-header-repeat line-left"><a href="">D.naissance</a></th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Passport</a></th>
					<th class="table-header-repeat line-left"><a href="">D.Effet-Passport</a></th>

				</tr>
				<?php 
				$i = 0;
				while ($row_res=$rqtassur->fetch()){
				$color = ++$i % 2 ? '#CCCCCC':'#FFFFFF'; 
				?>
				<tr>


					<td  bgcolor="<?php echo $color; ?>" align="center"><?php echo $row_res['nom_sous'];?></td>
					<td  bgcolor="<?php echo $color; ?>" align="center"><?php echo $row_res['pnom_sous'];?></td>
					<td  bgcolor="<?php echo $color; ?>" align="center"><?php echo date("d/m/Y", strtotime($row_res['dnais_sous']));?></td>
					<td  bgcolor="<?php echo $color; ?>" align="center"><?php echo $row_res['passport'];?></td>
					<td  bgcolor="<?php echo $color; ?>" align="center"><?php echo date("d/m/Y", strtotime($row_res['datedpass']));?></td>
				</tr>
				
				<?php } ?>
		
		<tr>
	
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td valign="top">
			<input class="bouton1" type="button" value="Fermer" onClick="quitter()"/></td>
			</tr>
		<tr>
		</table> </td></table>

<!--  end content -->
<div class="clear">&nbsp;</div>

</div>
 <?php
}else{
echo '<h2>Aucun Resultat pour ce souscripteur!</h2>';
} ?>
<script language="JavaScript">


		function quitter()
		{
			window.close();
		}

</script>
</body>
</html>