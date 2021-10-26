<?php 
session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
//Periode
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE  trt_per >='1' and cod_per not in ('5','18') ORDER BY `cod_per`");
$rqtper->execute();
$rqttyp=$bdd->prepare("SELECT * FROM `type_sous`  WHERE 1 ");
$rqttyp->execute();
$rqtopt=$bdd->prepare("SELECT * FROM `option`  WHERE  cod_opt ='22'");// OR cod_opt ='25' 
$rqtopt->execute();
$rqtzone=$bdd->prepare("SELECT * FROM `pays`  WHERE 1 ");
$rqtzone->execute();
 ?>
<div id="content-header">
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyave</a> <a>Formule-Couple</a> <a class="current">Simulateur</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <div class="controls">
               <select id="tsousscpl">
				<option value="">-- Type-Souscripteur (*)</option>
				<?php while ($row_res=$rqttyp->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_tsous']; ?>"><?php  echo $row_res['lib_tsous']; ?></option>
                  <?php } ?>
                </select>
				&nbsp;&nbsp;&nbsp;&nbsp;
                  <select id="optscpl" onchange="option()">
                      <option value="">-- Option (*)</option>
                      <?php while ($row_res=$rqtopt->fetch()){  ?>
                          <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                      <?php } ?>
                  </select>
				
              </div>
            </div>
			<div class="control-group"> 
			 <div class="controls">
				<select id="zonescpl">
				<option value="">-- Pays (*)</option>
				<?php while ($row_res=$rqtzone->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_pays']; ?>"><?php  echo $row_res['lib_pays']; ?></option>
                  <?php } ?>
                </select>
				&nbsp;&nbsp;&nbsp;&nbsp;
                 <select id="perscpl">
                     <option value="">-- Duree (*)</option>
                     <?php while ($row_res=$rqtper->fetch()){  ?>
                         <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                     <?php } ?>
                 </select>

				</div>
			</div>
			<div class="control-group">  
			<label class="control-label">D-Naissance des Assures :</label>  
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				 
				  <input type="text" class="date-pick dp-applied"  id="dnaisscpl1" placeholder="Assure-1 JJ/MM/AAAA"/> 
				  &nbsp;&nbsp;&nbsp;&nbsp;
				   <input type="text" class="date-pick dp-applied"  id="dnaisscpl2" placeholder="Assure-2 JJ/MM/AAAA"/> 
				   <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>	
              </div>
			  </div>		
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="vtarcpl('<?php echo $id_user; ?>')" value="Voir le Tarif" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoycpl.php')" value="Retour" />
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


function option()
{

    if(document.getElementById("optscpl").value==25){

        document.getElementById("perscpl").options[0].text ="1 Mois";
        document.getElementById("perscpl").disabled=true;
        document.getElementById("perscpl").options[0].value =7;//cod_per=4 correspond au 30 jours
        document.getElementById("zonescpl").options[0].text ="-- Pays (*)";
        document.getElementById("zonescpl").options[0].value ="";
        document.getElementById("perscpl").selectedIndex=0;
        document.getElementById("zonescpl").selectedIndex=0;
        // document.getElementById("perscpl").disabled = true;
        // document.getElementById("zonescpl").disabled = true;
        // document.getElementById("nbpf").options[0].text ="--";
        // document.getElementById("nbpf").options[0].value ="";
    }else{


        document.getElementById("perscpl").options[0].text = "-- Duree (Jours):";
        document.getElementById("perscpl").options[0].value = "";
        document.getElementById("zonescpl").options[0].text = "-- Pays (*)";
        document.getElementById("zonescpl").options[0].value = "";
        // document.getElementById("nbpf").options[0].text ="";
        // document.getElementById("nbpf").options[0].value ="";
        document.getElementById("perscpl").disabled = false;
        document.getElementById("zonescpl").disabled = false;

    }

}

function vtarcpl(user) {
    var tsous = document.getElementById("tsousscpl").value;
    var dure = document.getElementById("perscpl").value;
    var date1 = document.getElementById("dnaisscpl1");
    var date2 = document.getElementById("dnaisscpl2");
    var opt = document.getElementById("optscpl").value;
    var pays = document.getElementById("zonescpl").value;
    //  alert("tsous="+tsous+" dure="+dure+" date1="+date1.value+" date2="+date2.value+" option="+opt+" pays="+pays);
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var age1 = null, age2 = null;

    if (tsous && dure && opt && pays) {
        if(opt==25)
        {
            if (pays!="TN" && pays!="TR")
            {
                alert ("Cette option est reservee uniquement pour la Tunisie et la Turquie");
                document.getElementById("zonescpl").value = "";
                return;

            }

        }

        if (verifdate1(date1) && verifdate1(date2)) {
            age1 = calage(date1);
            age2 = calage(date2);

            xhr.open("GET", "php/tarif/voyage/rtvoycpl.php?age1=" + age1 + "&age2=" + age2 + "&dure=" + dure + "&opt=" + opt + "&tsous=" + tsous + "&pays=" + pays, false);
            xhr.send(null);
            alert(xhr.responseText);
        }

    } else {
        alert("Veuillez Remplir tous les champs obligatoire (*) !");
    }

}
</script>	