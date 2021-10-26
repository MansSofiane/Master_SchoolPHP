<?php session_start();

require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal'])
{}

else
{
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");

if (isset($_REQUEST['code']) && isset($_REQUEST['page'])) {
	$codedev = $_REQUEST['code'];$page = $_REQUEST['page'];
	}

//Calcule du nombre de page 
$rqtp=$bdd->prepare("SELECT * FROM `mpay` WHERE `cod_mpay`<>'2'");
$rqtp->execute();
$rqt=$bdd->prepare("SELECT cod_agence, lib_agence FROM `agence`  WHERE `id_user`= '$id_user'   ORDER BY `cod_agence` DESC");
$rqt->execute();
?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Validation</a><a class="current">Mode de Paiement</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div id="breadcrumb"> <a class="current"><i></i>Information-Paiement</a></div>
          <div class="widget-content nopadding">
            <form class="form-horizontal">
              <div class="control-group">
                <div class="controls">
                  <select id="mpay" onchange="cache()" >
				    <option value="">-- Mode de Paiement (*)</option>
				   <?php while ($row_res=$rqtp->fetch()){  ?>
                  <option value="<?php  echo $row_res['cod_mpay']; ?>"><?php  echo $row_res['lib_mpay']; ?></option>
                  <?php } ?>
                </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <select id="ag" >
                        <option value="">-- Affaire Direct</option>
                        <?php while ($row_res=$rqt->fetch()){  ?>
                            <option value="<?php  echo $row_res['cod_agence']; ?>"><?php  echo $row_res['lib_agence']; ?></option>
                        <?php } ?>
                    </select>
              </div>
            </div>
			<div class="control-group">
              <div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="datop" placeholder="Date-Virement 01/01/1970 (*)" disabled="disabled"/>
				 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="text" id="libpay" class="span4" placeholder="Numero-Cheque ou Date du Virement" disabled="disabled"/>
                 </div>
			  </div>
			
					
			
            <div class="form-actions" align="right">
			  <input id="btnsous" type="button" class="btn btn-success" onClick="validation('<?php echo $codedev; ?>','<?php echo $page; ?>')" value="Valider" />
                <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','<?php echo $page; ?>')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">


    function cache(){
        var mode=document.getElementById("mpay").value;
        var lib=document.getElementById("libpay").value;
        if(mode==1 || mode==4){
            document.getElementById('datop').disabled=true;
            document.getElementById('libpay').disabled=true;
        }
        if(mode==2){
            document.getElementById('datop').disabled=false;
            document.getElementById('libpay').disabled=false;
        }
        if(mode==3){
            document.getElementById('datop').disabled=false;
            document.getElementById('libpay').disabled=false;
        }
    }

function validation(codedev,page) {

    var mode = document.getElementById("mpay").value;
    var agence = document.getElementById("ag").value;
    var dateop = "<?php echo $datesys;?>";
    var  libmpay = null;

    if (mode == 2 || mode == 3)
    {
        dateop = dfrtoen(document.getElementById("datop").value);
        libmpay = document.getElementById("libpay").value;
    }
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }


    if (mode) {

        if (mode == 2 || mode == 3) {

            if (dateop && libmpay) {
                if (verifdate1(document.getElementById("datop"))) {
                    document.getElementById("btnsous").disabled = true;
                    xhr.open("GET", "php/validation/voy/val.php?code=" + codedev + "&mode=" + mode + "&dateop=" + dateop + "&libmpay=" + libmpay + "&agence=" + agence, false);
                    xhr.send(null);
                    Menu1('prod', 'pol' + page);
                }
            } else {
                alert("Veuillez remplir les information du paiement");
            }
        } else {


            libmpay="";
            document.getElementById("btnsous").disabled = true;
            xhr.open("GET", "php/validation/voy/val.php?code=" + codedev + "&mode=" + mode + "&dateop=" + dateop + "&libmpay=" + libmpay + "&agence=" + agence, false);
            xhr.send(null);
            Menu1('prod', 'pol' + page);
        }

    } else {
        alert("Veuillez Choisir le Mode de Paiement (*) !");
    }


}



</script>	