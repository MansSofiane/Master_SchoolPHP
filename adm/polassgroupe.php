<?php
session_start();
require_once("../../../data/conn7.php");
//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}else{$page=0;}
if (isset($_REQUEST['rech'])) {
	$rech = $_REQUEST['rech'];

//Calcule du nombre de page 
	$rqtc=$bdd->prepare("SELECT d.`cod_pol`,YEAR(d.dat_val) annee, d.sequence,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous`,u.`agence` FROM `policew` as d,`souscripteurw` as s,`utilisateurs` as u WHERE s.`cod_sous`=d.`cod_sous`  AND d.`cod_prod`='9' AND s.`id_user`=u.`id_user` AND s.`nom_sous` LIKE '%$rech%' ORDER BY d.`cod_pol` DESC");
	$rqtc->execute();
	$nbe = $rqtc->rowCount();
	$nbpage=ceil($nbe/7);
//Pointeur de page
	$part=$page*7;
//requete � suivre
	$rqt=$bdd->prepare("SELECT d.`cod_pol`,YEAR(d.dat_val) annee, d.sequence,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous`,u.`agence` FROM `policew` as d,`souscripteurw` as s,`utilisateurs` as u WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='9' AND s.`id_user`=u.`id_user` AND s.`nom_sous` LIKE '%$rech%' ORDER BY d.`cod_pol` DESC LIMIT $part ,7");
	$rqt->execute();

}else{
//Calcule du nombre de page 
	$rqtc=$bdd->prepare("SELECT d.`cod_pol`,YEAR(d.dat_val) annee, d.sequence,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous`,u.`agence` FROM `policew` as d,`souscripteurw` as s,`utilisateurs` as u WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='9' AND s.`id_user`=u.`id_user` ORDER BY d.`cod_pol` DESC");
	$rqtc->execute();
	$nbe = $rqtc->rowCount();
	$nbpage=ceil($nbe/7);
//Pointeur de page
	$part=$page*7;
//requete � suivre
	$rqt=$bdd->prepare("SELECT d.`cod_pol`,YEAR(d.dat_val) annee, d.sequence,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous`,u.`agence` FROM `policew` as d,`souscripteurw` as s,`utilisateurs` as u WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='9' AND s.`id_user`=u.`id_user` ORDER BY d.`cod_pol` DESC LIMIT $part ,7");
	$rqt->execute();
	$nb = $rqt->execute();
}
?>

<div id="content-header">
	<div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Assurance-Groupe</a> </div>
</div>
<div class="widget-box">
	<ul class="quick-actions">
		<li class="bg_lo"> <a onClick="aMenu1('macc','../adash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
		<!--<li class="bg_lr"> <a onClick="aMenu1('prod','polassgroupe.php')"> <i class="icon-folder-open"></i>Visualiser-Contrats</a> </li>-->
	</ul>
</div>
<div class="widget-box">
	<div class="widget-title">
		<div><input type="text" id="ansouspade" onchange="afrechpade()" class="span4" placeholder="Rechercher par Nom-Souscripteur..."/></div>
	</div>
	<div class="widget-content nopadding">
		<table class="table table-bordered data-table">
			<thead>
			<tr>
				<th></th>
				<th>Agence</th>
				<th>N-Contrat</th>
				<th>Exercice</th>
				<th>Nom/Prenom</th>
				<th>D-Effet</th>
				<th>D-Echeance</th>
				<th>P-Nette</th>
				<th>P-Totale</th>
				<th>Operations</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$i = 0;
			while ($row_res=$rqt->fetch()){  ?>
				<!-- Ici les lignes du tableau zone-->
				<tr class="gradeX">
					<?php if($row_res['etat']==0){ ?>
						<td><a title="Police-Valide"><img  src="img/icons/icon_2.png"/></a></td>
					<?php }
					if($row_res['etat']==2){
						?>
						<td><a title="Police-Ristournee"><img  src="img/icons/icon_4.png"/></a></td>
					<?php }
					if($row_res['etat']==3){
						?>
						<td><a title="Police-Annulee"><img  src="img/icons/icon_1.png"/></a></td>
					<?php } ?>
					<td><?php  echo $row_res['agence']; ?></td>
					<td><?php  echo $row_res['sequence']; ?></td>
					<td><?php  echo $row_res['annee']; ?></td>
					<td><?php  echo $row_res['nom_sous']."  ".$row_res['pnom_sous']; ?></td>
					<td><?php  echo date("d/m/Y",strtotime($row_res['ndat_eff'])); ?></td>
					<td><?php  echo date("d/m/Y",strtotime($row_res['ndat_ech'])); ?></td>
					<td><?php  echo number_format($row_res['pn'], 2, ',', ' ')." DZD"; ?></td>
					<td><?php  echo number_format($row_res['pt'], 2, ',', ' ')." DZD"; ?></td>
					<td>&nbsp;

						<a href="sortie/contrat8/<?php echo crypte($row_res['cod_pol']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="widget-title" align="center">
		<h5>Visualisation-Contrats-Groupe</h5>
		<a href="javascript:;" title="Premiere page" onClick="afpagepade('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
		<a href="javascript:;" title="Precedent" onClick="afpagepade('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
		<?php echo $page; ?>/<?php echo $nbpage; ?>
		<a href="javascript:;" title="Suivant" onClick="afpagepade('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
		<a href="javascript:;" title="Derniere page" onClick="afpagepade('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
	</div>
</div>
<script language="JavaScript">
	function afrechpade(){
		var rech=document.getElementById("ansouspade").value;
		$("#content").load('adm/polassgroupe.php?rech='+rech);
	}
	function afpagepade(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				swal("Information !","Vous ete a la derniere page!","info");
			}else{$("#content").load('adm/polassgroupe.php?page='+page);}
		}else{swal("Information !","Vous ete en premiere page !","info");}
	}

</script>		