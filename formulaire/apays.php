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
$id_user = $_SESSION['id_usersal'];
if (isset($_REQUEST['rech'])) {
	$rech = $_REQUEST['rech'];
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT * FROM `pays`  WHERE lib_pays LIKE '%$rech%' ORDER BY `cod_pays`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `pays`  WHERE lib_pays LIKE '%$rech%' ORDER BY `cod_pays` LIMIT $part ,5");
$rqt->execute();	
	
}else{
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT * FROM `pays`  WHERE 1 ORDER BY `cod_pays`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT * FROM `pays`  WHERE 1 ORDER BY `cod_pays` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-tasks"></i> Pays</a></div>
  </div>
  <div class="widget-box">
         
            <ul class="quick-actions">
              <li class="bg_lo"> <a href=""> <i class="icon-home"></i>Acceuil </a> </li>
			  <li class="bg_ls"> <a onClick="Menu2('param','zones.php')"> <i class="icon-tasks"></i>Zones </a> </li>
			  <li class="bg_ls"> <a onClick="affectation('<?php echo $code;?>')"> <i class="icon-tasks"></i>Affecter (Selection)</a> </li>
            </ul>
  </div>	
   <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
           <h5>Recherche Pays</h5>
		   <div><input type="text" id="rpayaff" onchange="frechpayaff('<?php echo $code ?>')" class="span3"/></div>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Code-Pays</th>
                  <th>Libelle-Pays</th>
				  <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="tchek" onClick="chekt()" title="Tout-Selectionner" /></th>
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
				  <a href="javascript:;" title="Selectionner">
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="<?php  echo $row_res['cod_pays']; ?>" value="<?php  echo $row_res['cod_pays']; ?>" onClick="cheksel('<?php  echo $row_res['cod_pays']; ?>')"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-pays</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpageap('0','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpageap('<?php echo $page-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpageap('<?php echo $page+1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpageap('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>	
<script language="JavaScript">
	function frechpayaff(code){
		var rech=document.getElementById("rpayaff").value;
        $("#content").load('formulaire/apays.php?rech='+rech+'&code='+code);
	}
	function fpageap(page,nbpage,code){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load('formulaire/apays.php?page='+page+'&code='+code);}
		}else{alert("Vous ete en premiere page !");}
	}
function cheksel(cod){
     var C1=document.getElementById(cod);
	 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	  if (C1.checked){ //on selection 
	  xhr.open("GET", "php/zone/selpays.php?code="+cod, false);
      xhr.send(null);
      // alert("pays selectione"+cod);  
	  //alert(xhr.responseText);
	  }else{ // on on decoche
	  xhr.open("GET", "php/zone/dselpays.php?code="+cod, false);
      xhr.send(null);
	  
	  };
	}	
function chekt(){
     var C2=document.getElementById('tchek');
	 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	  if (C2.checked){ //on selection 
	  xhr.open("GET", "php/zone/tselpays.php", false);
      xhr.send(null);
      // alert("pays selectione"+cod);  
	  //alert(xhr.responseText);
	  }else{ // on on decoche
	  xhr.open("GET", "php/zone/tdselpays.php", false);
      xhr.send(null);
	  
	  };
	}	
function affectation(code){
	 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 
	  xhr.open("GET", "php/zone/affpayszone.php?code="+code, false);
      xhr.send(null);
	  alert("selection affectee!");  
	  Menu2('param','zones.php');
	}		
</script>		