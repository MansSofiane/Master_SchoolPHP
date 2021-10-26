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
$rqtc=$bdd->prepare("SELECT * FROM `cpolice`  WHERE id_user=$id_user AND lib_cpl LIKE '%$rech%' ORDER BY `cod_cpl`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `cpolice`  WHERE id_user=$id_user AND lib_cpl LIKE '%$rech%' ORDER BY `cod_cpl` LIMIT $part ,5");
$rqt->execute();	
	
}else{

//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT * FROM `cpolice`  WHERE id_user=$id_user ORDER BY `cod_cpl`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `cpolice`  WHERE id_user=$id_user ORDER BY `cod_cpl` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Cout-Police / Accessoire</a></div>
  </div>
  <div class="widget-box">
         
            <ul class="quick-actions">
              <li class="bg_lo"> <a href=""> <i class="icon-home"></i>Acceuil </a> </li>
              <li class="bg_lg"> <a onClick="form('acpolice.php')"> <i class="icon-tasks"></i>Nouvel-Accessoire</a></li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Accessoire</h5>
		   <div><input type="text" id="racc" onchange="frechacc()" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Libelle</th>
				  <th>Montant</th>
				  <th>Taches</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_cpl']; ?></td>
                  <td><?php  echo $row_res['lib_cpl']; ?></td>
				  <td><?php  echo $row_res['mtt_cpl']; ?></td>
				  <td>
				  <a onClick="mcpolice('<?php echo $row_res['cod_cpl']; ?>')" title="Modifier"><img  src="img/icons/modi.png"/></a>
				  <a onClick="dcpolice('<?php echo $row_res['cod_cpl']; ?>')" title="Informations"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Accessoire</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpagecp('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpagecp('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpagecp('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpagecp('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function frechacc(){
		var rech=document.getElementById("racc").value;
        $("#content").load('code/cpolices.php?rech='+rech);
	}
	function fpagecp(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('code/cpolices.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}
function cheksel(cod){
     var C1=document.getElementById(cod);
	  if (C1.checked){ alert(C1.value)}else{alert("NON");};
	}	
function dcpolice(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Supprimer cet Accessoire ?");
if (ok){
 xhr.open("GET", "php/delete/dcpolice.php?code="+cod, false);
 xhr.send(null);  
 alert("Accessoire Supprimee !");    
}
Menu2('param','cpolices.php');
	}	
function mcpolice(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Modifier ce Cout police ?");
if (ok){
 xhr.open("GET", "php/modif/fmcpolice.php?code="+cod, false);
$("#content").load('php/modif/fmcpolice.php?code='+cod);    
}
	}			
</script>		