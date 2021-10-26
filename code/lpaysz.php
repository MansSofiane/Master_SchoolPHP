<?php 
session_start();
require_once("../../../data/conn7.php");
//$errone = false;
//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}else{$page=0;}
if (isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
if (isset($_REQUEST['rech'])) {
	$rech = $_REQUEST['rech'];
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT p.* FROM `pays` as p, `zone` as z, `zonepays` as l WHERE l.cod_zone=z.cod_zone and l.cod_pays=p.cod_pays and z.cod_zone=$code AND p.lib_pays LIKE '%$rech%' ORDER BY `cod_pays`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.* FROM `pays` as p, `zone` as z, `zonepays` as l WHERE l.cod_zone=z.cod_zone and l.cod_pays=p.cod_pays and z.cod_zone=$code AND p.lib_pays LIKE '%$rech%' ORDER BY `cod_pays` LIMIT $part ,5");
$rqt->execute();	
	
}else{
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT p.* FROM `pays` as p, `zone` as z, `zonepays` as l WHERE l.cod_zone=z.cod_zone and l.cod_pays=p.cod_pays and z.cod_zone=$code ORDER BY `cod_pays`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.* FROM `pays` as p, `zone` as z, `zonepays` as l WHERE l.cod_zone=z.cod_zone and l.cod_pays=p.cod_pays and z.cod_zone=$code ORDER BY `cod_pays` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Paysde Rattaches </a></div>
  </div>
  <div class="widget-box">
         
            <ul class="quick-actions">
              <li class="bg_ls"> <a onClick="Menu2('param','zones.php')"> <i class="icon-tasks"></i>Zones </a> </li>
            </ul>
  </div>	
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Pays</h5>
		   <div><input type="text" id="rpayzon" onchange="frechpayzon('<?php echo $code ?>')" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code-Pays</th>
                  <th>Libelle-Pays</th>
				  <th>Tache</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_pays']; ?></td>
                  <td><?php  echo $row_res['lib_pays']; ?></td>
				  <td>
				  <a href="javascript:;" onclick="supplien('<?php echo $code; ?>','<?php echo $row_res['cod_pays'];?>')" title="Retirer"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-pays</h5>
		     <a href="javascript:;" title="Premiere page" onclick="fpagepz('0','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onclick="fpagepz('<?php echo $page-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onclick="fpagepz('<?php echo $page+1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onclick="fpagepz('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>	
<script language="JavaScript">
	function frechpayzon(code){
		var rech=document.getElementById("rpayzon").value;
        $("#content").load('code/lpaysz.php?rech='+rech+'&code='+code);
	}
	function fpagepz(page,nbpage,code){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('code/lpaysz.php?page='+page+'&code='+code);}
		}else{alert("Vous ete en premiere page !");}
	}
function cheksel(cod){
     var C1=document.getElementById(cod);
	  if (C1.checked){ alert(C1.value)}else{alert("NON");};
	}	
function supplien(codz,codp){
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	  xhr.open("GET", "php/zone/delpaysz.php?code="+codz+"&codp="+codp, false);
      xhr.send(null);
	 //alert(xhr.responseText);
	  alert("Pays Retire!"); 
	  lien(codz);
	}	
			
</script>		