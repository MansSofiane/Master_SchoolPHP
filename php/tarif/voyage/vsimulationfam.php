<?php session_start();
require_once("../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
//Periode
$rqtper=$bdd->prepare("SELECT * FROM `periode`  WHERE  trt_per >='1' and cod_per not in ('5','18') ORDER BY `cod_per`");
$rqtper->execute();
$rqttyp=$bdd->prepare("SELECT * FROM `type_sous`  WHERE 1 ");
$rqttyp->execute();
$rqtopt=$bdd->prepare("SELECT * FROM `option`  WHERE  cod_opt ='22'  ");//OR cod_opt ='25'
$rqtopt->execute();
$rqtzone=$bdd->prepare("SELECT * FROM `pays`  WHERE 1 ");
$rqtzone->execute();
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyave</a> <a>Formule-Famille</a> <a class="current">Simulateur</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i></span><h5>Parametres-Tarif</h5></div>
            <div class="widget-content nopadding">
                <form class="form-horizontal">
                    <div class="control-group">
                        <div class="controls">
                            <select id="tsousscpl">
                                <option value="">-- Type-Souscripteur (*)</option>
                                <?php while ($row_res=$rqttyp->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_tsous']; ?>"><?php  echo $row_res['lib_tsous']; ?></option>
                                <?php } ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;

                            <select  class="styledselect_form_1"  id="nbpf" >
                                <option value="--">-Nombre de personnes:-</option>
                                <option value="3"> 3 Personnes</option>
                                <option value="4"> 4 Personnes</option>
                                <option value="5"> 5 Personnes</option>
                                <option value="6"> 6 Personnes</option>
                                <option value="7"> 7 Personnes</option>
                                <option value="8"> 8 Personnes</option>
                                <option value="9"> 9 Personnes</option>
                            </select>

                        </div>

                    </div>
                    <div class="control-group">
                        <div class="controls">


                            <select id="opt" onchange="option()">
                                <option value="" >-- Option (*)</option>
                                <?php while ($row_res=$rqtopt->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_opt']; ?>"><?php  echo $row_res['lib_opt']; ?></option>
                                <?php } ?>
                            </select>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select id="zone">
                                <option value="">-- Pays (*)</option>
                                <?php while ($row_res=$rqtzone->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_pays']; ?>"><?php  echo $row_res['lib_pays']; ?></option>
                                <?php } ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        </div>
                        <div class="controls">
                            <select id="jour">
                                <option value="" >-- Duree (Jours):</option>
                                <?php while ($row_res=$rqtper->fetch()){  ?>
                                    <option value="<?php  echo $row_res['cod_per']; ?>"><?php  echo $row_res['lib_per']; ?></option>
                                <?php } ?>
                            </select>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" class="inp-form"  id="agef"  placeholder="Age moyen (*)"/>
                            </div>
                    </div>
                    <div class="control-group">

                        <div class="controls">
                            <div data-date-format="dd/mm/yyyy">
                                <input type="hidden" name="token" id="datsys" value="<?php echo $datesys; ?>"/>
                            </div>
                        </div>
                        <div class="form-actions" align="right">
                            <input  type="button" class="btn btn-success" onClick="vtarfam()" value="Voir le Tarif" />
                            <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoyfam.php')" value="Retour" />
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
<script language="JavaScript">initdate();</script>
<script language="JavaScript">

  /*  function caltarfam(){
        var jour = document.getElementById("jour").value;
        var nbpf = document.getElementById("nbpf").value;
        var opt = document.getElementById("opt").value;
        var zone = document.getElementById("zone").value;
        var age = document.getElementById("agef").value;


        if(isNaN(jour) != true && isNaN(nbpf) != true && isNaN(age) != true)
        {
            if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            else if (window.ActiveXObject)
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xhr.open("GET", "fam/tarif.php?row="+jour+"&row1="+nbpf+"&row2="+opt+"&row3="+zone+"&row4="+age, false);
            xhr.send(null);
            alert(xhr.responseText);
        }else{
            alert("merci de saisir un nombre entier!");
        }
    }

*/

    function option()
    {
        if(document.getElementById("opt").value==24){

            document.getElementById("jour").options[0].text ="1 Mois";
            document.getElementById("jour").options[0].value =4;//cod_per=4 correspond au 30 jours
            document.getElementById("zone").options[0].text ="TUNISIE";
            document.getElementById("zone").options[0].value ="TN";
            document.getElementById("jour").selectedIndex=0;
            document.getElementById("zone").selectedIndex=0;
            document.getElementById("jour").disabled = true;
            document.getElementById("zone").disabled = true;
           // document.getElementById("nbpf").options[0].text ="--";
           // document.getElementById("nbpf").options[0].value ="";
        }else{
            if(document.getElementById("opt").value==25){

                document.getElementById("jour").options[0].text ="1 Mois";
                document.getElementById("jour").disabled=true;
                document.getElementById("jour").options[0].value =7;//cod_per=4 correspond au 30 jours
                document.getElementById("zone").options[0].text ="-- Pays (*)";
                document.getElementById("zone").options[0].value ="";
                document.getElementById("jour").selectedIndex=0;
                document.getElementById("zone").selectedIndex=0;
                // document.getElementById("jour").disabled = true;
                // document.getElementById("zone").disabled = true;
                // document.getElementById("nbpf").options[0].text ="--";
                // document.getElementById("nbpf").options[0].value ="";
            }else {

                document.getElementById("jour").options[0].text = "-- Duree (Jours):";
                document.getElementById("jour").options[0].value = "";
                document.getElementById("zone").options[0].text = "-- Pays (*)";
                document.getElementById("zone").options[0].value = "";
                // document.getElementById("nbpf").options[0].text ="";
                // document.getElementById("nbpf").options[0].value ="";
                document.getElementById("jour").disabled = false;
                document.getElementById("zone").disabled = false;
            }
        }

    }


  function vtarfam()
  {

      var jour = document.getElementById("jour").value;
      var nbpf = document.getElementById("nbpf").value;
      var opt = document.getElementById("opt").value;
      var zone = document.getElementById("zone").value;
      var age = document.getElementById("agef").value;
      var tsous=document.getElementById("tsousscpl").value;
      if(opt)
      {
          if(opt=="24")
          {
              jour="7";
          }
          if(opt=="25")
          {
              jour="7";
              //vérifier que le pays est soit la tunisie ou la turquie
              if(zone!="TN" && zone!="TR")
              {
                  alert ("Cette option est reservee uniquement pour la Tunisie et la Turquie");
                  document.getElementById("zone").value="";
                  return;
              }
          }
      }
      if(jour && nbpf && opt && zone && age && tsous)
      {
          if (isNaN(jour) != true && isNaN(nbpf) != true && isNaN(age) != true) {
              if (window.XMLHttpRequest) {
                  xhr = new XMLHttpRequest();
              }
              else if (window.ActiveXObject) {
                  xhr = new ActiveXObject("Microsoft.XMLHTTP");
              }

              xhr.open("GET", "php/tarif/voyage/rtvoyfam.php?row=" + jour + "&row1=" + nbpf + "&row2=" + opt + "&row3=" + zone + "&row4=" + age+"&tsous="+tsous, false);
              xhr.send(null);
              alert(xhr.responseText);
          } else {
              alert("merci de saisir un nombre entier!");
          }
      }else

      {alert("veuillez remplir tous les champs obligatiore!.");}

  }

    /////////////////////
 /*   function verifdate1(dd)
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
    function dfrtoen(date1)
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
    function calage(dd)
    {
        var bb1=document.getElementById("datsys");
        var aa=new Date(dfrtoen(dd.value));
        var bb=new Date(bb1.value);
        var sec1=bb.getTime();
        var sec2=aa.getTime();
        var sec=(sec1-sec2)/(365.24*24*3600*1000);
        age=Math.floor(sec);
        return age;

    }
*/

</script>	