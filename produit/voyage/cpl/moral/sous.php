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
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage-Couple</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a class="current"><i></i>Souscripteur</a><a>Assure</a><a>Destination</a> </div>
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
                            <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoycpl.php')" value="Annuler" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script language="JavaScript">initdate();</script>
    <script language="JavaScript">
        function initdate(){
            Date.firstDayOfWeek = 0;
            Date.format = 'dd/mm/yyyy';
            $(function()
            {$('.date-pick').datePicker({startDate:'01/01/1930'});});
        }
        function tarif(id,page) {
            document.getElementById('macc').setAttribute("class", "hover");
            document.getElementById('mstat').setAttribute("class", "hover");
            document.getElementById('mclt').setAttribute("class", "hover");
            document.getElementById('prod').setAttribute("class", "hover");
            document.getElementById(id).setAttribute("class", "active");
            $("#content").load('php/tarif/'+page);
        }
        function verifdate1(dd)
        {
            v1=true;
            var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
            var test = regex.test(dd.value);
            if(!test){
                v1=false;
                alert("Format date incorrect! jj/mm/aaaa");dd.value="";

            }
            return v1;
        }
        function dfrtoen(date1)
        {
            var split_date=date1.split('/');
            var new_d=new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
            var new_day = new_d.getDate();
            new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un zéro devant pour la forme
            var new_month = new_d.getMonth() + 1;
            new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un zéro devant pour la forme
            var new_year = new_d.getYear();
            new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
            var new_date_text = new_year + '-' + new_month + '-' + new_day;
            return new_date_text;
        }
        function instsous(user){

            var raison =document.getElementById("rs").value;
            var adresse =document.getElementById("adr").value;
            var  tel=null;
            tel =document.getElementById("telsous").value;

            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject)
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            if(raison  && adresse ){
                xhr.open("GET","produit/voyage/cpl/moral/new_sous.php?raison="+raison+"&adresse="+adresse+"&tel="+tel,false);
                xhr.send(null);
                $("#content").load("produit/voyage/cpl/moral/assure.php");
            }else{alert("Veuillez remplir tous les champs Obligatoire (*) !");}

        }

    </script>