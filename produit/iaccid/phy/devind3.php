<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
$id_user=$_SESSION['id_usersal'];
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$tokiacc2 = generer_token('devind2');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
if ( isset($_REQUEST['sous']) ){
    $codsous= $_REQUEST['sous'];
//Periode
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE cod_per >'6' AND cod_per <='20' AND cod_per <>'18' ORDER BY `cod_per`");
$rqtper->execute();
//Profession
$rqtpro=$bdd->prepare("SELECT * FROM `classe`  WHERE cod_cls > 1 ");
$rqtpro->execute();
	
}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a>Individuelle-Accident</a><a>Formule-Individuelle</a><a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a class="current">Capital</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
             
		<div class="control-group"> 
			  <div class="control-group">
			  <label class="control-label">Duree: (*)</label>
              <div class="controls">
               <select id="per">
				<option value="">-- (*)</option>
				<?php while ($row_res=$rqtper->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			  
			  <div class="control-group">
			  <label class="control-label">Profession: (*)</label>
              <div class="controls">
               <select id="cls">
				<option value="">-- Classe (*)</option>
				<?php while ($row_res1=$rqtpro->fetch()){  ?>
                  <option value="<?php  echo $row_res1['cod_cls']; ?>"><?php  echo $row_res1['lib_cls']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
			  
			 <div class="control-group">
			 <label class="control-label">Capital DC-IPP: (*)</label>
              <div class="controls">
                <input type="text" id="cap1" class="span5" placeholder="De 100 000 a 3 000 000 DZD" />
              </div>
            </div>
			<div class="control-group">
			<label class="control-label">Capital FMP: </label>
              <div class="controls">
                <input type="text" id="cap2" class="span5" placeholder="De 1 000 a 5 000 DZD" />
              </div>
            </div>
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="instqm('<?php echo $codsous; ?>','<?php echo $tokiacc2; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assiaccind.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function instqm(codsous,tok) {

    var classe = document.getElementById("cls").value;
    var periode = document.getElementById("per").value;
    var cap1 = document.getElementById("cap1").value;
    var cap2 = document.getElementById("cap2").value;
    var bool = 0;


    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (classe && periode && cap1) {
        //debut
        if (isNaN(cap1) != true && cap1 >= 100000) {


            if (cap1 <= 3000000) {

                if (cap2 && isNaN(cap2) != true && cap2 <= 5000 && cap2 >= 1000) {
                    //on traite ici
                    $("#content").load("produit/iaccid/phy/devind5.php?sous=" + codsous + "&classe=" + classe + "&periode=" + periode + "&cap1=" + cap1 + "&cap2=" + cap2 + "&bool=" + bool + "&tok=" + tok);
                } else {
                    cap2 = 0;
                    document.getElementById("cap2").value = 0;
                    // On traite ici
                    var ok = confirm("Garantie FMP Non introduite ");
                    if (ok) {
                        $("#content").load("produit/iaccid/phy/devind5.php?sous=" + codsous + "&classe=" + classe + "&periode=" + periode + "&cap1=" + cap1 + "&cap2=" + cap2 + "&bool=" + bool + "&tok=" + tok);

                    }
                }

            } else {
                alert("Plafond de souscription atteind, le devis sera soumis a la DG-AGLIC");
                bool = 1
                if (cap2 && isNaN(cap2) != true && cap2 <= 5000 && cap2 >= 1000) {
                    //on traite ici
                    $("#content").load("produit/iaccid/phy/devind5.php?sous=" + codsous + "&classe=" + classe + "&periode=" + periode + "&cap1=" + cap1 + "&cap2=" + cap2 + "&bool=" + bool + "&tok=" + tok);
                } else {
                    cap2 = 0;
                    document.getElementById("cap2").value = 0;
                    // On traite ici
                    var ok = confirm("Garantie FMP Non introduite ");
                    if (ok) {
                        $("#content").load("produit/iaccid/phy/devind5.php?sous=" + codsous + "&classe=" + classe + "&periode=" + periode + "&cap1=" + cap1 + "&cap2=" + cap2 + "&bool=" + bool + "&tok=" + tok);

                    }
                }

            }
        }
        //fin

    } else {
        alert("Veuillez Remplir tous les champs Obligatoire (*) !");
    }
}
			
</script>	