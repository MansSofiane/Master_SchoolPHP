<?php session_start();

require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
    $id_user=$_SESSION['id_usersal'];
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if (isset($_REQUEST['reponse'])) {
$reponse=$_REQUEST['reponse'];
$sexe1="";

}
$codsous = 0;

// recupération du code de dernier souscripteur inscrit par cet utilisateur.
    $rqtms = $bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$id_user'");
    $rqtms->execute();

    while ($row_res = $rqtms->fetch()) {
        $codsous = $row_res['maxsous'];
    }
$rqtsous = $bdd->prepare("SELECT * FROM `souscripteurw` WHERE cod_sous='$codsous'");
$rqtsous->execute();

//SELECT `cod_sous`, `id_emprunteur`, `nom_sous`, `nom_jfille`, `pnom_sous`, `passport`, `datedpass`, `datefpass`, `mail_sous`,
// `tel_sous`, `adr_sous`, `dnais_sous`, `age`, `civ_sous`, `rp_sous`, `nb_assu`, `cod_par`, `id_user`, `cod_prof`, `cod_postal`,
// `autre_prof`, `quot_sous`, `sel` FROM `souscripteurw`
while ($row_sous = $rqtsous->fetch()) {
    $codsous = $row_sous['cod_sous'];
    $civ1 = $row_sous['civ_sous'];

    if($civ1==1)
    {
        $sexe1="M";
    }
    if($civ1==2)
    {
        $sexe1="Mme";
    }
    if($civ1==3)
    {
        $sexe1="Mlle";
    }

    $nom1 = $row_sous['nom_sous'];
    $nomi1 = addslashes($row_sous['nom_sous']);
    $prenom1 = $row_sous['pnom_sous'];
    $prenomi1 = addslashes($row_sous['pnom_sous']);
    $adr1 = $row_sous['adr_sous'];
    $adri1 = addslashes($row_sous['adr_sous']);
    $mail1 = $row_sous['mail_sous'];
    $tel1 = $row_sous['tel_sous'];
    $age1 = $row_sous['age'];
    $dnais1 = $row_sous['dnais_sous'];
    $numpass1 = $row_sous['passport'];
    $datepass1 = $row_sous['datedpass'];
    $raison1 = null ;
}

