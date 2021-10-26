<?php session_start();
require_once("../../data/conn7.php");
$token = generer_token('acc');
if ($_SESSION['loginsal'] && $_SESSION['Role'] == "user"){
}
else {
header("Location:index.html");
}
$datesys=date("Y-m-d");
//echo "<script type="."'text/JavaScript'"."> alert("."'$datesys'".");  </script>"; 
$test=20;
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
<link  href="css/sweetalert.min.css" rel="stylesheet" />
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
<script src="js/jquery.flot.pie.min.js"></script> 
<script src="js/matrix.charts.js"></script> 
<script src="js/matrix.dashboard.js"></script>

<script src="js/swal.js"> </script>

</head>
<body>
<!--Header-part-->
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
        <li><a onClick="Menu('macc','php/cmpt/cmpt.php')"><i class="icon-user"></i> Compte</a></li>
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
    <li  id="macc" class="active"><a onClick="Menu('macc','dash.php')"><i class="icon icon-home"></i> <span>Acceuil</span></a> </li>
	 <li id="prod" class="submenu"> <a><i class="icon icon-th-list"></i> <span>Produits-Assurance</span> <span class="label label-important">5</span></a>
      <ul>
        <li><a onClick="Menu1('prod','assvoy.php')">&nbsp;&nbsp;&nbsp;&nbsp;Assurance-Voyage</a></li>
		<li><a onClick="Menu1('prod','asstd.php')">&nbsp;&nbsp;&nbsp;&nbsp;Temporaire-Deces</a></li>
		<li><a onClick="Menu1('prod','asscim.php')">&nbsp;&nbsp;&nbsp;&nbsp;A-Deces-Emprunteur</a></li>
		<li><a onClick="Menu1('prod','assiacc.php')">&nbsp;&nbsp;&nbsp;&nbsp;Individuel-Accident</a></li>
		<li><a onClick="Menu1('prod','assward.php')">&nbsp;&nbsp;&nbsp;&nbsp;Cancer du Sein Warda</a></li>
      </ul>
    </li>
	 
	 <li id="avoy" class="submenu" class="submenu" >  <a ><i class="icon icon-fullscreen"></i> <span>Convention-A-Voyage</span><span class="label label-important"></span><span class="label label-important">2</span></a> 
	   <ul>
        <li><a onClick="Menu1('avoy','new_agence.php')">&nbsp;&nbsp;&nbsp;&nbsp;Nouvelle-Convention</a></li>
        <li><a onClick="Menu1('avoy','list_agence.php')">&nbsp;&nbsp;&nbsp;&nbsp;Liste-Conventions</a></li>
      </ul>
	  </li>   
	 
	  <li id="msin" class="submenu" class="submenu">  <a ><i class="icon icon-info-sign"></i> <span>Sinistres</span><span class="label label-important"></span><span class="label label-important">3</span></a> 
	   <ul>
        <li><a onClick="Menu1('msin','sinistre/sinistre1.php')">&nbsp;&nbsp;&nbsp;&nbsp;Declarer-Sinistre</a></li>
        <li><a onClick="Menu1('msin','sinistre/lsinistre1.php')">&nbsp;&nbsp;&nbsp;&nbsp;Sinistre-En-Attente</a></li>
		<li><a onClick="Menu1('msin','sinistre/lsinistre2.php')">&nbsp;&nbsp;&nbsp;&nbsp;Sinistre-Traite</a></li>
      </ul>
	  </li> 
	   <li id="mstat" class="submenu" class="submenu" >  <a ><i class="icon icon-signal"></i> <span>Etats-Production</span><span class="label label-important"></span><span class="label label-important">2</span></a> 
	   <ul>
        <li> <a onClick="Menu1('mstat','stat.php')"><span>Etat-PDF</span></a> </li> 
	    <li> <a onClick="Menu1('mstat','statex.php')"><span>Etat-EXCEL</span></a> </li> 
      </ul>
	  </li>   
    <li id="mged"><a onClick="Menu1('mged','ged.html')"><i class="icon icon-file"></i> <span>Documents</span></a></li>
    
	<li> <a href="index.html" onClick="disconnect()" ><i class="icon icon-inbox"></i><span>Deconnexion</span></a> </li> 
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<script>$("#content").load('dash.php');</script>
</div>
</body>
</html>
<script type="text/javascript">
function Menu(id,page) {
document.getElementById('prod').setAttribute("class", "hover");
document.getElementById('mstat').setAttribute("class", "hover");
document.getElementById('mged').setAttribute("class", "hover");
document.getElementById('macc').setAttribute("class", "hover");
document.getElementById('avoy').setAttribute("class", "hover");
document.getElementById('msin').setAttribute("class", "hover");
document.getElementById(id).setAttribute("class", "active");
$("#content").load(page);
}
function Menu1(id,page) {
var tok='<?php echo $token; ?>';
document.getElementById('macc').setAttribute("class", "hover");
document.getElementById('mstat').setAttribute("class", "hover");
document.getElementById('mged').setAttribute("class", "hover");
document.getElementById('prod').setAttribute("class", "hover");
document.getElementById('avoy').setAttribute("class", "hover");
document.getElementById('msin').setAttribute("class", "hover");
document.getElementById(id).setAttribute("class", "active");
$("#content").load('produit/'+page+'?tok='+tok);
}
function form(page) {
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
function verif(chp)
{

    if ( chp.value == "" )
    {
        alert ( "Champs obligatoire !" );
        document.getElementById(chp.id).focus();
        return;
    }

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
function validepass(pass) {
    var nombre = pass.value;
    var chiffres = new String(nombre);
    // Enlever tous les charact�res sauf les chiffres
    chiffres = chiffres.replace(/[^0-9A-Za-z]/g, '');
    // Le champs est vide
    if ( nombre == "" )
    {
        alert ( "Champs Obligatoire !." );
        pass.value="";
        return;
    }
    // Nombre de chiffres
    compteur = chiffres.length;
    if (compteur!=9)
    {
        alert("Assurez-vous de rentrer un numero a 9 chiffres (xxx-xxx-xxx)");
        pass.value="";
        return;
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
//alert("OK") doc/file/Fichier-Archives.html;
    window.open('doc/file/Fichier-Archives.html', 'Devis', 'height=400, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');

}
function listexlxvoayegroupe()
{
//alert("OK") doc/file/Fichier-Archives.html;
    window.open('produit/voyage/groupe/file/modele_groupe.xlsx', 'groupeexcel', 'height=400, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');

}
function gtd(){
var win = window.open("doc/Guide-TD.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}	
function gwar(){
var win = window.open("doc/Guide-WARDA.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}
function gade(){
var win = window.open("doc/Guide-ADE.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}
function gava(){
var win = window.open("doc/Guide-S-AVA.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}
function gcava(){
var win = window.open("doc/Guide-A-Voyage.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}function Excel_indiv_grp(){
    var win = window.open("doc/excel-groupe.xlsx", "window1", "resizable=0,width=700,height=600");
    win.focus();
}

function giag(){
var win = window.open("doc/Guide-Individuelle-Accident-Groupe.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}
function giaind(){
var win = window.open("doc/Guide-Individuelle-Accident-Individuelle.pdf", "window1", "resizable=0,width=700,height=600");
win.focus();
}
function ddev(id,page,codedev){

 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
     var ok=confirm("Comfirmez la suppression du devis ");
	 if (ok){   
      xhr.open("GET", "php/delete/ddev.php?code="+codedev, false);
      xhr.send(null); 
	  alert("Devis Supprimer !");
	  Menu1(id,page);	
		}
		
	}	
function ndevwar(tok){
        $("#content").load('produit/warda/devwar.php?tok='+tok);
	}	
function ndevind(tok){
    $("#content").load('produit/iaccid/typ_sousc.php?tok='+tok);
}
function ndevindg(tok){
    $("#content").load('produit/iaccidg/typ_sousc.php?tok='+tok);
	}	
function ndevtd(tok){
        $("#content").load('produit/td/devtd.php?tok='+tok);
	}
function ndevade(tok){
        $("#content").load('produit/ade/devade.php?tok='+tok);
	}			
function vdev(codedev,date,page,token){

 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 
	 if(compdat2(date)){
	 
	 var ok=confirm("Comfirmez la Souscription ");
	 if (ok){
	  $("#content").load('php/validation/fval.php?code='+codedev+'&page='+page+'&tok='+token);
      	
		}
	 
	 }else{alert("Date d'effet du devis depasse !");}
		
	}		
function vdevgr(codedev,date,page,token){
    if (window.XMLHttpRequest) 
     { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
    var data = new FormData();
    data.append('code',codedev);
    data.append('page',page);
    data.append('tok',token);
    if(compdat2(date))
    {

     swal({
         title: "Validation !",
         text: "Comfirmez-vous la Souscription ?",
         showCancelButton: true,
         confirmButtonText: 'OUI, Valider!',
         cancelButtonText: "NON, Retourner !",
         type: "info"

     }, function() {
        // $("#content").load('php/validation/fval.php?code='+codedev+'&page='+page+'&tok='+token);
         $("#content").load('php/validation/fvalgrp.php',{code:codedev,page:page,tok:token});
     }); 
    }
    else{swal("Oops..","Date d'effet du devis depasse !","error");}	
}

function vav(codepol,date,page){

 if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 
	 if(compdat2(date)){
	 
	 var ok=confirm("Comfirmez la Souscription-Avenant");
	 if (ok){
	  $("#content").load('php/avenant/fav.php?code='+codepol+'&page='+page);
      	
		}
	 
	 }else{alert("Le Contrat a pris Effet !");
	 }
		
	}
function vavade(codepol,date,page){

    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if(compdat2(date)){
        var ok=confirm("Comfirmez la Souscription-Avenant");
        if (ok){
            $("#content").load('php/avenant/fav.php?code='+codepol+'&page='+page);

        }
    }else{alert("Le Contrat a pris Effet !");
    }

}

function vavvoy(codepol,date,page){

    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

   if(compdat2(date)){

        var ok=confirm("Comfirmez la Souscription-Avenant");
        if (ok){
            $("#content").load('php/avenant/voy/fav.php?code='+codepol+'&page='+page);

        }

    }else{alert("Le Contrat a pris Effet !");
   }

}
function DemandeResiliation(codepol,date,page){

if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
}
if(compdat2(date)){
    var datedujour = 0;
    var ok=confirm("Comfirmez la Demande");
    if (ok){
        $("#content").load('php/avenant/voy/favDemRes.php?code='+codepol+'&page='+page);

    }
}else{alert("Le Contrat a pris Effet !");
}

}
function lav(codepol,page){ 
var tok='<?php echo $token; ?>';
	  $("#content").load('produit/'+page+'?code='+codepol+'&tok='+tok);
}	
function test()
{
    alert('ok');
}

function devgroupe(tok){
    $("#content").load('produit/groupe/sous.php?tok='+tok);
}
function devpta(tok){
    $("#content").load('produit/PTA/sous.php?tok='+tok);
}
function vdev2(codedev,date,page,token)
{
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    swal({
        title: "Validation !",
        text: "Comfirmez-vous la Souscription ?",
        showCancelButton: true,
        confirmButtonText: 'OUI, Valider!',
        cancelButtonText: "NON, Retourner !",
        type: "info"
    }, function() {
        $("#content").load('php/validation/fvalgrp.php?code='+codedev+'&page='+page+'&tok='+token);
    });
}
//function vdev2(codedev,date,page,token){
//
//if (window.XMLHttpRequest) {
//    xhr = new XMLHttpRequest();
//}
//else if (window.ActiveXObject)
//{
//    xhr = new ActiveXObject("Microsoft.XMLHTTP");
//}
//
//swal({
//    title: "Validation !",
//    text: "Comfirmez-vous la Souscription ?",
//    showCancelButton: true,
//    confirmButtonText: 'OUI, Valider!',
//    cancelButtonText: "NON, Retourner !",
//    type: "info"
//
//}, function() {
//    $("#content").load('php/validation/fval.php?code='+codedev+'&page='+page+'&tok='+token);
//});
//}
function lavis(codepol,page,sequence){
    var tok='<?php echo $token; ?>';
    $("#content").load('produit/'+page+'?code='+codepol+'&tok='+tok+'&s='+sequence);
}
function reglement(codedev,type,cod_police,page){

if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
}

swal({
    title: "REGLEMENT !",
    text: "Comfirmez le reglement",
    showCancelButton: true,
    confirmButtonText: 'OUI, Valider!',
    cancelButtonText: "NON, Retourner !",
    type: "info"

}, function() {
    $("#content").load('php/validation/regl.php?code='+codedev+'&page='+page+'&t='+type+'&p='+cod_police);
});

}
		
</script>
