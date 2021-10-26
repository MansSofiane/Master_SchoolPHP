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
$rqtc=$bdd->prepare("SELECT * FROM `garantie` WHERE `cod_gar`='$code'");
$rqtc->execute();
while ($row_res=$rqtc->fetch()){
$lib=$row_res['lib_gar'];
$plafond=$row_res['plafond_gar'];
}

}

?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Modification-Garantie</a></div>
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
                <input type="text" id="mlibgar" class="span6" placeholder="Lib ..." value="<?php echo $lib; ?>"  />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Plafond-Garantie *:</label>
              <div class="controls">
                <input type="text" id="mplfgar" class="span6" placeholder="Plaf .." value="<?php echo $plafond; ?>" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Monnaie-Garantie *:</label>
              <div class="controls">
                <select id="mmongar">
				<option value="">--</option>
                  <option value="DZD">DZD</option>
                  <option value="EU">EU</option>
                </select>
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="minsgar('<?php echo $code; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','garanties.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function minsgar(code){
var lib=document.getElementById("mlibgar").value;
var plafond=document.getElementById("mplfgar").value;
var monnaie=document.getElementById("mmongar").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(lib && plafond && monnaie){ 
	if(isNaN(plafond) != true ){
	
	 xhr.open("GET", "php/modif/mgarantie.php?lib="+lib+"&plafond="+plafond+"&monnaie="+monnaie+"&code="+code, false);
     xhr.send(null);
	 //alert(xhr.responseText);
	 alert("Garantie Modifiee !");
	 Menu2('param','garanties.php');
	  }else{alert("Le Plafond doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	}	
			
</script>		