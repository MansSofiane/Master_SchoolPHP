<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
//$("#content").load('php/avenant/voy/report_date.php?page='+page+"&cod_pol="+cod_police+"&formul="+cod_formul+"&tav="+type_av);

function datenfr($dat)
{
    $d=new DateTime($dat);
    $dd=$d->format('d-m-Y');
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
}
    $rqt=$bdd->prepare("select p.*,s.cod_sous as sous from policew as p,souscripteurw as s where p.cod_pol='$codepol' and p.cod_sous=s.cod_sous ");
    $rqt->execute();

    while ($rows=$rqt->fetch()) {
        $datdeb = $rows['ndat_eff'];
        $datech = $rows['ndat_ech'];
        $cod_sous=$rows['sous'];
    }
if (isset($_REQUEST['rech'])) {
    $rech = $_REQUEST['rech'];
}else{$rech='';}

// verifier si on a fait des modifications sur les assures ou le souscripteurs
// le but c'est : permettre  de continuer la creation de lavenant de precision "bouton suivant"
$rqt1=$bdd->prepare("SELECT * FROM modif where cod_par='$cod_sous'");
$rqt1->execute();
$nbrow_assur=0;
$nbrow_assur=$rqt1->rowCount();
$modifier=0;
while($rowmod=$rqt1->fetch())
{
    if($rowmod['modif_sous']=='1')
    {
        $modifier=1;
    }
}


