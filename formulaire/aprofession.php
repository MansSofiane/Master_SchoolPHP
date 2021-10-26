<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$rqt=$bdd->prepare("SELECT * FROM `classe`  WHERE id_user=$id_user ORDER BY `cod_cls`");
$rqt->execute();
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouvelle-Profession</a></div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Profession</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Profession *:</label>
              <div class="controls">
                <input type="text" id="libprof" class="span6" placeholder="Lib ..." />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Classes *:</label>
              <div class="controls">
                <select id="codcls">
				<option value="--">--</option>
				<?php while ($row_res=$rqt->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_cls']; ?>"><?php  echo $row_res['lib_cls']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="insprof('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','professions.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function insprof(user){
var libprof=document.getElementById("libprof").value;
var codcls=document.getElementById("codcls").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libprof && codcls){ 
	if(isNaN(codcls) != true ){
	
	 xhr.open("GET", "php/insert/nprofession.php?libprof="+libprof+"&codcls="+codcls+"&user="+user, false);
     xhr.send(null);
	// alert(xhr.responseText);
	 alert("Profession Introduite !");
	 Menu2('param','professions.php');
	//  alert(lib); alert(plafond);alert(monnaie);alert(user);
	  }else{alert("Veuillez Selectionner la Classe !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	