<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
header("Location:index.html");
}
$id_user = $_SESSION['id_usersal'];

  $rqt = $bdd->prepare("SELECT distinct agence FROM `utilisateurs`  WHERE id_par='$id_user' ORDER BY `agence`");
  $rqt->execute();

?>
<div id="content-header">
  <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-signal"></i> Statistiques</a><a class="current">Production</a></div>
</div>
<div class="row-fluid">
  <div class="span12">
    <div class="widget-box">

      <div class="widget-content nopadding">
        <form class="form-horizontal">
          <div class="control-group">
            <label class="control-label">Agence *:</label>
            <div class="controls">
              <select id="user">
                <option value="0">Tout</option>
                <?php while ($row_res=$rqt->fetch()){  ?>
                  <option value="<?php  echo $row_res['agence']; ?>"><?php  echo $row_res['agence']; ?></option>
                <?php } ?>
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
      <li class="bg_lh"> <a onClick="dprod('1')"> <i class="icon-bar-chart"></i>A-Voyage</a> </li>
      <li class="bg_lb"> <a onClick="dprod('6')"> <i class="icon-bar-chart"></i>TD</a> </li>
      <li class="bg_ly"> <a onClick="dprod('7')"> <i class="icon-bar-chart"></i>ADE</a> </li>
      <li class="bg_lg"> <a onClick="dprod('2')"> <i class="icon-bar-chart"></i>I-Accident</a> </li>
      <li class="bg_lo"> <a onClick="dprod('5')"> <i class="icon-bar-chart"></i>C-Sein (Warda)</a> </li>
      <li class="bg_lv"> <a onClick="dprod('100')"> <i class="icon-bar-chart"></i>Production globale</a> </li>
    </ul>
  </div>
  <script language="JavaScript">initdate();</script>
  <script language="JavaScript">
    function dprod(code){
      var date1=document.getElementById("date1");
      var date2=document.getElementById("date2");
      var user=document.getElementById("user").value;

      if(verifdate1(date1) && verifdate1(date2)) {
        var d1 = dfrtoen(date1.value);
        var d2 = dfrtoen(date2.value);
        if (code != 100) {
          window.open('sortie/SD-Recapitulatif/' + d1 + '/' + code + '/' + user + '/' + d2, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
        }
        else
        {
          window.open('sortie/SD-Recapitulatifg/' + d1 + '/' + code  + '/' + user + '/' + d2, 'Devis', 'height=600, width=800, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');

        }
      }
    }

  </script>