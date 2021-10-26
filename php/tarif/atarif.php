<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
//segment commercials
$rqtseg=$bdd->prepare("SELECT * FROM `segment`  WHERE 1 ORDER BY `cod_seg`");
$rqtseg->execute();
//Formule
$rqtfrm=$bdd->prepare("SELECT * FROM `formule`  WHERE id_user='$id_user' ORDER BY `cod_formul`");
$rqtfrm->execute();
//Option
$rqtopt=$bdd->prepare("SELECT * FROM `option`  WHERE id_user='$id_user' ORDER BY `cod_opt`");
$rqtopt->execute();
//Zone
$rqtzone=$bdd->prepare("SELECT * FROM `zone`  WHERE id_user='$id_user' ORDER BY `cod_zone`");
$rqtzone->execute();
//Periode
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE id_user='$id_user' ORDER BY `cod_per`");
$rqtper->execute();
//Accessoire
$rqtdt=$bdd->prepare("SELECT * FROM `dtimbre`  WHERE id_user='$id_user' ORDER BY `cod_dt`");
$rqtdt->execute();
//C-police
$rqtcp=$bdd->prepare("SELECT * FROM `cpolice`  WHERE id_user='$id_user' ORDER BY `cod_cpl`");
$rqtcp->execute();
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage</a> <a class="current">Nouveau Tarif</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Categorie-Visee :</label>
              <div class="controls">
                 <select id="seg">
				<option value="">-- Segment (*)</option>
				<?php while ($row_res=$rqtseg->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_seg']; ?>"><?php  echo $row_res['lib_seg']; ?></option>
                  <?php } ?>
                </select>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="frm">
				<option value="">-- Formule (*)</option>
				<?php while ($row_res=$rqtfrm->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_formul']; ?>"><?php  echo $row_res['lib_formul']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Accessoires:</label>
              <div class="controls">
                <select id="dt">
				<option value="">-- Accessoire (*)</option>
				<?php while ($row_res=$rqtdt->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_dt']; ?>"><?php  echo $row_res['lib_dt']; ?></option>
                  <?php } ?>
                </select>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="cpl">
				<option value="">-- Cout police (*)</option>
				<?php while ($row_res=$rqtcp->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_cpl']; ?>"><?php  echo $row_res['lib_cpl']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Parametres-Calcul:</label>
              <div class="controls">
                <select id="opt">
				<option value="">-- Option (*)</option>
				<?php while ($row_res=$rqtopt->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                  <?php } ?>
                </select>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="zone">
				<option value="">-- Zone (*)</option>
				<?php while ($row_res=$rqtzone->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_zone']; ?>"><?php  echo $row_res['lib_zone']; ?></option>
                  <?php } ?>
                </select>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="per">
				<option value="">-- Duree (*)</option>
				<?php while ($row_res=$rqtper->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                  <?php } ?>
                </select>
              </div>
			   <div class="control-group">
              <label class="control-label">Interval-Age</label>
              <div class="controls">
                <input type="text" id="agemin" class="span4" placeholder="Age-Minimum" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="agemax" class="span4" placeholder="Age-Maximum" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Primes*:</label>
              <div class="controls">
                 <input type="text" id="pe" class="span4" placeholder="Prime-Entreprise (DZD)" />              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="pa" class="span4" placeholder="Prime-Assistance (DZD)" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Reduction-Majoration-Assurance *:</label>
              <div class="controls">
                <input type="text" id="mpe" class="span4" placeholder="Majoration-Assurance %" />              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="rpe" class="span4" placeholder="Rabais-Assurance %" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Reduction-Majoration-Assistance *:</label>
              <div class="controls">
                <input type="text" id="mpa" class="span4" placeholder="Majoration-Assistance %" />              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="rpa" class="span4" placeholder="Rabais-Assistance %" />
              </div>
            </div>
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instar('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','tarassvoy.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instar(user){
var segment=document.getElementById("seg").value;
var formule=document.getElementById("frm").value;
var timbre=document.getElementById("dt").value;
var cpolice=document.getElementById("cpl").value;
var option=document.getElementById("opt").value;
var zone=document.getElementById("zone").value;
var periode=document.getElementById("per").value;
var agemin=document.getElementById("agemin").value;
var agemax=document.getElementById("agemax").value;
var pe=document.getElementById("pe").value;
var pa=document.getElementById("pa").value;
var mpe=document.getElementById("mpe").value;
var rpe=document.getElementById("rpe").value;
var mpa=document.getElementById("mpa").value;
var rpa=document.getElementById("rpa").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(segment && formule && timbre && cpolice && option &&zone && periode && agemin && agemax && pe && pa && mpe && mpa && rpe && rpa){ 
	if(isNaN(agemin) != true && isNaN(agemax) != true && isNaN(pe) != true && isNaN(pa) != true && isNaN(mpe) != true && isNaN(mpa) != true && isNaN(rpe) != true && isNaN(rpa) != true){
xhr.open("GET", "php/insert/ntarif.php?segment="+segment+"&formule="+formule+"&timbre="+timbre+"&cpolice="+cpolice+"&zone="+zone+"&periode="+periode+"&option="+option+"&agemin="+agemin+"&agemax="+agemax+"&pe="+pe+"&pa="+pa+"&mpe="+mpe+"&rpe="+rpe+"&mpa="+mpa+"&rpa="+rpa+"&user="+user, false);
     xhr.send(null);
	 //alert(xhr.responseText);
	 alert("Tarif Introduit !");
	 Menu1('prod','tarassvoy.php');
	  }else{alert("Veuillez introduire un chiffre correct !");}
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	