<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$tokwar1 = generer_token('devwar1');
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
$codsous=0;
// recupération du code du dernier souscripteur de l'agence	
$rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$id_user'");
$rqtms->execute();

while ($row_res=$rqtms->fetch()){ 
$codsous=$row_res['maxsous']; 
}	
// Selection des info souscripteur
$rqtmrs=$bdd->prepare("SELECT * FROM `souscripteurw` WHERE cod_sous ='$codsous'");
$rqtmrs->execute();
$codsous=0;
while ($row=$rqtmrs->fetch()){ 
    $codsous= $row['cod_sous'];
    $nom = $row['nom_sous'];
	$prenom =$row['pnom_sous'];
	$adr = $row['adr_sous'];
	$mail = $row['mail_sous'];
	$tel = $row['tel_sous'];
	$dnais = $row['dnais_sous'];
}
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Warda</a> <a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Assure</a><a>Capital</a><a>Selection-Medical</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
           
			 <div class="control-group">
              <div class="controls">
                <input type="text" id="nsous" class="span5" value="Nom: <?php echo $nom; ?>" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="psous" class="span5" value="Prenom: <?php echo $prenom; ?>" disabled="disabled" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
                <input type="text" id="mailsous" class="span5" value="E-mail: <?php echo $mail; ?>" disabled="disabled" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="telsous" class="span5" value="Phone: <?php echo $tel; ?>" disabled="disabled" />
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
                <input type="text" id="adrsous" class="span5" value="Adresse: <?php echo $adr; ?>" disabled="disabled" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" class="span5"   id="dnaissous" value="D-Naissance: <?php echo date("d/m/Y",strtotime($dnais)); ?>" disabled="disabled"/>
              </div>
            </div>
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-success" onClick="capitalwar1('<?php echo $codsous; ?>','<?php echo $tokwar1; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assward.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function capitalwar1(codsous,tok){

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	
	$("#content").load("produit/warda/devwar3.php?sous="+codsous+"&tok="+tok);
	
	}	
			
</script>	