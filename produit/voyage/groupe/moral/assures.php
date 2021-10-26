<?php session_start();
require_once("../../../../../../data/conn7.php");
$folder = "../file/documents/";
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}
$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");
error_reporting(0);
if (  isset ($_REQUEST['codsous'])){$codsous = $_REQUEST['codsous'];}

require_once '../file/Classes/PHPExcel/IOFactory.php';

$rqtf=$bdd->prepare("select * from document where id_user='$id_user' and id_demande = '$codsous' order by id_doc DESC LIMIT 0,1");
$rqtf->execute();
$file="";$id_doc="";
while ($row=$rqtf->fetch())
{
    $file=$row["chemin"];
    $id_doc=$row["id_doc"];
}
?>
<div id="content-header">
    <div id="breadcrumb"> <a class="tip-bottom"><i class="icon-home"></i> Produit</a> <a>Assurance-Voyage-Groupe</a> <a class="current">Nouveau-Devis</a> </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div id="breadcrumb"> <a><i></i>Souscripteur</a><a class="current">Assure</a>
                <div class="widget-content nopadding">
                    <form class="form-horizontal">
                        <table class="table table-bordered data-table" id="tassur">

                        <thead>
                        <tr>
                            <th>Civilite</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Passport</th>
                            <th>Date_deliv_passport</th>
                            <th>Date_naissance</th>
                            <th>Adresse</th>
                            <th>Mail</th>
                            <th>Telephone</th>

                        </tr>
                        </thead>
                        <tbody>
<?php
error_reporting(0);
$objPHPExcel = PHPExcel_IOFactory::load($folder. $file.".xlsx");

/**
 * r�cup�ration de la premi�re feuille du fichier Excel
 * @var PHPExcel_Worksheet $sheet
 */
$sheet = $objPHPExcel->getSheet(0);

//echo '<table border="1">';

// On boucle sur les lignes
$i=0;
foreach($sheet->getRowIterator() as $row)
{

   if($i==0)
   {

   }
    else {
        echo ' <tr class="gradeX">';

        // On boucle sur les cellule de la ligne
        $j=0;

        foreach ($row->getCellIterator() as $cell) {
            $j++;
            echo '<td>';
            if($j==5 or $j==6)
            {
                print_r(PHPExcel_Style_NumberFormat::toFormattedString($cell->getValue(), 'DD/MM/YYYY'));
            }
            else
            {
                print_r($cell->getValue());
            }

            echo '</td>';
        }


        echo '</tr>';
    }
    $i++;
}
echo '</tbody>';
echo '</table>';

?>
                <div class="form-actions" align="right">
                    <input  type="button" class="btn btn-success" onClick="suivant('<?php echo $codsous; ?>', '<?php echo $file;?>','<?php echo $id_doc;?>')" value="Suivant" />
                    <input  type="button" class="btn btn-danger"  onClick="Menu1('prod','assvoygrp.php')" value="Annuler" />
                </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script language="JavaScript">initdate();</script>
    <script language="JavaScript">


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

       function suivant(codsous,file,id_doc)
       {
           var nb_assur='<?php echo $i;?>';

           if  (nb_assur>=10) {
           if (codsous && file && id_doc)
           {
               //inserer les assur�s.
               xhr.open("GET","produit/voyage/groupe/moral/new_assure.php?codsous=" + codsous+"&file="+file+"&id_doc="+id_doc);
               xhr.send(null);
               //aller a destination.
               $("#content").load("produit/voyage/groupe/moral/destination.php?codsous=" + codsous+"&file="+file+"&id_doc="+id_doc);
           }
           }
           else
           {
               //supprimer  le fichier dans la base de donn�es table document.
               //inserer les assur�s.
               xhr.open("GET","produit/voyage/groupe/moral/del_doc.php?id_doc=" + id_doc);
               xhr.send(null);

               alert("Le nombre d'assur�s doit etre superieur ou egal a 10!");
           }



       }

        </script>