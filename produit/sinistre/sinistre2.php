<?php 
session_start();
require_once("../../../../data/conn7.php");
//Recuperation de la page demandee 
$id_user = $_SESSION['id_usersal'];
$produit="";$nom="";$prenom="";$d1="";
if ( isset($_REQUEST['produit']) or isset($_REQUEST['nom']) or isset($_REQUEST['prenom']) or isset($_REQUEST['d1']) or isset($_REQUEST['filtre']) or isset($_REQUEST['page']) ) {
    $produit = $_REQUEST['produit'];$nom=$_REQUEST['nom'];$prenom=$_REQUEST['prenom'];$d1=$_REQUEST['d1'];$filtre=$_REQUEST['filtre'];$page=$_REQUEST['page'];
}
// Recherche Par Nom souscripteur
if($filtre==1) {	
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_pol`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='$produit' AND s.`id_user`='$id_user' AND s.`nom_sous` LIKE '%$nom%' ORDER BY d.`cod_pol` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_pol`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='$produit' AND s.`id_user`='$id_user' AND s.`nom_sous` LIKE '%$nom%' ORDER BY d.`cod_pol` DESC LIMIT $part ,7");
$rqt->execute();	
}
// Recherche Par Prenom Souscripteur
if($filtre==2) {	
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_pol`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='$produit' AND s.`id_user`='$id_user' AND s.`pnom_sous` LIKE '%$prenom%' ORDER BY d.`cod_pol` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_pol`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='$produit' AND s.`id_user`='$id_user' AND s.`pnom_sous` LIKE '%$prenom%' ORDER BY d.`cod_pol` DESC LIMIT $part ,7");
$rqt->execute();	
}
// Recherche Par Date d'effet
if($filtre==3) {	
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_pol`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='$produit' AND s.`id_user`='$id_user' AND d.`ndat_eff`='$d1' ORDER BY d.`cod_pol` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_pol`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='$produit' AND s.`id_user`='$id_user' AND d.`ndat_eff`='$d1' ORDER BY d.`cod_pol` DESC LIMIT $part ,7");
$rqt->execute();	
}

