<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user=$_SESSION['id_usersal'];
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouvelle-Formule</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Formule</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Formule *:</label>
              <div class="controls">
                <input type="text" id="libfrm" class="span7" placeholder="Lib ..." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Min-Nbr-Assure *:</label>
              <div class="controls">
                <input type="text" id="minfrm" class="span7" placeholder="0" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Max-Nbr-Assure *:</label>
              <div class="controls">
               <input type="text" id="maxfrm" class="span7" placeholder="0" />
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="insfrm('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','formules.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function insfrm(user){
var libfrm=document.getElementById("libfrm").value;
var minfrm=document.getElementById("minfrm").value;
var maxfrm=document.getElementById("maxfrm").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libfrm && minfrm && maxfrm){ 
	if(isNaN(minfrm) != true && isNaN(maxfrm) != true){
	if(minfrm<=maxfrm){
	
	 xhr.open("GET", "php/insert/nformule.php?libfrm="+libfrm+"&minfrm="+minfrm+"&maxfrm="+maxfrm+"&user="+user, false);
     xhr.send(null);
	 alert(xhr.responseText);
	 alert("Formule Introduite !");
	 Menu2('param','formules.php');
	 }else{alert("Nombre assues minimum doit etre infrieur au nombre assues maximum !");}
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("les champs Nombres assure doivent etre des chiffres !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	