<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$tokwar3 = generer_token('devwar3');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
$datesys=date("Y-m-d");
if ( isset($_REQUEST['sous']) &&  isset($_REQUEST['opt'])){
    $codsous= $_REQUEST['sous'];
    $opt= $_REQUEST['opt'];
}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Warda</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a>Capital</a><a class="current">Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
             
		    <div class="control-group"> 
              <label class="control-label">Q1:</label>
   
				 <div class="controls">
				 <input type="text" class="span8" value="Avez-vous eu au cours des dix derniere annees un cancer, des tumeurs, des kystes" disabled="disabled" />
<input type="text" class="span8" value="ou toutes autre masse ou etes-vous actuellement en enquete sur le cancer ?" disabled="disabled" />
				 &nbsp;&nbsp;&nbsp;
				 <select id="r1">
				 <option value="">-- Reponse (*)</option>
                 <option value="1">OUI</option>
				 <option value="2">Non</option>
                </select>
              </div>
			  </div>
			   <div class="control-group"> 
              <label class="control-label">Q2:</label>
   
				 <div class="controls">
				  <input type="text" class="span8" value="Avez-vous un parent ou l un de vos freres et soeurs  qui a developpe ou decede d un 
" disabled="disabled" />
<input type="text" class="span8" value="cancer du sein et/ou de l ovaire avant leurs soixantieme 60eme anniversaire ?" disabled="disabled" />
				 &nbsp;&nbsp;&nbsp;
				 <select id="r2">
				 <option value="">-- Reponse (*)</option>
                 <option value="1">OUI</option>
				 <option value="2">Non</option>
                </select>
              </div>
			  </div>	
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instvaldwar('<?php echo $codsous; ?>','<?php echo $opt; ?>','<?php echo $tokwar3; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assward.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instvaldwar(codsous,opt,tok){

var r1=document.getElementById("r1").value;
var r2=document.getElementById("r2").value;
var bool=0;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 
	 
	if(r1 && r2){
	 
	 if(r1==2 && r2==2){ 
	    
		$("#content").load("produit/warda/devwar5.php?sous="+codsous+"&opt="+opt+"&r1="+r1+"&r2="+r2+"&bool="+bool+"&tok="+tok);
	}else{
	
	if(r1==2){
	bool=1;
	$("#content").load("produit/warda/devwar6.php?sous="+codsous+"&opt="+opt+"&bool="+bool+"&tok="+tok);
	alert("Vueillez Remplir le questionnaire complementaire !");	
	}else{alert("Demande non prise en charge !");}
	
	
	}
	}else{alert("Veuillez repondre au questions SVP !");}
	
	
	
	}	
			
</script>	