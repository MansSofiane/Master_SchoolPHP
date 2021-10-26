<?php
session_start();
require_once("../../../data/conn7.php");

$id_user = $_SESSION['id_usersal'];

if ($_SESSION['loginsal']){}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];}else{$page=0;}
if (isset($_REQUEST['rech'])) {
    $rech = $_REQUEST['rech'];


//Calcule du nombre de page
    $rqtc = $bdd->prepare("SELECT * FROM `agence`  WHERE id_user='$id_user' and lib_agence LIKE '%$rech%' ORDER BY `id_agence` DESC");
    $rqtc->execute();
    $nbe = $rqtc->rowCount();
    $nbpage = ceil($nbe / 8);
//Pointeur de page
    $part = $page * 8;
//requete à suivre

    $rqt = $bdd->prepare("SELECT * FROM `agence`  WHERE id_user='$id_user'  and lib_agence LIKE '%$rech%' ORDER BY `id_agence` DESC  LIMIT $part ,8");
    $rqt->execute();


}else{

    $rqtc = $bdd->prepare("SELECT * FROM `agence`  WHERE id_user='$id_user'  ORDER BY `id_agence` DESC");
    $rqtc->execute();
    $nbe = $rqtc->rowCount();
    $nbpage = ceil($nbe / 8);
//Pointeur de page
    $part = $page * 8;
//requete à suivre

    $rqt = $bdd->prepare("SELECT * FROM `agence`  WHERE id_user='$id_user'   ORDER BY `id_agence` DESC  LIMIT $part ,8");
    $rqt->execute();
}


?>


<div id="content-header">
    <div id="breadcrumb">  <a class="current1">Agence</a><a class="current">Liste-Agence</a> </div>
</div>
<div class="widget-box">
    <ul class="quick-actions">
        <li class="bg_lo"> <a onClick="Menu('macc','dash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
        <li class="bg_lg"> <a onClick="Menu('avoy','produit/new_agence.php')"> <i class="icon-folder-open"></i>Nouvelle Agence </a> </li>
        <li class="bg_ly"> <a onClick="Menu('avoy','produit/list_agence.php')"> <i class="icon-folder-open"></i> Liste Agence</a> </li>

    </ul>
</div>
<div class="widget-box">
    <div class="widget-title">
        <div><input type="text" id="nag" onchange="frechag()" class="span4" placeholder="Rechercher par Agence..."/></div>
    </div>
    <div class="widget-content nopadding">
        <table class="table table-bordered data-table">
            <thead>
            <tr>
                <th></th>
                <th>Agence</th>
                <th>Nom </th>
                <th>Prenom</th>
                <th>mail</th>
                <th>Adresse</th>
                <th>Phone</th>
                <th>Date de creation </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php

            while ($row_res=$rqt->fetch()){  ?>
                <!-- Ici les lignes du tableau zone-->


                    <td><a title="Police-Valide"><img  src="img/icons/icon_3.png"/></a></td>


                    <td><?php  echo $row_res['lib_agence']; ?></td>
                     <td><?php  echo $row_res['nom_rep']; ?></td>
                      <td><?php  echo $row_res['prenom_rep']; ?></td>
                       <td><?php  echo $row_res['mail_agence']; ?></td>
                        <td><?php  echo $row_res['adr_agence']; ?></td>
                         <td><?php  echo $row_res['tel_agence']; ?></td>
                          <td><?php  echo $row_res['date']; ?></td>
<td> <a href="sortie/Convention/<?php echo crypte($row_res['id_agence']) ?>" onClick="window.open(this.href, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" title="Imprimer"><i CLASS="icon-print icon-2x" style="color:#0e90d2"/></a></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="widget-title" align="center">
        <h5>Visualisation-Liste-Agence</h5>
        <a href="javascript:;" title="Premiere page" onClick="fpageag('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
        <a href="javascript:;" title="Precedent" onClick="fpageag('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
        <?php echo $page; ?>/<?php echo $nbpage; ?>
        <a href="javascript:;" title="Suivant" onClick="fpageag('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
        <a href="javascript:;" title="Derniere page" onClick="fpageag('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
    </div>
</div>






<script language="JavaScript">
    function fpageag(page,nbpage){
        if(page >=0){
            if(page == nbpage){
                alert("Vous ete a la derniere page!");
            }else{$("#content").load('produit/list_agence.php?page='+page);}
        }else{alert("Vous ete en premiere page !");}
    }

    function frechag(){
            var rech=document.getElementById("nag").value;
            $("#content").load('produit/list_agence.php?rech='+rech);
                }

</script>
</body>
</html>