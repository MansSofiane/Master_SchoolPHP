<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$tokade6 = generer_token('devade6');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if ( isset($_REQUEST['sous']) &&  isset($_REQUEST['per']) &&  isset($_REQUEST['cap']) &&  isset($_REQUEST['bool'])){
    $codsous= $_REQUEST['sous'];
    $per= $_REQUEST['per'];
	$cap= $_REQUEST['cap'];
	$bool= $_REQUEST['bool'];
    $vari=0;$rp=0;$codsous1=0;$prime=0;$codtar=0;$jour=0;
//on recupere le nombre de jours du contrat

$rqtper=$bdd->prepare("SELECT `max_jour` FROM `periode`  WHERE `cod_per`='$per'");
$rqtper->execute();
while ($row3=$rqtper->fetch()){
$jour=$row3['max_jour'];
}


//on verifie l'assure
$rqtv=$bdd->prepare("SELECT `rp_sous` FROM `souscripteurw`  WHERE `cod_sous`='$codsous'");
$rqtv->execute();

while ($row=$rqtv->fetch()){
$rp=$row['rp_sous'];
}

//Requete pour le tarif sur souscripteur qui est l'assure
if($rp==1){	
$rqtu=$bdd->prepare("SELECT t.`cod_tar`,t.`pe`, d.`mtt_dt`, c.`mtt_cpl`  FROM `tarif` as t, `dtimbre` as d, `cpolice` as c, `souscripteurw` as s WHERE t.`cod_prod`='7' AND t.`cod_seg`='5' AND t.`cod_cls`='1' AND t.`cod_zone`='1' AND t.`cod_formul`='1' AND t.`cod_opt`='3' AND t.`cod_per`='$per' AND t.`agemin`<=s.`age` AND t.`agemax`>=s.`age` AND t.`cod_dt`=d.`cod_dt` AND t.`cod_cpl`=c.`cod_cpl` AND s.`cod_sous`='$codsous'");
$rqtu->execute();

while ($row_pu=$rqtu->fetch()){
$codtar=$row_pu['cod_tar'];
$prime=($row_pu['pe']*$cap)+$row_pu['mtt_dt']+$row_pu['mtt_cpl'];
$vari++;
}	
}

//Requete pour le tarif sur souscripteur qui n'est pas l'assure
if($rp==2){	
// on recupere le code de l'assure
$rqtv1=$bdd->prepare("SELECT `cod_sous` FROM `souscripteurw`  WHERE `cod_par`='$codsous'");
$rqtv1->execute();
$rp=0;
while ($row=$rqtv1->fetch()){
$codsous1=$row['cod_sous'];
}
//**************

$rqtu=$bdd->prepare("SELECT t.`cod_tar`,t.`pe`, d.`mtt_dt`, c.`mtt_cpl`  FROM `tarif` as t, `dtimbre` as d, `cpolice` as c, `souscripteurw` as s WHERE t.`cod_prod`='7' AND t.`cod_seg`='5' AND t.`cod_cls`='1' AND t.`cod_zone`='1' AND t.`cod_formul`='1' AND t.`cod_opt`='3' AND t.`cod_per`='$per' AND t.`agemin`<=s.`age` AND t.`agemax`>=s.`age` AND t.`cod_dt`=d.`cod_dt` AND t.`cod_cpl`=c.`cod_cpl` AND s.`cod_sous`='$codsous1'");
$rqtu->execute();

while ($row_pu=$rqtu->fetch()){
$codtar=$row_pu['cod_tar'];
$prime=($row_pu['pe']*$cap)+$row_pu['mtt_dt']+$row_pu['mtt_cpl'];
$vari++;
}	
}
}
if($vari>0){
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Deces-Emprunteur</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a>Beneficiaire</a><a>Capital</a><a>Selection-Medical</a><a class="current">Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
			  <div class="control-group"> 
              <label class="control-label">Date-Effet:</label>
   
				 <div class="controls" data-date-format="dd/mm/yyyy">
				<input type="text" class="date-pick dp-applied"  id="deffwar" placeholder="Format date JJ/MM/AAAA"/> 
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type="text" class="span4" value="Prime a payer: <?php echo number_format($prime, 2, ',', ' '); ?> DA" disabled="disabled" />
              </div>
			  </div>	
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instdevade('<?php echo $codsous; ?>','<?php echo $per; ?>','<?php echo $prime; ?>','<?php echo $codtar; ?>','<?php echo $vari; ?>','<?php echo $bool; ?>','<?php echo $cap; ?>','<?php echo $jour; ?>','<?php echo $tokade6; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asscim.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<?php }else{ ?>
<div id="content-header">
<div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Deces-Emprunteur</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div id="breadcrumb"> <a><i></i><a class="current">Cas Non Assure !!</a></div>
<div class="form-actions" align="right">
<input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asscim.php')" value="Retour" />
</div>
<?php } ?>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">

	function verifdateade5(dd)
	{
		v1=true;
		var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
		var test = regex.test(dd.value);
		if(!test){
			v1=false;
			alert("Format date incorrect! jj/mm/aaaa");dd.value="";

		}
		return v1;
	}

	function compdat(dd)
	{
		var rcomp=false;
		var bb1=document.getElementById("datsys");
		var aa=new Date(dfrtoen_ade5(dd.value));
		var bb=new Date(bb1.value);
		var sec1=bb.getTime();
		var sec2=aa.getTime();
		if(sec2>=sec1){rcomp=true;}
		return rcomp;

	}
	function addDays5(dd,xx) {
		// Date plus plus quelques jours
		var split_date = dd.split('/');
		var new_date = new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1 + parseInt(xx)-1);
		var dd= new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
		var new_day = new_date.getDate();
		new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un zéro devant pour la forme
		var new_month = new_date.getMonth() + 1;
		new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un zéro devant pour la forme
		var new_year = new_date.getYear();
		new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
		var new_date_text = new_day + '/' + new_month + '/' + new_year;
		return new_date_text;
	}
	function dfrtoen_ade5(date1)
	{
		var split_date=date1.split('/');
		var new_d=new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
		var new_day = new_d.getDate();
		new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un zéro devant pour la forme
		var new_month = new_d.getMonth() + 1;
		new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un zéro devant pour la forme
		var new_year = new_d.getYear();
		new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
		var new_date_text = new_year + '-' + new_month + '-' + new_day;
		return new_date_text;
	}


