<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");

?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a>Individuelle-Accident</a><a>Formule-Groupe</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a class="current"><i></i>Souscripteur</a><a>Assure (F-Excel)</a><a>Capital</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <div class="controls">
                 <select id="civ">
				<option value="">--  Civilite(*)</option>
				<option value="1">--  Mr</option>
				<option value="2">--  Mme</option>
				<option value="3">--  Mlle</option>
                </select>
              </div>
            </div>
			 <div class="control-group">
              <div class="controls">
                <input type="text" id="nsous" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="psous" class="span4" placeholder="Prenom (*)" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
                <input type="text" id="mailsous" class="span4" placeholder="E-mail" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="telsous" class="span4" placeholder="Tel: 213 XXX XX XX XX" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
                <input type="text" id="adrsous" class="span8" placeholder="Adresse (*)" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="dnaissous" placeholder="Date-Naissance 01/01/1970 (*)"/> 
				 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <select id="rpsous" disabled="disabled">
				  <option value="1">--  Le Souscripteur n'est pas l'assure(*)</option>
				  <option value="1">--  OUI</option>
				  <option value="2">--  NON</option>
                  </select>
              </div>
			  </div>		
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instarsousg('<?php echo $id_user; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assiaccgrp.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
    function verifdate_ind(dd)
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

    function dfrtoen_ind(date1)
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
    function calage_ind(dd)
    {
        var bb1=document.getElementById("datsys");
        var aa=new Date(dfrtoen_ind(dd.value));
        var bb=new Date(bb1.value);
        var sec1=bb.getTime();
        var sec2=aa.getTime();
        var sec=(sec1-sec2)/(365.24*24*3600*1000);
        age=Math.floor(sec);
        return age;

    }
function instarsousg(user){
var civilite=document.getElementById("civ").value;
var nom=document.getElementById("nsous").value;
var prenom=document.getElementById("psous").value;
var adr=document.getElementById("adrsous").value;
var datnais=document.getElementById("dnaissous");
var reponse=document.getElementById("rpsous").value;
var age=null,mail=null,tel=null;
var date2=null;
mail=document.getElementById("mailsous").value;
tel=document.getElementById("telsous").value;

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	
	 
	 if(civilite && nom && prenom && adr && reponse){ 
	
	
	 if(verifdate_ind(datnais)){
	    age=calage_ind(datnais);
		date2=dfrtoen_ind(datnais.value);
	    if(age>=18){	
		xhr.open("GET", "produit/iaccidg/phy/nsous.php?civs="+civilite+"&noms="+nom+"&prenoms="+prenom+"&adrs="+adr+"&ages="+age+"&dnaiss="+date2+"&mails="+mail+"&tels="+tel+"&rps="+reponse, false);
        xhr.send(null);
//alert(xhr.responseText);
//$("#content").load("doc/file/lifiles.php");
            $("#content").load("produit/iaccidg/phy/importerfile.php");


        }else{alert("Le souscripteur doit avoir plus de 18 ans !");}
	   
	   }
	
	}else{alert("Veuillez remplir tous les champs Obligatoire (*) !");}

	}	
			
</script>	