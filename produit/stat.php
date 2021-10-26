<?php session_start();
require_once("../../../data/conn7.php");
$token1 = generer_token('stat');
if ($_SESSION['loginsal']){
}
else {
header("Location:index.html");
}
if ( isset($_REQUEST['tok']) ) {
    $token = $_REQUEST['tok'];
}
?>

  <div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-signal"></i> Statistiques</a><a class="current">Production-PDF</a></div>
  </div>
  

     
  <div class="row-fluid">  
    <div class="span12">
      <div class="widget-box">
     
        <div class="widget-content nopadding">
          <form class="form-horizontal">
			<div class="control-group"> 
			<label class="control-label">Type-Etat:</label>
              <div class="controls">
			  <select id="te">
                  <option value="1">Positif</option>
                  <option value="2">Negatif avec Ristourne</option>
				  <option value="4">Negatif sans Ristourne</option>
				  <option value="3">Global</option>
                </select>
				</div>
				</div>
				
				<div class="control-group"> 
				<div class="controls">
				 <div data-date-format="dd/mm/yyyy">
				  <input type="text" class="date-pick dp-applied"  id="date1" placeholder="Du 01/01/2000 (*)"/>
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input type="text" class="date-pick dp-applied"  id="date2" placeholder="Au 01/01/2000 (*)"/>
              </div>
			  </div>	
			
          </form>
        </div>
      </div>
	 </div>
  
  <div class="widget-box">
         
            <ul class="quick-actions">
			  <li class="bg_lh"> <a onClick="prod('1')"> <i class="icon-bar-chart"></i>A-Voyage</a> </li>
			  <li class="bg_lb"> <a onClick="prod('6')"> <i class="icon-bar-chart"></i>TD</a> </li>
			  <li class="bg_ly"> <a onClick="prod('7')"> <i class="icon-bar-chart"></i>ADE</a> </li>
			  <li class="bg_lg"> <a onClick="prod('2')"> <i class="icon-bar-chart"></i>I-Accident</a> </li>
			  <li class="bg_lo"> <a onClick="prod('5')"> <i class="icon-bar-chart"></i>C-Sein (Warda)</a> </li>
		    <li class="bg_lv"> <a onClick="prod('100')"> <i class="icon-bar-chart"></i>production globale</a> </li>
			</ul>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">

	function verifdatestat(dd)
	{
		v1=true;
		var regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
		var test = regex.test(dd.value);
		if(!test){
			v1=false;
			alert("Format date incorrect! jj/mm/aaaa");dd.value="";

		}
		return v1;
	}

	function dfrtoenstat(date1)
	{
		var split_date=date1.split('/');
		var new_d=new Date(split_date[2], split_date[1]*1 - 1, split_date[0]*1);
		var new_day = new_d.getDate();
		new_day = ((new_day < 10) ? '0' : '') + new_day; // ajoute un zéro devant pour la forme
		var new_month = new_d.getMonth() + 1;
		new_month = ((new_month < 10) ? '0' : '') + new_month; // ajoute un zéro devant pour la forme
		var new_year = new_d.getYear();
		new_year = ((new_year < 200) ? 1900 : 0) + new_year; // necessaire car IE et FF retourne pas la meme chose
		var new_date_text = new_year + '-' + new_month + '-' + new_day;
		return new_date_text;
	}
function prod(code) {

	var type = document.getElementById("te").value;
	var date1 = document.getElementById("date1");
	var date2 = document.getElementById("date2");

	if (verifdatestat(date1) && verifdatestat(date2)) {
		var d1 = dfrtoenstat(date1.value);
		var d2 = dfrtoenstat(date2.value);

		if(code != 100) {
			if (type == 3) {
				window.open('sortie/Recapitulatif/' + d1 + '/' + code + '/' + d2, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			}
			if (type == 2) {
				window.open('sortie/Recapitulatif-N/' + d1 + '/' + code + '/' + d2, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			}
			if (type == 4) {
				window.open('sortie/Recapitulatif-NSR/' + d1 + '/' + code + '/' + d2, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			}
			if (type == 1) {
				window.open('sortie/Recapitulatif-P/' + d1 + '/' + code + '/' + d2, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			}
		}
	else
		{
			if (type == 3) {

				window.open('sortie/tousproduits/' + d1 + '/' + code + '/' + d2, 'DevisG', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			}
			if (type == 2) {
				window.open('sortie/Recapitulatifg-N/' + d1 + '/' + code + '/' + d2, 'DevisN', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			}
			if (type == 4) {
				window.open('sortie/Recapitulatifg-NSR/' + d1 + '/' + code + '/' + d2, 'DevisN', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			}
			if (type == 1) {
				window.open('sortie/Recapitulatifg-P/' + d1 + '/' + code + '/' + d2, 'DevisP', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
			}
		}
	}
}

</script>