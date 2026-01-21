<?php

require_once __DIR__.'/../config/database.php';

$db = new Database();
$conn = $db->getConnexion();

$id = intval($_GET['id']);

$sql = "UPDATE rental_requests SET statut = 'refusee' WHERE id = :id";
$req = $conn->prepare($sql);
$req->bindParam(':id', $id);
$req->execute();


header('Location: admin.php');