if($rech!='')// ON EST SÜR QUE LA TABLE MODIF N EST PAS VIDE
{
// la recherche fait appel au meme fichier  donc surement il y a des lignes dans la table transitoire.


        $rqth=$bdd->prepare("SELECT cod_assu as code,`nom_assu` as nom_sous,`pnom_assu` as pnom_sous, `passport` as passport,`datedpass` as datedpass, `adr_assu` as adr_sous,`mail_assu` as mail_sous,`tel_assu` as tel_sous from modif where cod_par='$cod_sous' and nom_assu like '%$rech%'");
        $rqth->execute();

        // $rqth = $bdd->prepare("select * from souscripteurw where cod_sous='$cod_sous' OR cod_par='$cod_sous'");
        $rqth->execute();
        $nbe = $rqth->rowCount();
        $nbpage=ceil($nbe/7);
//Pointeur de page
        $part=$pagepres*7;
        $rqth=$bdd->prepare("SELECT cod_assu as code,`nom_assu` as nom_sous,`pnom_assu` as pnom_sous, `passport` as passport,`datedpass` as datedpass, `adr_assu` as adr_sous,`mail_assu` as mail_sous,`tel_assu` as tel_sous from modif where cod_par='$cod_sous' and nom_assu like '%$rech%' LIMIT $part,7 ");
        $rqth->execute();




}
else
{
    $rqt1=$bdd->prepare("SELECT * FROM modif where cod_par='$cod_sous'");
    $rqt1->execute();
    $nbrow_assur=0;
    $nbrow_assur=$rqt1->rowCount();

    if($nbrow_assur>0)
    {
        $rqth=$bdd->prepare("SELECT cod_assu as code,`nom_assu` as nom_sous,`pnom_assu` as pnom_sous, `passport` as passport,`datedpass` as datedpass, `adr_assu` as adr_sous,`mail_assu` as mail_sous,`tel_assu` as tel_sous from modif where cod_par='$cod_sous'");
        $rqth->execute();
        $rech='';
        // $rqth = $bdd->prepare("select * from souscripteurw where cod_sous='$cod_sous' OR cod_par='$cod_sous'");
        $rqth->execute();
        $nbe = $rqth->rowCount();
        $nbpage=ceil($nbe/7);
//Pointeur de page
        $part=$pagepres*7;
        $rqth=$bdd->prepare("SELECT cod_assu as code,`nom_assu` as nom_sous,`pnom_assu` as pnom_sous, `passport` as passport,`datedpass` as datedpass, `adr_assu` as adr_sous,`mail_assu` as mail_sous,`tel_assu` as tel_sous from modif where cod_par='$cod_sous' LIMIT $part,7 ");
        $rqth->execute();


    }
    else
    {


        $rqt2=$bdd->prepare("select * from assure where cod_par='$cod_sous' and cod_av=(select MAX(cod_av) from assure where cod_pol='$codepol')");
        $rqt2->execute();
        $nbrow_assur=0;
        $nbrow_assur=$rqt2->rowCount();
        if($nbrow_assur>0)
        {
            $rqtmod=$bdd->prepare("INSERT INTO `modif`( `nom_assu`, `pnom_assu`, `passport`, `datedpass`, `datefpass`, `mail_assu`, `tel_assu`, `adr_assu`, `age_assu`, `sexe`, `cod_sous`, `cod_pol`, `cod_av`, `id_user`, `cod_par`)
                                 ( SELECT `nom_assu`, `pnom_assu`, `passport`, `datedpass`, `datefpass`, `mail_assu`, `tel_assu`, `adr_assu`, `age_assu`, `sexe`, `cod_sous`, `cod_pol`, `cod_av`, `id_user`, `cod_par`
                                   FROM assure
                                   where cod_par='$cod_sous' and cod_av=(select MAX(cod_av) from assure where cod_pol='$codepol')

                                   )");
            $rqtmod->execute();

            //CHARGER la table modif

            $rqth=$bdd->prepare("SELECT cod_assu as code,`nom_assu` as nom_sous,`pnom_assu` as pnom_sous, `passport` as passport,`datedpass` as datedpass, `adr_assu` as adr_sous,`mail_assu` as mail_sous,`tel_assu` as tel_sous from modif where cod_par='$cod_sous'");
            $rqth->execute();
            $rech='';
            // $rqth = $bdd->prepare("select * from souscripteurw where cod_sous='$cod_sous' OR cod_par='$cod_sous'");
            $rqth->execute();
            $nbe = $rqth->rowCount();
            $nbpage=ceil($nbe/7);
//Pointeur de page
            $part=$pagepres*7;
            $rqth=$bdd->prepare("SELECT cod_assu as code,`nom_assu` as nom_sous,`pnom_assu` as pnom_sous, `passport` as passport,`datedpass` as datedpass, `adr_assu` as adr_sous,`mail_assu` as mail_sous,`tel_assu` as tel_sous from modif where cod_par='$cod_sous' LIMIT $part,7 ");
            $rqth->execute();


        }
        else
        {

//insertion de souscripteur et les assures dans la table modif
            $rqtmod=$bdd->prepare("INSERT INTO `modif`(`nom_assu`, `pnom_assu`, `passport`, `datedpass`,  `mail_assu`, `tel_assu`, `adr_assu`, `age_assu`, `sexe`, `cod_sous`, `cod_pol`, `cod_av`, `id_user`, `cod_par`)
             (SELECT nom_sous as nom_assu,pnom_sous as pnom_assu ,passport as passport ,datedpass as datedpass ,mail_sous as mail_assu ,tel_sous as tel_assu ,adr_sous as adr_assu ,age as age_assu ,civ_sous as sexe,cod_sous as cod_sous ,'$codepol' as cod_pol,'0' as cod_av,'$id_user' as id_user,case cod_par when '0' then cod_sous else cod_par END as code_par from souscripteurw where cod_par='$cod_sous'  or cod_sous='$cod_sous'
              )");
            $rqtmod->execute();





            $rqth=$bdd->prepare("SELECT cod_assu as code,`nom_assu` as nom_sous,`pnom_assu` as pnom_sous, `passport` as passport,`datedpass` as datedpass, `adr_assu` as adr_sous,`mail_assu` as mail_sous,`tel_assu` as tel_sous from modif where cod_par='$cod_sous'");
            $rqth->execute();
            $rech='';
            // $rqth = $bdd->prepare("select * from souscripteurw where cod_sous='$cod_sous' OR cod_par='$cod_sous'");
            $rqth->execute();
            $nbe = $rqth->rowCount();
            $nbpage=ceil($nbe/7);
//Pointeur de page
            $part=$pagepres*7;
            $rqth=$bdd->prepare("SELECT cod_assu as code,`nom_assu` as nom_sous,`pnom_assu` as pnom_sous, `passport` as passport,`datedpass` as datedpass, `adr_assu` as adr_sous,`mail_assu` as mail_sous,`tel_assu` as tel_sous from modif where cod_par='$cod_sous' LIMIT $part,7 ");
            $rqth->execute();


        }
    }

}
?>

<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Avenant-Precision</h5></div>
            <div class="widget-title">
                <div><input type="text" id="nsouspade" onchange="fpagepade('0','<?php echo $nbpage; ?>')" value="<?php echo $rech; ?>" class="span4" placeholder="Rechercher par Nom-Souscripteur..."/></div>
            </div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="controls">
                    </div>
                    <div class="control-group">

                            <table class="table table-bordered data-table">
                            <thead>
                            <tr>

                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Passport</th>
                                <th>Date_deliv_passport</th>
                                <th>Adresse</th>
                                <th>Mail</th>
                                <th>Telephone</th>
                                <th>Modifier</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            while ($row=$rqth->fetch())

                            {?>
                              <tr class="gradeX">

                                   <td><?php echo $row['nom_sous'];?> </td>
                                   <td><?php echo $row['pnom_sous'];?> </td>
                                   <td><?php echo $row['passport'];?> </td>
                                   <td><?php echo $row['datedpass'];?> </td>
                                   <td><?php echo $row['adr_sous'];?> </td>
                                   <td><?php echo $row['mail_sous'];?> </td>
                                   <td><?php echo $row['tel_sous'];?> </td>
                                   <td>
                                       <a onClick="modif_assur('<?php echo $row['code'];?>','<?php echo $codepol;?>','<?php echo $pagepres;?>','<?php echo $page;?>','<?php echo $tav;?>','<?php echo $rech;?>','<?php echo $formul;?>')" title="Modifier"><i CLASS="icon-list-alt icon-2x" style="color:black"/></a>&nbsp;&nbsp;&nbsp;
                                   </td>



                              </tr>

                            <?php }


                            ?>
                            </tbody>
                         </table>

                    </div>
                    <div class="widget-title" align="center">
                        <h5>Visualisation-Assures</h5>
                        <a href="javascript:;" title="Premiere page" onClick="fpagepade('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
                        <a href="javascript:;" title="Precedent" onClick="fpagepade('<?php echo $pagepres-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
                        <?php echo $pagepres+1; ?>/<?php echo $nbpage; ?>
                        <a href="javascript:;" title="Suivant" onClick="fpagepade('<?php echo $pagepres+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
                        <a href="javascript:;" title="Derniere page" onClick="fpagepade('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
                    </div>
                        <div class="form-actions" align="right">
                            <input  type="button" class="btn btn-success" onClick="avenantprec('<?php echo $codepol; ?>','<?php echo $page; ?>','<?php echo $datesys;?>','<?php echo $datesys;?>','<?php echo $modifier;?>')" value="Valider" />
                            <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','<?php echo $page;?>')" value="Annuler" />
                        </div>

                </form>
            </div>
        </div>
    </div>

</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
//

    function fpagepade(pagepres,nbpage){
        var codepol='<?php echo  $codepol;?>';
        var page='<?php echo  $page; ?>';
        var formul='<?php echo $formul;?>';
        var tav='<?php echo $tav;?>';
        var rech=document.getElementById("nsouspade").value;
        if(pagepres >=0){
            if(pagepres == nbpage){
                alert("Vous ete a la derniere page!");


            }else{$("#content").load('php/avenant/voy/precision.php?page='+page+"&cod_pol="+codepol+"&formul="+formul+"&tav="+tav+'&pagepres='+pagepres+'&rech='+rech);}
        }else{alert("Vous ete en premiere page !");}
    }
    function modif_assur(cod_sous,cod_police,pageprec,page,tav,rech,formul)
    {
        $("#content").load('php/avenant/voy/modif_assur.php?page='+page+"&cod_pol="+cod_police+"&formul="+formul+"&tav="+tav+'&pagepres='+pageprec+'&rech='+rech+'&cod_sous='+cod_sous);
    }
    function avenantprec(cod_pol,page,datdeb,datfin,modifier)
    {
        // mode de paiement.
        if(modifier==1) {
            var av = 70;
            $("#content").load("php/avenant/voy/mpaiement.php?code=" + cod_pol + "&page=" + page + "&av=" + av + "&datdebut=" + datdeb + "&datfin=" + datfin);

        }
        else
        {alert("Aucune modification n'a ete apportee !");}
       // xhr.open("GET", "php/avenant/voy/validationav.php?code=" + cod_pol + "&date1=" + datsys + "&date2=" + datsys + "&av=" + av, false);
       // xhr.send(null);
       // Menu1('prod', page);

    }

</script>
