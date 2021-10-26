<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
//Periode
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE cod_per >'6' AND cod_per <='20' AND cod_per <>'18' ORDER BY `cod_per`");
$rqtper->execute();
//Profession
$rqtpro=$bdd->prepare("SELECT * FROM `classe`  WHERE cod_cls > 1 ");
$rqtpro->execute();
 ?>
<div id="content-header">
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Individuel-Accident</a><a>Formule-Individuelle</a> <a class="current">Simulateur</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
           
			<div class="control-group">
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="dnaissindacc" placeholder="D-Naissance JJ/MM/AAAA"/> 
				  &nbsp;&nbsp;&nbsp;&nbsp;
				 <select id="persindacc">
				<option value="">-- Duree (*)</option>
				<?php while ($row_res=$rqtper->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                  <?php } ?>
                </select>
				 &nbsp;&nbsp;&nbsp;&nbsp;
				 <select id="prosindacc">
				<option value="">-- Classe (*)</option>
				<?php while ($row_res1=$rqtpro->fetch()){  ?>
                  <option value="<?php  echo $row_res1['cod_cls']; ?>"><?php  echo $row_res1['lib_cls']; ?></option>
                  <?php } ?>
                </select>

                &nbsp;&nbsp;&nbsp;&nbsp;
                <select id="typsousindacc">
                         <option value="">-- Type souscripteur (*)</option>
                         <option value="1"> Personne Physique </option>
                         <option value="2"> Personne Morale </option>

                </select>
              </div>
			  </div>
			   <div class="control-group">
              <div class="controls">
                <input type="text" id="indacccap1" class="span4" placeholder="Capital DC-IPP (DZD)" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="indacccap2" class="span4" placeholder="Capital FMP (DZD)" />
				 <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>	
              </div>
            </div>			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="vtarind('<?php echo $id_user; ?>')" value="Voir le Tarif" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assiaccind.php')" value="Retour" />
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function verifdate1(dd)
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
function dfrtoen(date1)
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
function calage(dd)
{
   var bb1=document.getElementById("datsys");
   var aa=new Date(dfrtoen(dd.value));
   var bb=new Date(bb1.value);
   var sec1=bb.getTime();
   var sec2=aa.getTime(); 
   var sec=(sec1-sec2)/(365.24*24*3600*1000); 
   age=Math.floor(sec);
return age;

}
function vtarind(user){
var capital1=document.getElementById("indacccap1").value;
var capital2=document.getElementById("indacccap2").value;
var dure=document.getElementById("persindacc").value;
var classe=document.getElementById("prosindacc").value;
var date1=document.getElementById("dnaissindacc");
var typsous=document.getElementById("typsousindacc").value;

var age=null;

 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }


	if(capital1 && capital2 && classe && dure && date1 && typsous){ 
	if(isNaN(capital1) != true && capital1 <=3000000 && capital1 >= 100000){
	
	if(isNaN(capital2) != true && capital2 <=5000 && capital2 >= 1000){
	
	
	 if(verifdate1(date1)){
	  age=calage(date1);
	    xhr.open("GET", "php/tarif/rtindacc.php?age="+age+"&dure="+dure+"&cap1="+capital1+"&cap2="+capital2+"&classe="+classe+"&typsous="+typsous, false);
xhr.send(null);
alert(xhr.responseText);
	}
	
	 }else{alert("Pour la garantie FMP Veuillez Remplir un montant comprit Entre 1000 et 5 000 DA !");
	document.getElementById("indacccap2").value="";
	}	
    }else{alert("Pour la garantie DC-IPP Veuillez Remplir un montant comprit Entre 100 000 et 3 000 000 DA !");
	document.getElementById("indacccap1").value="";
	}
	
  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  
}		
</script>	