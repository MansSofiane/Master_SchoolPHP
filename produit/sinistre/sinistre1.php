<?php session_start();
require_once("../../../../data/conn7.php");
$token1 = generer_token('stat');
if ($_SESSION['loginsal']){
}
else {
header("Location:index.html");
}
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
?>

  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Sinistre</a><a>Declaration</a><a class="current">Filtre-Recherche-Contrat</a></div>
  </div>     
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
     
        <div class="widget-content nopadding">
          <form class="form-horizontal">
			<div class="control-group"> 
			<label class="control-label">Produits:</label>
              <div class="controls">
			  <select id="prd">
                  <option value="1">Assurance-Voyage</option>
                  <option value="2">Individuel-Accident</option>
				  <option value="6">Temporaire-Deces</option>
				  <option value="7">Emprunteur-Deces</option>
				  <option value="5">Concer-Sein</option>
                </select>
				</div>
				<label class="control-label">Filtre:</label>
				<div class="controls">
                <input type="text" id="sinsous" class="span6" placeholder="Nom Souscripteur" />
                </div>
			    <label class="control-label">Filtre:</label>
				<div class="controls">
                <input type="text" id="sinpsous" class="span6" placeholder="Prenom Souscripteur" />
                 </div>
				</div>
				<label class="control-label">Filtre:</label>
				<div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="date1" placeholder="D-effet le 01/01/2000 (*)"/>
              </div>
			  </div>	
			
          </form>
        </div>
      </div>
	 </div>
  
  <div class="widget-box">
         
            <ul class="quick-actions">
			  <li class="bg_lh"> <a onClick="prod('1')"> <i class="icon-info-sign"></i>Filtrer par Nom</a> </li>
			  <li class="bg_lb"> <a onClick="prod('2')"> <i class="icon-info-sign"></i>Filtrer par Prenom</a> </li>
			  <li class="bg_ly"> <a onClick="prod('3')"> <i class="icon-info-sign"></i>Filtrer par Date</a> </li>
			   <li class="bg_lo"> <a onClick="prod('4')"> <i class="icon-info-sign"></i>Filtrer par Nom  et Prenom</a> </li>
			</ul>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function prod(code){
var produit=document.getElementById("prd").value;
var nom=document.getElementById("sinsous").value;
var prenom=document.getElementById("sinpsous").value;
var date1=document.getElementById("date1");
var page=0;
if(code==3){ 
if(verifdate1(date1)){
var d1=dfrtoen(date1.value);
$("#content").load("produit/sinistre/sinistre2.php?produit="+produit+"&nom="+nom+"&prenom="+prenom+"&d1="+d1+"&filtre="+code+"&page="+page);
}


}else{
var d1=dfrtoen(date1.value);
$("#content").load("produit/sinistre/sinistre2.php?produit="+produit+"&nom="+nom+"&prenom="+prenom+"&d1="+d1+"&filtre="+code+"&page="+page);
}


}

</script>