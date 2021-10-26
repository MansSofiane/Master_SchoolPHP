<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user=$_SESSION['id_usersal'];
$token = generer_token('muser');
$rqts=$bdd->prepare("SELECT * FROM `utilisateurs` WHERE id_user='$id_user'");
$rqts->execute();
while ($row_res=$rqts->fetch()){
$nom=$row_res['nom'];
$pnom=$row_res['prenom'];
$tel=$row_res['tel_user'];
$mail=$row_res['mail_user'];
$adr=$row_res['adr_user'];
}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Compte-Utilisateur</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>informations-Compte</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Nom & Prenom (*):</label>
              <div class="controls">
                <input type="text" id="mnom" class="span4" placeholder="Nom ..." value="<?php echo $nom; ?>"  />     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="mpnom" class="span4" placeholder="Prenom .." value="<?php echo $pnom; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Phone & E-mail :</label>
              <div class="controls">
                <input type="text" id="mtel" class="span4" placeholder="213 212 121 212 ..." value="<?php echo $tel; ?>"  />     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="mmail" class="span4" placeholder="Ex: contact@aglic.dz" value="<?php echo $mail; ?>" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Adresse (*):</label>
              <div class="controls">
                <input type="text" id="madr" class="span6" placeholder="Adresse ..." value="<?php echo $adr; ?>"  />     
              </div>
			  <label class="control-label">Password (*):</label>
              <div class="controls">
                <input type="text" id="mpass" class="span6" placeholder="Nouveau Password" />     
              </div>
			  <div class="controls">
                <input type="text" id="mpass2" class="span6" placeholder="Confirmation Nouveau Password" />     
              </div>
            </div>
            <div class="form-actions" align="right">
			  <input  type="button" id="btnsousv" class="btn btn-success" onClick="muser('<?php echo $id_user; ?>','<?php echo $token; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu('macc','dash.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">

  function checkForm()
  {
    

    if(document.getElementById("mpass").value != "" && document.getElementById("mpass").value == document.getElementById("mpass2").value) {
      if(document.getElementById("mpass").value.length < 6) {
        alert("Erreur: Le Mot-de-Passe doit contenir \n Au minimum six caracteres! \n Au minimum Un nombre (0-9) \n Au minimum Un caractere des lettes Minuscule(a-z) \n Au minimum Un caractere des lettes Majuscule (A-Z) \n \n ----> Exemple: Ag2019liC");
		document.getElementById("mpass").value="";
		document.getElementById("mpass2").value="";
        document.getElementById("mpass").focus();
        return false;
      }
     
      re = /[0-9]/;
      if(!re.test(document.getElementById("mpass").value)) {
        alert("Erreur: Le Mot-de-Passe doit contenir \n Au minimum six caracteres! \n Au minimum Un nombre (0-9) \n Au minimum Un caractere des lettes Minuscule(a-z) \n Au minimum Un caractere des lettes Majuscule (A-Z) \n \n ----> Exemple: Ag2019liC");
		document.getElementById("mpass").value="";
		document.getElementById("mpass2").value="";
        document.getElementById("mpass").focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(document.getElementById("mpass").value)) {
        alert("Erreur: Le Mot-de-Passe doit contenir \n Au minimum six caracteres! \n Au minimum Un nombre (0-9) \n Au minimum Un caractere des lettes Minuscule(a-z) \n Au minimum Un caractere des lettes Majuscule (A-Z) \n \n ----> Exemple: Ag2019liC");
		document.getElementById("mpass").value="";
		document.getElementById("mpass2").value="";
        document.getElementById("mpass").focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(document.getElementById("mpass").value)) {
        alert("Erreur: Le Mot-de-Passe doit contenir \n Au minimum six caracteres! \n Au minimum Un nombre (0-9) \n Au minimum Un caractere des lettes Minuscule(a-z) \n Au minimum Un caractere des lettes Majuscule (A-Z) \n \n ----> Exemple: Ag2019liC");
		document.getElementById("mpass").value="";
		document.getElementById("mpass2").value="";
        document.getElementById("mpass").focus();
        return false;
      }
    } else {
      alert("Error: Verifiez que vous avez entrer et confirmer votre Mot-de-Passe!");
	  document.getElementById("mpass").value="";
	  document.getElementById("mpass2").value="";
      document.getElementById("mpass").focus();
      return false;
    }

    alert("Mot-de-Passe Valide- Veuillez le memoriser : " + document.getElementById("mpass").value);
    return true;
  }

function muser(user,tok){
var nom=document.getElementById("mnom").value;
var pnom=document.getElementById("mpnom").value;
var mail=document.getElementById("mmail").value;
var adr=document.getElementById("madr").value;
var tel=document.getElementById("mtel").value;
var pass=document.getElementById("mpass").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	 
	 if(nom && pnom && adr && pass && checkForm()){
	 xhr.open("GET", "php/cmpt/muser.php?nom="+nom+"&pnom="+pnom+"&adr="+adr+"&tel="+tel+"&mail="+mail+"&pass="+pass+"&tok="+tok+"&user="+user, false);
   xhr.send(null);
		//alert(xhr.responseText);	 
	 alert("Compte-Utilisateur Modifie !");
	 Menu('macc','dash.php');
	 
	 }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	
	}	
			
</script>		