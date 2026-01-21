<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/Vehicule.php';
require_once __DIR__.'/../models/Location.php';

$db = new Database();
$conn = $db->getConnexion();
$vehiculeModel = new Vehicule();

$id = $_GET['id'];

// Récupérer la demande
$sql = "SELECT * FROM locations WHERE id = :id";
$req = $conn->prepare($sql);
$req->bindParam(':id', $id);
$req->execute();
$remise = $req->fetch(PDO::FETCH_ASSOC);

// Récupérer le véhicule
$vehicule = $vehiculeModel->find($remise['vehicule_id']);

// Mise à jour
// $requestModel->updateStatut($id, 'confirmee');
$vehiculeModel->updateStatut($vehicule['id'], 'disponible');

// echo "<script>
// alert('Voiture rendu');
// window.location.href('location.php')
// </script>";

header('Location: admin.php');
