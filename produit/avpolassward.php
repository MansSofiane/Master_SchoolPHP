<?php 
session_start();
require_once("../../../data/conn7.php");

//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}else{$page=0;}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if (isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];}
if (isset($_REQUEST['rech'])) {
	$rech = $_REQUEST['rech'];
	
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_av`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,d.`lib_mpay`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as p,`avenantw` as d,`souscripteurw` as s WHERE s.`cod_sous`=p.`cod_sous` AND d.`cod_prod`='5' AND d.`cod_pol`=p.`cod_pol` AND d.`cod_pol`='$code' AND s.`nom_sous` LIKE '%$rech%' ORDER BY d.`cod_av` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_av`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,d.`lib_mpay`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as p,`avenantw` as d,`souscripteurw` as s WHERE s.`cod_sous`=p.`cod_sous` AND d.`cod_prod`='5' AND d.`cod_pol`=p.`cod_pol` AND d.`cod_pol`='$code' AND s.`nom_sous` LIKE '%$rech%' ORDER BY d.`cod_av` DESC LIMIT $part ,7");
$rqt->execute();	
	
}else{
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_av`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,d.`lib_mpay`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as p,`avenantw` as d,`souscripteurw` as s WHERE s.`cod_sous`=p.`cod_sous` AND d.`cod_prod`='5' AND d.`cod_pol`=p.`cod_pol` AND d.`cod_pol`='$code' ORDER BY d.`cod_av` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_av`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,d.`lib_mpay`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as p,`avenantw` as d,`souscripteurw` as s WHERE s.`cod_sous`=p.`cod_sous` AND d.`cod_prod`='5' AND d.`cod_pol`=p.`cod_pol` AND d.`cod_pol`='$code' ORDER BY d.`cod_av` DESC LIMIT $part ,7");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Assurance-Warda</a> </div>
  </div>
  <div class="widget-box">
            <ul class="quick-actions">
			  <li class="bg_lo"> <a onClick="Menu('macc','dash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
			  <li class="bg_ls"> <a onClick="ndevwar()"> <i class="icon-folder-open"></i>Nouveau-Devis</a> </li>
			  <li class="bg_lb"> <a onClick="Menu1('prod','assward.php')"> <i class="icon-folder-open"></i>Visualiser-Devis</a></li>
	          <li class="bg_lg"> <a onClick="Menu1('prod','polassward.php')"> <i class="icon-folder-open"></i>Visualiser-Contrats</a> </li>
			  <li class="bg_ly"> <a onClick="Menu('prod','php/tarif/vsimulationwarda.php')"> <i class="icon-dashboard"></i> Simulation</a> </li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> 
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
				  <th></th>
                  <th>Nom/Prenom</th>
				  <th>D-Effet</th>
                  <th>D-Echeance</th>
				  <th>P-Nette</th>
				  <th>P-Totale</th>
				  <th>Avenant</th>
				  <th>Operations</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
			 
				  <td><a><img  src="img/icons/icon_4.png"/></a></td>
                  <td><?php  echo $row_res['nom_sous']."  ".$row_res['pnom_sous']; ?></td>
				  <td><?php  echo date("d/m/Y",strtotime($row_res['ndat_eff'])); ?></td>
                  <td><?php  echo date("d/m/Y",strtotime($row_res['ndat_ech'])); ?></td>
				  <td><?php  echo number_format($row_res['pn'], 2, ',', ' ')." DZD"; ?></td>
				  <td><?php  echo number_format($row_res['pt'], 2, ',', ' ')." DZD"; ?></td>
				<?php if($row_res['lib_mpay']==74){ ?>
					<td><?php echo "Modification-Date"?></td>
				<?php }
				if($row_res['lib_mpay']==70){
					?>
					<td><?php echo "Precision"?></td>
				<?php }
				if($row_res['lib_mpay']==30){
					?>
					<td><?php echo"Avec-Ristourne";?></td>
				<?php }
				if($row_res['lib_mpay']==50){
					?>
					<td><?php echo"Sans-Ristourne";?></td>
				<?php }
				if($row_res['lib_mpay']==73){
					?>
					<td><?php echo"Subrogation";?></td>
				<?php }

				?>
				  <td>&nbsp;
				 <?php if($row_res['lib_mpay']==74){ ?>
				  <a href="sortie/Avenant-MD1/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
				  <?php }
				   if($row_res['lib_mpay']==30){ ?>
				  <a href="sortie/Avenant-AR1/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
				  <?php }
				   if($row_res['lib_mpay']==50){ ?>
				  <a href="sortie/Avenant-SR1/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
				  <?php }  if($row_res['lib_mpay']==70){ ?>
				  <a href="sortie/Avenant-PR1/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
				  <?php }?>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Avenants-Warda</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpageapwar('0','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpageapwar('<?php echo $page-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpageapwar('<?php echo $page+1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpageapwar('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
			
<script language="JavaScript">
	function frechapwar(){
		var rech=document.getElementById("nsousapwar").value;
        $("#content").load('produit/avpolassward.php?rech='+rech);
	}
	function fpageapwar(page,nbpage,code){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('produit/avpolassward.php?page='+page+'&code='+code);}
		}else{alert("Vous ete en premiere page !");}
	}	
	
</script>		