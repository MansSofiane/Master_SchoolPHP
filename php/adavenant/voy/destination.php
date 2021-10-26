<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
function datenfr($dat)
{
    $d=new DateTime($dat);
    $dd=$d->format('d-m-Y');
    return $dd;
}
if (isset($_REQUEST['cod_pol']) && isset($_REQUEST['page'])  && isset($_REQUEST['formul'])&& isset($_REQUEST['tav'])) {
    $codepol = $_REQUEST['cod_pol'];
    $page = $_REQUEST['page'];
    $formul = $_REQUEST['formul'];
    $tav = $_REQUEST['tav'];

    //requete 1 recuperer le max cod avenant de changement de destination
    $rqtmx=$bdd->prepare("SELECT MAX(p.cod_av) as cod from avenantw as p  where p.cod_pol='$codepol' and p.lib_mpay='14'");
    $rqtmx->execute();
    $cod_avmaw="";
    while($rowwx=$rqtmx->fetch())
    {
        $cod_avmaw=$rowwx['cod'];
    }

    if($cod_avmaw!="")
    {
        $rqt=$bdd->prepare("select p.cod_av as cod,p.cod_opt as opt,p.cod_zone as cod_zone,p.cod_pays as cod_pays,p.dat_val as dat_val ,y.lib_pays as lib_pays
                            from avenantw as p , pays as y where cod_pol='$codepol' and p.cod_pays=y.cod_pays and p.cod_zone=y.cod_zone and p.lib_mpay='14'  and p.cod_av ='$cod_avmaw'");

        $rqt->execute();
    }
    else
    {
        $rqt=$bdd->prepare("select p.cod_pol as cod,p.cod_opt as opt,p.cod_zone as cod_zone,p.cod_pays as cod_pays,p.dat_val as dat_val ,y.lib_pays as lib_pays from policew as p , pays as y where cod_pol='$codepol' and p.cod_pays=y.cod_pays ");
        $rqt->execute();
    }
    while ($rows=$rqt->fetch()) {
        $cod_zone=$rows['cod_zone'];
        $cod_pays=$rows['cod_pays'];
        $lib_pays=$rows['lib_pays'];
        $cod_opt=$rows['opt'];

    }


    if($cod_zone==3) {
        $rqtzone = $bdd->prepare("SELECT * FROM `pays` WHERE cod_zone='$cod_zone' and cod_pays<>'$cod_pays'");
    }else
    {
        $rqtzone = $bdd->prepare("SELECT * FROM `pays` WHERE cod_zone>'1' and cod_pays<>'$cod_pays'");
    }
    $rqtzone->execute();
   //date effet et echeance
    $reqtdate=$bdd->prepare("select ndat_eff,ndat_ech from policew where cod_pol='$codepol'");
    $reqtdate->execute();
    while ($rwdat=$reqtdate->fetch())
    {
        $dat_eff=$rwdat['ndat_eff'];
        $dat_ech=$rwdat['ndat_ech'];
    }
}

?>

<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Avenant-Changement-Destination</h5></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">

                    <div class="controls">
                        <div class="control-group">
                            <label>Destination actuelle:</label>
                            <input type="text" id="old_dest" value="<?php echo $lib_pays;?>" class="span3" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <select id="pays">
                                <option value="">-- Pays : (*)</option>
                                <?php
                                while ($row_per=$rqtzone->fetch()){ ?>
                                    <option value="<?php echo $row_per['cod_pays']; ?>"><?php echo $row_per['lib_pays'];  ?></option>
                                <?php } ?>
                            </select>&nbsp;&nbsp;
                        </div>


                    </div>

                    <div class="controls">
                        <div class="control-group">
                            <div class="form-actions" align="right">
                                <input  type="button" class="btn btn-success" onClick="avenantdest('<?php echo $codepol; ?>','<?php echo $page; ?>')" value="Valider" />
                                <input  type="button" class="btn btn-danger"  onClick="aMenu1('prod','<?php echo $page;?>')" value="Annuler" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
    function addDays2(dd,xx) {
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
        var aa=new Date(dfrtoen(dd));
        var bb=new Date(bb1.value);
        var sec1=bb.getTime();
        var sec2=aa.getTime();

        if(sec2>=sec1){rcomp=true;}

        return rcomp;

    }
    function avenantdest(codpol,page) {

        var pays = document.getElementById('pays').value;
        var dateff = null;
         var datech=null;

        dateff='<?php echo $dat_eff;?>';
        datech='<?php echo $dat_ech;?>';
        var av = 14;//code avenant changement de la destination
        var opt = '<?php echo $cod_opt;?>';
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }

        if (pays) {
            if (opt == 25 && ( pays != 'TN' && pays != 'TR')) {
                alert("Cette option est reservee uniquement pour la Tunisie et la Turquie");
                document.getElementById("pays").value = "";
                return;
            }
            else {


                $("#content").load("php/adavenant/voy/mpaiement.php?code=" + codpol + "&page=" + page + "&av=" + av + "&datdebut=" + dateff + "&datfin=" + datech + "&pays=" + pays);
            }
        }
        else {
            alert("Veuillez introduire une date superieure ou egale a la date de jour");
        }
    }
</script>
