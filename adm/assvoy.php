<?php 
session_start();
require_once("../../../data/conn7.php");
//$errone = false;
//Recuperation de la page demandee 
if (isset($_REQUEST['page'])) {
	$page = $_REQUEST['page'];
}else{$page=0;}
$id_user = $_SESSION['id_usersal'];

if (isset($_REQUEST['rech'])) {
	$rech = $_REQUEST['rech'];
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT p.*, g.* FROM `produit` as p,`garantie` as g,`affgarprod` as a WHERE a.cod_prod=p.cod_prod and a.cod_gar=g.cod_gar and a.id_user=$id_user AND g.lib_gar LIKE '%$rech%' ORDER BY `cod_aff`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.*, g.* FROM `produit` as p,`garantie` as g,`affgarprod` as a WHERE a.cod_prod=p.cod_prod and a.cod_gar=g.cod_gar and a.id_user=$id_user AND g.lib_gar LIKE '%$rech%' ORDER BY `cod_aff` LIMIT $part ,5");
$rqt->execute();	
	
}else{
//Calcule du nombre de page 
$rqtc=$bdd->prepare("SELECT p.*, g.* FROM `produit` as p,`garantie` as g,`affgarprod` as a WHERE a.cod_prod=p.cod_prod and a.cod_gar=g.cod_gar and a.id_user=$id_user ORDER BY `cod_aff`");
$rqtc->execute();
$nbe = $rqtc->rowCount();
$nbpage=ceil($nbe/5);
//Pointeur de page
$part=$page*5;
//requete à suivre
$rqt=$bdd->prepare("SELECT p.*, g.* FROM `produit` as p,`garantie` as g,`affgarprod` as a WHERE a.cod_prod=p.cod_prod and a.cod_gar=g.cod_gar and a.id_user=$id_user ORDER BY `cod_aff` LIMIT $part ,5");
$rqt->execute();
$nb = $rqt->execute();
}
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Assurance-Voyage</a> </div>
  </div>
  <div class="widget-box">
            <ul class="quick-actions">
			  <li class="bg_lo"> <a onClick="aMenu1('macc','../adash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
			  <li class="bg_ls"> <a onClick="aMenu1('prod','apolvoyind.php')"> <i class="icon-user"></i>F-Individuelle</a></li>
			  <li class="bg_lb"> <a onClick="aMenu1('prod','apolassvoycpl.php')"> <i class="icon-user"></i>F-Couple</a> </li>
	          <li class="bg_ly"> <a onClick="aMenu1('prod','apolassvoyfam.php')"> <i class="icon-folder-open"></i>F-Famille</a> </li>
			  <li class="bg_lg"> <a onClick="aMenu1('prod','apolassvoygrp.php')"> <i class="icon-user"></i>F-Groupe</a> </li>
            </ul>
  </div>
  