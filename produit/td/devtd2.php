<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
$toktd2 = generer_token('devtd2');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
}
else {
header("Location:login.php");
}
// recupération du code du dernier souscripteur de l'agence	
$rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$id_user'");
$rqtms->execute();
$codsous=0;
while ($row_res=$rqtms->fetch()){ 
$codsous=$row_res['maxsous']; 
}	
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Temporaire-Au-Deces</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Assure</a><a>Beneficiaires</a><a>Capital</a><a>Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
              <div class="control-group">
              <div class="controls">
                 <select id="civa">
				<option value="">--  Civilite(*)</option>
				<option value="1">--  Mr</option>
				<option value="2">--  Mme</option>
				<option value="3">--  Mlle</option>
                </select>
              </div>
			 <div class="control-group">
              <div class="controls">
                <input type="text" id="nassu" class="span4" placeholder="Nom assure (*)"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="passu" class="span4" placeholder="Prenom Assure (*)" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
                <input type="text" id="adrassu" class="span6" placeholder="Adresse assure (*)" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="dnaisassu" placeholder="D-Naissance JJ/MM/AAAA (*)"/> 
              </div>
			  </div>	
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="capitaltd2('<?php echo $codsous; ?>','<?php echo $toktd2; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asstd.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instarassu(tok){
var user= "<?php echo $id_user; ?>";
var codsous= "<?php echo $codsous; ?>";
var civilitea=document.getElementById("civa").value;
var noma=document.getElementById("nassu").value;
var prenoma=document.getElementById("passu").value;
var adra=document.getElementById("adrassu").value;
var datnaisa=document.getElementById("dnaisassu");
var agea=null,date2a=null;

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     } 
	 if(civilitea && noma && prenoma && adra ){ 	
	 if(verifdate1(datnaisa)){
	    agea=calage(datnaisa);
		date2a=dfrtoen(datnaisa.value);
		xhr.open("GET", "produit/td/nassu.php?civilitea="+civilitea+"&noma="+noma+"&prenoma="+prenoma+"&adra="+adra+"&datnaisa="+date2a+"&agea="+agea+"&sous="+codsous+"&user="+user+"&tok="+tok, false);
       xhr.send(null); 
	   }
	
	}else{alert("Veuillez remplir tous les champs Obligatoire (*) !");}
	
	}	
function capitaltd2(codsous,tok){

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	instarassu(tok);
	$("#content").load("produit/td/devtd6.php?sous="+codsous+"&tok="+tok);
	
	}			
</script>	