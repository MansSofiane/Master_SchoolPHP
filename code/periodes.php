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
$rqtc=$bdd->prepare("SELECT p.*,o.lib_opt FROM `periode` as p, `option` as o WHERE p.cod_opt=o.cod_opt and p.id_user=$id_user AND lib_per LIKE '%$rech%' ORDER BY `cod_per`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.*,o.lib_opt FROM `periode` as p, `option` as o WHERE p.cod_opt=o.cod_opt and p.id_user=$id_user AND lib_per LIKE '%$rech%' ORDER BY `cod_per` LIMIT $part ,5");
$rqt->execute();	
	
}else{


//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT p.*,o.lib_opt FROM `periode` as p, `option` as o WHERE p.cod_opt=o.cod_opt and p.id_user=$id_user ORDER BY `cod_per`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.*,o.lib_opt FROM `periode` as p, `option` as o WHERE p.cod_opt=o.cod_opt and p.id_user=$id_user ORDER BY `cod_per` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Periodes</a></div>
  </div>
  <div class="widget-box">
         
            <ul class="quick-actions">
			  <li class="bg_lo"> <a href=""> <i class="icon-home"></i>Acceuil </a> </li>
              <li class="bg_lg"> <a onClick="form('aperiode.php')"> <i class="icon-tasks"></i>Nouvelle-Periode</a></li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Periodes</h5>
		   <div><input type="text" id="rper" onchange="frechper()" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Periode</th>
				  <th>Jours-Min</th>
				  <th>Jours-Max</th>
				  <th>Option</th>
				  <th>Taches</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_per']; ?></td>
                  <td><?php  echo $row_res['lib_per']; ?></td>
				  <td><?php  echo $row_res['min_jour']; ?></td>
				  <td><?php  echo $row_res['max_jour']; ?></td>
				  <td><?php  echo $row_res['lib_opt']; ?></td>
				  <td>
				  <a onClick="mperiode('<?php echo $row_res['cod_per']; ?>')" title="Modifier"><img  src="img/icons/modi.png"/></a>
				  <a onClick="dperiode('<?php echo $row_res['cod_per']; ?>')" title="Informations"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Periodes</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpageper('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpageper('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpageper('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpageper('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function frechper(){
		var rech=document.getElementById("rper").value;
        $("#content").load('code/periodes.php?rech='+rech);
	}
	function fpageper(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('code/periodes.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}
function cheksel(cod){
     var C1=document.getElementById(cod);
	  if (C1.checked){ alert(C1.value)}else{alert("NON");};
	}	
function dperiode(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Supprimer cette Periode ?");
if (ok){
 xhr.open("GET", "php/delete/dperiode.php?code="+cod, false);
 xhr.send(null);  
 alert("Periode Supprimee !");    
}
Menu2('param','periodes.php');
	}	
function mperiode(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Modifier cette periode ?");
if (ok){
 xhr.open("GET", "php/modif/fmperiode.php?code="+cod, false);
$("#content").load('php/modif/fmperiode.php?code='+cod);    
}
	}
</script>		