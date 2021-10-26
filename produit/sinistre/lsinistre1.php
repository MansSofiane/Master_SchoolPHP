<?php
session_start();
require_once("../../../../data/conn7.php");

$id_user = $_SESSION['id_usersal'];

if ($_SESSION['loginsal']){}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];}else{$page=0;}
	
	
    $rqtc = $bdd->prepare("SELECT s.*,p.dat_eff,p.dat_ech, r.nom_sous,r.pnom_sous FROM `sinistre` as s, `policew` as p, `souscripteurw` as r WHERE s.cod_pol=p.cod_pol AND p.cod_sous=r.cod_sous AND s.etat_sin='0' AND r.id_user='$id_user' ORDER BY `cod_sin` DESC");
    $rqtc->execute();
    $nbe = $rqtc->rowCount();
    $nbpage = ceil($nbe / 8);
//Pointeur de page
    $part = $page * 8;
//requete à suivre
    $rqt = $bdd->prepare("SELECT s.*,p.dat_eff,p.dat_ech, r.nom_sous,r.pnom_sous FROM `sinistre` as s, `policew` as p, `souscripteurw` as r WHERE s.cod_pol=p.cod_pol AND p.cod_sous=r.cod_sous AND s.etat_sin='0' AND r.id_user='$id_user' ORDER BY `cod_sin` DESC  LIMIT $part ,8");
    $rqt->execute();



?>


<div id="content-header">
    <div id="breadcrumb">  <a class="current1">Sinistre</a><a class="current">Sinistre-En-Attente</a> </div>
</div>
<div class="widget-box">
    <div class="widget-content nopadding">
        <table class="table table-bordered data-table">
            <thead>
            <tr>
                <th></th>
                <th>Num-Sinistre</th>
                <th>Nom </th>
                <th>Prenom</th>
                <th>D-Effet</th>
                <th>D-Echeance</th>
                <th>D-Sinistre</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php

            while ($row_res=$rqt->fetch()){  ?>
                <!-- Ici les lignes du tableau zone-->
                   <td><a title="Police-Valide"><img  src="img/icons/icon_3.png"/></a></td>
                    <td><?php  echo $row_res['cod_sin']; ?></td>
                     <td><?php  echo $row_res['nom_sous']; ?></td>
                      <td><?php  echo $row_res['pnom_sous']; ?></td>
                       <td><?php  echo $row_res['dat_eff']; ?></td>
                        <td><?php  echo $row_res['dat_ech']; ?></td>
                         <td><?php  echo $row_res['dat_sin']; ?></td>
                          <td><a onclick="joindre('<?php echo $row_res['cod_sin'];?>')" title="Joindre un document"><i CLASS="icon-list-alt icon-2x" style="color:black"/></a> <a onClick="dsin('<?php echo $row_res['cod_sin'];?>')" title="Annuler le Sinistre"><i CLASS="icon-trash icon-2x" style="color:red"/></a> </td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="widget-title" align="center">
        <h5>Visualisation-Sinistre-En-Attente</h5>
        <a href="javascript:;" title="Premiere page" onClick="fpagels('0','<?php echo $nbpage; ?>')"><img  src="img/icons/fprec.png"/></a>
        <a href="javascript:;" title="Precedent" onClick="fpagels('<?php echo $page-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/prec.png"/></a>
        <?php echo $page; ?>/<?php echo $nbpage; ?>
        <a href="javascript:;" title="Suivant" onClick="fpagels('<?php echo $page+1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/suiv.png"/></a>
        <a href="javascript:;" title="Derniere page" onClick="fpagels('<?php echo $nbpage-1; ?>','<?php echo $nbpage; ?>')"><img  src="img/icons/fsuiv.png"/></a>
    </div>
</div>






<script language="JavaScript">
    function fpagels(page,nbpage){
        if(page >=0){
            if(page == nbpage){
                alert("Vous ete a la derniere page!");
            }else{$("#content").load('produit/sinistre/lsinistre1.php?page='+page);}
        }else{alert("Vous ete en premiere page !");}
    }

    function dsin(code){
	if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }	
	  xhr.open("GET", "produit/sinistre/dsinistre.php?code="+code, false);
      xhr.send(null);
	  alert("Sinistre Annule !");
	
      $("#content").load('produit/sinistre/lsinistre1.php');
                }
    function joindre(code)
    {
        window.open('produit/sinistre/Chargement.html', 'Chargement', 'height=200, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);

       /* if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }else if (window.ActiveXObject)
        {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.open("GET", "produit/sinistre/telecharger.php?code="+code, false);
        xhr.send(null);
        */
    }

</script>
</body>
</html>