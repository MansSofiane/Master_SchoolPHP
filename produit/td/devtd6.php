<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$toktd3 = generer_token('devtd3');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if ( isset($_REQUEST['sous']) ){$codsous= $_REQUEST['sous'];}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a>Temporaire-Au-Deces</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a class="current">Beneficiaires</a><a>Capital</a><a>Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
			 <div class="control-group">
              <div class="controls">
                 <input type="text" id="nomb1" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="pnomb1" class="span4" placeholder="Prenom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="prb1" class="span4" placeholder="quote part % (*)" />
              </div>
            </div>
			
			<div class="control-group">
              <div class="controls">
                 <input type="text" id="nomb2" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="pnomb2" class="span4" placeholder="Prenom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="prb2" class="span4" placeholder="quote part % (*)" />
              </div>
            </div>
			
			<div class="control-group">
              <div class="controls">
                 <input type="text" id="nomb3" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="pnomb3" class="span4" placeholder="Prenom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="prb3" class="span4" placeholder="quote part % (*)" />
              </div>
            </div>
			
			<div class="control-group">
              <div class="controls">
                 <input type="text" id="nomb4" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="pnomb4" class="span4" placeholder="Prenom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="prb4" class="span4" placeholder="quote part % (*)" />
              </div>
            </div>
			
			<div class="control-group">
              <div class="controls">
                 <input type="text" id="nomb5" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="pnomb5" class="span4" placeholder="Prenom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="prb5" class="span4" placeholder="quote part % (*)" />
              </div>
            </div>
			
			<div class="control-group">
              <div class="controls">
                 <input type="text" id="nomb6" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="pnomb6" class="span4" placeholder="Prenom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="prb6" class="span4" placeholder="quote part % (*)" />
              </div>
            </div>
					
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="capitaltd3('<?php echo $codsous; ?>','<?php echo $toktd3; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asstd.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function vbenef(){
var nom=null,prenom=null,reponse=false;
var somme=0,part=0;
	
	for (var iter = 1; iter <= 6; iter++) {
	 nom = document.getElementById("nomb"+iter).value;
	 prenom = document.getElementById("pnomb"+iter).value;
	 part = document.getElementById("prb"+iter).value;
	if(nom && prenom && isNaN(part) != true && part <= 100){
	//sum=sum+part;
	//alert("la quote part est de: "+part);
	somme=parseFloat(somme)+parseFloat(part);
	}
	 //fin de la boucle pour
	 }
	if(somme==100){reponse=true;}else{alert("le cumule des quotes-part doit etre de  100 %, aucun beneficiaire introduit !");} 
return reponse;	
	}
function insbenef(codsous){
var nom=null,prenom=null,part=null;
var reponse=false;
reponse=vbenef();

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	
	for (var iter = 1; iter <= 6; iter++) {
	 nom = document.getElementById("nomb"+iter).value;
	 prenom = document.getElementById("pnomb"+iter).value;
	 part = document.getElementById("prb"+iter).value;
	 
	if(nom && prenom && isNaN(part) != true && part <= 100 && reponse){
	//alert("insertion du "+nom+"-"+prenom+"-"+part);
	xhr.open("GET", "produit/td/nbenef.php?nom="+nom+"&pnom="+prenom+"&part="+part+"&sous="+codsous, false);
	xhr.send(null);
    // alert(xhr.responseText);
	
	}
	 //fin de la boucle pour
	 }
	}	
function capitaltd3(codsous,tok){

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	insbenef(codsous);
	$("#content").load("produit/td/devtd3.php?sous="+codsous+"&tok="+tok);
	
	}	
			
</script>	