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
$rqtc=$bdd->prepare("SELECT * FROM `dtimbre` WHERE `cod_dt`='$code'");
$rqtc->execute();
while ($row_res=$rqtc->fetch()){
$libdt=$row_res['lib_dt'];
$mttdt=$row_res['mtt_dt'];
}

}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Modification-D-Timbre</a></div>
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
                <input type="text" id="mlibdtmb" class="span7" value="<?php echo $libdt; ?>" />
              </div>
            </div>
            <div class="control-group" >
              <label class="control-label">Cout*:</label>
              <div class="controls">
                <input type="text" id="mcoudtmb" class="span7" value="<?php echo $mttdt; ?>" />
              </div>
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="minsdtmb('<?php echo $code; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','dtimbres.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function minsdtmb(code){
var libdtmb=document.getElementById("mlibdtmb").value;
var coudtmb=document.getElementById("mcoudtmb").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libdtmb && coudtmb){ 
	if(isNaN(coudtmb) != true ){
	
	 xhr.open("GET", "php/modif/mdtimbre.php?libdtmb="+libdtmb+"&coudtmb="+coudtmb+"&code="+code, false);
     xhr.send(null);
	//alert(xhr.responseText);
	 alert("Droit de Timbre Modifie !");
	 Menu2('param','dtimbres.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Cout doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	