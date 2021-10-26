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
$rqtc=$bdd->prepare("SELECT * FROM `periode` WHERE `cod_per`='$code'");
$rqtc->execute();
while ($row_res=$rqtc->fetch()){
$libper=$row_res['lib_per'];
$minj=$row_res['min_jour'];
$maxj=$row_res['max_jour'];
}
$rqto=$bdd->prepare("SELECT * FROM `option` WHERE `id_user`='$id_user'");
$rqto->execute();
}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Modification-Periode</a></div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Periode</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Periode *:</label>
              <div class="controls">
                <input type="text" id="mlibper" class="span6" value="<?php echo $libper; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Nbr-Jours-Min *:</label>
              <div class="controls">
                <input type="text" id="mjminper" class="span6" value="<?php echo $minj; ?>" />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Nbr-Jours-Max *:</label>
              <div class="controls">
                <input type="text" id="mjmaxper" class="span6" value="<?php echo $maxj; ?>" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Option-Rattachee *:</label>
              <div class="controls">
                <select id="mcodopt">
				<?php while ($row_res=$rqto->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="minsper('<?php echo $code; ?>')"  value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','periodes.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function minsper(code){
var libper=document.getElementById("mlibper").value;
var jminper=document.getElementById("mjminper").value;
var jmaxper=document.getElementById("mjmaxper").value;
var codopt=document.getElementById("mcodopt").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libper && jminper && jmaxper && codopt){ 
	if(isNaN(jminper) != true && isNaN(jmaxper) != true){
	if(jminper <= jmaxper ){
	 xhr.open("GET", "php/modif/mperiode.php?libper="+libper+"&jminper="+jminper+"&jmaxper="+jmaxper+"&codopt="+codopt+"&code="+code, false);
     xhr.send(null);
	 // alert(xhr.responseText);
	 alert("Periode Modifie !");
	 Menu2('param','periodes.php');	
	}else{alert("Le Nombre de jour Max doit etre superieur au jour Min !");}
	
	  }else{alert("Le Nombre de jour doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	