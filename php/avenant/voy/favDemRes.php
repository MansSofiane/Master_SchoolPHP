<?php session_start();
require_once("../../../../../data/conn7.php");


if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y.m.d-H");
if (isset($_REQUEST['code']) && isset($_REQUEST['page'])) {
	$codepol = $_REQUEST['code'];
	$page = $_REQUEST['page'];
	//$datesys = $__REQUEST[''];
}

$result="";
	
if (isset($_REQUEST['code']) && isset($_REQUEST['page'])) {
	$codepol = $_REQUEST['code'];
	$page = $_REQUEST['page'];
//On recupere le nombre de jour de la periode
	$rqtp = $bdd->prepare("SELECT j.min_jour as jour, p.cod_sous as csous,p.cod_prod as prod, p.ndat_eff,p.ndat_ech,p.cod_formul FROM `periode` as j,`policew` as p WHERE p.`cod_per`=j.`cod_per` AND p.`cod_pol`='$codepol'");
	$rqtp->execute();
	while ($row_res = $rqtp->fetch()) {
		$jour = $row_res['jour'];
		$dure=dure_en_jour($row_res['ndat_eff'],$row_res['ndat_ech']);
		$csous = $row_res['csous'];
		$cprod=$row_res['prod'];
		$dated=$row_res['ndat_eff'];
		$datef=$row_res['ndat_ech'];
		$cod_formul=$row_res['cod_formul'];
	}
	$rqtsous=$bdd->prepare ("SELECT * FROM souscripteurw where cod_sous='$csous'");
	$rqtsous->execute();
	while($rowsous=$rqtsous->fetch())
	{
		$noma=$rowsous['nom_sous'];
		$pnoma=$rowsous['pnom_sous'];
		$maila=$rowsous['mail_sous'];
		$tela=$rowsous['tel_sous'];
		$adra=$rowsous['adr_sous'];
		$passporta=$rowsous['passport'];
		$datpassa=$rowsous['datedpass'];

	}
	$rqtassur=$bdd->prepare ("SELECT * FROM souscripteurw where cod_par='$csous'");
	$rqtassur->execute();
	$nbe = $rqtassur->rowCount();

	while($rowassu=$rqtassur->fetch())
	{
		$nom=$rowassu['nom_sous'];
		$pnom=$rowassu['pnom_sous'];
		$mail=$rowassu['mail_sous'];
		$tel=$rowassu['tel_sous'];
		$adr=$rowassu['adr_sous'];
		$passport=$rowassu['passport'];
		$datpass=$rowassu['datedpass'];
	}
	$rqtav=$bdd->prepare("select count(*) as nb_av from avenantw where cod_pol='$codepol'");
	$rqtav->execute();
	$nbav=0;
	while ($rowas=$rqtav->fetch())
	{
		$nbav= $rowas['nb_av'];
	}
}
$rqtmotf=$bdd->prepare("select * from motif");
$rqtmotf->execute();

$rqterr=$bdd->prepare("select * from erreur");
$rqterr->execute();
?>
<style>
        .center1 {
           margin-left: 100px;
           margin-right: auto;
        }
</style>
<div id="content-header" >

