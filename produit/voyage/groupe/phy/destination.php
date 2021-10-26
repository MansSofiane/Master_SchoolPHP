<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");

if (  isset ($_REQUEST['codsous'])  && isset ($_REQUEST['file'])  && isset ($_REQUEST['id_doc']) ) {

    $codsous = $_REQUEST['codsous'];
    $file = $_REQUEST['file'];
    $id_doc = $_REQUEST['id_doc'];
}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage-Famille</a> <a class="current">Nouveau-Devis</a> </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a><i></i>Souscripteur</a><a>Assure</a><a class="current">Destination</a></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="control-group">
                        <div class="controls">
                            <select id="pays" onchange="hadjetomra(this)">
                                <option value="">-- Pays : (*)</option>
                                <?php

                                $rqtpay = $bdd->prepare("SELECT * FROM `pays` ");
                                //$res_rqtop=mysql_query($rqtop) or die ($rqtop . "-----" . mysql_error());
                                $rqtpay->execute();

                                while ($row_per=$rqtpay->fetch()){ ?>
                                    <option value="<?php echo $row_per['cod_pays']; ?>"><?php echo $row_per['lib_pays'];  ?></option>
                                <?php } ?>
                            </select>&nbsp;&nbsp;

                            <select id="opt" onchange="hadjetomra(this)">
                                <option value="">-- Option : (*)</option>
                                <?php

                                $rqtopt = $bdd->prepare("SELECT * FROM `option` WHERE cod_opt = '22' OR cod_opt >= '30'");//OR cod_opt = '25'
                                //$res_rqtop=mysql_query($rqtop) or die ($rqtop . "-----" . mysql_error());
                                $rqtopt->execute();

                                while ($row_per=$rqtopt->fetch()){ ?>
                                    <option value="<?php echo $row_per['cod_opt']; ?>"><?php echo $row_per['lib_opt'];  ?></option>
                                <?php } ?>
                            </select>&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" class="date-pick dp-applied"  id="dateeffet" placeholder="Date d'effet(*)"  onblur="verifdate(this),hadjetomra(this)"/>
                            <input type="text" id="dur" class="span2" placeholder="Duree (Jours)" onblur ="addDay(this),hadjetomra(this)"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" class="span3"  id="datecheance" placeholder="Date d'echeance(*)"  onblur="verifdate(this),hadjetomra(this)" disabled="disabled"/>
                        </div>
                    </div>



                    <div class="form-actions" align="right">

                        <input  type="button" class="btn btn-success" onClick="inserdevis('<?php echo $codsous; ?>')" value="Enregistrer" />
                        <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoygrp.php')" value="Annuler" />
                    </div>


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
        function calage(dd)
        {
            var bb1=document.getElementById("datsys");
            var aa=new Date(dfrtoen(dd.value));
            var bb=new Date(bb1.value);
            var sec1=bb.getTime();
            var sec2=aa.getTime();
            var sec=(sec1-sec2)/(365.24*24*3600*1000);
            age=Math.floor(sec);
            return age;

        }
        function compdat(dd)
        {
            var rcomp=false;
            var bb1=document.getElementById("datsys");
            var aa=new Date(dfrtoen(dd.value));
            var bb=new Date(bb1.value);
            var sec1=bb.getTime();
            var sec2=aa.getTime();
            if(sec2>=sec1){rcomp=true;}
            return rcomp;

        }
        function addDays(dd,xx) {
            // Date plus plus quelques jours
            var split_date = dd.split('/');
            var new_date = new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1 + parseInt(xx)-1);
            var dd= new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
            var new_day = new_date.getDate();
            new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un zéro devant pour la forme
            var new_month = new_date.getMonth() + 1;
            new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un zéro devant pour la forme
            var new_year = new_date.getYear();
            new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
            var new_date_text = new_day + '/' + new_month + '/' + new_year;
            return new_date_text;
        }
        function compare_deux_dates(date_debut,date_fin)
        {
            var rcomp=false;

            var aa=new Date(dfrtoen(date_debut.value));
            var bb=new Date(dfrtoen(date_fin.value));
            var sec1=aa.getTime();
            var sec2=bb.getTime();
            if(sec2>=sec1){rcomp=true;}
            return rcomp;
        }
        function duree_en_jours(date_debut,date_fin)
        {
            var aa=new Date(dfrtoen(date_debut.value));
            var bb=new Date(dfrtoen(date_fin.value));
            var sec1=aa.getTime();
            var sec2=bb.getTime();
            var sec=(sec2-sec1)/(24*3600*1000);
            var dure_jour=Math.floor(sec);
            return dure_jour;
        }
        function  addDay(nbj)
        {
            if(nbj)
            {

                var nb_j=nbj.value;

                var option = document.getElementById("opt").value;
                var pay = document.getElementById("pays").value;
                var dateffet = document.getElementById("dateeffet");
                var datech = document.getElementById("datecheance");
                var d_eff=null, d_ech=null
                if( dateffet )
                {
                    d_eff=dateffet.value;

                    if(verifdate1(dateffet)) {

                        if (option == 30)
                        {
                            nbj.value=40;
                            d_ech=addDays(d_eff,40);
                            document.getElementById("datecheance").value=d_ech;
                            document.getElementById("datecheance").focus();
                        }
                        else
                        {
                            if(option == 31)
                            {
                                nbj.value=21;
                                d_ech=addDays(d_eff,21);
                                document.getElementById("datecheance").value=d_ech;
                                document.getElementById("datecheance").focus();

                            }
                            else
                            {
                                if(option == 24)
                                {
                                    nbj.value=30;
                                    d_ech=addDays(d_eff,30);
                                    document.getElementById("datecheance").value=d_ech;
                                    document.getElementById("datecheance").focus();

                                }
                                else
                                {
                                    if(option == 25)
                                    {
                                        nbj.value=30;
                                        d_ech=addDays(d_eff,30);
                                        document.getElementById("datecheance").value=d_ech;
                                        document.getElementById("datecheance").focus();

                                    }
                                    else
                                    {
                                        d_ech=addDays(d_eff,nb_j);
                                        document.getElementById("datecheance").value=d_ech;
                                        document.getElementById("datecheance").focus();

                                    }

                                }

                            }
                        }
                    }

                }
            }
            else
            {
                document.getElementById("datecheance").value="";
            }

        }

        function hadjetomra()
        {
            var option = document.getElementById("opt").value;
            var pay = document.getElementById("pays").value;
            var dateffet = document.getElementById("dateeffet");
            var datech = document.getElementById("datecheance");
            var d_eff=null, d_ech=null
            if(option && dateffet)
            {
                d_eff=dateffet.value;
                if (option ==30 && d_eff)//hadj
                {
                    d_ech=addDays(d_eff,40);
                    document.getElementById("datecheance").value=d_ech;
                    document.getElementById("pays").value="SA";

                    document.getElementById("dur").value=40;

                }
                else {
                    if (option == 31 && d_eff)//omra
                    {
                        d_ech = addDays(d_eff, 21);
                        document.getElementById("datecheance").value = d_ech;
                        document.getElementById("pays").value = "SA";
                        document.getElementById("dur").value = 21;
                    }
                    else
                    {
                        if (option == 24 && d_eff)//omra
                        {
                            d_ech = addDays(d_eff, 30);
                            document.getElementById("datecheance").value = d_ech;
                            document.getElementById("pays").value = "TN";
                            document.getElementById("dur").value = 30;
                        }
                        else
                        {
                            if (option == 25 && d_eff)//omra
                            {
                                d_ech = addDays(d_eff, 30);
                                document.getElementById("datecheance").value = d_ech;
                                // document.getElementById("pays").value = "TR";
                                document.getElementById("dur").value = 30;
                            }
                            else
                            {
                                if( document.getElementById("dur"))
                                {
                                    var nb_i= document.getElementById("dur").value;

                                    d_ech = addDays(d_eff, nb_i);
                                    document.getElementById("datecheance").value = d_ech;
                                }
                            }

                        }

                    }
                }
            }

        }
        function inserdevis(codsous) {

            var option = document.getElementById("opt").value;
            var pay = document.getElementById("pays").value;
            var dateffet = document.getElementById("dateeffet");
            var datech = document.getElementById("datecheance");
            var date = null, date2 = null, nb_jour = 0;
            var id_doc = '<?php echo $id_doc?>';

            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }

            if (option && dateffet && pay && datech) {
                if (option=="25")
                {

                    if (pay!="TN" && pay!="TR")
                    {
                        alert ("Cette option est reservee uniquement pour la Tunisie et la Turquie");
                        document.getElementById("pays").value = "";
                        return;

                    }

                }
                if (verifdate1(dateffet) && verifdate1(datech)) {
                    if (compdat(dateffet) && compdat(datech)) {
                        if (compare_deux_dates(dateffet, datech)) {
                            nb_jour = duree_en_jours(dateffet, datech) + 1;
                            if (nb_jour <= 365)
                            {
                                date = dfrtoen(dateffet.value);
                                date2 = dfrtoen(datech.value);
                                xhr.open("GET", "produit/voyage/groupe/phy/devi.php?cod=" + codsous + "&option=" + option + "&duree=" + nb_jour + "&pay=" + pay + "&dateffet=" + date  + "&datech=" + date2+ "&iddoc=" + id_doc,false);
                                xhr.send(null);
                                var rp=xhr.responseText;
                                if(rp==1){alert('insertion reussi '); $("#content").load("produit/assvoygrp.php"); }else{alert('Erreur : Un ou plusieurs assures ne repondent pas aux criteres de la souscription!!');}

                            }else { alert("attention, la duree choisie depasse la duree maximum de couverture de 365 jours. Veuillez modifier la duree!.");}
                        } else {alert("La date d'echanece doit etre superieure a la date d'effet");}
                    } else {alert("La date d'effet et la ate d'echeance doivent etre superieure ou egale a la date du jour!.");}

                }
            } else {alert("Veuillez remplir tous les champs Obligatoire (*) !");}
        }

    </script>
