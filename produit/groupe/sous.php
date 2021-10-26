<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['login']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_user'];
$toktd1 = generer_token('sous');
$datesys=date("Y-m-d");
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a>Assurance-Groupe</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a class="current"><i></i>Souscripteur</a><a>Assure</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <div class="controls">
                <select id="civ"class="span4">
                                    <option value="">--Forme Jurdique(*)</option>
                                    <option value="SARL">SARL</option>
                                    <option value="EURL">EURL</option>
                                    <option value="SPA">SPA</option>
                                    <option value="SNC">SNC</option>

                                </select>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" id="nsous" class="span4" placeholder="Raison sociale (*)" /> &nbsp;&nbsp;&nbsp;
                <!--<input type="text" id="rc" class="span4" placeholder="Registre de commerce" />  -->
              </div>
                <div class="controls">
                    <input type="number" id="nbre" placeholder="nombre adherents" class="span4"  min="1" name="adh"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" id="adrsous" class="span4" placeholder="Adresse (*)" />
                </div>
            </div>

			 <div class="control-group">
              <div class="controls">
                  <input type="text" id="csous" class="span4" placeholder="Interlocuteur" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" id="mailsous" class="span4" placeholder="mail Interlocuteur" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </div>
                 <div class="controls">
                      <input type="text" id="telsous" class="span4" placeholder="T&eacute;l&eacute;phone  Interlocuteur " onkeypress="return isNumber(event)"   />
                 </div>
             </div>
              <div class="control-group">
             <div class="controls" data-date-format="dd/mm/yyyy"   >
                <input type="text" id="primeN" class="span4" placeholder="Prime nette (*)" onkeypress="return isNumberKey(event)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" id="coutP" class="span4" placeholder="cout de police (*)" onkeypress="return isNumberKey(event)" />
              </div>     
              <div class="controls" data-date-format="dd/mm/yyyy" >
                <input type="text" id="droit" class="span4" placeholder="droit de timbre (*)" onkeypress="return isNumberKey(event)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="date-pick dp-applied"  id="deff" placeholder=" Date effet Format date JJ/MM/AAAA"  onblur="verifdate3(this)"/>
               </div>
              </div>
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="TESTInsertion('<?php echo $id_user; ?>','<?php echo $toktd1; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assgroupe.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>


<script language="JavaScript">initdate();</script>
<script language="JavaScript">





function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
 $("#primeN").keypress(function(eve) {
  if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
    eve.preventDefault();
  }
     
// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
 $("#primeN").keyup(function(eve) {
  if($(this).val().indexOf('.') == 0) {    $(this).val($(this).val().substring(1));
  }
 });
});




function TESTInsertion(user,tok) {  


  var civilite = document.getElementById("civ").value;
  var nom = document.getElementById("nsous").value;
  var adr = document.getElementById("adrsous").value;
  mail = null, tel = null; 
  var dateff=document.getElementById("deff");
  var primeN1 = null ;
  var coutP1 = null ;
  var droit1 = null ;
  var datech=null;
  mail = document.getElementById("mailsous").value;
  tel = document.getElementById("telsous").value;
  var primeN = document.getElementById("primeN").value;
  var coutP  = document.getElementById("coutP").value;
  var droit  = document.getElementById("droit").value;
  var inter= document.getElementById("csous").value;
  var nbassur = document.getElementById("nbre").value;
  var civ =   document.getElementById("civ").value;
  var primeN1 =document.getElementById("primeN").value;
  var coutP1 =document.getElementById("coutP").value;
  var droit1= document.getElementById("droit").value; 
  if(verifdate(dateff)){
    datech=dfrtoen2(addDays(dateff.value,365));
    dateff=dfrtoen2(dateff.value); 
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
      }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
  if (civ && nom && adr && parseFloat(primeN1)  >0 && !isNaN(coutP1)  && !isNaN(droit1) ) 
  {
        xhr.open("GET", "produit/groupe/nsous.php?&noms=" + nom + "&nbassur=" + nbassur +"&primeN1=" + primeN1 +"&coutP1=" + coutP1 +"&droit1=" + droit1 + "&civ=" + civ +"&int="+inter+ "&d1="+dateff+"&d2="+datech + "&adrs=" + adr + "&mails=" + mail + "&tels=" + tel +"&tok=" + tok, false);
        xhr.send(null);
        swal("F\351licitation !"," insertion effectu\351e  (*) !", "success");
            $("#content").load("produit/assgroupe.php?tok=" + tok);
  } 
  else 
    {
       swal("Alerte !","Veuillez remplir tous les champs Obligatoire (*) !","warning");
    }
  }  
}
function dfrtoen_grpe(date1)
    {
        var split_date=date1.split('/');
        var new_d=new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
        var new_day = new_d.getDate();
        new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un z�ro devant pour la forme
        var new_month = new_d.getMonth() + 1;
        new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un z�ro devant pour la forme
        var new_year = new_d.getYear();
        new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
        var new_date_text = new_year + '-' + new_month + '-' + new_day;
        return new_date_text;
    }
function verifdate(dd)
    {
        v1=true;
        var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
        var test = regex.test(dd.value);
        if(!test){
            v1=false;
            swal("Erreur !","Format date incorrect!  jj/mm/aaaa", "error");dd.value="";

        }
        return v1;
    }
function verifdate3(dd)
    {
        var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
        var test = regex.test(dd.value);
        if(test){
        var dd1=new Date(dfrtoen2(dd.value));
        var Now = new Date();
        Now.setHours(0);
        Now.setMinutes(0);
        Now.setSeconds(0)
        dd1.setHours(1);
        dd1.setMinutes(0);
        dd1.setSeconds(0)
       /* if (dd1.getTime() < Now.getTime()){
            swal("Alerte !","la date ne doit pas \352tre inf\351rieure \340 la date d'aujourd'hui!","warning");
        dd.value="";
           }
     */
     }else{swal("Erreur !","Format date incorrect! jj/mm/aaaa", "error");dd.value="";}
    }


    function addDays(dd,xx) {
        // Date plus plus quelques jours
        var split_date = dd.split('/');
        var new_date = new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1 + parseInt(xx)-1);
        var dd= new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
        var new_day = new_date.getDate();
        new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un z�ro devant pour la forme
        var new_month = new_date.getMonth() + 1;
        new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un z�ro devant pour la forme
        var new_year = new_date.getYear();
        new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
        var new_date_text = new_day + '/' + new_month + '/' + new_year;
        return new_date_text;
    }

    function dfrtoen2(date1)
    {
        var split_date=date1.split('/');
        var new_d=new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
        var new_day = new_d.getDate();
        new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un z�ro devant pour la forme
        var new_month = new_d.getMonth() + 1;
        new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un z�ro devant pour la forme
        var new_year = new_d.getYear();
        new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
        var new_date_text = new_year + '-' + new_month + '-' + new_day;
        return new_date_text;
    }
function compda9(dd)
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

$("#coutP").keypress(function(eve) {
  if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
    eve.preventDefault();
  }
     
// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
 $("#coutP").keyup(function(eve) {
  if($(this).val().indexOf('.') == 0) {    $(this).val($(this).val().substring(1));
  }
 });
});
$("#droit").keypress(function(eve) {
  if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
    eve.preventDefault();
  }
     
// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
 $("#droit").keyup(function(eve) {
  if($(this).val().indexOf('.') == 0) {    $(this).val($(this).val().substring(1));
  }
 });
});




	
</script>	