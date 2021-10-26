<?php
//(1) On inclut la classe de Google Maps pour générer ensuite la carte.
require('GoogleMapAPI.class.php');
//(2) On crée une nouvelle carte; Ici, notre carte sera $map.
$map = new GoogleMapAPI('map');
//(3) On ajoute la clef de Google Maps.

$map->setAPIKey('AIzaSyBr2rIqWbSMsVxzzSP7OFJ6W0ENxRTCzYI');
//(4) On ajoute les caractéristiques que l'on désire à notre carte.

$map->setWidth("800px");
$map->setHeight("500px");
$map->setCenterCoords ('2', '48');
$map->setZoomLevel (5);


//(5) On applique la base XHTML avec les fonctions à appliquer ainsi que le onload du body.

?>
  
  
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-file"></i> Geolocalisation</a></div>
</div>
<?php $map->printHeaderJS(); ?>

<?php $map->printMapJS(); ?>


<iframe src="<?php $map->printMap();?>" width="800" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBr2rIqWbSMsVxzzSP7OFJ6W0ENxRTCzYI&callback=initMap"
  type="text/javascript"></script>
<!--
<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d14101605.945756597!2d3.358088331249993!3d30.357346948457373!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sdz!4v1518812239838" width="800" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>-->