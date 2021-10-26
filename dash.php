<?php 
 require_once("../../data/conn7.php");
  session_start();
$id_user=$_SESSION['id_usersal'];

  $rqt=$bdd->prepare("SELECT count(cod_pol) as total FROM `policew` as p, souscripteurw as s WHERE p.cod_sous=s.cod_sous and s.id_user='$id_user'");
  $rqt->execute();
  while ($row_res=$rqt->fetch()){
  $total=$row_res['total'];  
}

// Nombre de contrat Voyage
 $rqtv=$bdd->prepare("SELECT count(cod_pol) as totalv FROM `policew` as p, `souscripteurw` as s, `produit` as r WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='1' and s.id_user='$id_user'");
  $rqtv->execute();$totalv=0;
  while ($row_resv=$rqtv->fetch()){
  $totalv=$row_resv['totalv'];  
}
 
 // Nombre de contrat Individuel-Accident
 $rqti=$bdd->prepare("SELECT count(cod_pol) as totali FROM `policew` as p, `souscripteurw` as s, `produit` as r WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='2' and s.id_user='$id_user'");
  $rqti->execute();$totali=0;
  while ($row_resi=$rqti->fetch()){
  $totali=$row_resi['totali'];  
}
 
 // Nombre de contrat Tomporaire au deces
 $rqtt=$bdd->prepare("SELECT count(cod_pol) as totalt FROM `policew` as p, `souscripteurw` as s, `produit` as r WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='6' and s.id_user='$id_user'");
  $rqtt->execute();$totalt=0;
  while ($row_rest=$rqtt->fetch()){
  $totalt=$row_rest['totalt'];  
} 
// Nombre de contrat Desces emprunter
 $rqta=$bdd->prepare("SELECT count(cod_pol) as totala FROM `policew` as p, `souscripteurw` as s, `produit` as r WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='7' and s.id_user='$id_user'");
  $rqta->execute();$totala=0;
  while ($row_resa=$rqta->fetch()){
  $totala=$row_resa['totala'];  
} 
// Nombre de contrat Concer du sein
 $rqtc=$bdd->prepare("SELECT count(cod_pol) as totalc FROM `policew` as p, `souscripteurw` as s, `produit` as r WHERE p.cod_sous=s.cod_sous and p.cod_prod=r.cod_prod and r.cod_prod='5' and s.id_user='$id_user'");
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
			  <li class="bg_lh"> <a onClick="Menu1('prod','assvoy.php')"> <i class="icon-folder-open"></i>A-Voyage</a> </li>
              <li class="bg_ls"> <a onClick="Menu1('prod','asstd.php')"> <i class="icon-folder-open"></i>T-Deces</a> </li>
			  <li class="bg_ly"> <a onClick="Menu1('prod','asscim.php')"> <i class="icon-folder-open"></i>A-D-Emprunteur</a> </li>
			  <li class="bg_lg"> <a onClick="Menu1('prod','assiacc.php')"> <i class="icon-folder-open"></i>I-Accident</a> </li>
			  <li class="bg_lo"> <a onClick="Menu1('prod','assward.php')"> <i class="icon-folder-open"></i>C-S-Warda</a> </li>
			  <li class="bg_lb"> <a onClick="Menu1('mstat','stat.php')"> <i class="icon-bar-chart"></i>E-Production</a> </li>
        <li class="bg_lo"> <a onClick="Menu1('prod','assgroupe.php')"> <i class="icon-folder-open"></i>Groupe</a> </li>
        <li class="bg_lm"> <a onClick="Menu1('prod','asspta.php')"> <i class="icon-folder-open"></i>PTA</a> </li>
			</ul>
	 </div>	
	

<div class="widget-box">
    <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
        <h5>PANDEMIE COVID-19 </h5>
    </div>
    <div class="widget-content">

        <div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert">X</a>
            <h4 class="alert-heading">Mesures prises suite aux perturbations causees par la PANDEMIE COVID-19 </h4>
            <h5 style="color:#071B51" style="text-decoration:blink;"> Faisant suite a la situation sanitaire mondiale actuelle due a la pandemie du COVID-19 ayant causee l interruption momentanee des vols et voyages internationaux, nous vous communiquons nos orientations a observer afin d informer les clients sur le sort de leurs polices d assurance.
</h5>
		  <h5 style="color:#071B51" style="text-decoration:blink;">
Annulation de voyage : Nous rappelons que suivants les conditions particulieres du contrat d assurance, les seuls cas de remboursement des primes d assurances sont:</h5>
<h6 style="color:#071B51" style="text-decoration:blink;">1.	Le refus du visa </h6> 
<h6 style="color:#071B51" style="text-decoration:blink;">2.	Le deces d un proche parent</h6> 
<h6 style="color:#071B51" style="text-decoration:blink;">3.	L incapacite de l assure a voyager pour cause de sante.</h6>
<h5 style="color:#071B51" style="text-decoration:blink;">		  
Toutefois, etant donne cette situation exceptionnelle, l Algerienne Vie consent a permettre a l assure de suspendre son contrat d assurance via l emission de l avenant de report de date, a titre gratuit, a une date ulterieure.
</h5>
 <h5 style="color:#071B51" style="text-decoration:blink;"> 
  Aussi, nous rappelons que toutes les demandes de prise en charge ou d assistances doivent etre adressees a l Assisteur au numero indique sur la carte d assistance.
</h5>
    </div>
    </div>
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