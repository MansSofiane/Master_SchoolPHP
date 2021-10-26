<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user=$_SESSION['id_usersal'];
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouvelle-Classe</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Classe</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Classe *:</label>
              <div class="controls">
                <input type="text" id="libcls" class="span7" placeholder="Lib ..." />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Taux-Classe *:</label>
              <div class="controls">
               <input type="text" id="txcls" class="span7" placeholder="0" />
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="inscls('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','classes.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function inscls(user){
var libcls=document.getElementById("libcls").value;
var txcls=document.getElementById("txcls").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libcls && txcls && user){ 
	if(isNaN(txcls) != true ){
	
	 xhr.open("GET", "php/insert/nclasse.php?libcls="+libcls+"&txcls="+txcls+"&user="+user, false);
     xhr.send(null);
	// alert(xhr.responseText);
	 alert("Classe Introduite !");
	 Menu2('param','classes.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Taux doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>		