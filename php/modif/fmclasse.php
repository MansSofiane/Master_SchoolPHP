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
$rqtc=$bdd->prepare("SELECT * FROM `classe` WHERE `cod_cls`='$code'");
$rqtc->execute();
while ($row_res=$rqtc->fetch()){
$code=$row_res['cod_cls'];
$libcls=$row_res['lib_cls'];
$txcls=$row_res['taux_cls'];
}

}
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
                <input type="text" id="mlibcls" class="span7" value="<?php echo $libcls; ?>"  />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Taux-Classe *:</label>
              <div class="controls">
               <input type="text" id="mtxcls" class="span7" value="<?php echo $txcls; ?>" />
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="minscls('<?php echo $code; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','classes.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function minscls(code){

var libcls=document.getElementById("mlibcls").value;
var txcls=document.getElementById("mtxcls").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libcls && txcls){ 
	if(isNaN(txcls) != true ){
	
	 xhr.open("GET", "php/modif/mclasse.php?libcls="+libcls+"&txcls="+txcls+"&code="+code, false);
     xhr.send(null);
	 //alert(xhr.responseText);
	 alert("Classe Modifie !");
	 Menu2('param','classes.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Taux doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	}	
			
</script>		