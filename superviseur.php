<?php session_start();
if ($_SESSION['loginsal'] && $_SESSION['Role'] == "sp"){
}
else {
header("Location:index.html");
}
$datesys=date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>SIGMA</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="css/jquery.gritter.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/bootstrap-wysihtml5.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/colorpicker.css" />
<script src="js/excanvas.min.js"></script> 
<script src="js/jquery.flot.min.js"></script> 
<script src="js/jquery.flot.resize.min.js"></script> 
<script src="js/jquery.peity.min.js"></script>
<script src="js/fullcalendar.min.js"></script> 
<script src="js/matrix.calendar.js"></script> 
<script src="js/matrix.chat.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/matrix.form_validation.js"></script> 
<script src="js/jquery.wizard.js"></script>  
<script src="js/matrix.popover.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.tables.js"></script> 
<script src="js/matrix.interface.js"></script>
<script src="js/jquery.toggle.buttons.js"></script> 
<script src="js/masked.js"></script> 
<script src="js/bootstrap-wysihtml5.js"></script> 
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/bootstrap-colorpicker.js"></script> 
<script src="js/bootstrap-datepicker.js"></script>  
<script src="js/masked.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.form_common.js"></script> 
<script src="js/wysihtml5-0.3.0.js"></script>
<script src="js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery/date.js" type="text/javascript"></script>
<script src="js/jquery/jquery.datePicker.js" type="text/javascript"></script>
</head>
<body>
<div id="header">
<img src="img/logo.png" width="220" >
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
   <!--
	 <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> Nouveau message</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> Boite-Reception</a></li>
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> Boite-envois</a></li>
      </ul>
    </li>-->
    <li  class="dropdown" id="profile-messages2" ><a data-toggle="dropdown" data-target="#profile-messages2" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Bienvenue- <?php echo $_SESSION['nomsal']?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a onClick="Menu('macc','php/cmpt/scmpt.php')"><i class="icon-user"></i> Compte</a></li>
          <li class="divider"></li>
        <li><a href="index.html" onClick="disconnect()" ><i class="icon-key"></i> Deconnexion</a></li>
      </ul>
    </li>
  </ul>
</div>
<!--close-top-Header-menu-->
<!--sidebar-menu-->
<div id="sidebar">
   <ul><input type="hidden" id="datsys" value="<?php echo $datesys; ?>"/>
    <li  id="macc" class="active"><a onClick="sMenu1('macc','../sdash.php')"><i class="icon icon-home"></i> <span>Acceuil</span></a> </li>
	<!-- <li id="param" class="submenu"> <a><i class="icon icon-cog"></i> <span>Parametres</span> <span class="label label-important">3</span></a>
      <ul> 
	    <li><a onClick="Menu2('param','garanties.php')">&nbsp;&nbsp;&nbsp;&nbsp;Garanties</a></li>
		<li><a onClick="Menu2('param','classes.php')">&nbsp;&nbsp;&nbsp;&nbsp;Classes</a></li>
		<li><a onClick="Menu2('param','professions.php')">&nbsp;&nbsp;&nbsp;&nbsp;Professions</a></li>
		
      </ul>
    </li>-->
	 <li id="prod" class="submenu"> <a><i class="icon icon-th-list"></i> <span>Produits-Assurance</span> <span class="label label-important">5</span></a>
      <ul>
        <li><a onClick="sMenu1('prod','assvoy.php')">&nbsp;&nbsp;&nbsp;&nbsp;Assurance-Voyage</a></li>
		<li><a onClick="sMenu1('prod','polasstd.php')">&nbsp;&nbsp;&nbsp;&nbsp;Temporaire-Deces</a></li>
		<li><a onClick="sMenu1('prod','polasscim.php')">&nbsp;&nbsp;&nbsp;&nbsp;A-Deces-Emprunteur</a></li>
		<li><a onClick="sMenu1('prod','assiacc.php')">&nbsp;&nbsp;&nbsp;&nbsp;Individuel-Accident</a></li>
       <!-- <li><a onClick="Menu1('prod','assccon.php')">&nbsp;&nbsp;&nbsp;&nbsp;ADE-consommation</a></li>-->
		<li><a onClick="sMenu1('prod','polassward.php')">&nbsp;&nbsp;&nbsp;&nbsp;Cancer du Sein Warda</a></li>
      </ul>
    </li>
	<!--  
	 <li id="mclt" class="submenu" class="submenu" >  <a ><i class="icon icon-user"></i> <span>Clients</span><span class="label label-important"></span><span class="label label-important">2</span></a> 
	   <ul>
        <li><a onClick="Menu3('mclt','souscripteur.php')">&nbsp;&nbsp;&nbsp;&nbsp;Souscripteurs</a></li>
        <li><a onClick="Menu3('mclt','assure.php')">&nbsp;&nbsp;&nbsp;&nbsp;Assures</a></li>
      </ul>
	  </li>   
	 
    <li id="msin"><a  onClick=""><i class="icon icon-info-sign"></i> <span>Sinistres</span></a></li>
    <li id="mged"><a onClick="Menu1('mged','ged.html')"><i class="icon icon-file"></i> <span>Documents</span></a></li>-->
       <li id="mstat" class="submenu" class="submenu" >  <a ><i class="icon icon-signal"></i> <span>Etats-Production</span><span class="label label-important"></span><span class="label label-important">2</span></a> 
	   <ul>
        <li> <a onClick="sMenu1('mstat','stat.php')"><span>Etat-PDF</span></a> </li> 
	    <li> <a onClick="sMenu1('mstat','astatex.php')"><span>Etat-EXCEL</span></a> </li> 
      </ul>
	  </li> 
	<li id="mstat"> <a href="index.html" onClick="disconnect()" ><span>Deconnexion</span></a> </li> 
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<script>$("#content").load('sdash.php');</script>
</div>
</body>
</html>
<script type="text/javascript">
function Menu(id,page) {
document.getElementById('macc').setAttribute("class", "hover");
document.getElementById('mstat').setAttribute("class", "hover");
document.getElementById('prod').setAttribute("class", "hover");
document.getElementById(id).setAttribute("class", "active");
$("#content").load(page);
}
function sMenu1(id,page) {
document.getElementById('macc').setAttribute("class", "hover");
document.getElementById('mstat').setAttribute("class", "hover");
document.getElementById('prod').setAttribute("class", "hover");
document.getElementById(id).setAttribute("class", "active");
$("#content").load('sp/'+page);
}
function aform(page) {
$("#content").load('formulaire/'+page);
}
function disconnect() {
if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
 xhr.open("GET", "php/disconnect.php", false);
 xhr.send(null);
}
function initdate(){
Date.firstDayOfWeek = 0;
Date.format = 'dd/mm/yyyy';
$(function()
{$('.date-pick').datePicker({startDate:'01/01/1930'});});
}
function atarif(id,page) {
document.getElementById('macc').setAttribute("class", "hover");
document.getElementById('mstat').setAttribute("class", "hover");
document.getElementById('prod').setAttribute("class", "hover");
document.getElementById(id).setAttribute("class", "active");
$("#content").load('php/tarif/'+page);
}
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
function compdat2(dd)
{ 
   var rcomp=false;
   var bb1=document.getElementById("datsys");
   var aa=new Date(dd);
   var bb=new Date(bb1.value);
   var sec1=bb.getTime();
   var sec2=aa.getTime(); 
   if(sec2>=sec1){rcomp=true;}
return rcomp;

}
function addDays(dd,xx) {
   // Date plus plus quelques jours
   var split_date = dd.split('/');
   var new_date = new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1 + parseInt(xx)-1);
   var dd= new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
   var new_day = new_date.getDate();
       new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un zéro devant pour la forme
   var new_month = new_date.getMonth() + 1;
       new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un zéro devant pour la forme
   var new_year = new_date.getYear();
       new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
   var new_date_text = new_day + '/' + new_month + '/' + new_year; 
   return new_date_text;
}


