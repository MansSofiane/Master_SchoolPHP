function loadList(page){
$("#content").load(page);
}
function diffdate(d1,d2){
var WNbJours = d2.getTime() - d1.getTime();
return Math.ceil(WNbJours/(1000*60*60*24));
}
// Changement de date au format anglais ***********************
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
//**************************************************************
// Ajout un nombre de jour à une date *****************
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
//**************************
// Verification du format de la date
function verifdate(dd)
{
var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
   var test = regex.test(dd.value);
if(test){
var dd1=new Date(dfrtoen(dd.value));
var Now = new Date();
Now.setHours(0);
Now.setMinutes(0);
Now.setSeconds(0)
dd1.setHours(1);
dd1.setMinutes(0);
dd1.setSeconds(0)
if (dd1.getTime() < Now.getTime()){
alert("la date ne doit pas etre inferieur a aujourd'huit!");
dd.value="";
}}else{alert("Format date incorrect! jj/mm/aaaa");dd.value="";}
}
//*******************
// Verification du numero du passport
function validepass(pass) {

var nombre = pass.value;
var chiffres = new String(nombre);

// Enlever tous les charactères sauf les chiffres
chiffres = chiffres.replace(/[^0-9A-Za-z]/g, '');

// Le champs est vide
if ( nombre == "" )
{
alert ( "Champs obligatoire !" );
pass.value="";
return;
}
// Nombre de chiffres
compteur = chiffres.length;

if (compteur!=9)
{
alert("Assurez-vous de rentrer un numéro à 9 chiffres (xxx-xxx-xxxx)");
pass.value="";
return;
}
}
//*****************************
// Verifi le champs si il est vide ***********
function verif(chp)
{

if ( chp.value == "" )
{
alert ( "Champs obligatoire !" );
document.getElementById(chp.id).focus();
return;
}

}
//*******************************************
// Si le champs comporte un caractere speciale ************
function is_special(char)
 {
  var exp = new RegExp("[,*$?!=+|&°%àäâéèêëïîöôùüû']");
  return exp.test(char);
 }
function verif(ch) {	
if (is_special(ch.value)){ 
ch.value="";
alert("Votre pseudo ne dois pas contenir de caracteres speciaux");	}		
}
//******************************************************** 
// Format date ******************************************
function verifdate1(dd)
{
var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
var test = regex.test(dd.value);
if(!test){alert("Format date incorrect! jj/mm/aaaa");dd.value="";}
}
//***********************

// Limitation d'age a 82 ans  avec controle sur le format de l'age
function calage1(bb1,bb2,dd)
{
var datf=dfrtoen(addDays(bb1.value,bb2.value));
if(bb1.value && bb2.value ){	
var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
var test = regex.test(dd.value);
if(test){
   var aa=new Date(dfrtoen(dd.value));
   var bb=new Date(datf);
   var sec1=bb.getTime();
   var sec2=aa.getTime();
   var sec=(sec1-sec2)/(365.24*24*3600*1000); 
   var age=Math.floor(sec);
   if (age > 82){
    alert("L'age limite est de 82 ans!");
    dd.value="";
	}}else{alert("Format date incorrect! jj/mm/aaaa");dd.value="";}
	
}else{alert("Saisissez la date d'effet de la police et la duree avant!");dd.value="";}
}
// ****************************
// Limitation d'age a 65 ans avec controle sur le format ********
function calage(bb1,dd)
{
	
var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
var test = regex.test(dd.value);
if(test){
   var aa=new Date(dfrtoen(dd.value));
   var bb=new Date(dfrtoen(bb1.value));
   var sec1=bb.getTime();
   var sec2=aa.getTime(); 
   var sec=(sec1-sec2)/(365.24*24*3600*1000); 
   age=Math.floor(sec);
       }else{alert("Format date incorrect! jj/mm/aaaa"+dd.value);dd.value="";}
return age;

}

//***************************************************************
// avenant à la police individuelle **************
function avenantind(coddev,token)
{

$("#content").load('ind/avenant.php?row='+coddev+'&row1='+token);
//alert(coddev);
}
//**********************************************
// avenant à la police Couple **************
function avenantcpl(coddev,token)
{

$("#content").load('cpl/avenant.php?row='+coddev+'&row1='+token);
//alert(coddev);
}
//**********************************************
// Liste des avenant de la police Couple ****
function listeavenantcpl(coddev,token)
{

$("#content").load('cpl/lavenant.php?row='+coddev+'&row1='+token);
//alert(coddev);
}
//***********************************************
// Liste des avenant de la police individuelle ****
function listeavenantind(coddev,token)
{

$("#content").load('ind/lavenant.php?row='+coddev+'&row1='+token);
//alert(coddev);
}
//***********************************************
// Liste des avenant de la police famille ****
function listeavenantfam(coddev)
{

$("#content").load('fam/lavenant.php?row='+coddev);
//alert(coddev);
}
//***********************************************
// Liste des avenant de la police individuelle ****
function listeavenantgrp(coddev)
{

$("#content").load('grp/lavenant.php?row='+coddev);
//alert(coddev);
}
//Fermeture de la fenaitre *********************
function quitter()
{
 window.close();
}
//*********************************************
//Supprimer un assuré groupe
function deleteassu(codassu,codsous){

//alert(coddev);

if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
var ok=confirm("Confirmez la suppression ?");
if (ok){
 xhr.open("GET", "dassu.php?row="+codassu+"&row1="+codsous, false);
 xhr.send(null);  
 alert("Adherent Supprime. Veuillez rafrichir la page!");    
}	
}
//**************************
//***********************************************
// Scripte d'initialisation de la date **********
function initdate(){
Date.firstDayOfWeek = 0;
Date.format = 'dd/mm/yyyy';
$(function()
{$('.date-pick').datePicker({startDate:'01/01/1930'});});
}
//***********************************************
