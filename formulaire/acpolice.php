<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouvel-Accesoire</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Accesoire</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Accesoire *:</label>
              <div class="controls">
                <input type="text" id="libacc" class="span7" placeholder="Lib ..." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Cout-Accesoire *:</label>
              <div class="controls">
                <input type="text" id="couacc" class="span7" placeholder="..." />
              </div>
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="insacc('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','cpolices.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function insacc(user){
var libacc=document.getElementById("libacc").value;
var couacc=document.getElementById("couacc").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libacc && couacc){ 
	if(isNaN(couacc) != true ){
	
	 xhr.open("GET", "php/insert/ncpolice.php?libacc="+libacc+"&couacc="+couacc+"&user="+user, false);
     xhr.send(null);
	//alert(xhr.responseText);
	 alert("Accessoire Introduit !");
	 Menu2('param','cpolices.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Cout accessoire doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	