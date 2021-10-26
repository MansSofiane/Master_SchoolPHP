<?php session_start();

require_once("../../../../data/conn7.php");
if ($_SESSION['login'])
{}

else
{
    header("Location:login.php");
}
$id_user = $_SESSION['id_user'];


$datesys=date("y-m-d");
// $("#content").load('php/validation/regl.php?code='+codedev+'&page='+page+'&tok='+token+'&t='+type+'&p='+cod_police);

if (isset($_REQUEST['code']) && isset($_REQUEST['page'])) {
    $codedev = $_REQUEST['code'];$page = $_REQUEST['page'];
    $type=$_REQUEST['t'];
    $police=$_REQUEST['p'];

}
$requet_agence=$bdd->prepare("select agence from utilisateurs where id_user='$id_user'");
$requet_agence->execute();
$agence="";
while ($rwag=$requet_agence->fetch())
{
    $agence=$rwag['agence'];
}
$sens=0;
//Calcule du nombre de page 
$rqtp=$bdd->prepare("SELECT * FROM `mpay` WHERE cod_mpay <>  4 ");
$rqtp->execute();

if($type=='0')//reglement d'une police ou avenant.
    $rqt=$bdd->prepare("SELECT p.mtt_reg,p.mtt_solde,c.mtt_cpl,d.mtt_dt from policew as p,cpolice as c,dtimbre as d where cod_pol='$codedev' and p.cod_cpl=c.cod_cpl and p.cod_dt=d.cod_dt");
else
    $rqt=$bdd->prepare("SELECT p.mtt_reg,p.mtt_solde,p.lib_mpay,c.mtt_cpl,d.mtt_dt from avenantw as p,cpolice as c,dtimbre as d where cod_av='$codedev' and p.cod_cpl=c.cod_cpl and p.cod_dt=d.cod_dt");
$rqt->execute();
$mtt_solde=0;
$sens='0';
$mtt_cpl=0;$mtt_dt=0;
$mtt_reg_i=0;
while($row=$rqt->fetch())
{
    $mtt_solde=$row['mtt_solde'];
    if($type!='0')
    $sens=$row['lib_mpay'];// si sens=30 OU 50 on cr�e un avis de depense sinon un avis de recette.
    $mtt_cpl=$row['mtt_cpl'];$mtt_dt=$row['mtt_dt'];
    $mtt_reg_i=$row['mtt_reg'];
}


