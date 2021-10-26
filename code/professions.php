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
$rqtc=$bdd->prepare("SELECT p.*,c.lib_cls FROM `profession` as p, `classe` as c  WHERE p.cod_cls=c.cod_cls AND p.id_user=$id_user AND lib_prof LIKE '%$rech%' ORDER BY `cod_prof`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.*,c.lib_cls FROM `profession` as p, `classe` as c  WHERE p.cod_cls=c.cod_cls AND p.id_user=$id_user AND lib_prof LIKE '%$rech%' ORDER BY `cod_prof` LIMIT $part ,5");
$rqt->execute();	
	
}else{

//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT p.*,c.lib_cls FROM `profession` as p, `classe` as c  WHERE p.cod_cls=c.cod_cls AND p.id_user=$id_user ORDER BY p.`cod_prof`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.*,c.lib_cls FROM `profession` as p, `classe` as c  WHERE p.cod_cls=c.cod_cls AND p.id_user=$id_user ORDER BY p.`cod_prof` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Professions</a></div>
  </div>
  <div class="widget-box">
         
            <ul class="quick-actions">
			<li class="bg_lo"> <a href=""> <i class="icon-home"></i>Acceuil </a> </li>
            <li class="bg_lg"> <a onClick="form('aprofession.php')"> <i class="icon-tasks"></i>Nouvelle-Profession</a></li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Profession</h5>
		   <div><input type="text" id="rprof" onchange="frechprof()" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Profession</th>
				  <th>Classe</th>
				  <th>Taches</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_prof']; ?></td>
                  <td><?php  echo $row_res['lib_prof']; ?></td>
				  <td><?php  echo $row_res['lib_cls']; ?></td>
				  <td>
				  <a onClick="mprofession('<?php echo $row_res['cod_prof']; ?>')" title="Modifier"><img  src="img/icons/modi.png"/></a>
				  <a onClick="dprofession('<?php echo $row_res['cod_prof']; ?>')" title="Supprimer"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Professions</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpagepr('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpagepr('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpagepr('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpagepr('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function frechprof(){
		var rech=document.getElementById("rprof").value;
        $("#content").load('code/professions.php?rech='+rech);
	}
	function fpagepr(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('code/professions.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}
function dprofession(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Supprimer cette Profession ?");
if (ok){
 xhr.open("GET", "php/delete/dprofession.php?code="+cod, false);
 xhr.send(null);  
 alert("Profession Supprimee !");    
}
Menu2('param','professions.php');
	}	
function mprofession(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Modifier cette profession ?");
if (ok){
 xhr.open("GET", "php/modif/fmprofession.php?code="+cod, false);
$("#content").load('php/modif/fmprofession.php?code='+cod);    
}
	}		
</script>		