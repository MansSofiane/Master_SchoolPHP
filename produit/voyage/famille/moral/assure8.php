<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
    $id_user=$_SESSION['id_usersal'];
}
else {
    header("Location:login.php");
}

$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
if( isset ($_REQUEST['nbassur'])) {

    $nbassur=$_REQUEST['nbassur'];
// recupération du code du dernier souscripteur de l'agence
    $rqtms = $bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$id_user'");
    $rqtms->execute();
    $codsous = 0;
    while ($row_res = $rqtms->fetch()) {
        $codsous = $row_res['maxsous'];
    }
}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage-Famille</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Assures</a></div>
            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <td>
                    &nbsp;&nbsp;
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
                        <tr>
                            <th valign="top">Assure:(1)-Civilite(*): </th>
                            <td><select  class="styledselect_form_1" id="sexea31">
                                    <option value="">--</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select></td>
                            <th valign="top">Nom: (*)</th>
                            <td><input type="text" id="noma31"  class="inp-form" onblur="verif(this)" /></td>

                            <th valign="top">Prenom: (*) </th>
                            <td><input type="text" id="pnoma31"  class="inp-form" onblur="verif(this)" /></td>
                        </tr>
                        <tr>
                            <th valign="top"> &nbsp; de Naissance:</th>
                            <td><input type="text" class="date-pick dp-applied"  id="naisa31" onblur="compar_et_verifdat(this)"/></td>

                            <th valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  N Passport: (*)</th>
                            <td><input type="text" class="inp-form" id="passa31" onblur="validepass(this)"/></td>
                            <th valign="top">Delivre le: (*)</th>
                            <td><input type="text" id="datedpassa31"  class="date-pick dp-applied" onblur="compar_et_verifdat(this)"/></td>
                        </tr>
                        <tr> <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>


                        <tr>
                            <th valign="top">Assure:(2)-Civilite(*): </th>
                            <td><select  class="styledselect_form_1" id="sexea32">
                                    <option value="">--</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select></td>

                            <th valign="top">Nom: (*)</th>
                            <td><input type="text" id="noma32"  class="inp-form" onblur="verif(this)" /></td>
                            <th valign="top">Prenom: (*) </th>
                            <td><input type="text" id="pnoma32"  class="inp-form" onblur="verif(this)" /></td>
                        </tr>
                        <tr>
                            <th valign="top">Date de Naissance:</th>
                            <td><input type="text" class="date-pick dp-applied"  id="naisa32" onblur="compar_et_verifdat(this)" /></td>

                            <th valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  N Passport: (*)</th>
                            <td><input type="text" class="inp-form" id="passa32" onblur="validepass(this)"/></td>
                            <th valign="top">Delivre le: (*)</th>
                            <td><input type="text" id="datedpassa32"  class="date-pick dp-applied" onblur="compar_et_verifdat(this)" /></td>
                        </tr>
                        <tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>
                        <tr>
                            <th valign="top">Assure:(3)-Civilite(*): </th>
                            <td><select  class="styledselect_form_1" id="sexea33">
                                    <option value="">--</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select></td>

                            <th valign="top">Nom: (*)</th>
                            <td><input type="text" id="noma33"  class="inp-form" onblur="verif(this)" /></td>
                            <th valign="top">Prenom: (*) </th>
                            <td><input type="text" id="pnoma33"  class="inp-form" onblur="verif(this)" /></td>
                        </tr>
                        <tr>
                            <th valign="top">Date de Naissance:</th>
                            <td><input type="text" class="date-pick dp-applied"  id="naisa33"  onblur="compar_et_verifdat(this)"/></td>

                            <th valign="top">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N Passport: (*)</th>
                            <td><input type="text" class="inp-form" id="passa33" onblur="validepass(this)"/></td>
                            <th valign="top">Delivre le: (*)</th>
                            <td><input type="text" id="datedpassa33"  class="date-pick dp-applied" onblur="compar_et_verifdat(this)" /></td>
                        </tr>

                        <tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>
                        <tr>
                            <th valign="top">Assure:(4)-Civilite(*): </th>
                            <td><select  class="styledselect_form_1" id="sexea34">
                                    <option value="">--</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select></td>

                            <th valign="top">Nom: (*)</th>
                            <td><input type="text" id="noma34"  class="inp-form" onblur="verif(this)" /></td>
                            <th valign="top">Prenom: (*) </th>
                            <td><input type="text" id="pnoma34"  class="inp-form" onblur="verif(this)" /></td>
                        </tr>
                        <tr>
                            <th valign="top">Date de Naissance:</th>
                            <td><input type="text" class="date-pick dp-applied"  id="naisa34" onblur="compar_et_verifdat(this)" /></td>

                            <th valign="top">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N Passport: (*)</th>
                            <td><input type="text" class="inp-form" id="passa34" onblur="validepass(this)"/></td>
                            <th valign="top">Delivre le: (*)</th>
                            <td><input type="text" id="datedpassa34"  class="date-pick dp-applied" onblur="compar_et_verifdat(this)" /></td>
                        </tr>

                        <tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>
                        <tr>
                            <th valign="top">Assure:(5)-Civilite(*): </th>
                            <td><select  class="styledselect_form_1" id="sexea35">
                                    <option value="">--</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select></td>

                            <th valign="top">Nom: (*)</th>
                            <td><input type="text" id="noma35"  class="inp-form" onblur="verif(this)" /></td>
                            <th valign="top">Prenom: (*) </th>
                            <td><input type="text" id="pnoma35"  class="inp-form" onblur="verif(this)" /></td>
                        </tr>
                        <tr>
                            <th valign="top">Date de Naissance:</th>
                            <td><input type="text" class="date-pick dp-applied"  id="naisa35" onblur="compar_et_verifdat(this)" /></td>

                            <th valign="top">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N Passport: (*)</th>
                            <td><input type="text" class="inp-form" id="passa35" onblur="validepass(this)"/></td>
                            <th valign="top">Delivre le: (*)</th>
                            <td><input type="text" id="datedpassa35"  class="date-pick dp-applied" onblur="compar_et_verifdat(this)" /></td>
                        </tr>

                        <tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>
                        <tr>
                            <th valign="top">Assure:(6)-Civilite(*): </th>
                            <td><select  class="styledselect_form_1" id="sexea36">
                                    <option value="">--</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select></td>

                            <th valign="top">Nom: (*)</th>
                            <td><input type="text" id="noma36"  class="inp-form" onblur="verif(this)" /></td>
                            <th valign="top">Prenom: (*) </th>
                            <td><input type="text" id="pnoma36"  class="inp-form" onblur="verif(this)" /></td>
                        </tr>
                        <tr>
                            <th valign="top">Date de Naissance:</th>
                            <td><input type="text" class="date-pick dp-applied"  id="naisa36" onblur="compar_et_verifdat(this)" /></td>

                            <th valign="top">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N Passport: (*)</th>
                            <td><input type="text" class="inp-form" id="passa36" onblur="validepass(this)"/></td>
                            <th valign="top">Delivre le: (*)</th>
                            <td><input type="text" id="datedpassa36"  class="date-pick dp-applied" onblur="compar_et_verifdat(this)" /></td>
                        </tr>
                        <tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>
                        <tr>
                            <th valign="top">Assure:(7)-Civilite(*): </th>
                            <td><select  class="styledselect_form_1" id="sexea37">
                                    <option value="">--</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select></td>

                            <th valign="top">Nom: (*)</th>
                            <td><input type="text" id="noma37"  class="inp-form" onblur="verif(this)" /></td>
                            <th valign="top">Prenom: (*) </th>
                            <td><input type="text" id="pnoma37"  class="inp-form" onblur="verif(this)" /></td>
                        </tr>
                        <tr>
                            <th valign="top">Date de Naissance:</th>
                            <td><input type="text" class="date-pick dp-applied"  id="naisa37" onblur="compar_et_verifdat(this)" /></td>

                            <th valign="top">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N Passport: (*)</th>
                            <td><input type="text" class="inp-form" id="passa37" onblur="validepass(this)"/></td>
                            <th valign="top">Delivre le: (*)</th>
                            <td><input type="text" id="datedpassa37"  class="date-pick dp-applied" onblur="compar_et_verifdat(this)" /></td>
                        </tr>

                        <tr><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>
                        <tr>
                            <th valign="top">Assure:(8)-Civilite(*): </th>
                            <td><select  class="styledselect_form_1" id="sexea38">
                                    <option value="">--</option>
                                    <option value="1">M</option>
                                    <option value="2">Mme</option>
                                    <option value="3">Mlle</option>
                                </select></td>

                            <th valign="top">Nom: (*)</th>
                            <td><input type="text" id="noma38"  class="inp-form" onblur="verif(this)" /></td>
                            <th valign="top">Prenom: (*) </th>
                            <td><input type="text" id="pnoma38"  class="inp-form" onblur="verif(this)" /></td>
                        </tr>
                        <tr>
                            <th valign="top">Date de Naissance:</th>
                            <td><input type="text" class="date-pick dp-applied"  id="naisa38" onblur="compar_et_verifdat(this)" /></td>

                            <th valign="top">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N Passport: (*)</th>
                            <td><input type="text" class="inp-form" id="passa38" onblur="validepass(this)"/></td>
                            <th valign="top">Delivre le: (*)</th>
                            <td><input type="text" id="datedpassa38"  class="date-pick dp-applied" onblur="compar_et_verifdat(this)" /></td>
                        </tr>

                    </table> </td></table>
            <div class="form-actions" align="right">

                <input  type="button" class="btn btn-success" onClick="insertassur('<?php echo $codsous; ?>','<?php echo $nbassur;?>')" value="Suivant" />
                <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoyfam.php')" value="Annuler" />
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
    function champs_obligatiores(nbassu) {

        var bool=true;
        var sex = null, nom = null, pnom = null, nais = null, pass = null, ddpassa = null, datenais = null,dpass=null;
        for (var iter = 1; iter <= nbassu; iter++)
        {
            sex = document.getElementById("sexea3" + iter).value;
            nom = document.getElementById("noma3" + iter).value;
            pnom = document.getElementById("pnoma3" + iter).value;
            nais = dfrtoen(document.getElementById("naisa3" + iter).value);
            pass = document.getElementById("passa3" + iter).value;
            ddpassa = dfrtoen(document.getElementById("datedpassa3" + iter).value);
            dpass = document.getElementById("datedpassa3" + iter);
            datenais = document.getElementById("naisa3" + iter);
            if(!(sex && nom && pnom && nais && pass && ddpassa) )
            {
                bool=false;
                break;
            }
        }
        return bool;
    }

    function insertassur(codsous1,nbassu1) {
        var codsous = codsous1;
        var nbassu = nbassu1;
        var sex = null, nom = null, pnom = null, nais = null, pass = null, ddpassa = null, datenais = null;
        var age = 0;


        if (champs_obligatiores(nbassu)) {
        for (var iter = 1; iter <= nbassu; iter++) {
            sex = document.getElementById("sexea3" + iter).value;
            nom = document.getElementById("noma3" + iter).value;
            pnom = document.getElementById("pnoma3" + iter).value;
            nais = dfrtoen(document.getElementById("naisa3" + iter).value);
            pass = document.getElementById("passa3" + iter).value;
            ddpassa = dfrtoen(document.getElementById("datedpassa3" + iter).value);
            datenais = document.getElementById("naisa3" + iter);
            age = calage(datenais);
            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xhr.open("GET", "produit/voyage/famille/moral/new_assure.php?civ=" + sex + "&nom=" + nom + "&prenom=" + pnom + "&age=" + age + "&dnais=" + nais + "&numpass=" + pass + "&datpass=" + ddpassa + "&cod_sous=" + codsous);
            xhr.send(null);
        }
        $("#content").load("produit/voyage/famille/moral/destination.php?codsous=" + codsous + "&nb_assur=" + nbassu1);
        } else {
            alert("Veuillez remplir tous les champs Obligatoire (*) !");
        }
    }
</script>
