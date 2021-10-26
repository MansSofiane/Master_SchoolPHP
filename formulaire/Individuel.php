<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>AGLIC SPA</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../css/fullcalendar.css" />
<link rel="stylesheet" href="../css/matrix-style.css" />
<link rel="stylesheet" href="../css/matrix-media.css" />
<link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="../css/jquery.gritter.css" />
<link rel="stylesheet" href="../css/datepicker.css" />
<link rel="stylesheet" href="../css/uniform.css" />
<link rel="stylesheet" href="../css/select2.css" />
<link rel="stylesheet" href="../css/bootstrap-wysihtml5.css" />
<link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/colorpicker.css" />
<script src="../js/excanvas.min.js"></script> 
<script src="../js/jquery.flot.min.js"></script> 
<script src="../js/jquery.flot.resize.min.js"></script> 
<script src="../js/jquery.peity.min.js"></script>
<script src="../js/fullcalendar.min.js"></script> 
<script src="../js/matrix.calendar.js"></script> 
<script src="../js/matrix.chat.js"></script> 
<script src="../js/jquery.validate.js"></script> 
<script src="../js/matrix.form_validation.js"></script> 
<script src="../js/jquery.wizard.js"></script>  
<script src="../js/matrix.popover.js"></script> 
<script src="../js/jquery.dataTables.min.js"></script> 
<script src="../js/matrix.tables.js"></script> 
<script src="../js/matrix.interface.js"></script>
<script src="../js/jquery.toggle.buttons.js"></script> 
<script src="../js/masked.js"></script> 
<script src="../js/bootstrap-wysihtml5.js"></script> 
<script src="../js/jquery.min.js"></script> 
<script src="../js/jquery.ui.custom.js"></script> 
<script src="../js/bootstrap.min.js"></script> 
<script src="../js/bootstrap-colorpicker.js"></script> 
<script src="../js/bootstrap-datepicker.js"></script>  
<script src="../js/masked.js"></script> 
<script src="../js/jquery.uniform.js"></script> 
<script src="../js/select2.min.js"></script> 
<script src="../js/matrix.js"></script> 
<script src="../js/matrix.form_common.js"></script> 
<script src="../js/wysihtml5-0.3.0.js"></script>
</head>
<body>

<!--Header-part-->
<div id="header">
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Bienvennue-<?php echo $_SESSION['nomsal'];?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> Mon Profile</a></li>
        <li class="divider"></li>
        <li><a href="login.php" onClick="disconnect()" ><i class="icon-key"></i> Quitter</a></li>
      </ul>
    </li>
	 <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> Nouveau message</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> Boite-Reception</a></li>
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> Boite-envois</a></li>
        <li class="divider"></li>
      </ul>
    </li>
    <li class=""><a title=""  onClick="Menu('par.html')"><i class="icon icon-cog"></i> <span class="text">Parametres</span></a></li>
    <li class=""><a title="" href="login.php" onClick="disconnect()"><i class="icon icon-share-alt"></i> <span class="text">Quitter</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->
