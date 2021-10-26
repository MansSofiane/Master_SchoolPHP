<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");

?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage-Individuel</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a class="current"><i></i>Souscripteur_Moral</a><a>Assure</a>
                <div class="widget-content nopadding">
                    <form class="form-horizontal">
                        <div class="control-group">
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" id="rs" class="span4" placeholder="Raison social (*)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="adr" class="span4" placeholder= "Adresse (*)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="telsous" class="span3" placeholder="Tel: 213 XXX XX XX XX" />
                            </div>
                        </div>
                            <div class="form-actions" align="right">
                                <input  type="button" class="btn btn-success" onClick="instsous('<?php echo $id_user; ?>')" value="Suivant" />
                                <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoyind.php')" value="Annuler" />
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script language="JavaScript">initdate();</script>
    <script language="JavaScript">
        function instsous(user) {

            var raison = document.getElementById("rs").value;
            var adresse = document.getElementById("adr").value;
            var tel = null;
            tel = document.getElementById("telsous").value;

            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            if (raison && adresse)
            {
               xhr.open("GET", "produit/voyage/indi/moral/new_sous.php?raison=" + raison + "&adresse=" + adresse + "&tel=" + tel,false);
               xhr.send(null);
                $("#content").load("produit/voyage/indi/moral/assur.php");
            }else
            {
                alert("Veuillez remplir tous les champs Obligatoire (*) !");
            }
        }

    </script>