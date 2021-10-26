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
	$rech = $_REQUEST['rech'];
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT * FROM `zone`  WHERE id_user= $id_user AND lib_zone LIKE '%$rech%' ORDER BY `cod_zone`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `zone`  WHERE id_user= $id_user AND lib_zone LIKE '%$rech%' ORDER BY `cod_zone` LIMIT $part ,5");
$rqt->execute();	
	
}else{

//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT * FROM `zone`  WHERE id_user= $id_user ORDER BY `cod_zone`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `zone`  WHERE id_user= $id_user ORDER BY `cod_zone` LIMIT $part ,5");
$rqt->execute();
}
$nb = $rqt->execute();
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Zones de Couverture</a></div>
  </div>
   <div class="widget-box">
         
            <ul class="quick-actions">
               <li class="bg_lo"> <a href=""> <i class="icon-home"></i>Acceuil </a> </li>
               <li class="bg_lg"> <a onClick="form('azone.php')"> <i class="icon-tasks"></i>Nouvelle-Zone</a> </li>
			   <li class="bg_ls"> <a onClick="Menu2('param','pays.php')"> <i class="icon-tasks"></i>Liste-Pays</a> </li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche par Libelle-Zone</h5>
		   <div><input type="text" id="rzone" onchange="frechzone()" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code-Zone</th>
                  <th>Libelle-Zone</th>
				  <th>Commentaire</th>
				  <th>Taches</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_zone']; ?></td>
                  <td><?php  echo $row_res['lib_zone']; ?></td>
				  <td><?php  echo $row_res['com_zone']; ?></td>
				  <td>
				  
			 <a onclick="lien('<?php  echo $row_res['cod_zone']; ?>')" title="Pays-Rattaches"><img  src="img/icons/flag.png"/></a>
			 <a onClick="aff('apays.php','<?php  echo $row_res['cod_zone']; ?>')" title="Affecter-Pays"><img  src="img/icons/plus.png"/></a>             <a onClick="mzone('<?php echo $row_res['cod_zone']; ?>')" title="Modifier"><img  src="img/icons/modi.png"/></a>
			 <a onClick="dzone('<?php echo $row_res['cod_zone']; ?>')" title="Supprimer"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Zone</h5>
		     <a href="javascript:;" title="Premiere page" onclick="fpage('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onclick="fpage('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onclick="fpage('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onclick="fpage('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function frechzone(){
		var rech=document.getElementById("rzone").value;
        $("#content").load('code/zones.php?rech='+rech);
	}
	function fpage(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('code/zones?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}
function lien(code){	
$("#content").load('code/lpaysz.php?code='+code);
}
function aff(page,code){	
$("#content").load('formulaire/apays.php?code='+code);
}	
function dzone(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Supprimer cette Zone ?");
if (ok){
 xhr.open("GET", "php/delete/dzone.php?code="+cod, false);
 xhr.send(null);  
 alert("Zone Supprimee !");    
}
Menu2('param','zones.php');
	}	
function mzone(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Modifier cette zone ?");
if (ok){
 xhr.open("GET", "php/modif/fmzone.php?code="+cod, false);
$("#content").load('php/modif/fmzone.php?code='+cod);    
}
	}	
</script>		