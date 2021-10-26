<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$tokwar2 = generer_token('devwar2');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if ( isset($_REQUEST['sous']) ){
    $codsous= $_REQUEST['sous'];
//Selection des options Warda	
$rqtper=$bdd->prepare("SELECT * FROM `option`  WHERE cod_opt >='5' AND cod_opt <='6' ORDER BY `cod_opt`");
$rqtper->execute();
	
}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Warda</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a class="current">Capital</a><a>Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
             
		<div class="control-group"> 
              <label class="control-label">Capital:</label>
              
				 <div class="controls">
				<select id="optsw">
				<option value="">-- Option (*)</option>
				<?php while ($row_res=$rqtper->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                  <?php } ?>
                </select>
              </div>
			 	
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instqm('<?php echo $codsous; ?>','<?php echo $tokwar2; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assward.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instqm(codsous,tok){
var option=document.getElementById("optsw").value;

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 if(option){ 		
		$("#content").load("produit/warda/devwar4.php?sous="+codsous+"&opt="+option+"&tok="+tok);
	
	}else{alert("Veuillez Selectionner le Capital (*) !");}
}	
			
</script>	