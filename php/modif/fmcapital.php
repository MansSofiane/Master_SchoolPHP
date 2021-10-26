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
$rqtc=$bdd->prepare("SELECT * FROM `capital` WHERE `cod_cap`='$code'");
$rqtc->execute();
while ($row_res=$rqtc->fetch()){
$libcap=$row_res['lib_cap'];
$mttcap=$row_res['mtt_cap'];
}

}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Modification-Capital</a></div>
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
                <input type="text" id="mlibcap" class="span7" value="<?php echo $libcap; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Montant-Capital *:</label>
              <div class="controls">
                <input type="text" id="mmttcap" class="span7" value="<?php echo $mttcap; ?>"/>
              </div>
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="minscap('<?php echo $code; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','capitals.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function minscap(code){
var libcap=document.getElementById("mlibcap").value;
var mttcap=document.getElementById("mmttcap").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libcap && mttcap){ 
	if(isNaN(mttcap) != true ){
	
	 xhr.open("GET", "php/modif/mcapital.php?libcap="+libcap+"&mttcap="+mttcap+"&code="+code, false);
     xhr.send(null);
	 //alert(xhr.responseText);
	 alert("Capital Modifie !");
	 Menu2('param','capitals.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Le Plafond doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	