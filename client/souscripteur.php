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
$rqtc=$bdd->prepare("SELECT * FROM `garantie`  WHERE id_user=$id_user AND lib_gar LIKE '%$rech%' ORDER BY `cod_gar`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `garantie`  WHERE id_user=$id_user AND lib_gar LIKE '%$rech%' ORDER BY `cod_gar` LIMIT $part ,5");
$rqt->execute();	
	
}else{

//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT * FROM `garantie`  WHERE id_user=$id_user ORDER BY `cod_gar`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `garantie`  WHERE id_user=$id_user ORDER BY `cod_gar` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Clients</a><a class="current">Souscripteurs</a></div>
  </div>
  <div class="widget-box">
         
            <ul class="quick-actions">
			   <li class="bg_lo"> <a href=""> <i class="icon-home"></i>Acceuil </a> </li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Nom</h5>
		   <div><input type="text" id="rgar" onchange="frechgar()" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Libelle</th>
				  <th>Plafond</th>
				  <th>Monaie</th>
				  <th>Taches</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_gar']; ?></td>
                  <td><?php  echo $row_res['lib_gar']; ?></td>
				  <td><?php  echo $row_res['plafond_gar']; ?></td>
				  <td><?php  echo $row_res['monais_gar']; ?></td>
				  <td>
				  <a onClick="mgarantie('<?php echo $row_res['cod_gar']; ?>')" title="Informations"><img  src="img/icons/modi.png"/></a>
				  <a onClick="dgarantie('<?php echo $row_res['cod_gar']; ?>')" title="Informations"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Souscripteurs</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpageg('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpageg('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpageg('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpageg('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function frechgar(){
		var rech=document.getElementById("rgar").value;
        $("#content").load('code/garanties.php?rech='+rech);
	}
	function fpageg(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('code/garanties.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}
function cheksel(cod){
     var C1=document.getElementById(cod);
	  if (C1.checked){ alert(C1.value)}else{alert("NON");};
	}	
function dgarantie(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Supprimer cette garantie ?");
if (ok){
 xhr.open("GET", "php/delete/dgarantie.php?code="+cod, false);
 xhr.send(null);  
 alert("Garantie Supprimee !");    
}
Menu2('param','garanties.php');
	}	
function mgarantie(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Modifier cette garantie ?");
if (ok){
 xhr.open("GET", "php/modif/fmgarantie.php?code="+cod, false);
$("#content").load('php/modif/fmgarantie.php?code='+cod);    
}
	}		
</script>		