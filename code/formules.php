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
$rqtc=$bdd->prepare("SELECT * FROM `formule`  WHERE id_user=$id_user AND lib_formul LIKE '%$rech%' ORDER BY `cod_formul`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `formule`  WHERE id_user=$id_user AND lib_formul LIKE '%$rech%' ORDER BY `cod_formul` LIMIT $part ,5");
$rqt->execute();	
	
}else{


//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT * FROM `formule`  WHERE id_user=$id_user ORDER BY `cod_formul`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `formule`  WHERE id_user=$id_user ORDER BY `cod_formul` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Formules</a></div>
  </div>
  <div class="widget-box">
         
            <ul class="quick-actions">
              <li class="bg_lo"> <a href=""> <i class="icon-home"></i>Acceuil </a> </li>
              <li class="bg_lg"> <a onClick="form('aformule.php')"> <i class="icon-tasks"></i>Nouvelle-Formule</a> </li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Formule</h5>
		   <div><input type="text" id="rform" onchange="frechform()" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Libelle</th>
				  <th>Min-Assures</th>
				  <th>Max-Assures</th>
				  <th>Taches</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_formul']; ?></td>
                  <td><?php  echo $row_res['lib_formul']; ?></td>
				  <td><?php  echo $row_res['minnb_assu']; ?></td>
				  <td><?php  echo $row_res['maxnb_assu']; ?></td>
				  <td>
				  <a onClick="mformule('<?php echo $row_res['cod_formul']; ?>')" title="Informations"><img  src="img/icons/modi.png"/></a>
				  <a onClick="dformule('<?php echo $row_res['cod_formul']; ?>')" title="Informations"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Formules</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpagef('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpagef('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpagef('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpagef('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function frechform(){
		var rech=document.getElementById("rform").value;
        $("#content").load('code/formules.php?rech='+rech);
	}
	function fpagef(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('code/formules.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}
function cheksel(cod){
     var C1=document.getElementById(cod);
	  if (C1.checked){ alert(C1.value)}else{alert("NON");};
	}	
function dformule(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Supprimer cette Formule ?");
if (ok){
 xhr.open("GET", "php/delete/dformule.php?code="+cod, false);
 xhr.send(null);  
 alert("Formule Supprimee !");    
}
Menu2('param','formules.php');
	}	
function mformule(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Modifier cette garantie ?");
if (ok){
 xhr.open("GET", "php/modif/fmformule.php?code="+cod, false);
$("#content").load('php/modif/fmformule.php?code='+cod);    
}
	}			
</script>		