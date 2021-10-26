<?php 
session_start();
require_once("../../../data/conn7.php");
//$errone = false;
$id_user = $_SESSION['id_usersal'];
?>  
  
  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a class="current">Assurance-Individuelle-Accident</a> </div>
  </div>
  <div class="widget-box">
            <ul class="quick-actions">
			  <li class="bg_lo"> <a onClick="aMenu1('prod','../adash.php')"> <i class="icon-home"></i>Acceuil </a> </li>
			  <li class="bg_ls"> <a onClick="aMenu1('prod','assiaccind')"> <i class="icon-folder-open"></i>Formule-Individuelle</a> </li>
	          <li class="bg_lh"> <a onClick="aMenu1('prod','assiaccgrp')"> <i class="icon-folder-open"></i>Formule-Groupe</a> </li>
            </ul>
  </div>
 	