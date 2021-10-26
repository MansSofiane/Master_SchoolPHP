<?php session_start();
require_once("../../../../../../data/conn7.php");
if ($_SESSION['loginsal']){
}
else {
    header("Location:login.php");
}

$id_user = $_SESSION['id_usersal'];
$datesys=date("Y-m-d");

if (  isset($_REQUEST['civ']) && isset($_REQUEST['nom']) && isset($_REQUEST['prenom']) && isset($_REQUEST['age']) && isset($_REQUEST['dnais'])  && isset($_REQUEST['numpass']) && isset($_REQUEST['datpass']) && isset($_REQUEST['cod_sous']) ) {

    $civ = $_REQUEST['civ'];
    $nom = $_REQUEST['nom'];
    $nomi = addslashes($_REQUEST['nom']);
    $prenom = $_REQUEST['prenom'];
    $prenomi = addslashes($_REQUEST['prenom']);
    $age = $_REQUEST['age'];
    $dnais = $_REQUEST['dnais'];
    $numpass = $_REQUEST['numpass'];
    $ddpassa = $_REQUEST['datpass'];
    $cod_sous = $_REQUEST['cod_sous'];

    try {
        $rqtsous3 = $bdd->prepare("INSERT INTO  `souscripteurw`(`cod_sous`,`nom_sous`, `pnom_sous`, `passport`, `datedpass`, `dnais_sous`,`age`, `civ_sous`,`cod_par`, `id_user`) VALUES ('','$nom','$prenomi','$numpass','$ddpassa','$dnais','$age','$civ','$cod_sous','$id_user')");
        $rqtsous3->execute();
    } catch (Exception $ex) {
        echo 'Erreur : ' . $ex->getMessage() . '<br />';
        echo 'N° : ' . $ex->getCode();
    }
}
?>