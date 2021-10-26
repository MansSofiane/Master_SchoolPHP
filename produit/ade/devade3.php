<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$tokade4 = generer_token('devade4');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if ( isset($_REQUEST['sous']) ){
    $codsous= $_REQUEST['sous'];
//Selection des options Warda	
$rqtper=$bdd->prepare("SELECT * FROM `option`  WHERE cod_opt >='5' AND cod_opt <='6' ORDER BY `cod_opt`");
$rqtper->execute();

//Periode
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE cod_per >='20' ORDER BY `cod_per`");
$rqtper->execute();


//on verifie l'assure
    $rqtv=$bdd->prepare("SELECT `rp_sous`,`age` FROM `souscripteurw`  WHERE `cod_sous`='$codsous'");
    $rqtv->execute();

    while ($row=$rqtv->fetch()){
        $rp=$row['rp_sous'];
        $age=$row['age'];
    }
    if($rp==2)//le souscripteur n'est pas l assure
    {
        $rqtv2=$bdd->prepare("SELECT `age` FROM `souscripteurw`  WHERE `cod_par`='$codsous'");
        $rqtv2->execute();
        while ($row2=$rqtv2->fetch()){
            $age=$row2['age'];
        }
    }


}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Deces-Emprunteur</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a>Beneficiaire</a><a class="current">Capital</a><a>Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
             
		<div class="control-group"> 
		
		
            <label class="control-label">Capital: </label>
            <div class="control-group">
              <div class="controls">
               <input type="text" id="capade" class="span3" placeholder="credit accorde (DZD)" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="per">
				<option value="">-- Duree (*)</option>
				<?php while ($row_res=$rqtper->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                  <?php } ?>
                </select>
              </div>
			 </div>		
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instqm('<?php echo $codsous; ?>','<?php echo $tokade4; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asscim.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instqm(codsous,tok){

var per=document.getElementById("per").value;
var cap=document.getElementById("capade").value;
var bool=0;
var age=<?php echo $age;?>;

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	
	 
	 if(cap && per){ 
	 //debut
	  if(isNaN(cap) != true && cap >= 100000){
	 
	 if(cap <=3000000){
         if(age>=66)
         {
             alert("l'age de l'assure superieur a 65 ans, le devis sera soumis a la DG-AGLIC pour validation");
             bool=1;
             $("#content").load("produit/ade/devade4.php?sous="+codsous+"&per="+per+"&cap="+cap+"&bool="+bool+"&tok="+tok);
         }
         else {
             $("#content").load("produit/ade/devade4.php?sous=" + codsous + "&per=" + per + "&cap=" + cap + "&bool=" + bool + "&tok=" + tok);
         }
	}else{
	alert("Plafond de souscription atteind, le devis sera soumis a la DG-AGLIC");
	bool=1;
	$("#content").load("produit/ade/devade4.php?sous="+codsous+"&per="+per+"&cap="+cap+"&bool="+bool+"&tok="+tok);	
	
	}
	
	}else{alert("Veuillez Remplir un montant superieur ou egal a 100 000 DA !");}
	//fin
	}else{alert("Veuillez remplir tous les champs (*) !");}
	
	
	
	
	}	
			
</script>	