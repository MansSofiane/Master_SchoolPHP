<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user=$_SESSION['id_usersal'];
if ( isset($_REQUEST['code'])){
$code = $_REQUEST['code'];
$rqtc=$bdd->prepare("SELECT * FROM `cpolice` WHERE `cod_cpl`='$code'");
$rqtc->execute();
while ($row_res=$rqtc->fetch()){
$libcp=$row_res['lib_cpl'];
$mttcp=$row_res['mtt_cpl'];
}

}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Modification-Accesoire</a></div>
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
                <input type="text" id="mlibacc" class="span7" value="<?php echo $libcp; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Cout-Accesoire *:</label>
              <div class="controls">
                <input type="text" id="mcouacc" class="span7" value="<?php echo $mttcp; ?>" />
              </div>
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="minsacc('<?php echo $code; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','cpolices.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function minsacc(code){
var libacc=document.getElementById("mlibacc").value;
var couacc=document.getElementById("mcouacc").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libacc && couacc){ 
	if(isNaN(couacc) != true ){
	
	 xhr.open("GET", "php/modif/mcpolice.php?libacc="+libacc+"&couacc="+couacc+"&code="+code, false);
     xhr.send(null);
	//alert(xhr.responseText);
	 alert("Accessoire Modifie !");
	 Menu2('param','cpolices.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Cout accessoire doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	