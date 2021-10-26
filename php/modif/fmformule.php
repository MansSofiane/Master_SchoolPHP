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
$rqtc=$bdd->prepare("SELECT * FROM `formule` WHERE `cod_formul`='$code'");
$rqtc->execute();
while ($row_res=$rqtc->fetch()){
$libfrm=$row_res['lib_formul'];
$minfrm=$row_res['minnb_assu'];
$maxfrm=$row_res['maxnb_assu'];
}

}

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
                <input type="text" id="mlibfrm" class="span7" placeholder="Lib ..." value="<?php echo $libfrm; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Min-Nbr-Assure *:</label>
              <div class="controls">
                <input type="text" id="mminfrm" class="span7" placeholder="0" value="<?php echo $minfrm; ?>" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Max-Nbr-Assure *:</label>
              <div class="controls">
               <input type="text" id="mmaxfrm" class="span7" placeholder="0" value="<?php echo $maxfrm; ?>"  />
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="minsfrm('<?php echo $code; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','formules.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function minsfrm(code){
var libfrm=document.getElementById("mlibfrm").value;
var minfrm=document.getElementById("mminfrm").value;
var maxfrm=document.getElementById("mmaxfrm").value;
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
	
	 xhr.open("GET", "php/modif/mformule.php?libfrm="+libfrm+"&minfrm="+minfrm+"&maxfrm="+maxfrm+"&code="+code, false);
     xhr.send(null);
	// alert(xhr.responseText);
	 alert("Formule Modifiee !");
	 Menu2('param','formules.php');
	 }else{alert("Nombre assues minimum doit etre infrieur au nombre assues maximum !");}
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("les champs Nombres assure doivent etre des chiffres !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	