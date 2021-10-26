 <?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
    $id_user=$_SESSION['id_usersal'];
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];

 // recupération du code du dernier souscripteur de l'agence
$rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$id_user'");
$rqtms->execute();
$codsous=0;
while ($row_res=$rqtms->fetch()) {
    $codsous = $row_res['maxsous'];

}
$rqtmrs=$bdd->prepare("SELECT * FROM `souscripteurw` WHERE cod_sous ='$codsous'");
$rqtmrs->execute();


while ($row=$rqtmrs->fetch()) {

    $codsous = $row['cod_sous'];
    $nom = $row['nom_sous'];
    $prenom =$row['pnom_sous'];
    $adr = $row['adr_sous'];
    $mail = $row['mail_sous'];
    $tel = $row['tel_sous'];
    $age = $row['age'];
    $sexe = $row['civ_sous'];
    $passport = $row['passport'];
    $datedpass = $row['datedpass'];

}


?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage-Individuel</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Assure</a></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">


                    <div class="control-group">
                        <div class="controls">
                            <input type="text" id="nsous" class="span4" value="Nom: <?php echo $nom; ?>" disabled="disabled"/>&nbsp;&nbsp;
                            <input type="text" id="psous" class="span4" value="Prenom: <?php echo $prenom; ?>" disabled="disabled" />



                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input type="text" id="mailsous" class="span4" value="E-mail: <?php echo $mail; ?>" disabled="disabled" />&nbsp;&nbsp;
                            <input type="text" id="telsous"   class="span4" value="Phone: <?php echo $tel; ?>" disabled="disabled" />

                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" id="adrsous"   class="span4" value="Adresse: <?php echo $adr; ?>" disabled="disabled" />&nbsp;&nbsp;
                            <input type="text" id="age" class="span4" value="Age: <?php echo $age; ?>" disabled="disabled"/>


                        </div>
                    </div>


                            </select>
                    <div class="control-group">
                        <div class="controls">

                            <input type="text" id="passport" class="span4" value="Numero de passport: <?php echo $passport; ?>" disabled="disabled"/> &nbsp;&nbsp;
                            <input type="text" id="datedpass"   class="span4" value="Delivre le: <?php echo $datedpass; ?>" disabled="disabled" />&nbsp;&nbsp;


                        </div> </div>
</form>
                        </div>






                        <div class="form-actions" align="right">

                            <input  type="button" class="btn btn-success" onClick="insertassur('<?php echo $codsous; ?>')" value="Suivant" />
                            <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoyind.php')" value="Annuler" />
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
        if(sec2>sec1){rcomp=true;}
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

    function insertassur(codsous){


        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject)
        {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        $("#content").load("produit/voyage/indi/phy/destination.php?codsous="+codsous);

    }
</script>
