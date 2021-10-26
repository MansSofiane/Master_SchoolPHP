<?php session_start();
require_once("../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:index.html");
}
$id_user = $_SESSION['id_usersal'];

$rqtdre=$bdd->prepare("SELECT id_user,login FROM `utilisateurs`  WHERE type_user='user' and id_par='0' ORDER BY `login`");
$rqtdre->execute();

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
                        <label class="control-label">DRE *:</label>
                        <div class="controls">
                            <select id="dre">
                                <option value="0">Tout</option>
                                <?php while ($row_res=$rqtdre->fetch()){  ?>
                                    <option value="<?php  echo $row_res['id_user']; ?>"><?php  echo $row_res['login']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions" align="right">
                        <input  type="button" class="btn btn-success" onClick="next()" value="Suivant" />
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
    <script language="JavaScript">initdate();</script>
    <script language="JavaScript">
        function next()
        {
            var dre=document.getElementById("dre").value;
            $("#content").load("adm/stat.php?dre=" + dre);

        }

    </script>
