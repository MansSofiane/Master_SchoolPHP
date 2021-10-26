<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
$datesysfordem=date("Y.m.d-H");

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
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div id="breadcrumb"> <a class="current"><i></i>Avenants</a><a>Type-Avenant</a>
				<div class="widget-content nopadding">
					<form class="form-horizontal">
						<div id="step-holder">
							<div class="controls">
								<select   id="tav"  onchange="hidshowdem()">
									<option value="">--  Type Avenants</option>
									<?php
									 switch ($cod_formul)
									 {
										 case 2:
										 {?>
											 <option value='1'>Modification de date</option>
		                                     	<option value='2'>Changement de destination </option>
											 <!--<option value='4'>Prorogation de delais</option> -->
											 <option value='3'>Precision</option>
											<option value='5'>Demande d'annulation avec ristourne</option>
											 <?php if ($nbav==0){?>
											 <option value='4'>Demande d'annulation Sans ristourne</option>
										 <?php  }?>
										<?php  break;}
										 case 3:
										 {?>
											 <option value='1'>Modification de date</option>
											 <option value='2'>Changement de destination </option>
                                           <!-- <option value='4'>Prorogation de delais</option> -->
											 <option value='3'>Precision</option>
											 <option value='5'>Demande d'annulation avec ristourne</option>
											 <?php if ($nbav==0){?>
											 <option value='4'>Demande d'annulation Sans ristourne</option>
										 <?php  }?>
										 <?php  break;}
										 case 4:
										 {?>
											 <option value='1'>Modification de date</option>
											 	<option value='2'>Changement de destination </option>
                                           <!-- <option value='4'>Prorogation de delais</option> -->
											 <option value='3'>Precision</option>
											 <option value='5'>Demande d'annulation avec ristourne</option>
											 <?php if ($nbav==0){?>
											 <option value='4'>Demande d'annulation Sans ristourne</option>
										 <?php  }?>
										 <?php  break; }
										 case 5:
										 {?>
											 <option value='1'>Modification de date</option>
											 <option value='2'>Changement de destination </option>
                                           <!--<option value='4'>Prorogation de delais</option>-->
											 <option value='3'>Precision</option>
											 <option value='5'>Demande d'annulation avec ristourne</option>
											 <?php if ($nbav==0){?>
											 <option value='4'>Demande d'annulation Sans ristourne</option>
										 <?php  }?>
											 <option value='6'>Adjonction</option>

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
								<textarea id ="descSR" cols="500" rows= "10"  placeholder="description de la demande..."onchange="activerbtn()"></textarea> 
							</div>
						</div>
						</div>
						<div class="form-actions" align="right">
							<input  type="button" id="btnav" class="btn btn-success" onClick="choix_avenant('<?php echo $codepol; ?>','<?php echo $page;?>','<?php echo $id_user; ?>','<?php echo $datesysfordem; ?>')" value="Suivant" disabled="disabled"/>
							<input  type="button" class="btn btn-danger"  onClick="Menu1('prod','<?php echo $page; ?>')" value="Annuler" />
						</div>
				</div>
			</div>
		</div>

	</div>
</div>
<script language="JavaScript">
	function activerbtn()
    {
		if(document.getElementById("descSR").value !='' )
		{
			document.getElementById('btnav').disabled=false;
		}else
		{
			document.getElementById('btnav').disabled=true;
			alert("Veuillez saisir le numéro du nouveau contrat .. ");
		}
		
    }
	function hidshowdem()
	{
		if (document.getElementById('tav').value == 4)
		{
			document.getElementById('demavecres').style.display = "none";
			document.getElementById('demsonsres').style.display = "block";
			document.getElementById('btnav').disabled=true;

		}
		if (document.getElementById('tav').value == 5)
		{
			document.getElementById('btnav').disabled=true;
			document.getElementById('demavecres').style.display = "block";
			document.getElementById('demsonsres').style.display = "none";
		}
		if (document.getElementById('tav').value == 0)
		{
			document.getElementById('btnav').disabled=true;
			document.getElementById('demavecres').style.display = "none";
			document.getElementById('demsonsres').style.display = "none";
		}
		if (document.getElementById('tav').value != 4 && document.getElementById('tav').value != 5)
		{
			document.getElementById('btnav').disabled=false;
			document.getElementById('demavecres').style.display = "none";
			document.getElementById('demsonsres').style.display = "none";

		}

	}
	function showuploadfile()
	{
		document.getElementById('uploadfile').style.display = "block";
	}
	function charger()
    {
		var code = <?php echo $codepol; ?>;
		document.getElementById('btnav').disabled=false;
        window.open('php/avenant/voy/charger.php?code='+code , 'Chargement', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);
    }
	function choix_avenant(cod_police,page,id_user, datesys)
	{
		var type_av=document.getElementById('tav').value;
		var cod_formul='<?php echo $cod_formul;?>';
		var dateff='<?php echo $dated;?>';
		var datech='<?php echo $datef;?>';
		var av_sans_r='50';
		var av_avec_r='30';
		var av_prec='70';
		if (window.XMLHttpRequest) {
			xhr = new XMLHttpRequest();
		}
		else if (window.ActiveXObject)
		{
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}

		if(type_av==1)
		{
			$("#content").load('php/avenant/voy/report_date.php?page='+page+"&cod_pol="+cod_police+"&formul="+cod_formul+"&tav="+type_av);

		}
		if(type_av==2)
		{
			$("#content").load('php/avenant/voy/destination.php?page='+page+"&cod_pol="+cod_police+"&formul="+cod_formul+"&tav="+type_av);

		}
		if(type_av==3)
		{
			//suuprimer depuis la talble assur les lignes de cette police dans la condition est av=0
			xhr.open("GET", "php/avenant/voy/assurprecision.php?code=" + cod_police , false);
			xhr.send(null);
			$("#content").load('php/avenant/voy/precision.php?page='+page+"&cod_pol="+cod_police+"&formul="+cod_formul+"&tav="+type_av+'&pagepres=0');

		}
		if(type_av==4)//avenant sans ristourne
		{
			var type_annul = 4;
			var motif= document.getElementById("selctdemsonres").options[document.getElementById("selctdemsonres").selectedIndex].text;
			var desc = document.getElementById("descSR").value;
			document.getElementById('btnav').disabled=true;
			xhr.open("GET", "php/avenant/voy/validationDem.php?code=" + cod_police + "&type=" + type_annul+"&date="+datesys + "&motif=" + motif + "&chemin=SR&etat=0 &desc="+desc+"&iduser=" + id_user, false);
			xhr.send(null);
			alert("La demande a été créé avec succes");
			Menu1('prod', page);
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
		
		//edited by MS 
		//if(type_av==4)//avenant sans ristourne
		//{
		//	document.getElementById("btnav").disabled=true;
		//	xhr.open("GET", "php/avenant/voy/validationav.php?code=" + cod_police + "&date1=" + dateff + "&date2=" + datech + "&av=" + av_sans_r, false);
		//	xhr.send(null);
		//	Menu1('prod', page);
		//}
		//if(type_av==5)//avenant Avec ristourne
		//{
		//	document.getElementById("btnav").disabled=true;
		//	//$("#content").load("php/avenant/voy/mpaiement.php?code="+cod_police+"&page="+page+"&av="+av_avec_r+"&datdebut="+dateff+"&datfin="+datech);
		//	xhr.open("GET", "php/avenant/voy/validationav.php?code=" + cod_police + "&date1=" + dateff + "&date2=" + datech + "&av=" + av_avec_r, false);
		//	xhr.send(null);
		//	Menu1('prod', page);
		//}
		if(type_av==6)
		{
			$("#content").load('php/avenant/voy/adjonction.php?page='+page+"&cod_pol="+cod_police+"&formul="+cod_formul+"&tav="+type_av);

		}
	}
</script>