<?php 
session_start();
require_once("../../../data/conn7.php");
//$errone = false;
//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}else{$page=0;}
$id_user = $_SESSION['id_usersal'];
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT t.cod_tar,t.agemin,t.agemax,t.pe,t.pa,t.maj_pa,t.maj_pe,t.rab_pa,t.rab_pe, s.lib_seg,z.lib_zone,f.lib_formul, o.lib_opt, p.lib_per,d.lib_dt, c.lib_cpl FROM `tarif` as t, `segment` as s, `zone` as z, `formule` as f, `option` as o, `periode` as p,`dtimbre` as d,`cpolice` as c, `utilisateurs` as u 
WHERE t.cod_seg=s.cod_seg 
AND t.cod_zone=z.cod_zone
AND t.cod_formul=f.cod_formul
AND t.cod_opt=o.cod_opt
AND t.cod_per=p.cod_per
AND t.cod_dt=d.cod_dt
AND t.cod_cpl=c.cod_cpl
AND t.`cod_prod`='1'
AND t.`id_user`=u.`id_user`
AND t.`id_user`='$id_user'");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT t.cod_tar,t.agemin,t.agemax,t.pe,t.pa,t.maj_pa,t.maj_pe,t.rab_pa,t.rab_pe, s.lib_seg,z.lib_zone,f.lib_formul, o.lib_opt, p.lib_per,d.lib_dt, c.lib_cpl FROM `tarif` as t, `segment` as s, `zone` as z, `formule` as f, `option` as o, `periode` as p,`dtimbre` as d,`cpolice` as c, `utilisateurs` as u 
WHERE t.cod_seg=s.cod_seg 
AND t.cod_zone=z.cod_zone
AND t.cod_formul=f.cod_formul
AND t.cod_opt=o.cod_opt
AND t.cod_per=p.cod_per
AND t.cod_dt=d.cod_dt
AND t.cod_cpl=c.cod_cpl
AND t.`cod_prod`='1'
AND t.`id_user`=u.`id_user`
AND t.`id_user`='$id_user' LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
?>  
  
  <div id="content-header">
   <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage</a> <a class="current">Liste des Tarifs</a> </div>
  </div>
  </div>
  <div class="widget-box">
            <ul class="quick-actions">
			  <li class="bg_lo"> <a onClick="Menu('macc','acceuil.html')"> <i class="icon-home"></i>Acceuil </a> </li>
			  <li class="bg_ls"> <a onClick="Menu1('prod','tarassvoy.php')"> <i class="icon-bar-chart"></i> Tarifs </a> </li>
			  <li class="bg_lg"> <a onClick="tarif('prod','atarif.php')"> <i class="icon-folder-open"></i>Ajouter-Tarif</a> </li>
	          <li class="bg_lg"> <a href=""> <i class="icon-folder-open"></i>Ajouter-Garantie</a> </li>
			  <li class="bg_ly"> <a onClick="tarif('prod','vsimulation.php')"> <i class="icon-dashboard"></i> Simulation</a> </li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Liste des Tarifs</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code</th>
				  <th>Segment</th>
                  <th>Formule</th>
				  <th>Zone</th>
				  <th>Option</th>
				  <th>Duree</th>
				  <th>Age-Min</th>
				  <th>Age-Max</th>
				  <th>P-Entreprise</th>
				  <th>P-Assistance</th>
				  <th>D-timbre</th>
				  <th>C-police</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_tar']; ?></td>
				  <td><?php  echo $row_res['lib_seg']; ?></td>
                  <td><?php  echo $row_res['lib_formul']; ?></td>
				  <td><?php  echo $row_res['lib_zone']; ?></td>
				  <td><?php  echo $row_res['lib_opt']; ?></td>
				  <td><?php  echo $row_res['lib_per']; ?></td>
				  <td><?php  echo $row_res['agemin']; ?></td>
				  <td><?php  echo $row_res['agemax']; ?></td>
				  <td><?php  echo $row_res['pe']; ?></td>
				  <td><?php  echo $row_res['pa']; ?></td>
				  <td><?php  echo $row_res['lib_dt']; ?></td>
				  <td><?php  echo $row_res['lib_cpl']; ?></td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualiser-Garanties</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpagetar('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpagetar('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpagetar('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpagetar('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function fpagetar(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('produit/tarassvoy.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}	
</script>		