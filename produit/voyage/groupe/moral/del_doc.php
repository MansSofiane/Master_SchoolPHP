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
$folder = "../file/documents/";

if (  isset ($_REQUEST['id_doc'])){$id_doc = $_REQUEST['id_doc'];}

$qrt=$bdd->prepare("select  chemin FROM `document` WHERE `id_doc`='$id_doc' ");
$qrt->execute();
while ($row=$qrt->fetch())
{
    $file=$row["chemin"];

}
if( file_exists ( $folder. $file.".xlsx"))
{
    unlink($folder . $file . ".xlsx");
    Alternative:
    @unlink($folder . $file . ".xlsx");
}
$reqtdoc = $bdd->prepare("DELETE FROM `document` WHERE `id_doc`='$id_doc'");
$reqtdoc->execute();


?>