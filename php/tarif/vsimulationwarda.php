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
$rqtper=$bdd->prepare("SELECT * FROM `option`  WHERE cod_opt >='5' AND cod_opt <='6' ORDER BY `cod_opt`");
$rqtper->execute();
 ?>
<div id="content-header">
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>WARDA</a> <a class="current">Simulateur-Tarifs</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
			<div class="control-group"> 
              <label class="control-label">Date-Naissance:</label>
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="dnaisempw" placeholder="Format date JJ/MM/AAAA"/> 
				  <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>
				 &nbsp;&nbsp;&nbsp;&nbsp;
				<select id="optw">
				<option value="">-- Option (*)</option>
				<?php while ($row_res=$rqtper->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                  <?php } ?>
                </select>
              </div>
			  </div>		
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="vtar('<?php echo $id_user; ?>')" value="Voir le Tarif" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assward.php')" value="Retour" />
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

function vtar(user){
var opt=document.getElementById("optw").value;
var date1=document.getElementById("dnaisempw");

     if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }

	if(opt && date1){ 	
	 if(verifdate1(date1)){
	  age=calage(date1);
	  xhr.open("GET", "php/tarif/rtwarda.php?age="+age+"&opt="+opt, false);
xhr.send(null);
alert(xhr.responseText);
	// var win = window.open("php/tarif/rtwarda.php?age="+age+"&opt="+opt, "window1", "resizable=0,width=700,height=600");
    // win.focus();
	}
	
	
  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  
}		
</script>	