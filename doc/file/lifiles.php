<?php session_start();
require_once("../../../../data/conn7.php");
$user=$_SESSION['id_usersal'];
// recupération du code du dernier souscripteur de l'agence	
$rqtms=$bdd->prepare("SELECT max(cod_sous) as maxsous FROM `souscripteurw` WHERE id_user='$user'");
$rqtms->execute();
$codsous=0;
while ($row_res=$rqtms->fetch()){ 
$codsous=$row_res['maxsous']; 
}	
//recuperer la nature de souscripteur [physique/morale] champs civ_sous
$rqtciv=$bdd->prepare("SELECT civ_sous FROM `souscripteurw` WHERE cod_sous='$codsous'");
$rqtciv->execute();

while ($row_civ=$rqtciv->fetch()){
    $civ=$row_civ['civ_sous'];
}


// recupération du code du dernier souscripteur de l'agence	
$rqtu=$bdd->prepare("SELECT agence  FROM `utilisateurs` WHERE id_user='$user'");
$rqtu->execute();
$agence=0;
while ($rowu=$rqtu->fetch()){ 
$agence=$rowu['agence']; 
}
$i = 0;
$folder = "../indacc/documents/";
$dossier = opendir($folder);
while (false !== ($Fichier = readdir($dossier))) {
     if ($Fichier != "." && $Fichier != "..") {
	 
		$row_file[$i] = $Fichier;	
		$i++;
	 }
}
closedir($dossier);



?>
<div id="content-header">
      <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a><a>Individuelle-Accident</a><a>Formule-Groupe</a><a class="current">Nouveau-Devis</a> </div>
  </div>
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
      <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Assure (F-Excel)</a><a>Capital</a><a>Validation</a></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
		  <div class="control-group">
		  <label class="control-label">Fichier-A-Importer: </label>
           <?php if($i>=1){
                 for($index=0;$index<$i; $index++){  
                     $test = substr($row_file[$index],0,5);
				    $test2 = substr($row_file[$index],0,6);
                         if($test==$agence || $test2==$agence){
                           ?>
			 
              <div class="controls">
			   <a href="doc/file/Import-Excel.html?row=<?php echo $row_file[$index]?>&row1=<?php echo $codsous; ?> " onClick="window.open(this.href, 'Devis', 'height=200, width=600, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);" >

<?php echo $row_file[$index]?></a>
              </div>
            </div>
		
		   <?php }

                 } 
                 }else{
                ?>
 
              <div class="control-group">
              <label class="control-label">Aucun fichier en attente !</label>      
            </div>
			<?php } ?>
			
            <div class="form-actions" align="right">
              <!--  <input  type="button" class="btn btn-warning" onClick="cexel()" value="Importer Excel" />
                <input  type="button" class="btn btn-success" onClick="listexlx()" value="Excel-(En-cours)" />-->
			  <input  type="button" class="btn btn-warning" onClick="vlassug('<?php echo $codsous; ?>','<?php echo $civ; ?>')" value="Liste-Assures" />
			  <input  type="button" class="btn btn-success" onClick="capitalindg('<?php echo $codsous; ?>','<?php echo $civ; ?>')" value="Suivant" />
			  <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assiaccgrp.php')" value="Annuler" />
            </div>
          </form>
        </div>
      </div>
	 </div>
</div> 
<script language="JavaScript">
function capitalindg(codsous,civ){

	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(civ==0) {
        $("#content").load("produit/iaccidg/moral/devindg3.php?sous=" + codsous);
    }
    else
    {
        $("#content").load("produit/iaccidg/phy/devindg3.php?sous=" + codsous);
    }
	}	
function vlassug(sous,civ){
    if(civ==0)
    {
        var win = window.open("produit/iaccidg/moral/lassug.php?code=" + sous, "window1", "resizable=0,width=700,height=600");

    }
    else {
        var win = window.open("produit/iaccidg/phy/lassug.php?code=" + sous, "window1", "resizable=0,width=700,height=600");
    }
}		
			
</script>	
 
