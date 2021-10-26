<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$toktd5 = generer_token('devtd5');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
$datesys=date("Y-m-d");
if ( isset($_REQUEST['sous']) &&  isset($_REQUEST['pro']) &&  isset($_REQUEST['cap']) &&  isset($_REQUEST['bool'])){
    $codsous= $_REQUEST['sous'];
    $pro= $_REQUEST['pro'];
	$cap= $_REQUEST['cap'];
	$bool= $_REQUEST['bool'];
}	
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Temporaire-Au-Deces</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a>Beneficiaires</a><a>Capital</a><a class="current">Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
             
		    <div class="control-group"> 
              <label class="control-label">Reponse-1:</label>
				 <div class="controls">
                  <input type="text" id="r1" class="span9" title="Y a-t-il dans votre famille(Ascendants et collateraux) un antecedent de maladie
cardiaque, vasculaire, neurologique, psychiatrique, de cancer, de diabete, etc. ?
"   placeholder="Le(s) quel(s) ? quelle maladie et depuis quel age ?"/>
              </div>
			  </div>
			   <div class="control-group"> 
              <label class="control-label">Reponse-2:</label>
				 <div class="controls">
                  <input type="text" id="r2" class="span9" title="Suivez-vous actuellement un traitement ?"   placeholder="Le(s) quel(s) - Depuis quand et pourquoi ?"/>
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
                  <input type="text" id="r4" class="span9" title="Etes vous fumeur ?" placeholder="Quantites journalieres :"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-5:</label>
				 <div class="controls">
                  <input type="text" id="r5" class="span9" title="Etes-vous titulaire d une pension d invalidite ? ou Une procedure de mise en invalidite est-elle ou va-t-elle etre engagee ?
"   placeholder="Depuis quand - motif - taux d invalidite (preciser a titre civil ou militaire).
"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-6:</label>
				 <div class="controls">
                  <input type="text" id="r6" class="span9" title="Etes-vous actuellement en arret de travail ?, Durant les 3 dernieres annees avez-vous du interrompre votre travail pendant plus de 1 mois ?

"   placeholder="Depuis quand - motif - date de reprise previsible ? Quand - duree de chaque arret -motif ?
"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-7:</label>
				 <div class="controls">
                  <input type="text" id="r7" class="span9" title="Etes vous atteint d'une invalidite ou d'une maladie chronique ?"   placeholder="laquelle ? depuis quelles dates ?"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-8:</label>
				 <div class="controls">
                  <input type="text" id="r8" class="span9" title="Est-ce qu un ECG, un test de laboratoire,ou d'autres investigations medicales vous ont ete faites qui se soient reveles anormaux ?"   placeholder="lesquels (+date)"/>&nbsp;&nbsp;
 <input type="text" id="pds" class="span3" placeholder="Poid en KG (Ex: 75)"/>
              </div>
			  </div>
			  <div class="control-group"> 
              <label class="control-label">Reponse-9:</label>
				 <div class="controls">
                  <input type="text" id="r9" class="span9" title="une ou plusieurs propositions d assurance reposant sur votre tete ont-elles ete refusees, acceptees avec surprime ou acceptees avec exclusion (s)?
"   placeholder="decision et date (s) :   + motifs:"/>&nbsp;&nbsp;
 <input type="text" id="tail" class="span3" placeholder="Taille en M  (Ex: 1.65)"/>
              </div>
			  </div>			
            <div class="form-actions" align="right">
			 <input  type="button" class="btn btn-warning" onClick="quespdf()" value="Questionaire" />
			  <input  type="button" class="btn btn-success" onClick="instvaldtd('<?php echo $codsous; ?>','<?php echo $pro; ?>','<?php echo $cap; ?>','<?php echo $bool; ?>','<?php echo $toktd5; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asstd.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instvaldtd(codsous,pro,cap,bool,tok){
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
	
	
	imc=pds/(tail*tail);
	if(imc>18.5 && imc <30){	
	bool1=reponse(codsous,pds,tail);	
	if (bool==0 && bool1==0){
	$("#content").load("produit/td/devtd5.php?sous="+codsous+"&pro="+pro+"&cap="+cap+"&bool="+bool+"&tok="+tok);
	}else{
	bool=1;
	$("#content").load("produit/td/devtd5.php?sous="+codsous+"&pro="+pro+"&cap="+cap+"&bool="+bool+"&tok="+tok);
	alert("le dossier est soumis a un accord DG-AGLIC");
	}
    $("#content").load("produit/td/devtd5.php?sous="+codsous+"&pro="+pro+"&cap="+cap+"&bool="+bool+"&tok="+tok);	
	}else{	
	alert("le dossier est soumis a un accord DG-AGLIC");
	bool1=reponse(codsous,pds,tail);
	bool=1;
	$("#content").load("produit/td/devtd5.php?sous="+codsous+"&pro="+pro+"&cap="+cap+"&bool="+bool+"&tok="+tok);
	}	
	}else{alert("Veuillez mentionner  le poids et la taille !");}	
	}	
function reponse(codsous,pds,tail){
var r1=document.getElementById("r1").value;
var r2=document.getElementById("r2").value;
var r3=document.getElementById("r3").value;
var r4=document.getElementById("r4").value;
var r5=document.getElementById("r5").value;
var r6=document.getElementById("r6").value;
var r7=document.getElementById("r7").value;
var r8=document.getElementById("r8").value;
var r9=document.getElementById("r9").value;
var bool=0;
var imc=pds/(tail*tail);
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(r1 || r2 || r3 || r4 || r5 || r6 || r7 || r8 || r9){
	
	bool=1;
	//alert("Un accord de la DG-AGLIC est Obligatoire");
	 xhr.open("GET", "produit/td/nrep.php?pds="+pds+"&tail="+tail+"&bool="+bool+"&sous="+codsous+"&r1="+r1+"&r2="+r2+"&r3="+r3+"&r4="+r4+"&r5="+r5+"&r6="+r6+"&r7="+r7+"&r8="+r8+"&r9="+r9, false);
     xhr.send(null); 
	
	}else{
	//alert("Traitement direct");
	 xhr.open("GET", "produit/td/nrep.php?pds="+pds+"&tail="+tail+"&bool="+bool+"&sous="+codsous+"&r1="+r1+"&r2="+r2+"&r3="+r3+"&r4="+r4+"&r5="+r5+"&r6="+r6+"&r7="+r7+"&r8="+r8+"&r9="+r9, false);
     xhr.send(null); 
	}
return bool;	
	}		
function quespdf(){
var win = window.open("doc/questionnaire.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}	
	
			
</script>	