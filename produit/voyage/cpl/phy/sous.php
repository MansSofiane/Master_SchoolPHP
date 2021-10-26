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
    <ul><input type="hidden" id="datsys" value="<?php echo $datesys; ?>"/>
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage-Couple</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a class="current"><i></i>Souscripteur</a><a>Assure</a><a>Destination</a> </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal">

                        <div class="control-group">
                            <div class="controls">
                                <select id="rpsous" >
                                    <option value="">--  Le Souscripteur est l'assure(*)</option>
                                    <option value="1">OUI</option>
                                    <option value="2">NON</option>

                                </select>
                            </div>
                        </div>
                        <label class="control-label">Souscripteur:</label>
                        <div class="assure1" id="assur1">
                                 <div class="controls">
                                     <select id="civ1">
                                         <option value="">--  Civilite(*)</option>
                                         <option value="1">M</option>
                                         <option value="2">Mme</option>
                                         <option value="3">Mlle</option>
                                     </select>
                                 </div>

                                  <div class="controls">
                                      <input type="text" id="nsous1" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      <input type="text" id="psous1" class="span4" placeholder="Prenom (*)" />
                                  </div>
                                 <div class="controls">
                                     <input type="text" id="mailsous1" class="span4" placeholder="E-mail" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <input type="text" id="telsous1" class="span4" placeholder="Tel: 213 XXX XX XX XX" />

                                 </div>

                                        <div class="controls">
                                            <div data-date-format="dd/mm/yyyy">
                                                <input type="text" id="adrsous1" class="span4" placeholder="Adresse (*)" />
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text" class="date-pick dp-applied"  id="dnaissous1" placeholder="Date-Naissance 01/01/1970 (*)"/>
                                            </div>
                                        </div>
                                        <div class="controls">
                                            <input type="text" id="npass1" class="span4" placeholder="Numero Passport:(*)" />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="text" class="date-pick dp-applied"  id="dpass1" placeholder="Delivre le: 01/01/2000 (*)"/>
                                        </div>
                            </div>
                        <div class="control-group">
                            <div class="controls">
                            </div>
                        </div>
                            <div class="form-actions" align="right">
                                <input  type="button" class="btn btn-success" onClick="instarsous('<?php echo $id_user; ?>')" value="Suivant" />
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

        function instarsous(user) {

            var civilite1 = document.getElementById("civ1").value;
            var nom1 = document.getElementById("nsous1").value;
            var prenom1 = document.getElementById("psous1").value;
            var adr1 = document.getElementById("adrsous1").value;
            var datnais1 = document.getElementById("dnaissous1");
            var numpass1 = document.getElementById("npass1").value;
            var datepass1 = document.getElementById("dpass1");
            var rpsous1 = document.getElementById("rpsous").value;
            var age1 = null, mail1 = null, tel1 = null;
            var date21 = null;
            var date31 = null;
            mail1 = document.getElementById("mailsous1").value;
            tel1 = document.getElementById("telsous1").value;

            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }

            if (rpsous1) {

                if (rpsous1 == 1)// le souscripteur est l'assure
                {
                    if (civilite1 && nom1 && prenom1 && adr1 && numpass1 && datepass1) {

                        if (verifdate1(datnais1)) {

                            age1 = calage(datnais1);
                            date21 = dfrtoen(datnais1.value);
                            if (verifdate1(datepass1))//Verifier format date
                            {
                                if(!compdat(datepass1)) //vérifier que la date du passport est superieure a la date du jour.
                                {
                                    date31 = dfrtoen(datepass1.value);
                                    validepass(document.getElementById("npass1"));
                                    var numpass = document.getElementById("npass1").value;
                                    if (numpass && date31) {
                                        if (age1 >= 18 )
                                        {
                                           //inserer le souscripteur avec les parametre nbassur=1 et
                                            xhr.open("GET", "produit/voyage/cpl/phy/new_sous.php?civ1=" + civilite1 + "&nom1=" + nom1 + "&prenom1=" + prenom1 + "&adr1=" + adr1 + "&age1=" + age1 + "&dnais1=" + date21 + "&mail1=" + mail1 + "&tel1=" + tel1 + "&numpass1=" + numpass1 + "&datepass1=" + date31 + "&reponse=" + rpsous1,false);
                                            xhr.send(null);

                                            $("#content").load("produit/voyage/cpl/phy/assure.php?reponse=" + rpsous1);
                                        }
                                        else {alert("Le souscripteur doit avoir plus de 18 ans !");}
                                    } else {alert("Le numero du passport est obligatoire");}
                                } else { alert("La date du passport est superiere a la date du jour");}
                            }else {alert("Format date incorrect");}
                        }else {alert("Format date incorrect");}
                    }else {alert("Veuillez remplir tous les champs Obligatoire (*) !");}
                }
                else
                {//   le souscripteur nest pas l'assure
                    if (civilite1 && nom1 && prenom1 && adr1)
                    {
                        if (verifdate1(datnais1))
                        {
                            age1 = calage(datnais1);
                            date21 = dfrtoen(datnais1.value);
                            if (age1 >= 18) {
                               // alert("le souscripteur n'est pas , l assure la valeur est="+rpsous1);
                                xhr.open("GET", "produit/voyage/cpl/phy/new_sous.php?civ1=" + civilite1 + "&nom1=" + nom1 + "&prenom1=" + prenom1 + "&adr1=" + adr1 + "&age1=" + age1 + "&dnais1=" + date21 + "&mail1=" + mail1 + "&tel1=" + tel1 + "&numpass1=" + numpass1 + "&datepass1=" + date31 + "&reponse=" + rpsous1,false);
                                xhr.send(null);
                                $("#content").load("produit/voyage/cpl/phy/assure.php?reponse=" + rpsous1);
                            }
                            else {alert("Le souscripteur doit avoir plus de 18 ans !");}
                        }else {alert("Format date incorrect");}
                    } else {alert("Veuillez remplir tous les champs Obligatoire (*) !");}
                }
            }else {alert("Veuillez remplir tous les champs Obligatoire (*) !");}
        }

    </script>