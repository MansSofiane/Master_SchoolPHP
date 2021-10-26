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
$rqtp = $bdd->prepare("SELECT j.min_jour as jour, p.cod_sous as csous,p.cod_prod as prod, p.ndat_eff,p.ndat_ech,p.cod_formul FROM `periode` as j,`policew` as p WHERE p.`cod_per`=j.`cod_per` AND p.`cod_pol`='$code'");
$rqtp->execute();
while ($row_res = $rqtp->fetch()) {
	$jour = $row_res['jour'];
	$dure=dure_en_jour($row_res['ndat_eff'],$row_res['ndat_ech']);
	$csous = $row_res['csous'];
	$cprod=$row_res['prod'];
	$dated=$row_res['ndat_eff'];
	$datef=$row_res['ndat_ech'];
	$cod_formul=$row_res['cod_formul'];
	}
$rqtc=$bdd->prepare("SELECT * FROM `policew` as p,`demande` as d,`utilisateurs` as u, document as doc WHERE p.cod_pol = d.cod_pol and d.id_user = u.id_user and doc.id_demande = d.id_demande and d.is_avenant = False and u.id_user = $id_user and p.`cod_pol`='$code'");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/7);
?>


<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Assurance-Voyage-Famille  > demande </a> </div>
</div>
<div class="widget-box">
<ul class="quick-actions">
        <li class="bg_lo"> <a onClick="Menu('macc','dash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
        <li class="bg_lv"> <a onClick="Menu1('prod','polassvoyfam.php')"> <i class="icon-backward"></i>Precedent</a></li>
        <li class="bg_ly"> <a onClick="Menu('prod','php/tarif/voyage/vsimulationfam.php')"> <i class="icon-dashboard"></i> Simulation</a> </li>
        <li class="bg_ls"> <a onClick="ndev()"> <i class="icon-folder-open"></i>Nouveau-Devis</a> </li>
        <li class="bg_lb"> <a onClick="Menu1('prod','assvoycpl.php')"> <i class="icon-folder-open"></i>Visualiser-Devis</a></li>
        <li class="bg_lg"> <a onClick="Menu1('prod','polassvoyfam.php')"> <i class="icon-folder-open"></i>Visualiser-Contrats</a> </li>

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
                <th>Justificatif</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            while ($row_res=$rqtc->fetch()){ 
                $id_demande= $row_res['id_demande'];
                
                ?>
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
                        <td><?php  echo "<span style=color:green;>  valider </span>"?></td>
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

                    <a download="MODELE_VOYAGE" href=" <?php echo $lien; ?>"  title="download"><i CLASS="icon-download icon-2x" style="color:#0e90d2"/></a>
                    <?php
                     }
                    if ($row_res['etat_dem']==1)
                    {
                        
                    ?>
                    <a onClick="validerav()" title="Creer l avenant">  <i CLASS="icon-check icon-2x" style="color:green"/></a>
                    <?php } 
                    if ($row_res['etat_dem']==2)
                    {
                    ?>
                    <a  href=""><i CLASS="icon-fixed-width icon-ban-circle icon-2x" style="color:red"/></a>
                    <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="widget-title" align="center">
        <h5>Visualisation-Avenant-Voyage-Famille</h5>
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
    function validerav()
    {
        code = <?php echo $code;?>;
        date1 = <?php echo $dated;?>;
        date2 = <?php echo $datef; ?>;
        id_dem = <?php echo $id_demande;?>;
        var ok = confirm("Confirmez la creation de lavenat");
        if (ok)
        {
            $("#content").load("/Intranet-Salama-test/php/avenant/voy/validationav.php?code="+code+"&av=30&pays=&mode=&datop=&date1="+date1+"&date2="+date2+"&id_dem="+id_dem);
            alert('lavenant a ete creer avec succes');
        }
        
        Menu1('prod','dempolvoyind.php?code='+code);
        
        //xhr.open("GET", "validationav.php?code="+code+"&av=30&pays=&mode=&datop=&date1="+date1+"&date2="+date2, false);
		//xhr.send(null);
    }

</script>