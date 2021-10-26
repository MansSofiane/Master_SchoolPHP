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
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE cod_per >='20' ORDER BY `cod_per`");
$rqtper->execute();
 ?>
<div id="content-header">
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>ADE-Immobilier</a> <a class="current">Simulateur-Tarifs</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Infos-Emprun :</label>
              <div class="controls">
                <input type="text" id="cap" class="span4" placeholder="Capital Maximum est 100 000 000 DA" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="per">
				<option value="">-- Duree (*)</option>
				<?php while ($row_res=$rqtper->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Infos-Emprunteur:</label>
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="dnaisemp" placeholder="D-Naissance JJ/MM/AAAA"/> 
				  &nbsp;&nbsp;&nbsp;&nbsp;
				  <select id="frm" onchange="mask()" disabled="disabled">
				  <option value="1">-- Sans Co-Emprunter</option>
				  <option value="2">-- Avec Co-Emprunter</option>
                  </select>
              </div>
			  </div>
			   <div class="control-group" id="coemp" style="visibility:hidden">
               <label class="control-label">Infos-Co-Emprunteur</label>
               <div class="controls" >
               <input type="text" class="date-pick dp-applied"  id="dnaiscoemp" placeholder="D-Naissance JJ/MM/AAAA"/>	  
               </div>
			   &nbsp;&nbsp;&nbsp;&nbsp;
			   <div class="controls" >
               <input type="text" class="span4"  id="sal1" placeholder="Salaire Emprunteur (DA)"/>
                &nbsp;&nbsp;&nbsp;&nbsp;
			   <input type="text" class="span4"  id="sal2" placeholder="Saleire Co-Emprunteur (DA)"/>
			   <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>	
               </div>
             </div>
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="vtar('<?php echo $id_user; ?>')" value="Voir le Tarif" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asscim.php')" value="Retour" />
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
function mask(){
     var formule=document.getElementById("frm").value;
	 // alert(formule);
	  if(formule==1){document.getElementById('coemp').style.visibility='hidden';}
	   if(formule==2){document.getElementById('coemp').style.visibility='visible';}
	  
	}
function vtar(user){
var capital=document.getElementById("cap").value;
var dure=document.getElementById("per").value;
var date1=document.getElementById("dnaisemp");
var formule=document.getElementById("frm").value;
var date2=null,sal1=null,sal2=null,age=null,age2=null;
date2=document.getElementById("dnaiscoemp");
sal1=document.getElementById("sal1").value;
sal2=document.getElementById("sal2").value;
 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 
	if(capital && formule && dure && date1){ 
	if(formule==1){
	if(isNaN(capital) != true && capital <=100000000){
	 if(verifdate1(date1)){
	  age=calage(date1);
	  
	   xhr.open("GET", "php/tarif/rtimmo.php?age="+age+"&dure="+dure+"&capital="+capital, false);
       xhr.send(null);
       alert(xhr.responseText);
	}
	
    }else{alert("Veuillez Remplir un montant inferieur a 100 000 000 DA!");
	document.getElementById("cap").value="";
	}
	}
	if(formule==2){
	//*******
	if(isNaN(capital) != true && capital <=100000000 && isNaN(sal1) != true && isNaN(sal2) != true){
	 if(verifdate1(date1) && verifdate1(date2)){
	  age=calage(date1);age2=calage(date2);
	 var win = window.open("php/tarif/rtimmoco.php?age="+age+"&dure="+dure+"&capital="+capital+"&age2="+age2+"&sal1="+sal1+"&sal2="+sal2, "window1", "resizable=0,width=700,height=600");
     win.focus();
	// alert(age2);
	}
	
    }else{alert("Veuillez Remplir un montant inferieur a 100 000 000 DA!");
	document.getElementById("cap").value="";
	}
	
	
	//*****************
	}
	
  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  
}		
</script>	