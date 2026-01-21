<?php
session_start();

require_once __DIR__.'/../../models/vehicule.php';

$vehicule = new Vehicule;

$id = intval($_GET["id"]);
$vehicule->delete($id);

header("Location: ../vehicule.php");

?>