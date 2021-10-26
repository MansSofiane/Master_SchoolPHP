<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Nouvelle-Zone</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Zone</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Libelle-Zone *:</label>
              <div class="controls">
                <input type="text" id="libzon" class="span7" placeholder="Lib ..." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Commentaire *:</label>
              <div class="controls">
                <input type="text" id="comzon" class="span7" placeholder="..." />
              </div>
            </div>
            <div class="form-actions" align="center">
			  <input  type="button" class="btn btn-success" onClick="inszon('<?php echo $id_user; ?>')" value="Enregistrer" />
			  <input  type="button" class="btn btn-danger" onClick="Menu2('param','zones.php')" value="Annuler" />
			  
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">
function inszon(user){
var libzon=document.getElementById("libzon").value;
var comzon=document.getElementById("comzon").value;
	   if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
     }
     else if (window.ActiveXObject) 
     {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
	if(libzon && comzon){ 	
	 xhr.open("GET", "php/insert/nzone.php?libzon="+libzon+"&comzon="+comzon+"&user="+user, false);
     xhr.send(null);
	 //alert(xhr.responseText);
	 alert("Zone Introduite !");
	 Menu2('param','zones.php');
	  }else{alert("Veuillez Remplir tous les champs obligatoire (*) !");}
	  //lien(codz);
	}	
			
</script>	