<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$tokade3 = generer_token('devade3');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if ( isset($_REQUEST['sous']) ){
    $codsous= $_REQUEST['sous'];
}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Deces-Emprunteur</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a class="current">Beneficiaire</a><a >Capital</a><a>Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <div class="controls">
               <input type="text" id="nbenef" class="span5" placeholder="Ogranisme-Preteur: (*)" />	
              </div>
			  <div class="control-group">
              <div class="controls">
               <input type="text" id="agbenef" class="span5" placeholder="Code-Agence de l'ogranisme-Preteur: (*)" />	
              </div>
			  <div class="control-group">
              <div class="controls">
               <input type="text" id="tbenef" class="span5" placeholder="Tel: 213XXXXXXXXX (*)" />
              </div>
			  <div class="control-group">
              <div class="controls">
               <input type="text" id="adrbenef" class="span7" placeholder="Adresse de l'ogranisme-Preteur: (*)" />	
              </div>			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instben('<?php echo $codsous; ?>','<?php echo $tokade3; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asscim.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div> 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instben(codsous,tok){
var nom=document.getElementById("nbenef").value;
var agence=document.getElementById("agbenef").value;
var tel=document.getElementById("tbenef").value;
var adr=document.getElementById("adrbenef").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	
	 
	 if(nom && agence && tel && adr){ 
		xhr.open("GET", "produit/ade/nbenef.php?nom="+nom+"&agence="+agence+"&tel="+tel+"&adr="+adr+"&sous="+codsous+"&tok="+tok, false);
       xhr.send(null); 
	   $("#content").load("produit/ade/devade3.php?sous="+codsous+"&tok="+tok);
	
	}else{alert("Veuillez remplir tous les champs (*) !");}
	
	
	
	
	}	
			
</script>	