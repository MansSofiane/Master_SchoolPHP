<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
//Periode
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE  trt_per >='1'   ORDER BY `cod_per`");
$rqtper->execute();
$rqttyp=$bdd->prepare("SELECT * FROM `type_sous`  WHERE 1 ");
$rqttyp->execute();
$rqtopt=$bdd->prepare("SELECT * FROM `option`  WHERE  cod_opt = '22' OR cod_opt >= '30'");// OR cod_opt ='25' 
$rqtopt->execute();
$rqtzone=$bdd->prepare("SELECT * FROM `pays`  WHERE 1 ");
$rqtzone->execute();
 ?>
<div id="content-header">
     <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyave</a> <a>Formule-Individuelle</a> <a class="current">Simulateur</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <div class="controls">
               <select id="tsoussind">
				<option value="">-- Type-Souscripteur (*)</option>
				<?php while ($row_res=$rqttyp->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_tsous']; ?>"><?php  echo $row_res['lib_tsous']; ?></option>
                  <?php } ?>
                </select>
				&nbsp;&nbsp;&nbsp;&nbsp;
                  <select id="optsind" onchange="hadjetomra()">
                      <option value="">-- Option (*)</option>
                      <?php while ($row_res=$rqtopt->fetch()){  ?>
                          <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                      <?php } ?>
                  </select>

				&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="zonesind" onchange="hadjetomra()">
				<option value="">-- Pays (*)</option>
				<?php while ($row_res=$rqtzone->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_pays']; ?>"><?php  echo $row_res['lib_pays']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			<div class="control-group"> 
			
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
                     <select id="persind" onchange="hadjetomra()">
                         <option value="">-- Duree (*)</option>
                         <?php while ($row_res=$rqtper->fetch()){  ?>
                             <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                         <?php } ?>
                     </select>
				  &nbsp;&nbsp;&nbsp;&nbsp;
				   <input type="text" class="date-pick dp-applied"  id="dnaissind" placeholder="D-Naissance JJ/MM/AAAA" onblur="verifierdais(this)"/>
				   <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>	
              </div>
			  </div>		
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="vtar('<?php echo $id_user; ?>')" value="Voir le Tarif" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoyind.php')" value="Retour" />
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

function hadjetomra()
{
    var dure=document.getElementById("persind").value;
    var opt=document.getElementById("optsind").value;
    var zone=document.getElementById("zonesind").value;

    if(opt ) {
        if (opt == 30) {
            document.getElementById("zonesind").value = "SA";
           document.getElementById("persind").value = '';
           // document.getElementById("persind").style.visibility = "hidden";
            document.getElementById("persind").options[0].text ="40 jours";
        }
        else {
            if (opt == 31) {
                document.getElementById("zonesind").value = "SA";
              document.getElementById("persind").value = '';
                document.getElementById("persind").options[0].text ="21 jours";
            }
            else
            {
                if (opt == 25) {


                    document.getElementById("persind").options[0].text = "1 Mois";
                    document.getElementById("persind").disabled=true;
                    document.getElementById("persind").options[0].value = "7";

                }
                else
                {

                    document.getElementById("persind").options[0].text ="-- Duree (Jours):";
                    document.getElementById("persind").options[0].value ="";

                }

            }
        }
    }

}

function compdat(dd)
{
    var rcomp=false;
    var bb1=document.getElementById("datsys");
    var aa=new Date(dfrtoen(dd.value));
    var bb=new Date(bb1.value);
    var sec1=bb.getTime();
    var sec2=aa.getTime();
    if(sec2>=sec1){rcomp=true;}
    return rcomp;

}
function verifierdais(dd)
{
    if(verifdate1(dd)) {
        if (compdat(dd)) {
            alert("Date de naissance est superieure a la date du jour");
            document.getElementById("dnaissind").value = '';
        }
    }

}
function vtar(user){
var tsous=document.getElementById("tsoussind").value;
var dure=document.getElementById("persind").value;
var date=document.getElementById("dnaissind");
var opt=document.getElementById("optsind").value;
var zone=document.getElementById("zonesind").value;
var age=null;


    if (window.XMLHttpRequest)
    {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if(opt)
    {
        if(opt=="30")
        {
            dure="18";
        }
        if(opt=="31")
        {
            dure="5";
        }
        if (opt=="25")
        {
            dure="7";
            if (zone!="TN" && zone!="TR")
            {
                alert ("Cette option est reservee uniquement pour la Tunisie et la Turquie");
                document.getElementById("zonesind").value = "";
                return;

            }

        }

    }
	if(tsous && dure  && opt && zone){ 
	
	 if(verifdate1(date)){
	  age=calage(date);

         xhr.open("GET","php/tarif/voyage/rtvoyind.php?age="+age+"&dure="+dure+"&opt="+opt+"&tsous="+tsous+"&zone="+zone, false);
         xhr.send(null);
         alert(xhr.responseText);
	}
	
    
  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  
}		
</script>	