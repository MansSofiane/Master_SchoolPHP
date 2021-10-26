<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user=$_SESSION['id_usersal'];

?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouvelle-Garantie</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Garantie</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Garantie *:</label>
              <div class="controls">
                <input type="text" id="libgar" class="span6" placeholder="Lib ..." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Plafond-Garantie *:</label>
              <div class="controls">
                <input type="text" id="plfgar" class="span6" placeholder="Plaf .." />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Monnaie-Garantie *:</label>
              <div class="controls">
                <select id="mongar">
                  <option value="DZD">DZD</option>
                  <option value="EU">EU</option>
                </select>
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="insgar('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','garanties.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function insgar(user){
var lib=document.getElementById("libgar").value;
var plafond=document.getElementById("plfgar").value;
var monnaie=document.getElementById("mongar").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(lib && plafond && monnaie && user){ 
	if(isNaN(plafond) != true ){
	
	 xhr.open("GET", "php/insert/ngarantie.php?lib="+lib+"&plafond="+plafond+"&monnaie="+monnaie+"&user="+user, false);
     xhr.send(null);
	 //alert(xhr.responseText);
	 alert("Garantie Introduite !");
	 Menu2('param','garanties.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Plafond doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>		