<!--sidebar-menu-->
<div id="sidebar">
   <ul>
    <li  id="macc" ><a onClick="Menu2('macc','acceuil.html')"><i class="icon icon-home"></i> <span>Acceuil</span></a> </li>
	 <li id="mpro" class="submenu active"> <a><i class="icon icon-th-list"></i> <span>Produits</span> <span class="label label-important">5</span></a>
      <ul>
        <li><a onClick="Menu2('mpro','passvoy.html')">Assurance-Voyage</a></li>
        <li><a onClick="Menu2('mpro','adei.html')">ADE-immobilier</a></li>
        <li><a onClick="Menu2('mpro','adec.html')">ADE-consommation</a></li>
		<li><a onClick="Menu2('mpro','warda.html')">Warda</a></li>
		<li><a onClick="Menu2('mpro','modulo.html')">Simulateur-Groupe</a></li>
      </ul>
    </li>
    <li id="mclt" class="submenu" class="submenu"> <a ><i class="icon icon-user"></i> <span>Clients</span><span class="label label-important">2</span></a> 
	 <ul>
        <li><a onClick="Menu2('mclt','cltp.html')">Clients-Physique</a></li>
        <li><a onClick="Menu2('mclt','cltm.html')">Clients-Morale</a></li>
      </ul>
	</li>
    <li id="msin"><a  onClick="Menu2('msin','sin.html')"><i class="icon icon-info-sign"></i> <span>Sinistres</span></a></li>
    <li id="mdos"><a onClick="Menu2('mdos','dos.html')"><i class="icon icon-file"></i> <span>Dossiers</span></a></li>
    <li id="mtar"><a onClick="Menu2('mtar','tar.html')"><i class="icon icon-tint"></i> <span>Baremes & Tarifs</span></a></li>
    <li id="mstat"> <a onClick="Menu2('mstat','stat.html')"><i class="icon icon-signal"></i> <span>Statistique</span></a> </li>
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content"> 
 <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Voyage-Individuel</a></div>
  </div>
 <div class="container-fluid">
  <hr>
  <div class="row-fluid">
  
  
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Souscripteur</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
		   <div class="control-group">
              <label class="control-label">Type-Souscripteur</label>
              <div class="controls">
                <select id="typsous">
				  <option value="0">--</option>
                  <option value="1">Personne-Moral</option>
                  <option value="2">Personne-Physique</option>
                </select>
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Le Souscripteur est l'assure:</label>
              <div class="controls">
                <label>
                  <input type="radio" id="r1" name="radios" onClick="souscripteur()" />
                  Oui</label><label>
                  <input type="radio" id="r2" name="radios" />
                  Non</label>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Nom *:</label>
              <div class="controls">
                <input type="text" id="nom" class="span11" placeholder="Nom" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Prenom *:</label>
              <div class="controls">
                <input type="text" id="pnom" class="span11" placeholder="Prenom" />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Raison Sociale *:</label>
              <div class="controls">
                <input type="text" id="raison" class="span11" placeholder="R-Sociale.." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Adresse *:</label>
              <div class="controls">
                <input type="text" id="adr" class="span11" placeholder="Adresse"  />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Telephone:</label>
              <div class="controls">
                <input type="text" id="tel" class="span11" placeholder="+213 ...." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">E-mail:</label>
              <div class="controls">
                <input type="text" id="mail" class="span11" placeholder="E-mail..." />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Numero Passeport:</label>
              <div class="controls">
                <input type="text" id="pass" class="span11" placeholder="Passport numero" />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Date-Naissance</label>
              <div class="controls">
                  <div  data-date="12-02-2012" data-date-format="dd/mm/yyyy" class="input-append date datepicker">
                  <input type="text" id="date" data-date-format="dd/mm/yyyy" class="datepicker span11">
                  <span class="add-on"><i class="icon-th"></i></span> 
				  </div>
              </div>           
            </div>
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-primary" onClick="souscripteur()" value="Reset" />
              <input  type="button" class="btn btn-info" onClick="test()" value="Editer" />
			  <input  type="button" class="btn btn-danger" onClick="test()" value="Annuler" />
			  <input  type="button" class="btn btn-success" onClick="suivant()" value="Suivant" />
            </div>
          </form>
        </div>
      </div>
	 </div>
   
    <div class="span6" id="voy" style="visibility:visible">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Info-Assure-Voyage</h5>
        </div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
          
            
			  <div class="control-group">
              <label class="control-label">Nom *:</label>
              <div class="controls">
                <input type="text" id="nom" class="span11" placeholder="Nom" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Prenom *:</label>
              <div class="controls">
                <input type="text" id="pnom" class="span11" placeholder="Prenom" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Adresse *:</label>
              <div class="controls">
                <input type="text" id="adr" class="span11" placeholder="Adresse"  />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Telephone:</label>
              <div class="controls">
                <input type="text" id="tel" class="span11" placeholder="+213 ...." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">E-mail:</label>
              <div class="controls">
                <input type="text" id="mail" class="span11" placeholder="E-mail..." />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Numero Passeport:</label>
              <div class="controls">
                <input type="text" id="pass" class="span11" placeholder="Passport numero" />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Date-Naissance</label>
              <div class="controls">
                  <div  data-date="12-02-2012" data-date-format="dd/mm/yyyy" class="input-append date datepicker">
                  <input type="text" id="date" data-date-format="dd/mm/yyyy" class="datepicker span11">
                  <span class="add-on"><i class="icon-th"></i></span> 
				  </div>
              </div>           
            </div>
			<div class="control-group">
			<label class="control-label">Date Picker (mm-dd)</label>
              <div class="controls">
                  <div  data-date="12-02-2012" data-date-format="dd/mm/yyyy" class="input-append date datepicker">
                  <input type="text" id="date2" data-date-format="dd/mm/yyyy" class="datepicker span11">
                  <span class="add-on"><i class="icon-th"></i></span> 
				  </div>
              </div>           
            </div>
			
            <div class="form-actions">
              <button type="submit" class="btn btn-success">Save</button>
              <button type="submit" class="btn btn-primary">Reset</button>
              <button type="submit" class="btn btn-info">Edit</button>
              <button type="submit" class="btn btn-danger">Cancel</button>
            </div>
          </form>
        </div>
      </div>   
  </div>
</div>
</body>
</html>
<script type="text/javascript">
function Menu(page) {
document.getElementById('macc').setAttribute("class", "hover");
document.getElementById('msin').setAttribute("class", "hover");
document.getElementById('mdos').setAttribute("class", "hover");
document.getElementById('mtar').setAttribute("class", "hover");
document.getElementById('mstat').setAttribute("class", "hover");
document.getElementById('mclt').setAttribute("class", "hover");
document.getElementById('mpro').setAttribute("class", "hover");
$("#content").load('code/'+page);
}
function Menu2(id,page) {
document.getElementById('macc').setAttribute("class", "hover");
document.getElementById('msin').setAttribute("class", "hover");
document.getElementById('mdos').setAttribute("class", "hover");
document.getElementById('mtar').setAttribute("class", "hover");
document.getElementById('mstat').setAttribute("class", "hover");
document.getElementById('mclt').setAttribute("class", "hover");
document.getElementById('mpro').setAttribute("class", "hover");
document.getElementById(id).setAttribute("class", "active");
$("#content").load('code/'+page);
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
function souscripteur() {

if(document.getElementById("r1").checked==true){

alert("OK");}else{alert("non");}
}
function voyage() {

document.getElementById("voy").style.visibility='visible';
alert("test");
} 


</script>