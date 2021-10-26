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
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE cod_per >'3' AND cod_per <='20' ORDER BY `cod_per`");
$rqtper->execute();
//Profession
$rqtpro=$bdd->prepare("SELECT * FROM `profession`  WHERE cod_cls='2'");
$rqtpro->execute();
 ?>
<div id="content-header">
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Temporaire-Au-Deces</a> <a class="current">Simulateur</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
             <div class="control-group">
              <div class="controls">
               <input type="text" id="stdccap" class="span3" placeholder="Capital DC-IPP (DZD)" />
				 <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>
					
              </div>
            </div>		
			<div class="control-group"> 
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="dnaisstd" placeholder="D-Naissance JJ/MM/AAAA"/> 
				 
				   				
              </div>
			  </div>
			   <div class="control-group">
              <div class="controls">
              <select id="prostd">
				<option value="">-- Profession (*)</option>
				<?php while ($row_res1=$rqtpro->fetch()){  ?>
                  <option value="<?php  echo $row_res1['cod_cls']; ?>"><?php  echo $row_res1['lib_prof']; ?></option>
                  <?php } ?>
                </select>
					
              </div>
            </div>		
			  	
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="vtartd('<?php echo $id_user; ?>')" value="Voir le Tarif" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','asstd.php')" value="Retour" />
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
function vtartd(user){
var capital=document.getElementById("stdccap").value;
var classe=document.getElementById("prostd").value;
var date1=document.getElementById("dnaisstd");
var age=null;
 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }



	if(capital && classe && date1){ 
	if(isNaN(capital) != true && capital <=3000000 && capital >= 100000){
	
	
	 if(verifdate1(date1)){
	  age=calage(date1);
	  //alert(age);
	   xhr.open("GET", "php/tarif/rttd.php?age="+age+"&cap="+capital+"&classe="+classe, false);
xhr.send(null);
alert(xhr.responseText);
	  
	// var win = window.open("php/tarif/rttd.php?age="+age+"&cap="+capital+"&classe="+classe, "window1", "resizable=0,width=700,height=600");
     //win.focus();
	}
	
	 	
    }else{alert("Veuillez Remplir un montant comprit Entre 100 000 et 3 000 000 DA !");
	document.getElementById("stdcap").value="";
	}
	
  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  
}		
</script>	