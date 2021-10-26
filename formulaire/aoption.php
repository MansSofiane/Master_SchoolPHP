<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouvelle-Option</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Option</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Opion *:</label>
              <div class="controls">
                <input type="text" id="libopt" class="span7" placeholder="Lib ..." />
              </div>
            </div>
           <div class="control-group">
              <label class="control-label">Date-Effet</label>
              <div class="controls">
                  <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="effopt"/>
                  <span class="add-on"><i class="icon-th"></i></span> 
				  </div>
              </div>           
            </div>
			 <div class="control-group">
              <label class="control-label">Date-Echeance</label>
              <div class="controls">
                  <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="echopt"/>
                  <span class="add-on"><i class="icon-th"></i></span> 
				  </div>
              </div>           
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="insopt('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','options.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
// Format date ******************************************
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
// Verification du format de la date
function verifdate(dd1,dd2)
{
var dd3=new Date(dfrtoen(dd1.value));
var dd4=new Date(dfrtoen(dd2.value));
if (dd4.getTime() < dd3.getTime()){
v2=false;
alert("la date Echeance doit pas etre inferieur a la Date Effet !");
dd1.value="";dd2.value="";

}
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
//*******************
//***********************
function insopt(user){
var libopt=document.getElementById("libopt").value;
var effopt=document.getElementById("effopt");
var echopt=document.getElementById("echopt");

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 //verifdate1(echopt);
     verifdate1(effopt);
	 verifdate1(echopt);
	 verifdate(effopt,echopt);
     if(libopt && effopt.value && echopt.value){ 
	 var effopte=dfrtoen(effopt.value);	
     var echopte=dfrtoen(echopt.value); 
	 xhr.open("GET", "php/insert/noption.php?libopt="+libopt+"&effopte="+effopte+"&echopte="+echopte+"&user="+user, false);
     xhr.send(null);
	// alert(xhr.responseText);
	 alert("Option Introduite !");
	 Menu2('param','options.php');
	 }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  
	}	
			
</script>	