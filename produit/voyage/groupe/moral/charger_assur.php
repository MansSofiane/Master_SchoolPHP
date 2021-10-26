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
$folder = "documents/";
// recup�ration du code du dernier souscripteur de l'agence
$rqtms = $bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$id_user'");
$rqtms->execute();
$codsous = 0;
$existefile = 0;
while ($row_res = $rqtms->fetch()) {
    $codsous = $row_res['maxsous'];

}
$rqts=$bdd->prepare("SELECT * FROM `souscripteurw` WHERE cod_sous='$codsous'");
$rqts->execute();
$nom='';$pnom='';$adr='';
while ($row = $rqts->fetch())
{
    $nom=$row["nom_sous"];
    $pmon=$row["adr_sous"];
}
$agence="";
$rqtuser=$bdd->prepare("select agence from utilisateurs where id_user='$id_user'");
$rqtuser->execute();
while($rw=$rqtuser->fetch())
{
    $agence=$rw["agence"];
}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage-Groupe</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Chargement</a><a>Assures</a></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="control-group">
                        <div class="controls">
                            <th valign="top">Nom: </th>
                            <input type="text" id="noma31"  class="span4" value ="<?php echo $nom; ?>" disabled="disabled" />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <th valign="top">Adresse:  </th>
                            <input type="text" id="pnoma31"  class="span4" value ="<?php echo $pmon; ?>" disabled="disabled" />

                        </div>
                    </div>
                </form>
            </div>
            <div id="wait" align="center" hidden >
                    <p><img src="img/loader.gif"  alt="Loading..." width="100" height="150"/> Please Wait</p>
                </div>
            <div id ="groupBtn" class="form-actions" align="right">
                
                <input  type="button"  id="tele" class="btn btn-warning" onClick="charger_mexcel()" value="Telecharger Modele" />
                <input  type="button"  id="charg" class="btn btn-warning" onClick="charger('<?php echo $codsous; ?>')" value="Charger"  />
                <input  type="button"  id="suiv" class="btn btn-success"  value="Suivant" disabled="disabled"/>
                <input  type="button"  id = "annul"class="btn btn-danger"  onClick="Menu1('prod','assvoygrp.php')" value="Annuler" />
                
            </div>
            

        </div>
    </div>
</div>


<script language="JavaScript">initdate();</script>
<script language="JavaScript">
$(document).ready(function(){
    $("#suiv").click(function(){
        var codsous = <?php echo $codsous; ?>;
        $.ajax({
            type:"post",
            url:"produit/voyage/groupe/phy/check.php",
            data:{id_demande: codsous},
            beforeSend: function()
            {
                document.getElementById('tele').disabled=true;
                document.getElementById('charg').disabled=true;
                document.getElementById('suiv').disabled=true;
                document.getElementById('annul').disabled=true;
                $("#wait").show();  
            },
            complete:function(data)
            {
                $("#wait").hide();
                document.getElementById('tele').disabled= false;
                document.getElementById('charg').disabled=false;
                document.getElementById('suiv').disabled= false;
                document.getElementById('annul').disabled=false;
            },
            success:function(cc)
            {
                if(cc==0){
                    
                    alert("Veuillez charger  le fichier excel ...");
                }
                else
                {
                    xhr.open("GET","produit/voyage/groupe/phy/nbassur.php?codsous="+codsous,false);
                    xhr.send(null);
                    var rp=xhr.responseText;
                    if(rp==0) {
                        $("#content").load("produit/voyage/groupe/phy/assures.php?codsous=" + codsous);
                    }
                    else {
                        if (window.XMLHttpRequest) {
                            xhr = new XMLHttpRequest();
                        }
                        else if (window.ActiveXObject) {
                            xhr = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xhr.open("GET", "produit/voyage/groupe/phy/del_doc.php?id_doc=" + rp);
                        xhr.send(null);
                        var rp = xhr.responseText;
                        alert("Le nombre d'assures doit etre superieur ou egal a 10!");
                    }
                    $("#wait").hide();
                }
            }
        });
    });
});
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
        new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un z�ro devant pour la forme
        var new_month = new_d.getMonth() + 1;
        new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un z�ro devant pour la forme
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
        alert("age="+age);
        return age;
    }
    function charger_mexcel()
    {
        window.open('produit/voyage/groupe/file/modele_groupe.xlsx', 'groupeexcel', 'height=400, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
        document.getElementById('charg').disabled=false;
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
        new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un z�ro devant pour la forme
        var new_month = new_date.getMonth() + 1;
        new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un z�ro devant pour la forme
        var new_year = new_date.getYear();
        new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
        var new_date_text = new_day + '/' + new_month + '/' + new_year;
        return new_date_text;
    }

    function suivant(codsous)
    {
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject)
        {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        //xhr.open("GET","produit/voyage/groupe/phy/nbassur.php",false);
       
        xhr.open("GET","produit/voyage/groupe/moral/nbassur.php?codsous="+codsous,false);
        xhr.send(null);
        var rp=xhr.responseText;
        if(rp==0) {
        $("#content").load("produit/voyage/groupe/moral/assures.php?codsous="+codsous);
        }
        else
        {
            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject)
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xhr.open("GET","produit/voyage/groupe/moral/del_doc.php?id_doc=" + rp);
            xhr.send(null);
            var rp=xhr.responseText;

            alert("Le nombre d'assures doit etre superieur ou egal a 10!");
        }
    }

    function charger(cod_sous)
    {
        document.getElementById('suiv').disabled=false;
        window.open('produit/voyage/groupe/file/Chargement.html', 'Chargement', 'height=200, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);
    }

</script>
