<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouveau-Capital</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Capital</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Capital *:</label>
              <div class="controls">
                <input type="text" id="libcap" class="span7" placeholder="Lib ..." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Montant-Capital *:</label>
              <div class="controls">
                <input type="text" id="mttcap" class="span7" placeholder="0" />
              </div>
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="inscap('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','capitals.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function inscap(user){
var libcap=document.getElementById("libcap").value;
var mttcap=document.getElementById("mttcap").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libcap && mttcap){ 
	if(isNaN(mttcap) != true ){
	
	 xhr.open("GET", "php/insert/ncapital.php?libcap="+libcap+"&mttcap="+mttcap+"&user="+user, false);
     xhr.send(null);
	//alert(xhr.responseText);
	 alert("Capital Introduit !");
	 Menu2('param','capitals.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Plafond doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	