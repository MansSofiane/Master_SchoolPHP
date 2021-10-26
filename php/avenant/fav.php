<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
if (isset($_REQUEST['code']) && isset($_REQUEST['page'])) {
	$codepol = $_REQUEST['code'];$page = $_REQUEST['page'];
//On recupere le nombre de jour de la periode 
$rqtp=$bdd->prepare("SELECT j.min_jour as jour, p.cod_sous as csous,p.cod_prod as prod,p.ndat_eff,p.ndat_ech FROM `periode` as j,`policew` as p WHERE p.`cod_per`=j.`cod_per` AND p.`cod_pol`='$codepol'");
$rqtp->execute();	
while ($row_res=$rqtp->fetch()){
    $jour=$row_res['jour'];
    $csous=$row_res['csous'];
    $cod_prod=$row_res['prod'];
    $ndat_eff=$row_res['ndat_eff'];
    $ndat_ech=$row_res['ndat_ech'];
}

	
	}

?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Avenants</a><a class="current">Avenant-au-Contrat</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a class="current"><i></i>Information-Avenant</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <div class="controls">
                <select id="av" onchange="cachev()">
				<option value="">-- Type-Avenant (*)</option>
				<!--<option value="74">-- Modification de date</option>
				<option value="30">-- Annulation-Avec-Ristourne</option>-->
				<option value="70">-- Avenant-De-Precision</option>
				<!--<option value="50">-- Annulation-Sans-Ristourne</option>-->
                    <?php  if ($cod_prod=='7' ){?>
                    <option value="73">-- Avenant de subrogation</option>
                    <?php  }?>

                </select>
              </div>
            </div>
			
			
					
			
            <div class="form-actions" align="right">
			  <input id="btnav" type="button" class="btn btn-success" onClick="validation2('<?php echo $codepol; ?>','<?php echo $jour; ?>','<?php echo $page; ?>','<?php echo $csous; ?>')" value="Souscription" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','<?php echo $page; ?>')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function cachev(){
var av=document.getElementById("av").value;
if(av==74){
document.getElementById('datef').disabled=false;
alert("Cout d'avenant est de 140 DZD");
}
if(av==73){
document.getElementById('datef').disabled=false;
alert("Cout d'avenant est de 140 DZD");
}
if(av==30){
document.getElementById('datef').disabled=true;
}
if(mode==50){
document.getElementById('datef').disabled=true;
}
if(mode==70){
document.getElementById('datef').disabled=true;
}
}

function validation2(codepol,jour,page,codsous) {
    var av = document.getElementById("av").value;
    var dateff = null, datech = null;


    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }


    if (av) {
        document.getElementById("btnav").disabled = true;
        if (av == 74) {
            dateff = document.getElementById("datef").value;
            datech = addDays(dateff, jour);
            dateff = dfrtoen(dateff);
            datech = dfrtoen(datech);
          //  xhr.open("GET", "php/avenant/validationav.php?code=" + codepol + "&av=" + av, false);
          //  xhr.send(null);
            Menu1('prod', page);
        }
        if (av == 50) {
            document.getElementById("btnav").disabled=true;
            xhr.open("GET", "php/avenant/validationav.php?code=" + codepol + "&av=" + av+"&mode=''"+"&datop=''", false);
            xhr.send(null);
            Menu1('prod', page);
        }
        if (av == 73) {
            var ndat_eff=<?php echo $datesys;?>;
            var ndat_ech=<?php echo $ndat_ech;?>;
            $("#content").load("php/avenant/mpaiement.php?code="+codepol+"&page="+page+"&av="+av+"&datdebut="+ndat_eff+"&datfin="+ndat_ech);

          //  xhr.open("GET", "php/avenant/validationav.php?code=" + codepol + "&av=" + av, false);
          //  xhr.send(null);
          //  Menu1('prod', page);
        }
        if (av == 70) {
            //xhr.open("GET", , false);
            $("#content").load("php/avenant/fsous.php?code=" + codepol + "&sous=" + codsous + "&page=" + page + "&av=" + av);
            //alert("php/avenant/fsous.php?code="+codepol+"&sous="+codsous+"&page="+page+"&av="+av);
        }

        //alert(xhr.responseText);
        // alert("php/avenant/validationav.php?code="+codepol+"&date1="+dateff+"&date2="+datech+"&av="+av);

    } else {
        alert("Veuillez Choisir le Type-Avenant (*) !");
    }


}
	
	
			
</script>	