<?php session_start();
require_once("../../../../data/conn7.php");
$token1 = generer_token('stat');
if ($_SESSION['loginsal']){
}
else {
header("Location:index.html");
}
$code="";
$rqt=$bdd->prepare("select cod_pol  from  `policew` WHERE  `sel`='1' ");
$rqt->execute();
while($row_res=$rqt->fetch()){
$code=$row_res['cod_pol'];
}
$rqtc=$bdd->prepare("UPDATE `policew` SET `sel`='0' WHERE 1");
$rqtc->execute();

//on recupere les infos du contrat
$date1="";$date2="";$produit="";$nomsous="";$pnomsous="";
$rqtr=$bdd->prepare("select p.ndat_eff,p.ndat_ech, s.nom_sous,s.pnom_sous, r.lib_prod  from  `policew` as p,`souscripteurw` as s,`produit` as r WHERE p.cod_sous=s.cod_sous AND p.cod_prod=r.cod_prod AND p.`cod_pol`='$code' ");
$rqtr->execute();
while($row_res=$rqtr->fetch()){
$date1=$row_res['ndat_eff'];
$date2=$row_res['ndat_ech'];
$nomsous=$row_res['nom_sous'];
$pnomsous=$row_res['pnom_sous'];
$produit=$row_res['lib_prod'];
}
?>

  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Sinistre</a><a>Declaration</a><a>Filtre-Recherche-Contrat</a><a>Resultat-Recherche</a><a class="current">Declaration-Sinistre</a></div>
  </div>     
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
     
        <div class="widget-content nopadding">
          <form class="form-horizontal">
			<div class="control-group"> 
			<label class="control-label">Produits:</label>
              <div class="controls">
			 <input type="text" class="span3" placeholder="<?php echo $produit; ?>" disabled="disabled"/>
				</div>
				<label class="control-label">Date-Contrat:</label>
				<div class="controls">
                <input type="text"  class="span6" placeholder="<?php echo date("d/m/Y",strtotime($date1)); ?>" disabled="disabled"/>
                <input type="text"  class="span6" placeholder="<?php echo date("d/m/Y",strtotime($date2)); ?>" disabled="disabled"/>
                 </div>
				 <label class="control-label">Souscripteur:</label>
				<div class="controls">
                <input type="text"  class="span12" placeholder="<?php echo $nomsous." / ".$pnomsous; ?>" disabled="disabled"/>
                 </div>
				</div>
				<label class="control-label">Date-Sinistre:</label>
				<div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="datesin" placeholder="Survenu le 01/01/2000 (*)"/>
              </div>
			  </div>	
			<label class="control-label">Description du Sinistre:</label>
				<div class="controls">
				  <input type="text" id="comsin" class="span12" placeholder="Description du sinistre ........ " />
              </div>
			  </div>	
          </form>
        </div>
      </div>
	 </div>
  <div class="form-actions" align="right">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input  type="button" class="btn btn-success" onClick="insertsin('<?php echo $code; ?>','<?php echo $date1; ?>','<?php echo $date2; ?>')" value="Enregistrer" />
                        <input  type="button" class="btn btn-danger"  onClick="Menu1('msin','sinistre/sinistre1.php')" value="Annuler" />
                        </div>
 
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function insertsin(code,date1,date2){
var comm=document.getElementById("comsin").value;
var datesin=dfrtoen(document.getElementById("datesin").value);
if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }	 
if(verifdate1(document.getElementById("datesin"))){

   var aa=new Date(date1);
   var bb=new Date(date2);
   var cc=new Date(datesin);  
   var sec1=aa.getTime();
   var sec2=cc.getTime(); 
   var sec3=bb.getTime();
   
   if(sec1<=sec2 && sec2<=sec3){
      xhr.open("GET", "produit/sinistre/isinistre.php?code="+code+"&comm="+comm+"&datesin="+datesin, false);
      xhr.send(null);  
	  alert("Sinistre Enregistre !!");
      $("#content").load("produit/sinistre/lsinistre1.php");
   }else{alert("Sinistre Non-Supporte par la police !");}

}



}

</script>