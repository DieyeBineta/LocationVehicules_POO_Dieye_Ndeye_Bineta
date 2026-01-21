<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/Vehicule.php';
require_once __DIR__.'/../models/Location.php';

$db = new Database();
$conn = $db->getConnexion();

$vehiculeModel = new Vehicule();
$locationModel = new Location();

$id = $_GET['id'];

// Récupérer la demande
$sql = "SELECT * FROM rental_requests WHERE id = :id";
$req = $conn->prepare($sql);
$req->bindParam(':id', $id);
$req->execute();
$demande = $req->fetch(PDO::FETCH_ASSOC);

// Récupérer le véhicule
$vehicule = $vehiculeModel->find($demande['vehicule_id']);

// Créer la location
$locationModel->create(
    $demande['vehicule_id'],
    $demande['client_id'],
    $demande['date_debut'],
    $demande['date_fin'],
    $vehicule['prix_jour']
);

// Mise à jour
// $requestModel->updateStatut($id, 'confirmee');

$sql1 = "UPDATE rental_requests SET statut = 'confirmee' WHERE id = :id";
$req1 = $conn->prepare($sql1);
$req1->bindParam(':id', $id);
$req1->execute();
$vehiculeModel->updateStatut($demande['vehicule_id'], 'loué');

header('Location: admin.php');
