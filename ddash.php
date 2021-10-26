<?php 
 require_once("../../data/conn7.php");
  session_start();
$id_user=$_SESSION['id_usersal'];

  $rqt=$bdd->prepare("SELECT count(cod_pol) as total FROM `policew` as p, souscripteurw as s,utilisateurs as u WHERE p.cod_sous=s.cod_sous AND s.id_user=u.id_user AND u.id_par='$id_user'");
  $rqt->execute();
  while ($row_res=$rqt->fetch()){
  $total=$row_res['total'];  
}

// Nombre de contrat Voyage
 $rqtv=$bdd->prepare("SELECT count(cod_pol) as totalv FROM `policew` as p, `souscripteurw` as s, `produit` as r,utilisateurs as u WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='1' AND s.id_user=u.id_user AND u.id_par='$id_user'");
  $rqtv->execute();$totalv=0;
  while ($row_resv=$rqtv->fetch()){
  $totalv=$row_resv['totalv'];  
}
 
 // Nombre de contrat Individuel-Accident
 $rqti=$bdd->prepare("SELECT count(cod_pol) as totali FROM `policew` as p, `souscripteurw` as s, `produit` as r,utilisateurs as u WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='2' AND s.id_user=u.id_user AND u.id_par='$id_user'");
  $rqti->execute();$totali=0;
  while ($row_resi=$rqti->fetch()){
  $totali=$row_resi['totali'];  
}
 
 // Nombre de contrat Tomporaire au deces
 $rqtt=$bdd->prepare("SELECT count(cod_pol) as totalt FROM `policew` as p, `souscripteurw` as s, `produit` as r,utilisateurs as u WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='6' AND s.id_user=u.id_user AND u.id_par='$id_user'");
  $rqtt->execute();$totalt=0;
  while ($row_rest=$rqtt->fetch()){
  $totalt=$row_rest['totalt'];  
} 
// Nombre de contrat Desces emprunter
 $rqta=$bdd->prepare("SELECT count(cod_pol) as totala FROM `policew` as p, `souscripteurw` as s, `produit` as r,utilisateurs as u WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='7' AND s.id_user=u.id_user AND u.id_par='$id_user'");
  $rqta->execute();$totala=0;
  while ($row_resa=$rqta->fetch()){
  $totala=$row_resa['totala'];  
} 
// Nombre de contrat Concer du sein
 $rqtc=$bdd->prepare("SELECT count(cod_pol) as totalc FROM `policew` as p, `souscripteurw` as s, `produit` as r,utilisateurs as u WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='5' AND s.id_user=u.id_user AND u.id_par='$id_user'");
  $rqtc->execute();$totalc=0;
  while ($row_resc=$rqtc->fetch()){
  $totalc=$row_resc['totalc'];  
} 

if($total==0){$total=1;}
?>  
  
   <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Acceuil</a></div>
  </div>
    <div class="widget-box">
         
            <ul class="quick-actions">
			  <li class="bg_lh"> <a onClick="dMenu1('prod','assvoy.php')"> <i class="icon-folder-open"></i>A-Voyage</a></li>
		      <li class="bg_ls"> <a onClick="dMenu1('prod','polasstd.php')"> <i class="icon-folder-open"></i>T-Deces</a> </li>
			  <li class="bg_ly"> <a onClick="dMenu1('prod','polasscim.php')"> <i class="icon-folder-open"></i>A-D-Emprunteur</a> </li>
			  <li class="bg_lg"> <a onClick="dMenu1('prod','assiacc.php')"> <i class="icon-folder-open"></i>I-Accident</a> </li>
			  <li class="bg_lo"> <a onClick="dMenu1('prod','polassward.php')"> <i class="icon-folder-open"></i>C-S-Warda</a> </li>
			  <li class="bg_lb"> <a onClick="dMenu1('mstat','stat.php')"> <i class="icon-bar-chart"></i>E-Production</a> </li>
        <li class="bg_lo"> <a onClick="dMenu1('prod','polassgroupe.php')"> <i class="icon-folder-open"></i>Groupe</a> </li>
        <li class="bg_lm"> <a onClick="dMenu1('prod','polasspta.php')"> <i class="icon-folder-open"></i>PTA</a> </li>
			</ul>
	 </div>	
 <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
            <h5>Suivi-Production  -- Nombre de contrats: <?php echo $total; ?> </h5>
          </div>
          <div class="widget-content">
            <ul class="unstyled">
              <li> <span class="icon24 icomoon-icon-arrow-up-2 green"></span> <?php echo number_format(($totalv/$total)*100, 2, ',', ''); ?> % Assurance Voyage <span class="pull-right strong"><?php echo $totalv; ?></span>
                <div class="progress progress-striped ">
                  <div style="width: <?php echo ($totalv/$total)*100; ?>%;" class="bar"></div>
                </div>
              </li>
              <li> <span class="icon24 icomoon-icon-arrow-up-2 green"></span> <?php echo number_format(($totali/$total)*100, 2, ',', ''); ?> % Individuel-Accident <span class="pull-right strong"><?php echo $totali; ?></span>
                <div class="progress progress-success progress-striped ">
                  <div style="width: <?php echo ($totali/$total)*100; ?>%;" class="bar"></div>
                </div>
              </li>
              <li> <span class="icon24 icomoon-icon-arrow-down-2 red"></span> <?php echo ($totalt/$total)*100; ?>% TD <span class="pull-right strong"><?php echo $totalt; ?></span>
                <div class="progress progress-warning progress-striped ">
                  <div style="width: <?php echo ($totalt/$total)*100; ?>%;" class="bar"></div>
                </div>
              </li>
              <li> <span class="icon24 icomoon-icon-arrow-up-2 green"></span> <?php echo number_format(($totala/$total)*100, 2, ',', ''); ?> % ADE <span class="pull-right strong"><?php echo $totala; ?></span>
                <div class="progress progress-danger progress-striped ">
                  <div style="width: <?php echo ($totala/$total)*100; ?>%;" class="bar"></div>
                </div>
              </li>
			   <li> <span class="icon24 icomoon-icon-arrow-up-2 green"></span> <?php echo number_format(($totalc/$total)*100, 2, ',', ''); ?> % Warda <span class="pull-right strong"><?php echo $totalc; ?></span>
                <div class="progress  progress-striped ">
                  <div style="width: <?php echo ($totalc/$total)*100; ?>%;" class="bar"></div>
                </div>
              </li>
            </ul>
          </div>
        </div>		