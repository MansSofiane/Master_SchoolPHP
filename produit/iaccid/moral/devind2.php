<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$tokiacc1 = generer_token('devind1');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
// recupération du code du dernier souscripteur de l'agence	
$rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$id_user'");
$rqtms->execute();
$codsous=0;
while ($row_res=$rqtms->fetch()){ 
$codsous=$row_res['maxsous']; 
}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a>Individuelle-Accident</a><a>Formule-Individuelle</a><a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Assure</a><a>Capital</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
              <div class="control-group">
              <div class="controls">
                 <select id="civa">
				<option value="">--  Civilite(*)</option>
				<option value="1">--  Mr</option>
				<option value="2">--  Mme</option>
				<option value="3">--  Mlle</option>
                </select>
              </div>
			 <div class="control-group">
              <div class="controls">
                <input type="text" id="nassu" class="span4" placeholder="Nom assure (*)"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="passu" class="span4" placeholder="Prenom Assure (*)" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
                <input type="text" id="adrassu" class="span6" placeholder="Adresse assure (*)" />
              </div>
            </div>
                  <div class="control-group">
                      <div class="controls">
                          <input type="text" id="profassu" class="span6" placeholder="Profession" />
                      </div>
                  </div>
			<div class="control-group">
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="dnaisassu" placeholder="D-Naissance JJ/MM/AAAA (*)"/> 
              </div>
			  </div>	
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="capitalind('<?php echo $codsous; ?>','<?php echo $tokiacc1; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assiaccind.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">

    function verifdate_ind2(dd)
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

    function dfrtoen_ind2(date1)
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
    function calage_ind2(dd)
    {
        var bb1=document.getElementById("datsys");
        var aa=new Date(dfrtoen_ind2(dd.value));
        var bb=new Date(bb1.value);
        var sec1=bb.getTime();
        var sec2=aa.getTime();
        var sec=(sec1-sec2)/(365.24*24*3600*1000);
        age=Math.floor(sec);
        return age;

    }
function instarassu(tok){
var user= "<?php echo $id_user; ?>";
var codsous= "<?php echo $codsous; ?>";
var civilitea=document.getElementById("civa").value;
var noma=document.getElementById("nassu").value;
var prenoma=document.getElementById("passu").value;
var adra=document.getElementById("adrassu").value;
var datnaisa=document.getElementById("dnaisassu");
var profassu=document.getElementById("profassu").value;

var agea=null,date2a=null;

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     } 
	 if(civilitea && noma && prenoma && adra ){ 	
	 if(verifdate_ind2(datnaisa)){
	    agea=calage_ind2(datnaisa);
	    
		date2a=dfrtoen_ind2(datnaisa.value);
	
		xhr.open("GET", "produit/iaccid/moral/nassu.php?civilitea="+civilitea+"&noma="+noma+"&prenoma="+prenoma+"&adra="+adra+"&datnaisa="+date2a+"&agea="+agea+"&sous="+codsous+"&user="+user+"&tok="+tok+"&prof="+profassu, false);
       xhr.send(null); 
	   }
	
	}else{alert("Veuillez remplir tous les champs Obligatoire (*) !");}
	
	}	
function capitalind(codsous,tok){

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	instarassu(tok);
	$("#content").load("produit/iaccid/moral/devind3.php?sous="+codsous+"&tok="+tok);
	
	}			
</script>	