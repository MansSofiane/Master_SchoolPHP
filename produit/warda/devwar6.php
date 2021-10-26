<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$tokwar5 = generer_token('devwar3');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
$datesys=date("Y-m-d");
if ( isset($_REQUEST['sous']) &&  isset($_REQUEST['opt']) &&  isset($_REQUEST['bool'])){
    $codsous= $_REQUEST['sous'];
    $opt= $_REQUEST['opt'];
	$bool= $_REQUEST['bool'];
}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Warda</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a>Capital</a><a class="current">Selection-Medical(Complementaire)</a><a>Validation</a></div>

        <div class="widget-content nopadding">
          <form class="form-horizontal">
             
		    <div class="control-group"> 
              <label class="control-label">Reponse-1:</label>
				 <div class="controls">
                  <input type="text" id="r1" class="span9" title="Veuillez indiquer le nombre de parents (premiere generation, y compris les parents, freres et soeurs) avec un cancer du sein et / ou des ovaires / Autres informations medicales ?
"   placeholder="Precisez : "/>
              </div>
			  </div>
			   <div class="control-group"> 
              <label class="control-label">Reponse-2:</label>
				 <div class="controls">
                  <input type="text" id="r2" class="span9" title="Durant les six derniers mois, avez-vous involontairement perdu plus de 4 kg (ou 10 % de votre poids total) ?"   placeholder="Combien ? Quand et pourquoi ?
"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-3:</label>
				 <div class="controls">
                  <input type="text" id="r3" class="span9" title="Souffrez-vous ou avez-vous ete atteint d une maladie de l appareil digestif, cardio-vasculaire, respiratoire, du systeme nerveux, de l appareil genito-urinaire, l Hepatite, VIH, d une maladie endocrinienne ou metabolique, neuropsychique, des os et des articulations ou de toute autre maladie non citee ci-dessus ?"   placeholder="Precisez :"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-4:</label>
				 <div class="controls">
                  <input type="text" id="r4" class="span9" title="Avez-vous eu recours a un avis medical ou une consultation de specialiste, conseil ou traitement de troubles gynecologiques ?" placeholder="Precisez : Quand et pourquoi ?"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-5:</label>
				 <div class="controls">
                  <input type="text" id="r5" class="span9" title="Avez-vous fait un frottis cervical anormal, une mammographie une biopsie du sein, de l uterus ou du col de l uterus ?"   placeholder="Precisez : Quand et pourquoi ?"/>&nbsp;&nbsp;
 <input type="text" id="pds" class="span3" placeholder="Poid en KG (Ex: 75)"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-6:</label>
				 <div class="controls">
                  <input type="text" id="r6" class="span9" title="Fumez-vous plus de 2 jours par semaine ? "placeholder="Precisez :"/>&nbsp;&nbsp;
 <input type="text" id="tail" class="span3" placeholder="Taille en M  (Ex: 1.65)"/>
              </div>
			  </div>	
            <div class="form-actions" align="right">
			 <input  type="button" class="btn btn-warning" onClick="quespdfc()" value="Questionaire" />
			  <input  type="button" class="btn btn-success" onClick="instvaldtd('<?php echo $codsous; ?>','<?php echo $opt; ?>','<?php echo $bool; ?>','<?php echo $tokwar5; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asstd.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instvaldtd(codsous,opt,bool,tok){
var pds=document.getElementById("pds").value;
var tail=document.getElementById("tail").value;
var imc=0;var bool1=0;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     } 
	if(pds && tail && isNaN(pds) != true && isNaN(tail) != true){
	   bool=reponse(codsous,pds,tail);	
	
	   $("#content").load("produit/warda/devwar5.php?sous="+codsous+"&opt="+opt+"&bool="+bool+"&tok="+tok);
	   alert("Devis soumis a la vlidation DG-AGLIC");
	
	}else{alert("Veuillez mentionner  le poids et la taille !");}	
	}	
function reponse(codsous,pds,tail){
var r1=document.getElementById("r1").value;
var r2=document.getElementById("r2").value;
var r3=document.getElementById("r3").value;
var r4=document.getElementById("r4").value;
var r5=document.getElementById("r5").value;
var r6=document.getElementById("r6").value;
var bool=1;
var imc=pds/(tail*tail);
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(r1 || r2 || r3 || r4 || r5 || r6 || pds || tail){
	
	bool=1;
	//alert("Un accord de la DG-AGLIC est Obligatoire");
	 xhr.open("GET", "produit/warda/nrep.php?pds="+pds+"&tail="+tail+"&bool="+bool+"&sous="+codsous+"&r1="+r1+"&r2="+r2+"&r3="+r3+"&r4="+r4+"&r5="+r5+"&r6="+r6, false);
     xhr.send(null); 
	}
return bool;	
	}					
</script>	