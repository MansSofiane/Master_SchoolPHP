<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
// $("#content").load('php/avenant/voy/modif_assur.php?page='+page+"&cod_pol="+cod_police+"&formul="+formul+"&tav="+tav+'&pagepres='+pageprec+'&rech='+rech+'&cod_sous='+cod_sous);


function datenfr($dat)
{
    $d=new DateTime($dat);
    $dd=$d->format('d/m/Y');
//$dd=date("d/m/y",strtotime($dat));
    return $dd;
}
if (isset($_REQUEST['pagepres']))
{
    $pagepres= $_REQUEST['pagepres'];
}else
{$pagepres=0;}

if (isset($_REQUEST['cod_pol']))
{
    $codepol = $_REQUEST['cod_pol'];
}
if ( isset($_REQUEST['page']) ) {

    $page = $_REQUEST['page'];
    $codepol = $_REQUEST['cod_pol'];
    $formul = $_REQUEST['formul'];
    $tav = $_REQUEST['tav'];
    $cod_sous=$_REQUEST['cod_sous'];
    $rech=$_REQUEST['rech'];
}

$rqtas=$bdd->prepare("SELECT * FROM  modif where cod_assu='$cod_sous' order by cod_assu");
$rqtas->execute();
$i=0;
$nom_sous="";
$pnom_sous="";
$adr_sous="";
$passport="";
$mail_sous="";
$tel_sous="";
$datedpass="";
while($rowas=$rqtas->fetch())
{
    $i++;
    $nom_sous=$rowas['nom_assu'];
    $pnom_sous=$rowas['pnom_assu'];
    $adr_sous=$rowas['adr_assu'];
    $passport=$rowas['passport'];
    $mail_sous=$rowas['mail_assu'];
    $tel_sous=$rowas['tel_assu'];
    $datedpass=$rowas['datedpass'];

}
/*
if($i==0) {
    $rqt = $bdd->prepare("select * from souscripteurw where cod_sous='$cod_sous'");
    $rqt->execute();
    while ($rowassur = $rqt->fetch()) {
        $nom_sous = $rowassur['nom_sous'];
        $pnom_sous = $rowassur['pnom_sous'];
        $adr_sous = $rowassur['adr_sous'];
        $passport = $rowassur['passport'];
        $mail_sous = $rowassur['mail_sous'];
        $tel_sous = $rowassur['tel_sous'];
        $datedpass = $rowassur['datedpass'];
    }
}*/
?>


<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage</a> <a class="current">Avenant</a> </div>
</div>

            <div id="breadcrumb"> <a> Avenant-Precision</a><a class="current"><i></i>Modifier</a></div>
                <table border="0" width="100%" cellpadding="0" cellspacing="0">

                   <td>
                       <tr>
                        <th> Nom:</th>
                           <td> <input type="text" id="nsous" class="span4" value="<?php echo $nom_sous;?>" placeholder="Nom (*)" /></td>
                           <th>Prenom:</th>
                           <td> <input type="text" id="psous" class="span4" value="<?php echo $pnom_sous;?>" placeholder="Prenom (*)" /></td>

                       </tr>
                       <tr>
                           <th>Adresse:</th>
                           <td> <input type="text" id="adrsous" class="span4" value="<?php echo $adr_sous;?>" placeholder="Adresse (*)" /></td>
                           <th>E-mail:</th>
                           <td> <input type="text" id="mailsous" class="span4" value="<?php echo $mail_sous;?>" placeholder="E-mail" /></td>
                           <th>Telephone:</th>
                           <td> <input type="text" id="telsous" class="span4" value="<?php echo $tel_sous;?>" placeholder="Tel: 213 XXX XX XX XX" /></td>
                        </tr>
                       <tr>
                           <th>Numero de passport:</th>
                           <td><input type="text" id="passport" class="span4" value="<?php echo $passport;?>" onblur="validepass(this)" placeholder="Passport" /></td>
                           <th>Delivre le:</th>
                           <td> <input type="text" class="date-pick dp-applied"  id="dpassport" value="<?php echo datenfr( $datedpass);?>" placeholder="Delivre le:"/> </td>

                       </tr>
                   </td>
                </table>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="control-group">
                        <div class="form-actions" align="right">
                            <input  type="button" class="btn btn-success" onClick="modifier('<?php echo $id_user; ?>','<?php echo $cod_sous; ?>','<?php echo $codepol; ?>')" value="Suivant" />
                            <input  type="button" class="btn btn-danger"  onClick="annuler('<?php echo $id_user; ?>','<?php echo $cod_sous; ?>','<?php echo $codepol; ?>')" value="Annuler" />
                        </div>
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
    function annuler(id_user,cod_sous,cod_pol)
    {
        var page='<?php echo  $page;?>';
        var pageprcis='<?php echo  $pagepres;?>';
        var formul= '<?php echo  $formul;?>';
        var tav= '<?php echo  $tav;?>';
        var rech='<?php echo $rech;?>';
        $("#content").load('php/avenant/voy/precision.php?page='+page+"&cod_pol="+cod_pol+"&formul="+formul+"&tav="+tav+"&pagepres="+pageprcis+'&rech='+rech);

    }
    function modifier (id_user,cod_sous,cod_pol)
    {

        var nnom=document.getElementById('nsous').value;
        var nprenom=document.getElementById('psous').value;
        var nadr=document.getElementById('adrsous').value;
        var nmail=document.getElementById('mailsous').value;
        var ntel=document.getElementById('telsous').value;
        var npass=document.getElementById('passport').value;

        var ndatpass= null;
        var ndatpass2=null;
        if(npass!="")
        {

           if(verifdate1( document.getElementById('dpassport'))) {
               ndatpass = document.getElementById('dpassport').value;
               ndatpass2 = dfrtoen(ndatpass);
           }else
           {return;}

        }


        var oldnom='<?php echo $nom_sous ;?>';
        var oldprenom='<?php echo $pnom_sous;?>';
        var oldadr='<?php echo $adr_sous;?>';
        var oldmail='<?php echo $mail_sous ;?>';
        var oldtel='<?php echo $tel_sous;?>';
        var oldpass='<?php echo $passport;?>';
        var olddatpass=<?php echo $datedpass;?>;


        if((nnom==oldnom) && (nprenom==oldprenom) && (nadr==oldadr) && (nmail==oldmail) && (ntel==oldtel) && (npass==oldpass)  && (ndatpass2==olddatpass) )
       {


        }
        else
        {

          //inserer dans assure

            xhr.open("GET", "php/avenant/voy/nmodif.php?code=" + cod_pol +"&nom="+nnom+"&pnom="+nprenom+"&adr="+nadr+"&mail="+nmail+"&tel="+ntel+"&pass="+npass+"&dpas="+ndatpass2+"&cod_sous="+cod_sous, false);
            xhr.send(null);
            //revenir a precision.

          var page='<?php echo  $page;?>';
            var pageprcis='<?php echo  $pagepres;?>';
          var formul= '<?php echo  $formul;?>';
          var tav= '<?php echo  $tav;?>';
            var rech='<?php echo $rech;?>';
        $("#content").load('php/avenant/voy/precision.php?page='+page+"&cod_pol="+cod_pol+"&formul="+formul+"&tav="+tav+"&pagepres="+pageprcis+'&rech='+rech);

        }








    }


</script>