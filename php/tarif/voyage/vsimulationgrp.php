<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
//Periode
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE  trt_per >='1'  ORDER BY `cod_per`");
$rqtper->execute();
$rqttyp=$bdd->prepare("SELECT * FROM `type_sous`  WHERE 1 ");
$rqttyp->execute();
$rqtopt=$bdd->prepare("SELECT * FROM `option`  WHERE cod_opt = '22' OR cod_opt >= '30' ");// OR cod_opt ='25' 
$rqtopt->execute();
$rqtzone=$bdd->prepare("SELECT * FROM `pays`  WHERE 1 ");
$rqtzone->execute();
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyave</a> <a>Formule-Famille</a> <a class="current">Simulateur</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="control-group">
                        <div class="controls">
                            <select id="tsousscpl">
                                <option value="">-- Type-Souscripteur (*)</option>
                                <?php while ($row_res=$rqttyp->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_tsous']; ?>"><?php  echo $row_res['lib_tsous']; ?></option>
                                <?php } ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" class="inp-form"  id="nbpf"  placeholder="Nombre de personnes (*)"/>
                        </div>

                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <select id="opt" onchange="hadjetomra()">
                                <option value="" >-- Option (*)</option>
                                <?php while ($row_res=$rqtopt->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                                <?php } ?>
                            </select>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select id="zone" onchange="hadjetomra()">
                                <option value="">-- Pays (*)</option>
                                <?php while ($row_res=$rqtzone->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_pays']; ?>"><?php  echo $row_res['lib_pays']; ?></option>
                                <?php } ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        </div>
                        <div class="controls">
                            <select id="jour" onchange="hadjetomra()">
                                <option value="" >-- Duree (Jours):</option>
                                <?php while ($row_res=$rqtper->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                                <?php } ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" class="inp-form"  id="agef"  placeholder="Age moyen (*)"/>
                        </div>
                    </div>
                    <div class="control-group">

                        <div class="controls">
                            <div data-date-format="dd/mm/yyyy">
                                <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>
                            </div>
                        </div>
                        <div class="form-actions" align="right">
                            <input  type="button" class="btn btn-success" onClick="vtarfam()" value="Voir le Tarif" />
                            <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoygrp.php')" value="Retour" />
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">

    function hadjetomra()
    {
        var dure=document.getElementById("jour").value;
        var opt=document.getElementById("opt").value;
        var zone=document.getElementById("zone").value;

        if(opt ) {
            if (opt == 30) {
                document.getElementById("zone").value = "SA";
                document.getElementById("jour").value = '';
                document.getElementById("jour").options[0].text ="40 jours";
            }
            else {
                if (opt == 31) {
                    document.getElementById("zone").value = "SA";
                    document.getElementById("jour").value = '';
                    document.getElementById("jour").options[0].text = "21 jours";
                }
                else
                {
                    if (opt == 24) {
                        document.getElementById("zone").value = "TN";

                        document.getElementById("jour").options[0].text = "1 Mois";
                        document.getElementById("jour").disabled=true;
                        document.getElementById("jour").options[0].value = "7";
                        document.getElementById("jour").selectedIndex=0;

                    }else
                    {
                        if (opt == 25) {


                            document.getElementById("jour").options[0].text = "1 Mois";
                            document.getElementById("jour").disabled=true;
                            document.getElementById("jour").options[0].value = "7";
                            document.getElementById("jour").selectedIndex=0;
                            // document.getElementById("zonescpl").selectedIndex=0;

                        }else
                        {
                            document.getElementById("jour").options[0].text ="-- Duree (Jours):";
                            document.getElementById("jour").options[0].value ="";
                        }


                    }
                }
            }
        }

    }


    function vtarfam()
    {

        var jour = document.getElementById("jour").value;
        var nbpf = document.getElementById("nbpf").value;
        var opt = document.getElementById("opt").value;
        var zone = document.getElementById("zone").value;
        var age = document.getElementById("agef").value;
        var tsous=document.getElementById("tsousscpl").value;
        if(opt)
        {
            if(opt=="30")
            {
                jour="18";
            }
            if(opt=="31")
            {
                jour="5";
            }
            if(opt=="24")
            {
                jour="7";
            }
            if(opt=="25")
            {
                jour="7";
                if (zone!="TN" && zone!="TR")
                {
                    alert ("Cette option est reservee uniquement pour la Tunisie et la Turquie");
                    document.getElementById("zone").value = "";
                    return;

                }
            }

        }
        if(jour && nbpf && opt && zone && age && tsous)
        {
            if (isNaN(jour) != true && isNaN(nbpf) != true && isNaN(age) != true) {
                if (window.XMLHttpRequest) {
                    xhr = new XMLHttpRequest();
                }
                else if (window.ActiveXObject) {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }

                xhr.open("GET", "php/tarif/voyage/rtvoygrp.php?row=" + jour + "&row1=" + nbpf + "&row2=" + opt + "&row3=" + zone + "&row4=" + age+"&tsous="+tsous, false);
                xhr.send(null);
                alert(xhr.responseText);
            } else {
                alert("merci de saisir un nombre entier!");
            }
        }else

        {alert("veuillez remplir tous les champs obligatiore!.");}

    }

</script>	