<?php
session_start();
require_once("../../../data/conn7.php");
//Recuperation de la page demandee
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}else{$page=0;}
$id_user = $_SESSION['id_usersal'];
if (isset($_REQUEST['code'])) 
{
    $code = $_REQUEST['code'];
}

$rqtc=$bdd->prepare("SELECT * FROM `policew` as p,`demande` as d,`utilisateurs` as u, document as doc WHERE p.cod_pol = d.cod_pol and d.id_user = u.id_user and doc.id_demande = d.id_demande and p.cod_pol=$code");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);

?>

<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Assurance-Voyage-Groupe  > demande </a> </div>
</div>
<div class="widget-box">
    <ul class="quick-actions">
        <li class="bg_lo"> <a onClick="aMenu1('macc','../adash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
        <li class="bg_lv"> <a onClick="aMenu1('prod','apolassvoygrp.php')"> <i class="icon-backward"></i>Precedent</a></li>
        <li class="bg_lg"> <a onClick="aMenu1('prod','apolassvoygrp.php')"> <i class="icon-folder-open"></i>Visualiser-Contrats</a> </li>

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
                <th>Nom/Prenom</th>
                <th>Code Agence</th>
                <th>Type Demande</th>
                <th>Date de demande</th>
                <th>Motif</th>
                <th>description</th>
                <th>etat  de la demande</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            while ($row_res=$rqtc->fetch()){  ?>
                <!-- Ici les lignes du tableau zone-->
                <tr class="gradeX">

                    <td>
                    <?php
                    if($row_res['etat_dem']==0){
                    ?>
                    <a><img  src="img/icons/icon_4.png"/></a>
                    <?php }
                    if($row_res['etat_dem']==1){
                    ?>
                    <a><img  src="img/icons/icon_2.png"/></a>
                    <?php }
                    if($row_res['etat_dem']==2){
                    ?>
                    <a><img  src="img/icons/icon_1.png"/></a>
                    <?php }
                    ?>
                    </td>
                    <td><?php  echo $row_res['nom']."  ".$row_res['prenom']; ?></td>
                    <td><?php  echo $row_res['cod_agence']; ?></td>
                    <td>
                    <?php
                         if( $row_res['type_annulation'] == 5) echo "annulation avec ristourn"; 
                         if( $row_res['type_annulation'] == 4) echo "annulation son ristourn";
                    ?>
                    </td>
                    <td><?php  echo $row_res['date_annulation']; ?></td>
                    <td><?php  echo $row_res['motif_annulation']; ?></td>
                    <td><?php  echo $row_res['Description']; ?></td>
                    <?php
                    if($row_res['etat_dem']==0){
                        ?>
                        <td><?php echo "En cour ..."?></td>
                   <?php }
                    if($row_res['etat_dem']==1){
                        ?>
                        <td><?php echo "<span style=color:green;>  valider </span>"?></td>
                    <?php }
                    if($row_res['etat_dem']==2){
                        ?>
                        <td><?php echo"<span style=color:red;> Refuser </span>" ;?></td>
                    <?php }
                    ?>
                    <td>
                    <?php
                     $lien =  "/Intranet-Salama-test/php/avenant/voy/file/documents/".$row_res['chemin'] ;
                     if( $row_res['type_annulation'] == 5){
                    ?>
                    <a download="MODELE_VOYAGE" href=" <?php  echo $lien;?>" ><i CLASS="icon-download icon-2x" style="color:#0e90d2"/></a>
                    <?php } 
                    if($row_res['etat_dem']!=1){
                    ?>
                    <a onClick="accorder('prod','dempolvoygrp.php','<?php echo $row_res['id_demande']; ?>', '<?php echo $row_res['cod_pol']; ?>')" title="Accorder"><i CLASS="icon-thumbs-up icon-2x" style="color:green"/></a>&nbsp;&nbsp;&nbsp;
                    <?php } 
                     if($row_res['etat_dem']!=2){
                    ?>
				    <a onClick="rejeter('prod','dempolvoygrp.php','<?php echo $row_res['id_demande']; ?>', '<?php echo $row_res['cod_pol']; ?>')" title="Rejeter"><i CLASS="icon-thumbs-down icon-2x" style="color:red"/></a>
                    <?php } ?>    
                </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="widget-title" align="center">
        <h5>Visualisation-Avenant-Voyage-Groupe</h5>
        <a href="javascript:;" title="Premiere page" onClick="fpageapconso('0','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fprec.png"/></a>
        <a href="javascript:;" title="Precedent" onClick="fpageapconso('<?php echo $page-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/prec.png"/></a>
        <?php echo $page; ?>/<?php echo $nbpage; ?>
        <a href="javascript:;" title="Suivant" onClick="fpageapconso('<?php echo $page+1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/suiv.png"/></a>
        <a href="javascript:;" title="Derniere page" onClick="fpageapconso('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>','<?php echo $code; ?>')"><img  src="img/icons/fsuiv.png"/></a>
    </div>
</div>
<script language="JavaScript">
    function frechapconso(){
        var rech=document.getElementById("nsousapwar").value;
        $("#content").load('produit/avpolvoyind.php?rech='+rech);
    }
    function fpageapconso(page,nbpage,code){
        if(page >=0){
            if(page == nbpage){
                alert("Vous ete a la derniere page!");
            }else{$("#content").load('produit/avpolvoyind.php?page='+page+'&code='+code);}
        }else{alert("Vous ete en premiere page !");}
    }

</script>