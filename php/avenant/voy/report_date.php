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

    $rqt=$bdd->prepare("select * from policew where cod_pol='$codepol'");
    $rqt->execute();

    while ($rows=$rqt->fetch()) {
        $datdeb = $rows['ndat_eff'];
        $datech = $rows['ndat_ech'];

    }
    $nbjour=dure_en_jour($datdeb,$datech)+1;

}

?>

<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Avenant-report-de-date</h5></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="controls">
                        <input type="text" id="old_datdeb" value="<?php echo datenfr($datdeb);?>" class="span3" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" id="old_datfin" value="<?php echo datenfr($datech);?>" class="span3"disabled="disabled" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th>Duree en jours</th>
                        <input type="text" id="nbjour" value="<?php echo $nbjour;?>" class="span1"disabled="disabled" />
                    </div>
                    <div class="controls">
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div data-date-format="dd/mm/yyyy">
                                <input type="text" class="date-pick dp-applied"  id="ndatdeb" placeholder="Nouvelle date d effet"/>
                                <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>
                            </div>
                        </div>
                        <div class="form-actions" align="right">
                            <input  type="button" class="btn btn-success" onClick="avenantrpdate('<?php echo $codepol; ?>','<?php echo $page; ?>')" value="Valider" />
                            <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','<?php echo $page;?>')" value="Annuler" />
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
    function avenantrpdate(codpol,page)
    {

        var nbj=document.getElementById('nbjour').value;
        var ndatdeb=document.getElementById('ndatdeb').value;
        var av=74;//code avenant report de date.
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject)
        {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }

       if(ndatdeb) {

           if(compdat(ndatdeb)) {
               var datech = dfrtoen(addDays2(ndatdeb, nbj));
               var dateff = dfrtoen(ndatdeb);
               $("#content").load("php/avenant/voy/mpaiement.php?code="+codpol+"&page="+page+"&av="+av+"&datdebut="+dateff+"&datfin="+datech);
           }
           else
           {
              alert("Veuillez introduire une date superieure ou egale a la date de jour");
           }
       }



    }
</script>
