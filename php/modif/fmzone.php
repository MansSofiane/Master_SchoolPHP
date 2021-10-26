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
$rqtc=$bdd->prepare("SELECT * FROM `zone` WHERE `cod_zone`='$code'");
$rqtc->execute();
while ($row_res=$rqtc->fetch()){
$lib=$row_res['lib_zone'];
$com=$row_res['com_zone'];
}

}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Modification-Zone</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Zone</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Zone *:</label>
              <div class="controls">
                <input type="text" id="mlibzon" class="span7" value="<?php echo $lib; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Commentaire *:</label>
              <div class="controls">
                <input type="text" id="mcomzon" class="span7" value="<?php echo $com; ?>" />
              </div>
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="minszon('<?php echo $code; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','zones.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function minszon(code){
var libzon=document.getElementById("mlibzon").value;
var comzon=document.getElementById("mcomzon").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libzon && comzon){ 	
	 xhr.open("GET", "php/modif/mzone.php?libzon="+libzon+"&comzon="+comzon+"&code="+code, false);
     xhr.send(null);
	 //alert(xhr.responseText);
	 //alert("php/modif/mzone.php?libzon="+libzon+"&comzon="+comzon+"&code="+code);
	 alert("Zone Modifie !");
	 Menu2('param','zones.php');
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	