function instdevade(codsous,per,prime,tar,vari,bool,cap,jour,tok){

var dateff=document.getElementById("deffwar");
var datech=null;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 
	if(vari==0){alert("Cas Non-Assure !");}else{
	  if(verifdateade5(dateff)){
	 
          	if(compdat(dateff)){
			   datech=dfrtoen_ade5(addDays5(dateff.value,jour));
			   dateff=dfrtoen_ade5(dateff.value)
			   if(bool==0){
			   
			   xhr.open("GET", "produit/ade/ndev.php?cap="+cap+"&tar="+tar+"&per="+per+"&pt="+prime+"&d1="+dateff+"&d2="+datech+"&sous="+codsous+"&bool="+bool+"&tok="+tok, false);
			   xhr.send(null);
			   //alert(xhr.responseText);
			   alert("Devis Enregistre !");
			   Menu1('prod','asscim.php');
			   }else{
			   alert("Devis soumis au traitement de la DG-AGLIC");
				   xhr.open("GET", "produit/ade/ndev.php?cap="+cap+"&tar="+tar+"&per="+per+"&pt="+prime+"&d1="+dateff+"&d2="+datech+"&sous="+codsous+"&bool="+bool+"&tok="+tok, false);
				   xhr.send(null);
			      // alert(xhr.responseText);
				  alert("Devis Enregistre !");
				  Menu1('prod','asscim.php');
			   }
			   
	        }else{
	         alert("la date d'effet doit pas etre anterieure !");
	             }
				 }else{alert("Cas Non-Assure !");}
				 
	
	}
	
	}	
			
</script>	