<?php
//session_destroy();
session_start();
require_once("../../data/conn7.php");
$token = generer_token('intranet');
$errone = false;
$loginOK = false;$type="";
if(isset($_POST['user']) && isset($_POST['pass'])){
$user = $_REQUEST['user'];$pass = sha1($_REQUEST['pass']);
$reponse = $bdd->prepare("SELECT * FROM utilisateurs WHERE login=? AND pass=?");
$reponse->execute(array($user, $pass));
while ($utilisateur = $reponse->fetch())
{
        $errone=true;
		if($utilisateur['etat_user']=='A'){ 
		$_SESSION['id_usersal'] = $utilisateur['id_user'];
		$_SESSION['loginsal'] = $utilisateur['login'];
        $_SESSION['login'] = $utilisateur['login']; 
		$_SESSION['passsal'] = $utilisateur['pass'];
		$_SESSION['nomsal'] = $utilisateur['nom'];
		$_SESSION['agencesal'] = $utilisateur['agence'];
		$_SESSION['prenomsal'] = $utilisateur['prenom'];
        $_SESSION['Role'] = $utilisateur['type_user']; 
        $_SESSION['id_user'] = $utilisateur['id_user'];
		if($utilisateur['type_user']=='admin'){$loginOK=true;$type="adm";}
		if($utilisateur['type_user']=='user'){$loginOK=true;$type="agc";}
		if($utilisateur['type_user']=='dr'){$loginOK=true;$type="dr";}
		if($utilisateur['type_user']=='sp'){$loginOK=true;$type="sp";}
		}else {
		  echo "<script type="."'text/JavaScript'"."> alert("."'Compte desactive !'".");  </script>"; 
          
		}
}
$reponse->closeCursor(); 

/*
if($errone==false){
echo "<script type="."'text/JavaScript'"."> alert("."'Utilisateur ou Password incorrect !'".");  </script>";         
}*/

if (!isset($_SESSION['limitation'])) 
   { 
    $_SESSION['limitation'] = 1; 
   } 
else { 
    $_SESSION['limitation'] = $_SESSION['limitation'] +1; 
     } 
  
// Si le login a été validé on met les données en sessions 
if ($loginOK) { 
       // sleep(3);
		if($type=="adm"){header("Location:Administration.html"); }
		if($type=="agc"){header("Location:Espace.html");}
		if($type=="dr"){header("Location:Direction.html");}          
		if($type=="sp"){header("Location:Superviseur.html");}   
}else {
      
    if ((isset($_SESSION['limitation'])) && ($_SESSION['limitation'] < 3)) 
          { 
		  echo "<script type="."'text/JavaScript'"."> alert("."'Utilisateur ou Password incorrect !'".");  </script>";         
		
          }
    elseif ((isset($_SESSION['limitation'])) && ($_SESSION['limitation'] > 3)) 
          { 
        $_SESSION['limitation'] = 0; //  initialisation du compteur à 0
        sleep(3);
		echo "<script type="."'text/JavaScript'"."> alert("."'trop de tentative 1!'".");  </script>";         
          }
    else {     
        $_SESSION['limitation'] = 0; //  initialisation du compteur à 0
        sleep(10);
		echo "<script type="."'text/JavaScript'"."> alert("."'trop de tentatives !'".");  </script>";         
         }
     
     } 
}
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Intranet</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/matrix-login.css" />
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical"  method="post" action="index.php">
				 <div class="control-group normal_text"> <h3><img src="img/logo.png" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input id="user" name="user" type="text" placeholder="Utilisateur" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input id="pass" name="pass" type="password" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a class="flip-link btn btn-info" id="to-recover">password Oublie?</a></span>
                    <span class="pull-right"><input type="submit" class="btn btn-success" value="Login" /> </span>
                </div>
            </form>
            <form id="recoverform" method="post" action="login.php" class="form-vertical">
				<p class="normal_text">Entez E-mail du compte ainsi que votre login Utilisateur et nous allons vous envoyer un nouveau Mot-de-Passe apres verification des informations relatives au compte</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input id="mail2" name="mail2" type="text" placeholder="addresse E-mail" />                          <span class="add-on bg_lg"><i class="icon-user"> </i></span><input id="user2" name="user2" type="text" placeholder="Utilisateur" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a class="flip-link btn btn-success" id="to-login">&laquo; Retour au login</a></span>
                    <span class="pull-right"><a class="btn btn-info" onClick="gmail()" />Envoyer</a></span>
                </div>
            </form>
        </div>
        
        <script src="js/jquery.min.js"></script>  
        <script src="js/matrix.login.js"></script> 
		<script language="JavaScript">
		function gmail(){
		var mail=document.getElementById("mail2").value;
        var user=document.getElementById("user2").value;
        if (window.XMLHttpRequest) { 
         xhr = new XMLHttpRequest();
         }
         else if (window.ActiveXObject) 
         {
          xhr = new ActiveXObject("Microsoft.XMLHTTP");
         }
       var ok=confirm("Réinisialisation Password ?");
       if (ok && mail && user){
       xhr.open("GET", "php/mail.php?mail="+mail+"&user="+user, false);
       xhr.send(null); 
		 // alert(xhr.responseText); 
       alert("Mot-de-passe envoye, Veuillez consulter votre E-mail !"); 
	   document.getElementById("mail2").value="";
	   document.getElementById("user2").value="";   
       }else{alert("Veuillez renseigner E-mail du compte ainsi que le login");}
	   }
</script>	
    </body>

</html>