function condition_generale_AVA()
{
    var win = window.open("doc/CG-AVA.pdf", "window7", "resizable=0,width=700,height=600");
    win.focus();
}

function condition_generale_ADE()
{
    var win = window.open("doc/CG-ADE.pdf", "window8", "resizable=0,width=700,height=600");
    win.focus();
}

function raport_med_compl_ADE()
{
    var win = window.open("doc/Rapport-medical-ADE.pdf", "window11", "resizable=0,width=700,height=600");
    win.focus();
}
function condition_generale_IA()
{
    var win = window.open("doc/CG-Accidents-CorporelsIA.pdf", "window9", "resizable=0,width=700,height=600");
    win.focus();
}

function tab_classe_IA()
{
    var win = window.open("doc/Table-classes-prof-IA.pdf", "window10", "resizable=0,width=700,height=600");
    win.focus();
}
function condition_generale_WR()
{
    var win = window.open("doc/CG-warda.pdf", "window10", "resizable=0,width=700,height=600");
    win.focus();
}

function quespdfc(){
var win = window.open("doc/questionnaire-comp.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}
function quespdf(){
var win = window.open("doc/questionnaire.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}	
function profpdf(){
var win = window.open("doc/profession-a-risque.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}	
function cexel(){
var win = window.open("doc/file/Chargement.html", 'Devis', 'height=200, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
win.focus();
}
function listexlx()
{
//alert("OK");
window.open('doc/file/Fichier-En-Cours.html', 'Devis', 'height=400, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); 

}
function listexlxa()
{
//alert("OK");
window.open('doc/file/Fichier-Archives.html', 'Devis', 'height=400, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); 

}

function adev(id,page,codedev){

 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
     var ok=confirm("Comfirmez Accord du devis ");
	 if (ok){   
      xhr.open("GET", "php/validation/accord.php?code="+codedev, false);
      xhr.send(null); 
	  alert("Demande Accordee !");
	  aMenu1(id,page);	
		}
		
	}
function surprime(id,page,codedev,pn)
{
    $("#content").load("adm/surprime.php?id="+id+"&page="+page+"&cod_dev=" + codedev + "&prime=" + pn  );


}
function rdev(id,page,codedev){

 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
     var ok=confirm("Comfirmez Rejet du devis ");
	 if (ok){   
      xhr.open("GET", "php/validation/refu.php?code="+codedev, false);
      xhr.send(null); 
	  alert("Demande rejetee !");
	  aMenu1(id,page);	
		}
		
	}		
function ndevwar(){
        $("#content").load('produit/warda/devwar.php');
	}	
function ndevind(){
        $("#content").load('produit/iaccid/devind.php');
	}
function ndevindg(){
        $("#content").load('produit/iaccidg/devindg.php');
	}	
function ndevtd(){
        $("#content").load('produit/td/devtd.php');
	}
function ndevade(){
        $("#content").load('produit/ade/devade.php');
	}			

function alav(codepol,page){ 
	  $("#content").load('adm/'+page+'?code='+codepol);
	}	
		
</script>