?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current"><a>Assure</a><a>Destination</a> </div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
   <?php if( $reponse==1) {?>
                    <label class="control-label">Assure(e)1:</label>

                    <div class="assure1" id="assur1">
                        <div class="controls">
                            <input type="text" id="civ1" value="<?php echo $sexe1;?>" class="span4"  disabled="disabled" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="controls">
                            <input type="text" id="nsous1" value="<?php echo $nomi1;?>" class="span4" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="psous1" value="<?php echo $prenomi1;?>" class="span4"disabled="disabled" />
                        </div>
                        <div class="controls">
                            <input type="text" id="mailsous1"  value="<?php echo $mail1;?>" class="span4" disabled="disabled" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="telsous1" value="<?php echo $tel1;?>" class="span4" disabled="disabled" />
                        </div>
                        <div class="controls">
                            <div data-date-format="dd/mm/yyyy">
                                <input type="text" id="adrsous1" value="<?php echo $adri1;?>" class="span4" disabled="disabled" />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" class="date-pick dp-applied"  id="dnaissous1"value="<?php echo $dnais1;?>" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="controls">
                            <input type="text" id="npass1" value="<?php echo $numpass1;?>"class="span4" disabled="disabled" />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" class="date-pick dp-applied"  id="dpass1" value="<?php echo $datepass1;?>" disabled="disabled"/>
                        </div>
                    </div>
                    <!-- separation ------>
                    <div class="control-group">
                        <div class="controls">
                        </div>
                    </div>
                    <!-- fin separation ------>
                    <label class="control-label" id="labassur2">Assure(e)2:</label>
                    <div class="assure1" id="assur2" >
                        <div class="controls">
                            <select id="civ2">
                                <option value="">--  Civilite(*)</option>
                                <option value="1">M</option>
                                <option value="2">Mme</option>
                                <option value="3">Mlle</option>
                            </select>
                        </div>
                        <div class="controls">
                            <input type="text" id="nsous2" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="psous2" class="span4" placeholder="Prenom (*)" />
                        </div>
                        <div class="controls">
                            <input type="text" id="mailsous2" class="span4" placeholder="E-mail" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="telsous2" class="span4" placeholder="Tel: 213 XXX XX XX XX" />
                        </div>
                        <div class="controls">
                            <div data-date-format="dd/mm/yyyy">
                                <input type="text" id="adrsous2" class="span4" placeholder="Adresse (*)" />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" class="date-pick dp-applied"  id="dnaissous2" placeholder="Date-Naissance 01/01/1970 (*)" onblur="compar_et_verifdat(this)"/>
                            </div>
                        </div>

                        <div class="controls">
                            <input type="text" id="npass2" class="span4" placeholder="Numero Passport:(*)" onblur="validepass(this)"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" class="date-pick dp-applied"  id="dpass2" placeholder="Delivre le: 01/01/2000 (*)" onblur="compar_et_verifdat(this)"/>
                        </div>
 <?php } else { ?>

                        <label class="control-label">Assure(e)1:</label>
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
                                    <input type="text" class="date-pick dp-applied"  id="dnaissous1" placeholder="Date-Naissance 01/01/1970 (*)" onblur="compar_et_verifdat(this)"/>
                                </div>
                            </div>
                            <div class="controls">
                                <input type="text" id="npass1" class="span4" placeholder="Numero Passport:(*)" onblur="validepass(this)" />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" class="date-pick dp-applied"  id="dpass1" placeholder="Delivre le: 01/01/2000 (*)" onblur="compar_et_verifdat(this)"/>
                            </div>
                        </div>
                        <!-- separation ------>
                        <div class="control-group">
                            <div class="controls">
                            </div>
                        </div>
                        <!-- fin separation ------>
                        <label class="control-label" id="labassur2">Assure(e)2:</label>
                        <div class="assure1" id="assur2" >
                            <div class="controls">
                                <select id="civ2">
                                    <option value="">--  Civilite(*)</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select>
                            </div>
                            <div class="controls">
                                <input type="text" id="nsous2" class="span4" placeholder="Nom (*)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="psous2" class="span4" placeholder="Prenom (*)" />
                            </div>
                            <div class="controls">
                                <input type="text" id="mailsous2" class="span4" placeholder="E-mail" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="telsous2" class="span4" placeholder="Tel: 213 XXX XX XX XX" />

                            </div>
                            <div class="controls">
                                <div data-date-format="dd/mm/yyyy">
                                    <input type="text" id="adrsous2" class="span4" placeholder="Adresse (*)" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" class="date-pick dp-applied"  id="dnaissous2" placeholder="Date-Naissance 01/01/1970 (*)" onblur="compar_et_verifdat(this)"/>
                                </div>
                            </div>
                            <div class="controls">
                                <input type="text" id="npass2" class="span4" placeholder="Numero Passport:(*)" onblur="validepass(this)"/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" class="date-pick dp-applied"  id="dpass2" placeholder="Delivre le: 01/01/2000 (*)" onblur="compar_et_verifdat(this)"/>
                            </div>
 <?php }?>
                    </div>
                    <div class="form-actions" align="right">
                        <input  type="button" class="btn btn-success" onClick="insertassur('<?php echo $reponse; ?>','<?php echo $codsous;?>')" value="Valider" />
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
    function insertassur(reponse1,cod_sous) {

        var reponse = reponse1;
        var codsous = cod_sous;
        var civilite1 = document.getElementById("civ1").value;
        var nom1 = document.getElementById("nsous1").value;
        var prenom1 = document.getElementById("psous1").value;
        var datnais1 = document.getElementById("dnaissous1");
        var numpass1 = document.getElementById("npass1").value;
        var datepass1 = document.getElementById("dpass1");
        var age1 = null, mail1 = null, tel1 = null, age12 = null;
        var date11 = null;
        var date12 = null;
        var date13 = null;
        var date14 = null;
        mail1 = document.getElementById("mailsous1").value;
        tel1 = document.getElementById("telsous1").value;
        var adr1 = document.getElementById("adrsous1").value;

        var civilite2 = document.getElementById("civ2").value;
        var nom2 = document.getElementById("nsous2").value;
        var prenom2 = document.getElementById("psous2").value;
        var datnais2 = document.getElementById("dnaissous2");
        var numpass2 = document.getElementById("npass2").value;
        var datepass2 = document.getElementById("dpass2");
        var age2 = null, mail2 = null, tel2 = null, age22 = null;
        var date21 = null;
        var date22 = null;
        var date23 = null;
        var date24 = null;
        mail2 = document.getElementById("mailsous2").value;
        tel2 = document.getElementById("telsous2").value;
        var adr2 = document.getElementById("adrsous2").value;

        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if (reponse == 2) {
            //le souscripteur n'est pas l'assure
            // on insert deux requetes assures
            codsous = cod_sous;
            if (civilite1 && nom1 && prenom1 && numpass1 && datepass1 && civilite2 && nom2 && prenom2 && numpass2 && datepass2 && adr1) {
                if (verifdate1(datnais1) && verifdate1(datnais2)) {
                    age1 = calage(datnais1);
                    age2 = calage(datnais2);
                    date11 = dfrtoen(datnais1.value);
                    date21 = dfrtoen(datnais2.value);
                    if (verifdate1(datepass1) && verifdate1(datepass2)) {
                        if (!compdat(datepass1) || !compdat(datepass2)) //vérifier que la date du passport est superieure a la date du jour.
                        {
                            date13 = dfrtoen(datepass1.value);
                            date23 = dfrtoen(datepass2.value);

                            validepass(document.getElementById("npass1"));
                            var numpass = document.getElementById("npass1").value;
                            validepass(document.getElementById("npass2"));
                            var numpass2 = document.getElementById("npass2").value;
                            if (numpass && date13 && numpass2 && date23) {

                                xhr.open("GET", "produit/voyage/cpl/phy/new_assu.php?codsous=" + codsous + "&mail=" + mail1 + "&tel=" + tel1 + "&adr=" + adr1 + "&civ=" + civilite1 + "&nom=" + nom1 + "&prenom=" + prenom1 + "&age=" + age1 + "&dnais=" + date11 + "&numpass=" + numpass1 + "&datepass=" + date13 + "&repense=" + reponse);
                                xhr.send(null);
                                if (window.XMLHttpRequest) {
                                    xhr = new XMLHttpRequest();
                                }
                                else if (window.ActiveXObject) {
                                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                                }

                                xhr.open("GET", "produit/voyage/cpl/phy/new_assu.php?codsous=" + codsous + "&mail=" + mail2 + "&tel=" + tel2 + "&adr=" + adr2 + "&civ=" + civilite2 + "&nom=" + nom2 + "&prenom=" + prenom2 + "&age=" + age2 + "&dnais=" + date21 + "&numpass=" + numpass2 + "&datepass=" + date23 + "&repense=" + reponse);
                                xhr.send(null);


                                $("#content").load("produit/voyage/cpl/phy/destination.php?reponse=" + reponse+"&codsous="+codsous);

                            } else {
                                alert("Le numero du passport et la date du passport sont obligatoires!.");
                            }
                        } else {
                            alert("La date du passport est superiere a la date du jour");
                        }
                    }
                }

            }
            else {
                alert("Veuillez remplir tous les champs Obligatoire (*) !");
            }
        }
        else {
            //le souscripteur c'est lui l assure
            //on insert un souscripteur  'souscripteur2' avec comme  nbassur=0 et cod_par=codsous


            if ( civilite2 && nom2 && prenom2 && numpass2 && datepass2 && adr1) {
                if (verifdate1(datnais2)) {

                    age2 = calage(datnais2);
                    if ( !compdat(datepass2)) //vérifier que la date du passport est superieure a la date du jour.
                    {

                        date21 = dfrtoen(datnais2.value);
                        validepass(document.getElementById("npass2"));
                        var numpass2 = document.getElementById("npass2").value;
                        date23 = dfrtoen(datepass2.value);
                        if (numpass2 && date23)
                        {

                            xhr.open("GET", "produit/voyage/cpl/phy/new_assu.php?codsous=" + codsous + "&mail=" + mail2 + "&tel=" + tel2 + "&adr=" + adr2 + "&civ=" + civilite2 + "&nom=" + nom2 + "&prenom=" + prenom2 + "&age=" + age2 + "&dnais=" + date21 + "&numpass=" + numpass2 + "&datepass=" + date23 + "&repense=" + reponse);
                            xhr.send(null);
                                $("#content").load("produit/voyage/cpl/phy/destination.php?reponse=" + reponse+"&codsous="+codsous);


                        } else {alert("Le numero du passport et la date du passport sont obligatoires!.");}

                    } else {alert("La date du passport est superiere a la date du jour");}
                }
            }
            else {alert("Veuillez remplir tous les champs Obligatoire (*) !");}
        }
    }


</script>
