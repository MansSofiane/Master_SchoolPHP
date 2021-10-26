<?php session_start();
require_once("../../../../../data/conn7.php");
$user=$_SESSION['id_usersal'];
// recupération du code du dernier souscripteur de l'agence
$rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$user'");
$rqtms->execute();
$codsous=0;
while ($row_res=$rqtms->fetch()){
    $codsous=$row_res['maxsous'];
}

// recupération du code du dernier souscripteur de l'agence
$rqtu=$bdd->prepare("SELECT agence  FROM `utilisateurs` WHERE id_user='$user'");
$rqtu->execute();
$agence=0;
while ($rowu=$rqtu->fetch()){
    $agence=$rowu['agence'];
}

?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a>Individuelle-Accident</a><a>Formule-Groupe</a><a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">(F-Excel)</a><a>Capital</a><a>Validation</a></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="control-group">

                    <div class="form-actions" align="right">
                        <input  type="button" class="btn btn-warning" onClick="Excel_indiv_grp()" value="Modele Excel" />
                        <input  type="button" class="btn btn-warning" onClick="cexel()" value="Importer Excel" />
                          <input  type="button" class="btn btn-success" onClick="listexlx()" value="Excel-(En-cours)" />
                        <input  type="button" class="btn btn-success" onClick="capitalindg('<?php echo $codsous; ?>')" value="Suivant" />
                        <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assiaccgrp.php')" value="Annuler" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript">
    function capitalindg(codsous){

        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject)
        {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        $("#content").load("doc/file/lifiles.php");
       // $("#content").load("produit/iaccidg/devindg3.php?sous="+codsous);

    }
    function vlassug(sous){
        var win = window.open("produit/iaccidg/phy/lassug.php?code="+sous, "window1", "resizable=0,width=700,height=600");
    }

</script>

