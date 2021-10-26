<?php session_start();
require_once("../../../../data/conn7.php");
if ($_SESSION['login']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_user'];
$datesys=date("Y-m-d");
if (isset($_REQUEST['code']) && isset($_REQUEST['page'])) {
	$codedev = $_REQUEST['code'];$page = $_REQUEST['page'];
	}

$sqttaux=$bdd->prepare("SELECT taux_com,taux_com_agence,taux_com_courtier,cod_prod FROM produit where cod_prod=(select cod_prod from devisw where cod_dev='$codedev');");
$sqttaux->execute();
$tauxcom=0;
$tauxcom_ag=0;
$tauxcom_court=0;
$cod_prod="";
if($rw=$sqttaux->fetch())
{
    $tauxcom=$rw['taux_com'];
    $tauxcom_ag=$rw['taux_com_agence'];
    $tauxcom_court=$rw['taux_com_courtier'];
    $cod_prod=$rw['cod_prod'];
}

$assurance_group=9;// pour controler la r�partition des couts de commissions

//Calcule du nombre de page 
$rqtp=$bdd->prepare("SELECT * FROM `mpay` WHERE 1");
$rqtp->execute();
//agence de voyage
$rqt=$bdd->prepare("SELECT cod_agence, lib_agence FROM `agence`  WHERE id_user in (select id_user from utilisateurs where agence=(select agence from utilisateurs where id_user='$id_user'))   ORDER BY `lib_agence` ");
$rqt->execute();
//apporteur d'affaire  or typ_agence='2'
$rqtap=$bdd->prepare("SELECT cod_agence, lib_agence FROM `agence`  WHERE  cod_agence<>'133'  ORDER BY `lib_agence` ");
$rqtap->execute();
if ($cod_prod==10)
{
    $rqtap=$bdd->prepare("SELECT cod_agence, lib_agence FROM `agence`  WHERE   cod_agence='133'   ORDER BY `lib_agence` ");
    $rqtap->execute();
}

?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Validation</a><a class="current">Apporteur</a> </div>
  </div>
  <div class="row-fluid">  
    <div  class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a class="current"><i></i>Type-Apporteur</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <div class="controls">
                  <select id="ag" onchange="affectation()" >
                      <option value="">-- Affaire Direct</option>
                      <?php if ($cod_prod=='1'){?>
                      <option value="1">-- Convention</option>
                      <?php }?>
                      <option value="2">-- Apporteur d'affaire</option>
                  </select>
              </div>
                  <div class="controls">
                  <select id="ag1" style="display: none;" >
                      <?php while ($row_res=$rqt->fetch()){  ?>
                          <option value="<?php  echo $row_res['cod_agence']; ?>"><?php  echo utf8_decode($row_res['lib_agence']); ?></option>

                      <?php }
                      ?>
                  </select>
                  <select id="ag2"  style="display: none;">
                      <?php while ($row_resap=$rqtap->fetch()){  ?>
                          <option value="<?php  echo $row_resap['cod_agence']; ?>"><?php  echo utf8_decode($row_resap['lib_agence']); ?></option>
                      <?php } ?>
                  </select>
              </div>
            </div>
             <div class="control-group" id="com" style="display: none;">

                      <div class="controls">
                            <span> Apport             agence       : </span>
                            <input type="text" id="tcomag" class="span1" placeholder="Taux de commission Agence cash .."  value="<?php echo $tauxcom_ag;?>"/>
                          </div>
                          <div class="controls">
                             <span> Apport courtier              : </span>
                             <input type="text" id="tcomcourt" class="span1" placeholder="Taux de commission Agence courtier .." value="<?php echo $tauxcom_court;?>"/>
                          </div>
             </div>

			<div class="control-group">
            <div class="form-actions" align="right">
			  <input id="btnsous" type="button" class="btn btn-success" onClick="validation('<?php echo $codedev; ?>','<?php echo $page; ?>')" value="Valider" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','<?php echo $page; ?>')" value="Annuler" />
            </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



<script language="JavaScript">initdate();</script>
<script language="JavaScript">

    function affectation()
    {

       var mode=document.getElementById("ag").value;

        if(mode==''){
            document.getElementById('ag1').style.display='none';
            document.getElementById('ag2').style.display='none';
            document.getElementById('com').style.display='none';
        }
        if(mode=='1'){
            document.getElementById('ag1').style.display='block';
            document.getElementById('ag2').style.display='none';
            document.getElementById('com').style.display='none';
        }
        if(mode=='2'){
            document.getElementById('ag1').style.display='none';
            document.getElementById('ag2').style.display='block';
            if (<?php echo $cod_prod;?>==<?php echo $assurance_group;?> )
            document.getElementById('com').style.display='block';
            else
            document.getElementById('com').style.display='none';
        }
    }
    function verifdateval(dd)
    {
        v1=true;
        var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
        var test = regex.test(dd.value);
        if(!test){
            v1=false;
            swal("Erreur !","Format date incorrect! jj/mm/aaaa","error");dd.value="";

        }
        return v1;
    }

    function dfrtoen_val(date1)
    {
        var split_date=date1.split('/');
        var new_d=new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
        var new_day = new_d.getDate();
        new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un z�ro devant pour la forme
        var new_month = new_d.getMonth() + 1;
        new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un z�ro devant pour la forme
        var new_year = new_d.getYear();
        new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
        var new_date_text = new_year + '-' + new_month + '-' + new_day;
        return new_date_text;
    }


function validation(codedev,page) {

    var choix = document.getElementById("ag").value;
    var agence = "";
    var comag = 0;
    var comc = 0;
    if (choix == "") {
        agence = "";
        comag =<?php echo $tauxcom;?>;
        comc = 0;

    }else {
        if (choix == "1") {
            agence = document.getElementById("ag1").value;
            comag =<?php echo $tauxcom;?>;
            comc = 0;
        }
        else {
            if (<?php echo $cod_prod;?>==<?php echo $assurance_group;?>) {
                comag = document.getElementById("tcomag").value;
                comc = document.getElementById("tcomcourt").value;
            }
            else {
                comag = <?php echo $tauxcom_ag;?>;
                comc =  <?php echo $tauxcom_court;?>;
            }
            if (comag && comc && !isNaN(comag) && !isNaN(comc)) {
                agence = document.getElementById("ag2").value;

            }
            else {
                 swal("Attention !","Veuillez mentionner les taux de commissions","warning");

            }

        }
    }
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject)
        {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xhr.onreadystatechange =function()
        {

            if (this.readyState == 4 && this.status == 200)
            {

                res    = xhr.responseText.split(',');

                Menu1('prod','pol'+page);

            }
            else
            {
                document.getElementById("content-header").innerHTML='<div style="padding:20%; "><img src="img/spinner.gif" style="width:35px" alt=""/><H4>Validation en cours ...</H4></div>';
            }

        };

        // document.getElementById("btnsous").disabled=true;
        xhr.open("GET", "php/validation/validationgrp.php?code="+codedev+ "&agence=" + agence+"&cag="+comag+"&comc="+comc, false);
        xhr.send(null);





}

	
			
</script>	