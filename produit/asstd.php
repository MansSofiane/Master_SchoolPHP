<?php 
session_start();
require_once("../../../data/conn7.php");
$token1 = generer_token('asstd');
//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}else{$page=0;}
$id_user = $_SESSION['id_usersal'];
$rech='';$crit='';
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if (isset($_REQUEST['rech'])) {
	$rech = $_REQUEST['rech'];
	$crit=$_REQUEST['crit'];
	$condition="";
	if($crit==1){$condition="d.cod_dev='".$rech."'";}//code devis
	if($crit==2){$condition="s.nom_sous like '%".$rech."%'";}//nom souscripteur
	
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_dev`,d.`dat_eff`,d.`dat_ech`,d.`pn`,d.`pt`,d.`bool`,s.`nom_sous`,s.`pnom_sous` FROM `devisw` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`etat`='0' AND d.`cod_prod`='6' AND s.`id_user`='$id_user' AND $condition ORDER BY d.`cod_dev` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_dev`,d.`dat_eff`,d.`dat_ech`,d.`pn`,d.`pt`,d.`bool`,s.`nom_sous`,s.`pnom_sous` FROM `devisw` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`etat`='0' AND d.`cod_prod`='6' AND s.`id_user`='$id_user' AND $condition ORDER BY d.`cod_dev` DESC LIMIT $part ,7");
$rqt->execute();	
	
}else{
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_dev`,d.`dat_eff`,d.`dat_ech`,d.`pn`,d.`pt`,d.`bool`,s.`nom_sous`,s.`pnom_sous` FROM `devisw` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`etat`='0' AND d.`cod_prod`='6' AND s.`id_user`='$id_user' ORDER BY d.`cod_dev` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_dev`,d.`dat_eff`,d.`dat_ech`,d.`pn`,d.`pt`,d.`bool`,s.`nom_sous`,s.`pnom_sous` FROM `devisw` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`etat`='0' AND d.`cod_prod`='6' AND s.`id_user`='$id_user' ORDER BY d.`cod_dev` DESC LIMIT $part ,7");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
   <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Temporaire-Au-Deces</a> </div>
  </div>
  <div class="widget-box">
            <ul class="quick-actions">
			  <li class="bg_lo"> <a onClick="Menu('macc','dash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
			  <li class="bg_ls"> <a onClick="ndevtd('<?php echo $token1; ?>')"> <i class="icon-folder-open"></i>Nouveau-Devis</a> </li>
	          <li class="bg_lb"> <a onClick="Menu1('prod','asstd.php')"> <i class="icon-folder-open"></i>Visualiser-Devis</a></li>
	          <li class="bg_lg"> <a onClick="Menu1('prod','polasstd.php')"> <i class="icon-folder-open"></i>Visualiser-Contrats</a></li>
			  <li class="bg_ly"> <a onClick="Menu('prod','php/tarif/vsimulationtd.php')"> <i class="icon-dashboard"></i> Simulation</a> </li>
            </ul>
  </div>
   <div class="widget-box">
	   <div class="widget-title">
		   <div><input type="text" id="nsouspade"  value="<?php echo $rech;?>"  class="span4" placeholder="Recherche"/>
			   &nbsp;&nbsp;

			   <select   id="critere"  >
				   <option value="1">Numero Devis</option>
				   <option value="2">Nom de souscripteur</option>


			   </select>
			   &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;
			   <input  type="button" class="btn btn-success" onClick="frechpade()" value="Rechercher" />
			   &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;
			   <?php if ($rech!=''){?>
				   <input  type="button" class="btn btn-danger" onClick="frechpade2()" value="Annuler"  />
			   <?php } else {?>
				   <input  type="button" class="btn btn-danger" onClick="frechpade2()" value="Annuler" disabled="disabled" />
			   <?php }?>
		   </div>
		   &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;
		   &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;
	   </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
				  <th></th>
				  <th>N Devis</th>
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
			      <?php if($row_res['bool']==0){ ?>
			      <td><a title="Validation permise"><img  src="img/icons/icon_2.png"/></a></td>
				  <?php }
				  if($row_res['bool']==1){
				  ?>
				  <td><a title="En attente Accord"><img  src="img/icons/icon_4.png"/></a></td>
				  <?php }
				  if($row_res['bool']==2){
				  ?>
				  <td><a title="Demande-Rejete"><img  src="img/icons/icon_1.png"/></a></td>
				  <?php } ?>
				  <td><?php  echo $row_res['cod_dev']; ?></td>
                  <td><?php  echo $row_res['nom_sous']."  ".$row_res['pnom_sous']; ?></td>
				  <td><?php  echo date("d/m/Y",strtotime($row_res['dat_eff'])); ?></td>
                  <td><?php  echo date("d/m/Y",strtotime($row_res['dat_ech'])); ?></td>
				  <td><?php  echo number_format($row_res['pn'], 2, ',', ' ')." DZD"; ?></td>
				  <td><?php  echo number_format($row_res['pt'], 2, ',', ' ')." DZD"; ?></td>
				  <td>&nbsp;
				 
				  <a href="sortie/devis3/<?php echo crypte($row_res['cod_dev']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>&nbsp;&nbsp;&nbsp;
				  <?php if($row_res['bool']==0){ ?>
			       <a onClick="vdev('<?php echo $row_res['cod_dev'];?>','<?php echo $row_res['dat_eff'];?>','asstd.php')" title="Valider"><i CLASS="icon-ok icon-2x" style="color:green"/></a>&nbsp;&nbsp;&nbsp;
				  <?php } ?>
				  <a onClick="ddev('prod','asstd.php','<?php echo $row_res['cod_dev'];?>')" title="Supprimer"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Devis-Temporaire-Au-Deces</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpagepade('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpagepade('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpagepade('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpagepade('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">

	function frechpade(){
		var rech=document.getElementById("nsouspade").value;

		var crit=document.getElementById("critere").value;
		$("#content").load('produit/asstd.php?rech='+rech+'&crit='+crit);
	}
	function frechpade2(){
		var rech='';
		var crit=2;

		$("#content").load('produit/asstd.php?rech='+rech+'&crit='+crit);
	}
	function fpagepade(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{
				var rech='<?php echo $rech;?>';
				var crit='<?php echo $crit;?>';
				if(rech!='')
					$("#content").load('produit/asstd.php?page='+page+'&rech='+rech+'&crit='+crit);
				else
					$("#content").load('produit/asstd.php?page='+page);
			}
		}else{alert("Vous ete en premiere page !");}
	}
	/*function frechdtd(){
		var rech=document.getElementById("nsousdtd").value;
        $("#content").load('produit/asstd.php?rech='+rech);
	}
	function fpagedtd(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('produit/asstd.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}
		*/
</script>		