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
            <div id="breadcrumb"> <a class="current"><i></i>Souscripteur</a><a>Assure</a>
                <div class="widget-content nopadding">
                    <form class="form-horizontal">

                        <div class="control-group">
                            <div class="controls">
                                <select id="civ">
                                    <option value="">--  Civilite(*)</option>
                                    <option value="1"> M</option>
                                    <option value="2"> Mme</option>
                                    <option value="3"> Mlle</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <input type="text" id="nsous" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="psous" class="span4" placeholder="Prenom (*)" />
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" id="mailsous" class="span4" placeholder="E-mail" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="telsous" class="span4" placeholder="Tel: 213 XXX XX XX XX" />

                            </div>
                        </div>
                            <div class="control-group">
                                <div class="controls">
                                     <div data-date-format="dd/mm/yyyy">
                                         <input type="text" id="adrsous" class="span4" placeholder="Adresse (*)" />
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="text" class="date-pick dp-applied"  id="dnaissous" placeholder="Date-Naissance 01/01/1970 (*)"onblur="compar_et_verifdat(this)"/>


                                    </div>
                                </div>

                        <div class="control-group">
                            <div class="controls">
                                <input type="text" id="npass" class="span4" placeholder="Numero Passport:" onblur="validepass(this)"/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" class="date-pick dp-applied"  id="dpass" placeholder="Delivre le: 01/01/2015" onblur="compar_et_verifdat(this)"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls" >

                                <div data-date-format="dd/mm/yyyy" align="middle">

                                    <select id="rpsous" >
                                        <option value="">--  Le Souscripteur est l'assure(*)</option>
                                        <option value="1">--  OUI</option>
                                        <option value="2">--  NON</option>
                                    </select>
                                </div>
                             </div>

                            <div class="form-actions" align="right">
                                <input  type="button" class="btn btn-success" onClick="instarsous('<?php echo $id_user; ?>')" value="Suivant" />
                                <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoyind.php')" value="Annuler" />
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
        function compar_et_verifdat(dd)
        {
            if( verifdate1(dd) )
            {
                if( compdat(dd))
                {
                    alert ("La date  est superiere a la date du jour");
                    dd.value="";
                    return ;
                }
            }
        }
        function instarsous(user){
            var civilite=document.getElementById("civ").value;
            var nom=document.getElementById("nsous").value;
            var prenom=document.getElementById("psous").value;
            var adr=document.getElementById("adrsous").value;
            var datnais=document.getElementById("dnaissous");
            
            var datepass=document.getElementById("dpass");
            var reponse=document.getElementById("rpsous").value;
            var age=null,mail=null,tel=null;
            var date2=null; var date3=null;
            mail=document.getElementById("mailsous").value;
            tel=document.getElementById("telsous").value;


            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject)
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }

            if(civilite && nom && prenom && adr && reponse)
            {
                if(verifdate1(datnais)) {
                    age = calage(datnais);
                    date2 = dfrtoen(datnais.value);
                    if (verifdate1(datepass)) {date3 = dfrtoen(datepass.value);}
                        if (age >= 18) {
                            if (reponse == 1) {
                                if (!compdat(datepass))
                                {
                                    validepass(document.getElementById("npass"));
                                    var numpass = document.getElementById("npass").value;
                                    if (numpass && date3) {
                                        xhr.open("GET", "produit/voyage/indi/phy/new_sous.php?civ=" + civilite + "&nom=" + nom + "&prenom=" + prenom + "&adr=" + adr + "&age=" + age + "&dnais=" + date2 + "&mail=" + mail + "&tel=" + tel + "&numpass=" + numpass + "&datepass=" + date3,false);
                                        xhr.send(null);
                                        var rp=xhr.responseText;
                                        if(rp==1) {
                                            $("#content").load("produit/voyage/indi/phy/assur.php");
                                        }else
                                        {alert("Erreur d'insertion");}
                                    } else {
                                        alert("Le numero du passport est obligatoire");
                                    }
                                } else {alert("La date du passport est superiere a la date du jour");}

                            } else {
                                xhr.open("GET", "produit/voyage/indi/phy/new_sous1.php?civ=" + civilite + "&nom=" + nom + "&prenom=" + prenom + "&adr=" + adr + "&age=" + age + "&dnais=" + date2 + "&mail=" + mail + "&tel=" + tel + "&numpass=" + numpass + "&datepass=" + date3,false);

                                xhr.send(null);
                                $("#content").load("produit/voyage/indi/phy/assur1.php");
                            }

                        } else {
                            alert("Le souscripteur doit avoir plus de 18 ans !");
                        }                    
                }

            }else{alert("Veuillez remplir tous les champs Obligatoire (*) !");}

        }

    </script>