<div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Voyage</a><a class="current">Avenant</a> </div>
</div>
<div class="row-fluid"  >
	<div class="span12">
		<div class="widget-box">
			<div id="breadcrumb"> <a class="current"><i></i>Demande de résiliation </a><a>Type-demande</a>
				<div class="widget-content nopadding">
					
						<div id="step-holder">
							<div class="controls">
								<select   id="tav"  onchange="hidshowdem()" >
									<option value="0">--  Type Demande</option>
									<?php
									 switch ($cod_formul)
									 {
										 case 2:
										 {?>
											<option value='5'>Demande d'annulation avec ristourne</option>
											 <?php if ($nbav==0){?>
											 <option value='4'>Demande d'annulation Sans ristourne</option>
										 <?php  }?>

										<?php  break;}

										 case 3:
										 {?>
											 <option value='5'>Demande d'annulation avec ristourne</option>
											 <?php if ($nbav==0){?>
											 <option value='4'>Demande d'annulation Sans ristourne</option>
										 <?php  }?>

										 <?php  break;}
										 case 4:
										 {?>
											 <option value='5'>Demande d'annulation avec ristourne</option>
											 <?php if ($nbav==0){?>
											 <option value='4'>Demande d'annulation Sans ristourne</option>
										 <?php  }?>

										 <?php  break; }

										 case 5:
										 {?>
											 <option value='5'>Demande d'annulation avec ristourne</option>
											 <?php if ($nbav==0){?>
											 <option value='4'>Demande d'annulation Sans ristourne</option>
										 <?php  }?>

										 <?php  break;}
									 }
									?>
								</select>
							</div>
							<div >
							<div  class="center1" id="demavecres" onchange="showuploadfile()"  hidden>
								<p>
									<select id = "selctdemavecres" name ="s1">
									<option value="">-- Justificatif</option>
										<?php
										while ($rowas=$rqtmotf->fetch())
										{
											echo "<option value=$rowas[id_motif]>$rowas[motif]</option>";
										}
										?>
								</select>
								<input  type="button" id="charg" class="btn btn-warning" onClick="charger()" value="Charger ..." />
								<label>  </label>
								</p>
								
								<textarea id ="desc" cols="300" rows= "10"  placeholder="description de la demande..."></textarea> 
								
							</div>
							
							<div class="center1" id="demsonsres" hidden>
							<select  id = "selctdemsonres" name ="s2">
									<option value="">-- Justificatif</option>
									<?php
										while ($rowase=$rqterr->fetch())
										{
											echo "<option value=$rowase[cod_err]>$rowase[lib_err]</option>";
										}
										?>
								</select>
								<p style="color:red; font-size: 18px">veuillez entrer  le numéro de contrat qui le remplace </p>
								<textarea id ="descSR" cols="500" rows= "10"  placeholder="description de la demande..." onchange="activerbtn()"></textarea> 
							</div>
						</div>
						</div>

						<div class="form-actions" align="right">
							<input  type="button" id="suiv" class="btn btn-success" onClick="choix_Demande('<?php echo $codepol; ?>','<?php echo $page; ?>','<?php echo $id_user; ?>','<?php echo $datesys; ?>')" value="Suivant"  disabled="disabled"/>
							<input  type="button" class="btn btn-danger"  onClick="Menu1('prod','<?php echo $page; ?>')" value="Annuler" />
						</div>

				</div>
			</div>
		</div>

	</div>
</div>
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
<script language="JavaScript">
	function hidshowdem()
	{
		if (document.getElementById('tav').value == 4)
		{
			document.getElementById('demavecres').style.display = "none";
			document.getElementById('demsonsres').style.display = "block";
		}
		if (document.getElementById('tav').value == 5)
		{
			document.getElementById('demavecres').style.display = "block";
			document.getElementById('demsonsres').style.display = "none";
		}
		if (document.getElementById('tav').value == 0)
		{
			document.getElementById('demavecres').style.display = "none";
			document.getElementById('demsonsres').style.display = "none";
		}
	}
	function showuploadfile()
	{
		document.getElementById('uploadfile').style.display = "block";
	}
	function choix_Demande(cod_police,page, id_user, datesys)
	{
		var type_av=document.getElementById('tav').value;
		
		var cod_formul='<?php echo $cod_formul;?>';
		var dateff='<?php echo $dated;?>';
		if (window.XMLHttpRequest) {
			xhr = new XMLHttpRequest();
		}
		else if (window.ActiveXObject)
		{
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}

		if(type_av==5)//avenant Avec ristourne
		{
			var x = document.getElementById("tav").selectedIndex;
			var y = document.getElementById("tav").options;
			var type_annul = 5;
			var motif= document.getElementById("selctdemavecres").options[document.getElementById("selctdemavecres").selectedIndex].text;

			var desc = document.getElementById("desc").value;

			xhr.open("GET", "php/avenant/voy/validationDem.php?code=" + cod_police + "&type=" + type_annul+"&date="+datesys + "&motif=" + motif + "&chemin=/Intranet-Salama-test/php/avenant/voy/file/documents/ &etat=0 &desc="+desc+"&iduser=" + id_user, false);
			xhr.send(null);
			alert("La demande a été créé avec succes");
			Menu1('prod', page);
		}
		if(type_av==4)
		{
			var type_annul = 4;
			var motif= document.getElementById("selctdemsonres").options[document.getElementById("selctdemsonres").selectedIndex].text;
			var desc = document.getElementById("descSR").value;
			document.getElementById('suiv').disabled=true;
			xhr.open("GET", "php/avenant/voy/validationDem.php?code=" + cod_police + "&type=" + type_annul+"&date="+datesys + "&motif=" + motif + "&chemin=SR&etat=0 &desc="+desc+"&iduser=" + id_user, false);
			xhr.send(null);
			alert("La demande a été créé avec succes");
			Menu1('prod', page);
		}
	}
	function charger()
    {
		var code = <?php echo $codepol; ?>;
		document.getElementById('suiv').disabled=false;
        window.open('php/avenant/voy/charger.php?code='+code , 'Chargement', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);
		document.getElementById('suiv').disabled=false;
    }
	function activerbtn()
    {
		if(document.getElementById("descSR").value !='' )
		{
			document.getElementById('suiv').disabled=false;
		}else
		{
			document.getElementById('suiv').disabled=true;
			alert("Veuillez saisir le numéro du nouveau contrat .. ");
		}
		
    }

</script>