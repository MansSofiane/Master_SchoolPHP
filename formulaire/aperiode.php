<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$rqt=$bdd->prepare("SELECT * FROM `option`  WHERE id_user=$id_user ORDER BY `cod_opt`");
$rqt->execute();
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouvelle-Periode</a></div>
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
                <input type="text" id="libper" class="span6" placeholder="Lib ..." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Nbr-Jours-Min *:</label>
              <div class="controls">
                <input type="text" id="jminper" class="span6" placeholder="O.." />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Nbr-Jours-Max *:</label>
              <div class="controls">
                <input type="text" id="jmaxper" class="span6" placeholder="0.." />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Option-Rattachee *:</label>
              <div class="controls">
                <select id="codopt">
				<?php while ($row_res=$rqt->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="insper('<?php echo $id_user; ?>')"  value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','periodes.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function insper(user){
var libper=document.getElementById("libper").value;
var jminper=document.getElementById("jminper").value;
var jmaxper=document.getElementById("jmaxper").value;
var codopt=document.getElementById("codopt").value;
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
	 xhr.open("GET", "php/insert/nperiode.php?libper="+libper+"&jminper="+jminper+"&jmaxper="+jmaxper+"&codopt="+codopt+"&user="+user, false);
     xhr.send(null);
	 alert(xhr.responseText);
	 alert("Periode Introduite !");
	 Menu2('param','periodes.php');	
	}else{alert("Le Nombre de jour Max doit etre superieur au jour Min !");}
	
	  }else{alert("Le Nombre de jour doit etre un chiffre !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	