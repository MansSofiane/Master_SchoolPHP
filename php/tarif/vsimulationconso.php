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
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE id_user='$id_user' AND cod_per >='20' AND cod_per <='24' ORDER BY `cod_per`");
$rqtper->execute();
 ?>
<div id="content-header">
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>ADE-Consommation</a> <a class="current">Simulateur-Tarifs</a> </div>
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
                <input type="text" id="capc" class="span4" placeholder="Capital Maximum est 3 000 000 DA" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="perc">
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
				  <input type="text" class="date-pick dp-applied"  id="dnaisempc" placeholder="D-Naissance JJ/MM/AAAA"/> 
				  <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>	
              </div>
			  </div>			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="vtarc('<?php echo $id_user; ?>')" value="Voir le Tarif" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assccon.php')" value="Retour" />
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
function vtarc(user){
var capital=document.getElementById("capc").value;
var dure=document.getElementById("perc").value;
var date1=document.getElementById("dnaisempc");
var age=null;
	if(capital && dure && date1){ 
	if(isNaN(capital) != true && capital <=3000000){
	
	 if(verifdate1(date1)){
	  age=calage(date1);
	  
	 // alert(age+" "+dure+" "+capital);
	 var win = window.open("php/tarif/rtconso.php?age="+age+"&dure="+dure+"&capital="+capital, "window1", "resizable=0,width=700,height=600");
     //win.focus();
	}
	
    }else{alert("Veuillez Remplir un montant inferieur a 3 000 000 DA!");
	document.getElementById("capC").value="";
	}
  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  
}		
</script>	