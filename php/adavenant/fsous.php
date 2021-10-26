<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user=$_SESSION['id_usersal'];
if ( isset($_REQUEST['code']) && isset($_REQUEST['sous']) && isset($_REQUEST['page']) && isset($_REQUEST['av'])){
$code = $_REQUEST['code'];
$csous = $_REQUEST['sous'];
$page = $_REQUEST['page'];
$av = $_REQUEST['av'];
$rps=1;

$rqts=$bdd->prepare("SELECT * FROM `souscripteurw` WHERE `cod_sous`='$csous'");
$rqts->execute();
while ($row_res=$rqts->fetch()){
$noms=$row_res['nom_sous'];
$pnoms=$row_res['pnom_sous'];
$mails=$row_res['mail_sous'];
$tels=$row_res['tel_sous'];
$adrs=$row_res['adr_sous'];
$rps=$row_res['rp_sous'];
}
if($rps==2){
// On recupere les info de l'assuré
$rqta=$bdd->prepare("SELECT * FROM `souscripteurw` WHERE `cod_par`='$csous'");
$rqta->execute();
while ($row=$rqta->fetch()){
$noma=$row['nom_sous'];
$pnoma=$row['pnom_sous'];
$maila=$row['mail_sous'];
$tela=$row['tel_sous'];
$adra=$row['adr_sous'];
$cod_sousa=   $row['cod_sous'] ;
}
}



}

?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Avenant de Precision</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>information-Souscripteur (Assure)</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Nom & Prenom (*):</label>
              <div class="controls">
                <input type="text" id="mnoms" class="span4" placeholder="Nom ..." value="<?php echo $noms; ?>"  />     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="mpnoms" class="span4" placeholder="Prenom .." value="<?php echo $pnoms; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">E-mail & Phone :</label>
              <div class="controls">
                <input type="text" id="mmails" class="span4" placeholder="E-mail ..." value="<?php echo $mails; ?>"  />     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="mtels" class="span4" placeholder="213 XXX XXX XXX .." value="<?php echo $tels; ?>" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Adresse (*):</label>
              <div class="controls">
                <input type="text" id="madrs" class="span6" placeholder="Adresse ..." value="<?php echo $adrs; ?>"  />     
              </div>
            </div>
			<?php if($rps==2){?>
			<div class="control-group">
              <label class="control-label">Nom & Prenom (Assure)(*):</label>
              <div class="controls">
                <input type="text" id="mnoma" class="span4" placeholder="Nom ..." value="<?php echo $noma; ?>"  />     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="mpnoma" class="span4" placeholder="Prenom .." value="<?php echo $pnoma; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">E-mail & Phone (assure):</label>
              <div class="controls">
                <input type="text" id="mmaila" class="span4" placeholder="E-mail ..." value="<?php echo $maila; ?>"  />     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" id="mtela" class="span4" placeholder="213 XXX XXX XXX .." value="<?php echo $tela; ?>" />
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">Adresse (assure) (*):</label>
              <div class="controls">
                <input type="text" id="madra" class="span6" placeholder="Adresse ..." value="<?php echo $adra; ?>"  />     
              </div>
            </div>
			<?php } ?>
            <div class="form-actions" align="right">
			  <input  type="button" id="btnsousv" class="btn btn-success" onClick="msous('<?php echo $code; ?>','<?php echo $csous; ?>','<?php echo $rps; ?>','<?php echo $page; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="aMenu1('prod','<?php echo $page; ?>')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">
function msous(code,sous,rp,page) {
    var noms = document.getElementById("mnoms").value;
    var pnoms = document.getElementById("mpnoms").value;
    var mails = document.getElementById("mmails").value;
    var adrs = document.getElementById("madrs").value;
    var tels = document.getElementById("mtels").value;
    var dateff = null, datech = null;
    var av = 70;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (rp == 1) {//Souscripteur uniquement


        if (noms && pnoms && adrs) {

            document.getElementById("btnsousv").disabled = true;
            xhr.open("GET", "php/adavenant/nmodif.php?code=" + code + "&nom=" + noms + "&pnom=" + pnoms + "&adr=" + adrs + "&mail=" + mails + "&tel=" + tels + "&cod_sous=" + sous, false);
            xhr.send(null);
            $("#content").load("php/adavenant/mpaiement.php?code=" + code + "&page=" + page + "&av=" + av);
        } else {alert("Veuillez Remplir tous les champs obligatoire (*) !"); }
    }

    else {//Souscripteur et assuré
        var noma = document.getElementById("mnoma").value;
        var pnoma = document.getElementById("mpnoma").value;
        var maila = document.getElementById("mmaila").value;
        var adra = document.getElementById("madra").value;
        var tela = document.getElementById("mtela").value;
        var cod_sousa = '<?php echo $cod_sousa;?>';
        if (noms && pnoms && adrs && noma && pnoma && adra) {
            document.getElementById("btnsousv").disabled = true;
            xhr.open("GET", "php/adavenant/nmodif.php?code=" + code + "&nom=" + noms + "&pnom=" + pnoms + "&adr=" + adrs + "&mail=" + mails + "&tel=" + tels + "&cod_sous=" + sous, false);
            xhr.send(null);
            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xhr.open("GET", "php/adavenant/nmodif.php?code=" + code + "&nom=" + noma + "&pnom=" + pnoma + "&adr=" + adra + "&mail=" + maila + "&tel=" + tela + "&cod_sous=" + cod_sousa, false);
            xhr.send(null);
            $("#content").load("php/adavenant/mpaiement.php?code=" + code + "&page=" + page + "&av=" + av);
        } else {alert("Veuillez Remplir tous les champs obligatoire (*) !");}
    }

}
			
</script>		