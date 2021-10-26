<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouveau-D-Timbre</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-D-Timbre</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-D-Timbre *:</label>
              <div class="controls">
                <input type="text" id="libdtmb" class="span7" placeholder="Lib ..." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Cout *:</label>
              <div class="controls">
                <input type="text" id="coudtmb" class="span7" placeholder="..." />
              </div>
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="insdtmb('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','dtimbres.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function insdtmb(user){
var libdtmb=document.getElementById("libdtmb").value;
var coudtmb=document.getElementById("coudtmb").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libdtmb && coudtmb){ 
	if(isNaN(coudtmb) != true ){
	
	 xhr.open("GET", "php/insert/ndtimbre.php?libdtmb="+libdtmb+"&coudtmb="+coudtmb+"&user="+user, false);
     xhr.send(null);
	//alert(xhr.responseText);
	 alert("Droit de Timbre Introduit !");
	 Menu2('param','dtimbres.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Cout doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	