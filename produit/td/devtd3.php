<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$toktd4 = generer_token('devtd4');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if ( isset($_REQUEST['sous']) ){
    $codsous= $_REQUEST['sous'];
//Selection des options Warda	
$rqtper=$bdd->prepare("SELECT * FROM `option`  WHERE cod_opt >='5' AND cod_opt <='6' ORDER BY `cod_opt`");
$rqtper->execute();

//Profession
$rqtpro=$bdd->prepare("SELECT * FROM `profession`  WHERE cod_cls='2'");
$rqtpro->execute();
	
}

?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Temporaire-Au-Deces</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a>Beneficiaires</a><a class="current">Capital</a><a>Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
             
		<div class="control-group"> 
		
		
            <label class="control-label">Capital: </label>
            <div class="control-group">
              <div class="controls">
               <input type="text" id="captd" class="span3" placeholder="Capital DC-IAD (DZD)" />
					
              </div>
            </div>		
				 <div class="controls">
				<select id="protd">
				<option value="">-- Profession (*)</option>
				<?php while ($row_res1=$rqtpro->fetch()){  ?>
                  <option value="<?php  echo $row_res1['cod_cls']; ?>"><?php  echo $row_res1['lib_prof']; ?></option>
                  <?php } ?>
                </select>
              </div>
			 	
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instqm('<?php echo $codsous; ?>','<?php echo $toktd4; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asstd.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instqm(codsous,tok){

var pro=document.getElementById("protd").value;
var cap=document.getElementById("captd").value;
var bool=0;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	
	 
	 if(cap && pro){ 
	 //debut
	  if(isNaN(cap) != true && cap >= 100000){
	 
	 if(cap <=3000000){		
	 
		$("#content").load("produit/td/devtd4.php?sous="+codsous+"&pro="+pro+"&cap="+cap+"&bool="+bool+"&tok="+tok);		
	}else{
	alert("Plafond de souscription atteind, le devis sera soumis a la DG-AGLIC");
	bool=1;
	$("#content").load("produit/td/devtd4.php?sous="+codsous+"&pro="+pro+"&cap="+cap+"&bool="+bool+"&tok="+tok);	
	
	}
	
	}else{alert("Veuillez Remplir un montant superieur ou egual a 100 000 DA !");}
	//fin
	}else{alert("Veuillez remplir tous les champs (*) !");}
	
	
	
	
	}	
			
</script>	