<?php session_start();
if ($_SESSION['loginsal']){
}
else {
header("Location:login.php");
}

?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-info-sign"></i> Insertion-Zone</a></div>
  </div>
  <div class="row-fluid">
  
  
    <div class="span12">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>info-Souscripteur</h5></div>
        <div class="widget-content nopadding">
          <form class="form-horizontal">
		   <div class="control-group">
              <label class="control-label">Type-Souscripteur</label>
              <div class="controls">
                <select id="typsous">
				  <option value="0">--</option>
                  <option value="1">Personne-Moral</option>
                  <option value="2">Personne-Physique</option>
                </select>
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Date-Naissance</label>
              <div class="controls">
                  <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="age"/>
                  <span class="add-on"><i class="icon-th"></i></span> 
				  </div>
              </div>           
            </div>
            <div class="control-group">
              <label class="control-label">Nom *:</label>
              <div class="controls">
                <input type="text" id="nom" class="span11" placeholder="Nom" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Prenom *:</label>
              <div class="controls">
                <input type="text" id="pnom" class="span11" placeholder="Prenom" />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Raison Sociale *:</label>
              <div class="controls">
                <input type="text" id="raison" class="span11" placeholder="R-Sociale.." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Adresse *:</label>
              <div class="controls">
                <input type="text" id="adr" class="span11" placeholder="Adresse"  />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Telephone:</label>
              <div class="controls">
                <input type="text" id="tel" class="span11" placeholder="+213 ...." />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">E-mail:</label>
              <div class="controls">
                <input type="text" id="mail" class="span11" placeholder="E-mail..." />
              </div>
            </div>
			 <div class="control-group">
              <label class="control-label">Numero Passeport:</label>
              <div class="controls">
                <input type="text" id="pass" class="span6" placeholder="Passport numero" />
              </div>
			  
            </div>
			
            <div class="form-actions" align="right">
			  <input  type="button" class="btn btn-primary" onClick="souscripteur()" value="Reset" />
              <input  type="button" class="btn btn-info" onClick="test()" value="Editer" />
			  <input  type="button" class="btn btn-danger" onClick="test()" value="Annuler" />
			  <input  type="button" class="btn btn-success" onClick="suivant()" value="Suivant" />
            </div>
          </form>
        </div>
      </div>
	 </div>
 
</div>
<script language="JavaScript">initdate();</script>