?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Validation</a><a class="current">Mode de Paiement</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a class="current"><i></i>Information-Paiement</a></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="control-group">
                        <div class="controls">
                            <select id="mpay" onchange="cache()" >
                                <option value="">-- Mode de Paiement (*)</option>
                                <?php while ($row_res=$rqtp->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_mpay']; ?>"><?php  echo $row_res['lib_mpay']; ?></option>
                                <?php } ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <div data-date-format="dd/mm/yyyy">
                                <input type="text" class="date-pick dp-applied"  id="datop" placeholder="Date-Operation" disabled="disabled"/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="libpay" class="span4" placeholder="Numero-Operation" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <span> Montant &agrave; r&eacute;gler : <strong>  <?php echo number_format(abs($mtt_solde), 2, ',', ' ') ;?> DA </strong></span>
                            </div>
                            <div class="controls">
                                <input type="text" id="mreg" class="span4" placeholder="Montant a regler"  />
                            </div>

                        </div>



                        <div class="form-actions" align="right">
                            <input id="btnsous" type="button" class="btn btn-success" onClick="validation('<?php echo $codedev; ?>','<?php echo $type; ?>','<?php echo $page; ?>')" value="Valider" />
                            <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','<?php echo $page.'?code='.$police; ?>')" value="Annuler" />
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">


    function affectation()
    {
        var mode=document.getElementById("ag").value;

        if(mode==''){
            document.getElementById('ag1').style.visibility='hidden';
            document.getElementById('ag2').style.visibility='hidden';
        }
        if(mode=='1'){
            document.getElementById('ag1').style.visibility='visible';
            document.getElementById('ag2').style.visibility='hidden';
        }
        if(mode=='2'){
            document.getElementById('ag1').style.visibility='hidden';
            document.getElementById('ag2').style.visibility='visible';
        }
    }
    function cache(){
        var mode=document.getElementById("mpay").value;
        var lib=document.getElementById("libpay").value;
        if(mode==1 ){
            document.getElementById('datop').disabled=true;
            document.getElementById('libpay').disabled=true;
            document.getElementById('mreg').disabled=false;
        }
        if( mode==4){
            document.getElementById('datop').disabled=true;
            document.getElementById('libpay').disabled=true;
            document.getElementById('mreg').disabled=true;
        }
        if(mode==2){
            document.getElementById('datop').disabled=false;
            document.getElementById('libpay').disabled=false;
            document.getElementById('mreg').disabled=false;
        }
        if(mode==3){
            document.getElementById('datop').disabled=false;
            document.getElementById('libpay').disabled=false;
            document.getElementById('mreg').disabled=false;
        }
        if(mode==5){
            document.getElementById('datop').disabled=false;
            document.getElementById('libpay').disabled=false;
            document.getElementById('mreg').disabled=false;
        }
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
    function validation(codedev,type,page) {
        var mode = document.getElementById("mpay").value;
        var dateop = "<?php echo $datesys;?>";
        var agence="<?php echo $agence;?>";
        var solde="<?php echo abs($mtt_solde);?>";
        var ref="<?php echo $police;?>";
        var ref_p="<?php echo $page;?>";
        var t="<?php echo $type;?>";
        var sens="<?php echo $sens;?>";
        var mtt_cpl="<?php echo abs($mtt_cpl);?>";
        var mtt_dt="<?php echo abs($mtt_dt);?>";
        var mtt_reg_i=parseFloat("<?php echo abs($mtt_reg_i);?>");//total virement precedent

        var virm1= parseFloat(mtt_cpl)+parseFloat(mtt_dt);
        var  libmpay = null;

        if (mode == 2 || mode == 3 || mode == 5)
        {

            dateop = dfrtoen(document.getElementById("datop").value);
            libmpay = document.getElementById("libpay").value;
        }
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var mreg=document.getElementById("mreg").value;
        mreg=mreg.replace(' ','');
        mreg=mreg.replace(',','.');
        mreg=mreg.replace(' ','');


        if (mode && mreg  && !isNaN(mreg) && mreg>=virm1-mtt_reg_i ) {
            if(Math.abs(mreg)>Math.abs(solde))
            {
                swal("Alerte !","le montant saisi est supperieur","warning");
            }

            solde=solde-Math.abs(mreg);
            //alert("solde="+solde);
            if (mode == 2 || mode == 3 || mode == 5) {

                if (dateop && libmpay) {
                    if (verifdate1(document.getElementById("datop"))) {
                        document.getElementById("btnsous").disabled = true;
                        xhr.open("GET", "php/validation/vregl.php?code=" + codedev + "&mode=" + mode + "&dateop=" + dateop + "&libmpay=" + libmpay+"&agence="+agence+"&mtt="+mreg+"&s="+solde+"&t="+type+'&p='+ref+'&dir='+sens+'&ri='+mtt_reg_i+'&cpl='+mtt_cpl+'&dt='+mtt_dt , false);
                         xhr.send(null);
                        rep=xhr.responseText;
                        if(rep==0)
                            swal("F\351licitation !","R\350glement effectu\351 avec succ\350s","success");
                        else
                            swal("Alerte !","une erreur s'est produite ,veuillez v\351rifier si le syst\350me a g\351n\351rer un document","warning");
                        if (t=='0')
                       // Menu1('prod', page);
                        $("#content").load('produit/'+'avis'+ref_p+'?page='+0+'&code='+ref);
                        else

                      //  $("#content").load('produit/'+ref_p+'?page='+0+'&code='+ref);
                        $("#content").load('produit/'+'avis'+ref_p.substr(2)+'?page='+0+'&code='+ref);
                    }
                } else {
                    swal("Alerte","Veuillez remplir les information du paiement","warning");
                }
            } else {


                libmpay="";
                document.getElementById("btnsous").disabled = true;
                xhr.open("GET", "php/validation/vregl.php?code=" + codedev + "&mode=" + mode + "&dateop=" + dateop + "&libmpay=" + libmpay+"&agence="+agence+"&mtt="+mreg+"&s="+solde+"&t="+type+'&p='+ref +'&dir='+sens+'&ri='+mtt_reg_i+'&cpl='+mtt_cpl+'&dt='+mtt_dt , false);
                xhr.send(null);
                rep=xhr.responseText;
                if(rep==0)
                    swal("F\351licitation !","R\350glement effectu\351 avec succ\350s","success");
                else
                    swal("Alerte !","une erreur s'est produite ,veuillez v\351rifier si le syst\350me a g\351n\351rer un document","warning");
                if (t=='0')
                    $("#content").load('produit/'+'avis'+ref_p+'?page='+0+'&code='+ref);
                    //Menu1('prod', page);
                else

                    $("#content").load('produit/'+'avis'+ref_p.substr(2)+'?page='+0+'&code='+ref);
            }

        } else {
            if(isNaN(mreg)) {
                swal("Erreur !","format incorrect","error");
            } else {
                if (mreg < virm1 - mtt_reg_i) {
                    swal("Alerte !","le premier reglement doit \352tre supirieur aux co\373ts de police et droit de timbre !","warning");
                } else {
                    swal("Alerte !","Veuillez remplir les champs obligatoires (*) !","warning");
                }
            }
        }


    }



</script>   