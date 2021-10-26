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
$rqtc=$bdd->prepare("SELECT * FROM `classe`  WHERE id_user=$id_user AND lib_cls LIKE '%$rech%' ORDER BY `cod_cls`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `classe`  WHERE id_user=$id_user AND lib_cls LIKE '%$rech%' ORDER BY `cod_cls` LIMIT $part ,5");
$rqt->execute();	
	
}else{


//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT * FROM `classe`  WHERE id_user=$id_user ORDER BY `cod_cls`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `classe`  WHERE id_user=$id_user ORDER BY `cod_cls` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Classes</a></div>
  </div>
  <div class="widget-box">
         
            <ul class="quick-actions">
			<li class="bg_lo"> <a href=""> <i class="icon-home"></i>Acceuil </a> </li>
              <li class="bg_lg"> <a onClick="form('aclasse.php')"> <i class="icon-tasks"></i>Nouvelle-Classe</a></li>
            </ul>
  </div>
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Classe</h5>
		   <div><input type="text" id="rclass" onchange="frechclass()" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Classe</th>
				  <th>Taux</th>
				  <th>Taches</th>
                </tr>
              </thead>
              <tbody>    
			<?php while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
                  <td><?php  echo $row_res['cod_cls']; ?></td>
                  <td><?php  echo $row_res['lib_cls']; ?></td>
				  <td><?php  echo $row_res['taux_cls']; ?></td>
				  <td>
				  <a onClick="mclasse('<?php echo $row_res['cod_cls']; ?>')" title="Modifier"><img  src="img/icons/modi.png"/></a>
				  <a onClick="dclasse('<?php echo $row_res['cod_cls']; ?>')" title="Supprimer"><i CLASS="icon-trash icon-2x" style="color:red"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Classes</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpagecl('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpagecl('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpagecl('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpagecl('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>		
<script language="JavaScript">
	function frechclass(){
		var rech=document.getElementById("rclass").value;
        $("#content").load('code/classes.php?rech='+rech);
	}
	function fpagecl(page,nbpage){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('code/classes.php?page='+page);}
		}else{alert("Vous ete en premiere page !");}
	}
function dclasse(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Supprimer cette Classe ?");
if (ok){
 xhr.open("GET", "php/delete/dclasse.php?code="+cod, false);
 xhr.send(null);  
 alert("Classe Supprimee !");    
}
Menu2('param','classes.php');
	}		
function mclasse(cod){
    if (window.XMLHttpRequest) { 
      xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("vous etes sur de Modifier cette garantie ?");
if (ok){
 xhr.open("GET", "php/modif/fmclasse.php?code="+cod, false);
$("#content").load('php/modif/fmclasse.php?code='+cod);    
}
	}		
</script>		