<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
if ( isset($_REQUEST['code'])){

    $sous= $_REQUEST['code'];
    
$rqta=$bdd->prepare("SELECT s.`cod_sous`,s.`nom_sous`, s.`pnom_sous`,s.`dnais_sous` FROM `souscripteurw` as s  WHERE  s.`cod_par`='$sous'");
$rqta->execute();
}
 ?><head>
<title>Intranet</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../../css/bootstrap.min.css" />
<link rel="stylesheet" href="../../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../../css/fullcalendar.css" />
<link rel="stylesheet" href="../../css/matrix-style.css" />
<link rel="stylesheet" href="../../css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="../../css/jquery.gritter.css" />
<link rel="stylesheet" href="../../css/datepicker.css" />
<link rel="stylesheet" href="../../css/uniform.css" />
<link rel="stylesheet" href="../../css/select2.css" />
<link rel="stylesheet" href="../../css/bootstrap-wysihtml5.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../../css/colorpicker.css" />
</head> 
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Liste des Assures</h5></div>
        <div class="widget-content nopadding">
          <table class="table table-bordered data-table">
              <thead>
                <tr>
				  <th></th>
                  <th>Nom/Prenom</th>
				  <th>Date-Naissance</th>
				  <th>Operations</th>
                </tr>
              </thead>
              <tbody>    
			<?php
				$i = 0;
				while ($row_a=$rqta->fetch()){  ?>
			<!-- Ici les lignes du tableau zone-->
			<tr class="gradeX">
			   
				  <td><a><img  src="../../img/icons/icon_3.png"/></a></td>
                  <td><?php  echo $row_a['nom_sous']."  ".$row_a['pnom_sous']; ?></td>
				  <td><?php  echo date("d/m/Y",strtotime($row_a['dnais_sous'])); ?></td>
				  <td>&nbsp;
		 <a onClick="dassug('<?php echo $row_a['cod_sous'];?>')" title="Liste-Avenants"><img  src="../../img/icons/supp.png"/></a>
				  </td>
                </tr>
				<?php } ?>
              </tbody>
            </table>	 
        </div>
      </div>
	 </div>
</div>
<script language="JavaScript">
function fermer() {
   this.close();
}	
function dassug(codsous){

	  if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
     var ok=confirm("Comfirmez la suppression Assure ");
	 if (ok){   
      xhr.open("GET", "dassu.php?code="+codsous, false);
      xhr.send(null); 
	  alert("Assure Supprimer !");	
	  fermer();
		}
	
	}	
</script>	
