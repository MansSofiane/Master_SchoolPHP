<?php
session_start();
require_once("../../../data/conn7.php");

//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}else{$page=0;}
$id_user = $_SESSION['id_user'];
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
$seq="";
if (isset($_REQUEST['code'])) {
    $code = $_REQUEST['code'];

}
if (isset($_REQUEST['s'])) {

    $seq= $_REQUEST['s'];
}
if (isset($_REQUEST['rech'])) {
    $rech = $_REQUEST['rech'];

//Calcule du nombre de page 
    $rqtc=$bdd->prepare("SELECT a.*,s.nom_sous,s.pnom_sous,p.sequence,p.cod_prod,m.lib_mpay as mode FROM `avis_recette` as a,policew as p,souscripteurw as s,mpay as m WHERE  s.`cod_sous`=p.`cod_sous`  AND a.`cod_ref`=p.`cod_pol` AND a.`cod_ref`='$code' and a.cod_mpay=m.cod_mpay and a.cod_avis like '%$rech%' ORDER BY a.`id_avis`");
    $rqtc->execute();
    $nbe = $rqtc->rowCount();
    $nbpage=ceil($nbe/7);
//Pointeur de page
    $part=$page*7;
//requete � suivre
    $rqt=$bdd->prepare("SELECT a.*,s.nom_sous,s.pnom_sous,p.sequence,p.cod_prod,m.lib_mpay as mode FROM `avis_recette` as a,policew as p,souscripteurw as s,mpay as m  WHERE  s.`cod_sous`=p.`cod_sous`  AND a.`cod_ref`=p.`cod_pol` AND a.`cod_ref`='$code' and a.cod_mpay=m.cod_mpay and a.cod_avis like '%$rech%' ORDER BY a.`id_avis`  LIMIT $part ,7");
    $rqt->execute();

}else{
//Calcule du nombre de page 
    $rqtc=$bdd->prepare("SELECT a.*,s.nom_sous as nom,s.pnom_sous as prenom,p.sequence as sequence,p.cod_prod as produit,m.lib_mpay as mode,'Police-mere' as Nature FROM `avis_recette` as a,policew as p,souscripteurw as s,mpay as m  WHERE  s.`cod_sous`=p.`cod_sous`  AND a.`cod_ref`=p.`cod_pol`  AND a.`cod_ref`='$code' and a.cod_mpay=m.cod_mpay and a.`type_avis`=0

union

SELECT a.*,s.nom_sous as nom,s.pnom_sous prenom,v.sequence as sequence,p.cod_prod as produit,m.lib_mpay as mode

,case when v.lib_mpay='74' THEN 'Modification Date' when v.lib_mpay='30' THEN 'Avec Ristourne' when v.lib_mpay='73' THEN 'Avenant de subrogation' when v.lib_mpay='50' THEN 'Sans Ristourne' when v.lib_mpay='70' THEN 'Precision' when v.lib_mpay='14' THEN 'Changement destination' END as Nature
FROM `avis_recette` as a,policew as p,souscripteurw as s,mpay as m,avenantw as v  WHERE  s.`cod_sous`=p.`cod_sous`  AND a.`cod_ref`=p.`cod_pol`  AND a.`cod_ref`='$code' and a.cod_mpay=m.cod_mpay and a.`type_avis`=1 and p.cod_pol=v.cod_pol and a.cod_av=v.cod_av

");
    $rqtc->execute();
    $nbe = $rqtc->rowCount();
    $nbpage=ceil($nbe/7);
//Pointeur de page
    $part=$page*7;
//requete � suivre
    $rqt=$bdd->prepare("SELECT a.*,s.nom_sous as nom,s.pnom_sous as prenom,p.sequence as sequence,p.cod_prod as produit,m.lib_mpay as mode,'Police-mere' as Nature FROM `avis_recette` as a,policew as p,souscripteurw as s,mpay as m  WHERE  s.`cod_sous`=p.`cod_sous`  AND a.`cod_ref`=p.`cod_pol`  AND a.`cod_ref`='$code' and a.cod_mpay=m.cod_mpay and a.`type_avis`=0
union
SELECT a.*,s.nom_sous as nom,s.pnom_sous prenom,v.sequence as sequence,p.cod_prod as produit,m.lib_mpay as mode

,case when v.lib_mpay='74' THEN 'Modification Date' when v.lib_mpay='30' THEN 'Avec Ristourne' when v.lib_mpay='73' THEN 'Avenant de subrogation' when v.lib_mpay='50' THEN 'Sans Ristourne' when v.lib_mpay='70' THEN 'Precision' when v.lib_mpay='14' THEN 'Changement destination' END as Nature
FROM `avis_recette` as a,policew as p,souscripteurw as s,mpay as m,avenantw as v  WHERE  s.`cod_sous`=p.`cod_sous`  AND a.`cod_ref`=p.`cod_pol`  AND a.`cod_ref`='$code' and a.cod_mpay=m.cod_mpay and a.`type_avis`=1 and p.cod_pol=v.cod_pol and a.cod_av=v.cod_av

  LIMIT $part ,7");
    $rqt->execute();
    $nb = $rqt->execute();
}
?>

<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Temporaire-Au-Deces</a> </div>
</div>
<div class="widget-box">
    <ul class="quick-actions">
        <li class="bg_lo"> <a onClick="Menu('macc','dash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
        <li class="bg_ls"> <a onClick="ndevtd()"> <i class="icon-folder-open"></i>Nouveau-Devis</a> </li>
        <li class="bg_lb"> <a onClick="Menu1('prod','asspta.php')"> <i class="icon-folder-open"></i>Visualiser-Devis</a></li>
        <li class="bg_lg"> <a onClick="Menu1('prod','polasspta.php')"> <i class="icon-folder-open"></i>Visualiser-Contrats</a></li>

    </ul>
</div>
<div class="widget-box">
    <div class="widget-title">
    </div>
    <div class="widget-content nopadding">
        <table class="table table-bordered data-table">
            <thead>
            <tr>
                <th></th>
                <th>Type</th>
                <th>N-Avis</th>
                <th>Nom/Prenom</th>
                <th>Date-avis</th>
                <th>Mode de reglement</th>
                <th>Date-Reglement</th>
                <th>Libelle</th>
                <th>N-police/Avenant</th>
                <th>Nature</th>
                <th>Montant</th>
                <th>Operations</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            while ($row_res=$rqt->fetch()){ $seq= $row_res['sequence'];  ?>
                <!-- Ici les lignes du tableau zone-->
                <tr class="gradeX">

                    <?php if ($row_res['sens_avis']=='1'){?>
                        <td><a title="Avis-Depense"><img  src="img/icons/icon_1.png"/></a></td>
                        <td><?php echo "Avis-Depense";?></td>
                    <?php } else {?>
                        <td><a title="Avis-Recette"><img  src="img/icons/icon_2.png"/></a></td>
                        <td><?php echo "Avis-Recette";?></td>
                    <?php } ?>

                    <td><?php  echo $row_res['cod_avis'] ?></td>
                    <td><?php  echo $row_res['nom']."  ".$row_res['prenom']; ?></td>
                    <td><?php  echo date("d/m/Y",strtotime($row_res['dat_avis'])); ?></td>
                    <td><?php  echo $row_res['mode'] ?></td>
                    <td><?php  echo date("d/m/Y",strtotime($row_res['dat_mpay'])); ?></td>
                    <td><?php  echo $row_res['lib_mpay']; ?></td>
                    <td><?php  echo $row_res['sequence']; ?></td>
                    <td><?php  echo $row_res['Nature'] ?></td>
                    <td><?php  echo number_format($row_res['mtt_avis'], 2, ',', ' ')." DZD"; ?></td>
                    <td>&nbsp;
                        <a href="sortie/Avis-recette/<?php echo crypte($row_res['id_avis']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="widget-title" align="center">
        <h5>Visualisation-Avis-recette-police N: <?php echo $seq;?></h5>
        <a href="javascript:;" title="Premiere page" onClick="fpageatd('0','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fprec.png"/></a>
        <a href="javascript:;" title="Precedent" onClick="fpageatd('<?php echo $page-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/prec.png"/></a>
        <?php echo $page; ?>/<?php echo $nbpage; ?>
        <a href="javascript:;" title="Suivant" onClick="fpageatd('<?php echo $page+1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/suiv.png"/></a>
        <a href="javascript:;" title="Derniere page" onClick="fpageatd('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fsuiv.png"/></a>
    </div>
</div>

<script language="JavaScript">
    function frechatd(){
        var rech=document.getElementById("nsousatd").value;
        $("#content").load('produit/avispolasspta.php?rech='+rech);
    }
    function fpageatd(page,nbpage,code){
        if(page >=0){
            if(page == nbpage){
                swal("Information !","Vous ete a la derniere page!","info");
            }else{$("#content").load('produit/avispolasspta.php?page='+page+'&code='+code);}
        }else{swal("Information !","Vous ete en premiere page !","info");}
    }

</script>		