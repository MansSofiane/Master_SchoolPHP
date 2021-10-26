<?php
session_start();
require_once("../../../../data/conn7.php");
$rqtc=$bdd->prepare("UPDATE `pays` SET `sel_pays`='0' WHERE 1");
$rqtc->execute();

?>