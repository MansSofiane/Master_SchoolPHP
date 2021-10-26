<?php 
session_start();
require_once("../../../data/conn7.php");
//$errone = false;
//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}else{$page=0;}
$id_user = $_SESSION['id_usersal'];

if (isset($_REQUEST['rech'])) {
	 $rech =addslashes( $_REQUEST['rech']);
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT p.*, g.* FROM `produit` as p,`garantie` as g,`affgarprod` as a WHERE a.cod_prod=p.cod_prod and a.cod_gar=g.cod_gar and a.id_user=$id_user AND g.lib_gar LIKE '%$rech%' ORDER BY `cod_aff`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.*, g.* FROM `produit` as p,`garantie` as g,`affgarprod` as a WHERE a.cod_prod=p.cod_prod and a.cod_gar=g.cod_gar and a.id_user=$id_user AND g.lib_gar LIKE '%$rech%' ORDER BY `cod_aff` LIMIT $part ,5");
$rqt->execute();	
	
}else{
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT p.*, g.* FROM `produit` as p,`garantie` as g,`affgarprod` as a WHERE a.cod_prod=p.cod_prod and a.cod_gar=g.cod_gar and a.id_user=$id_user ORDER BY `cod_aff`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.*, g.* FROM `produit` as p,`garantie` as g,`affgarprod` as a WHERE a.cod_prod=p.cod_prod and a.cod_gar=g.cod_gar and a.id_user=$id_user ORDER BY `cod_aff` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Assurance-Credit-Consommation</a> </div>
  </div>
  <div class="widget-box">
            <ul class="quick-actions">
			  <li class="bg_lo"> <a onClick="Menu('macc','acceuil.html')"> <i class="icon-home"></i>Acceuil </a> </li>
			  <li class="bg_ls"> <a onClick="tarif('prod','atarif.php')"> <i class="icon-folder-open"></i>Devis</a> </li>
	          <li class="bg_lg"> <a href=""> <i class="icon-folder-open"></i>Contrats</a> </li>
			  <li class="bg_ly"> <a onClick="tarif('prod','vsimulationconso.php')"> <i class="icon-dashboard"></i> Simulation</a> </li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Garantie</h5>
		   <div><input type="text" id="rgarprod" onchange="frechgarprod()" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code-Produit</th>
				  <th>Code-Garantie</th>
                  <th>Libelle-Garantie</th>
				  <th>Plafond</th>
				  <th>Monaie</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_prod']; ?></td>
				  <td><?php  echo $row_res['cod_gar']; ?></td>
                  <td><?php  echo $row_res['lib_gar']; ?></td>
				  <td><?php  echo $row_res['plafond_gar']; ?></td>
				  <td><?php  echo $row_res['monais_gar']; ?></td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualiser-Garanties</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpagegav('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpagegav('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpagegav('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpagegav('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function frechgarprod(){
		var rech=document.getElementById("rgarprod").value;
        $("#content").load('produit/assvoy.php?rech='+rech);
	}
	function fpagegav(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('produit/assvoy.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}	
</script>		