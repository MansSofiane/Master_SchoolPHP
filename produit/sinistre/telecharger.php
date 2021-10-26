<?php
session_start();
require_once("../../../../data/conn7.php");

$id_user = $_SESSION['id_usersal'];

if ($_SESSION['loginsal']){}
else {
    header("Location:../index.html?erreur=login"); // redirection en cas d'echec
}
$cod_sinistre='0';
if (isset($_REQUEST['cod'])) {
    $cod_sinistre = $_REQUEST['cod'];
}

if(isset($_POST['submit'])) {

    if (!empty($_FILES))
    {

        $file_name = $id_user.'-'.$_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];



        $file_dest = '/CASH/produit/voyage/groupe/file/sinistre/'.$file_name;


        if (move_uploaded_file($file_name, $file_dest))
        {
            echo ' fichier envoyé avec succés ';



        }
        else
        {
            echo' une erreur est survenu lors de l envoie de fichier ';
        }


    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <title>Intranet</title>
    <link rel="stylesheet" href="../../css/screen.css" type="text/css" media="screen" title="default" />

</head>
<body>
<div id="content">
    <br />
    <div id="page-heading">
        <h1><b><big>telecharger un fichier</big></b></h1>
    </div>
    <br />
    <br />
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file"/>
        <input type="submit" name="submit"/>
    </form>
</body>
</html>

