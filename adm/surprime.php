<?php
session_start();
require_once("../../../data/conn7.php");

if ($_SESSION['loginsal']){
    $id_user=$_SESSION['id_usersal'];
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];

//  $("#content").load("adm/surprime.php?id="+id+"&page="+page+"&cod_dev=" + codedev + "&prime=" + pn  );


if ( isset($_REQUEST['id']) && isset($_REQUEST['page']) && isset($_REQUEST['cod_dev']) && isset($_REQUEST['prime'])  ) {

    $cod_dev = $_REQUEST['cod_dev'];
    $prime = $_REQUEST['prime'];
    $id = $_REQUEST['id'];
    $page = $_REQUEST['page'];
   switch ($page)
   {
       case 'asstd.php':
       {
           $nom_produit="Temporaire-Deces";
           break;
       }
       case 'asscim.php':
       {
           $nom_produit="A-Deces-Emprunteur";
           break;
       }
       case 'assiaccind.php':
       {
           $nom_produit="Individuel-Accident";
           break;
       }
       case 'assiaccgrp.php':
       {
           $nom_produit="Individuel-Accident";
           break;
       }
       case 'assward.php':
       {
           $nom_produit="Cancer-Du-Sein-Warda";
           break;
       }


   }

    $rqtv=$bdd->prepare("SELECT * FROM `devisw`  WHERE `cod_dev`='$cod_dev'");
    $rqtv->execute();

    while ($row=$rqtv->fetch()){
        $primeold=$row['pn'];
        $primetold=$row['pt'];
        $cod_dt=$row['cod_dt'];
        $cod_cpl=$row['cod_cpl'];

    }
    $rqtdt=$bdd->prepare("SELECT * FROM `dtimbre`  WHERE `cod_dt`='$cod_dt'");
    $rqtdt->execute();

    while ($rowdt=$rqtdt->fetch()){
        $dt=$rowdt['mtt_dt'];

    }
    $rqcpl=$bdd->prepare("SELECT * FROM `cpolice`  WHERE `cod_cpl`='$cod_cpl'");
    $rqcpl->execute();

    while ($rowcpl=$rqcpl->fetch())
    {
        $cpl=$rowcpl['mtt_cpl'];
    }

}
?>

<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a><?php echo $nom_produit;?></a><a><?php echo "Devis N:".$cod_dev;?></a><a class="current">Nouvelle prime</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">

            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <label class="control-label">Prime Actuelle:</label>
                    <div class="controls">
                        <input type="text" id="nprim" class="span4" value="<?php echo "".number_format($primeold, 2, ',', ' ');?>" disabled="disabled"/>

                    </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select id="nformule" onchange="mask()">
                    <option value="">--  Formule</option>
                    <option value="1">-- Prime telle quelle</option>
                    <option value="3">--  Surprime</option>
                </select>

            </div>
        </div>
        <div class="control-group" id="grnprime" >
            <label class="control-label">:</label>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="controls">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="hidden" id="taux" class="span2"  onblur="calculprime()" placeholder="Nouveau taux" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="hidden" class="span2"  id="nprim2" onblur="separateur(this)" placeholder="Nouvelle prime a payer" disabled="disabled" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
        <div class="form-actions" align="right">
            <input  type="button" class="btn btn-success" onClick="mise_ajour_prime()" value="Valider" />
            <input  type="button" class="btn btn-danger"  onClick="aMenu1('<?php echo $id;?>','<?php echo $page;?>')" value="Annuler" />
        </div>
        </form>
    </div>
</div>

<script language="JavaScript">initdate();</script>
<script language="JavaScript">
    function separateur(nb1)
    {
        var capital =nb1.value.replace(' ','');
        var arryacap=capital.split(' ');
        var i=0;
        var cap1="";
        while(i<arryacap.length)
        {
            cap1+=arryacap[i];
            i++;
        }
        if(cap1.length>0 && isNaN(cap1))
        {
            alert("Format numerique incorrect!.");
        }
        nb1.value=formatValeur( cap1);
    }
    function mise_ajour_prime()
    {
        if (window.XMLHttpRequest){ xhr = new XMLHttpRequest();}
        else if (window.ActiveXObject){xhr = new ActiveXObject("Microsoft.XMLHTTP");}

        var id = "<?php echo $id;?>";//Code devis
        var page = '<?php echo $page;?>';//prime old.
        var codedev = "<?php echo $cod_dev;?>";//Code devis
        var primold = <?php echo $primeold;?>;//prime old.
        var primetold=<?php echo $primetold;?>;// prime total old
        var dt=<?php echo $dt;?>;//montant_dtimbre
        var cpl=<?php echo $cpl;?>;//montant de police
        var nprime=0;
        var nprimet=0;
        var nformule=document.getElementById("nformule").value;
        var surtaux=document.getElementById("taux").value;//surtaux

        if(nformule)
        {
            if(!isNaN(surtaux) ) {
                switch (nformule) {
                    case "1":
                    {
                        nprime = primold;
                        nprimet = primetold;
                        break;
                    }
                    case "3":
                    {
                        nprime = primold * (1 + surtaux / 100);
                        nprimet = nprime+dt+cpl;
                        break;
                    }
                }
                if (isNaN(nprimet) != true) {
                    var ok = confirm("Comfirmez Accord du devis ");
                    if (ok) {
                        xhr.open("GET", "php/validation/accordprime.php?code=" + codedev + "&prime=" + nprime+ "&primet=" + nprimet, false);
                        xhr.send(null);
                        alert("Demande Accordee !");
                        aMenu1(id, page);
                    }
                }else {alert("Format dincorrect!");}
            }else{alert("veuillez v�rifier le format de nouveau taux");}
        }else{alert("Veuillez selectionner une formule!"); }
    }

    function mask()
    {
        var formule=document.getElementById("nformule").value;

        if(formule==1)
        {

            document.getElementById('grnprime').style.visibility='hidden';
            document.getElementById('taux').value="0";
            document.getElementById('nprim2').value="<?php echo $primeold;?>";
        }
        else{
            document.getElementById('grnprime').style.visibility='visible';
            document.getElementById('taux').type='txt';
            document.getElementById('taux').placeholder = "surprime (%)";
            document.getElementById('nprim2').disabled=true;
            document.getElementById('nprim2').type='txt';
            document.getElementById('taux').value="";
            document.getElementById('nprim2').value="";
        }
    }

    function calculprime()
    {
        var codedev = "<?php echo $cod_dev;?>";//Code devis
        var primold = <?php echo $primeold;?>;//prime old.
        var primetold=<?php echo $primetold;?>;// prime total old
        var dt=<?php echo $dt;?>;//montant_dtimbre
        var cpl=<?php echo $cpl;?>;//montant de police
        var nprime=0;
        var nprimet=0;
        var nformule= document.getElementById("nformule").value;
        var surtaux=  document.getElementById("taux").value;//surtaux

        if(nformule)
        {
            if (!isNaN(surtaux))
            {
                switch (nformule) {
                    case "1":
                    {
                        nprime = primold;
                        nprimet = primetold;
                        document.getElementById("nprim2").value=nprime;
                        break;
                    }
                    case "3":
                    {
                        nprime = primold * (1 + surtaux / 100);
                        nprimet = nprime+dt+cpl;
                        document.getElementById("nprim2").value=nprime;
                        break;
                    }
                }
            }
            else
            {
                document.getElementById("nprim2").value="";
            }
        }
    }
</script>