// Recherche Par Nom et Prenom Souscripteur
if($filtre==4) {	
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT d.`cod_pol`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='$produit' AND s.`id_user`='$id_user' AND s.`nom_sous` LIKE '%$nom%' AND s.`pnom_sous` LIKE '%$prenom%' ORDER BY d.`cod_pol` DESC");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
//Pointeur de page
$part=$page*7;
//requete à suivre
$rqt=$bdd->prepare("SELECT d.`cod_pol`,d.`ndat_eff`,d.`ndat_ech`,d.`pn`,d.`pt`,d.`etat`,s.`nom_sous`,s.`pnom_sous` FROM `policew` as d,`souscripteurw` as s WHERE s.`cod_sous`=d.`cod_sous` AND d.`cod_prod`='$produit' AND s.`id_user`='$id_user' AND s.`nom_sous` LIKE '%$nom%' AND s.`pnom_sous` LIKE '%$prenom%' ORDER BY d.`cod_pol` DESC LIMIT $part ,7");
$rqt->execute();	
}
?>  
  
   <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Sinistre</a><a>Declaration</a><a>Filtre-Recherche-Contrat</a><a class="current">Resultat-Recherche</a></div>
  </div>
   <div class="widget-box">
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
				  <th></th>
                  <th>Nom/Prenom</th>
				  <th>D-Effet</th>
                  <th>D-Echeance</th>
				  <th>P-Nette</th>
				  <th>P-Totale</th>
				  <th>Selection</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_res=$rqt->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
			     <?php if($row_res['etat']==0){ ?>
			      <td><a title="Police-Valide"><img  src="img/icons/icon_2.png"/></a></td>
				  <?php }
				  if($row_res['etat']==2){
				  ?>
				  <td><a title="Police-Ristournee"><img  src="img/icons/icon_4.png"/></a></td>
				  <?php }
				  if($row_res['etat']==3){
				  ?>
				  <td><a title="Police-Annulee"><img  src="img/icons/icon_1.png"/></a></td>
				  <?php } ?>			  
                  <td><?php  echo $row_res['nom_sous']."  ".$row_res['pnom_sous']; ?></td>
				  <td><?php  echo date("d/m/Y",strtotime($row_res['ndat_eff'])); ?></td>
                  <td><?php  echo date("d/m/Y",strtotime($row_res['ndat_ech'])); ?></td>
				  <td><?php  echo number_format($row_res['pn'], 2, ',', ' ')." DZD"; ?></td>
				  <td><?php  echo number_format($row_res['pt'], 2, ',', ' ')." DZD"; ?></td>
				  <td> <a href="javascript:;" title="Selectionner">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="<?php  echo $row_res['cod_pol']; ?>" value="<?php  echo $row_res['cod_pol']; ?>" onClick="cheksel('<?php  echo $row_res['cod_pol']; ?>')"/></a>
				  </td>
                </tr>
			<?php } ?>
              </tbody>
            </table>
          </div>
		  <div class="widget-title" align="center">
            <h5>Visualisation-Resultat-Recherche</h5>
		     <a href="javascript:;" title="Premiere page" onClick="fpagesin('0','<?php echo $nbpage; ?>','<?php echo $produit; ?>','<?php echo $nom; ?>','<?php echo $prenom; ?>','<?php echo $d1; ?>','<?php echo $filtre; ?>')"><img  src="img/icons/fprec.png"/></a>
			 <a href="javascript:;" title="Precedent" onClick="fpagesin('<?php echo $page-1; ?>','<?php echo $nbpage; ?>','<?php echo $produit; ?>','<?php echo $nom; ?>','<?php echo $prenom; ?>','<?php echo $d1; ?>','<?php echo $filtre; ?>')"><img  src="img/icons/prec.png"/></a>
				  <?php echo $page; ?>/<?php echo $nbpage; ?>
			 <a href="javascript:;" title="Suivant" onClick="fpagesin('<?php echo $page+1; ?>','<?php echo $nbpage; ?>','<?php echo $produit; ?>','<?php echo $nom; ?>','<?php echo $prenom; ?>','<?php echo $d1; ?>','<?php echo $filtre; ?>')"><img  src="img/icons/suiv.png"/></a>
			 <a href="javascript:;" title="Derniere page" onClick="fpagesin('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>','<?php echo $produit; ?>','<?php echo $nom; ?>','<?php echo $prenom; ?>','<?php echo $d1; ?>','<?php echo $filtre; ?>')"><img  src="img/icons/fsuiv.png"/></a>
          </div>
        </div>	
		<div class="form-actions" align="right">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input  type="button" class="btn btn-success" onClick="declare()" value="Suivant" />
                        <input  type="button" class="btn btn-danger"  onClick="Menu1('msin','sinistre/sinistre1.php')" value="Annuler" />
                        </div>
			
<script language="JavaScript">
	function fpagesin(page,nbpage,produit,nom,prenom,d1,code){
		if(page >=0){
			if(page == nbpage){
				alert("Vous ete a la derniere page!");
			}else{$("#content").load("produit/sinistre/sinistre2.php?produit="+produit+"&nom="+nom+"&prenom="+prenom+"&d1="+d1+"&filtre="+code+"&page="+page);}
			
		}else{alert("Vous ete en premiere page !");}
	}	
// Fonction de Selection
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
	  xhr.open("GET", "php/police/selpol.php?code="+cod, false);
      xhr.send(null);
      // alert("pays selectione"+cod);  
	  //alert(xhr.responseText);
	  }else{ // on on decoche
	  xhr.open("GET", "php/police/dselpol.php?code="+cod, false);
      xhr.send(null);
	  
	  };
	}	
function declare(){
if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
      xhr.open("GET", "php/police/selverif.php", false);
      xhr.send(null);  
	  var i=xhr.responseText;	
	  if(i==0){ 
	       alert("Aucun contrat selectionne !");
	       }else{
	   if (i==1){	   
	    //on traite
		//alert("On traite!!");
		$("#content").load("produit/sinistre/sinistre3.php?produit=");
  
		   
	   }else{alert("Veuillez corriger votre selection!");}
	 
	 }
	 
}
	
</script>		