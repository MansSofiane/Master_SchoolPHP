<?php 
session_start();
require_once("../../../data/conn7.php");
//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}else{$page=0;}
if (isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];}
if (isset($_REQUEST['rech'])) {
	 $rech =addslashes( $_REQUEST['rech']);
	
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_av`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,d.`lib_mpay`,s.`nom_sous`,s.`pnom_sous`,u.`agence` FROM `policew` as p,`avenantw` as d,`souscripteurw` as s,`utilisateurs` as u WHERE s.`cod_sous`=p.`cod_sous`  AND d.`cod_prod`='7' AND d.`cod_pol`=p.`cod_pol` AND s.`id_user`=u.`id_user` AND d.`cod_pol`='$code' AND s.`nom_sous` LIKE '%$rech%' ORDER BY d.`cod_pol` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_av`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,d.`lib_mpay`,s.`nom_sous`,s.`pnom_sous`,u.`agence` FROM `policew` as p,`avenantw` as d,`souscripteurw` as s,`utilisateurs` as u WHERE s.`cod_sous`=p.`cod_sous` AND d.`cod_prod`='7' AND d.`cod_pol`=p.`cod_pol` AND s.`id_user`=u.`id_user` AND d.`cod_pol`='$code' AND s.`nom_sous` LIKE '%$rech%' ORDER BY d.`cod_pol` DESC LIMIT $part ,7");
$rqt->execute();	
	
}else{
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_av`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,d.`lib_mpay`,s.`nom_sous`,s.`pnom_sous`,u.`agence` FROM `policew` as p,`avenantw` as d,`souscripteurw` as s,`utilisateurs` as u WHERE s.`cod_sous`=p.`cod_sous` AND d.`cod_prod`='7' AND d.`cod_pol`=p.`cod_pol` AND s.`id_user`=u.`id_user` AND d.`cod_pol`='$code' ORDER BY d.`cod_pol` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_av`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,d.`lib_mpay`,s.`nom_sous`,s.`pnom_sous`,u.`agence` FROM `policew` as p,`avenantw` as d,`souscripteurw` as s,`utilisateurs` as u WHERE s.`cod_sous`=p.`cod_sous` AND d.`cod_prod`='7' AND d.`cod_pol`=p.`cod_pol` AND s.`id_user`=u.`id_user` AND d.`cod_pol`='$code' ORDER BY d.`cod_pol` DESC LIMIT $part ,7");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Assurance-Credit-Immobilier</a> </div>
  </div>
  <div class="widget-box">
            <ul class="quick-actions">
			  <li class="bg_lo"> <a onClick="aMenu1('macc','../adash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
	          <li class="bg_lb"> <a onClick="aMenu1('prod','asscim.php')"> <i class="icon-folder-open"></i>Devis-En-Attente</a></li>
	          <li class="bg_lg"> <a onClick="aMenu1('prod','polasscim.php')"> <i class="icon-folder-open"></i>Visualiser-Contrats</a> </li>
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
				  <th>Agence</th>
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
				  <td><a><img  src="img/icons/icon_1.png"/></a></td>
				  <?php } ?>
				  <td><?php  echo $row_res['agence']; ?></td>
                  <td><?php  echo $row_res['nom_sous']."  ".$row_res['pnom_sous']; ?></td>
				  <td><?php  echo date("d/m/Y",strtotime($row_res['ndat_eff'])); ?></td>
                  <td><?php  echo date("d/m/Y",strtotime($row_res['ndat_ech'])); ?></td>
				  <td><?php  echo number_format($row_res['pn'], 2, ',', ' ')." DZD"; ?></td>
				  <td><?php  echo number_format($row_res['pt'], 2, ',', ' ')." DZD"; ?></td>
				  <td>&nbsp;
				  <?php if($row_res['lib_mpay']==74){ ?>
				  <a href="sortie/Avenant-MD3/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
				  <?php }
				   if($row_res['lib_mpay']==30){ ?>
				  <a href="sortie/Avenant-AR3/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
				  <?php }
				   if($row_res['lib_mpay']==50){ ?>
				  <a href="sortie/Avenant-SR3/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
				  <?php }
				   if($row_res['lib_mpay']==70){ ?>
				  <a href="sortie/Avenant-PR3/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
				   <?php }
				  if($row_res['lib_mpay']==73){ ?>
					  <a href="sortie/Avenant-SUB3/<?php echo crypte($row_res['cod_av']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
					<?php }?>
				    </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Avenants-Deces-Emprunteur</h5>
		     <a href="javascript:;" title="Premiere page" onClick="afpageaade('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="afpageaade('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="afpageaade('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="afpageaade('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function afrechaade(){
		var rech=document.getElementById("ansousaade").value;
        $("#content").load('adm/avpolasscim.php?rech='+rech);
	}
	function afpageaade(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('adm/avpolasscim.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}	

</script>		