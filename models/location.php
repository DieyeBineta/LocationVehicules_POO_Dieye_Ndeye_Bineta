<?php

require_once __DIR__.'/../config/database.php';

class Location {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnexion();
    }

    public function getAll() {
        $sql = "SELECT * FROM locations";
        $req = $this->db->query($sql);
        return $req->fetchAll();
    }

    public function create($vehicule_id, $client_id, $date_debut, $date_fin, $prix_jour) {
        $jours = (new DateTime($date_debut))->diff(new DateTime($date_fin))->days;
        $montant = $jours * $prix_jour;

        $sql = "INSERT INTO locations(vehicule_id, client_id, date_debut, date_fin, nombre_jours, montant_total)
                VALUES(:vehicle, :client, :debut, :fin, :jours, :montant)";
        $req = $this->db->prepare($sql);

        $req->bindParam(':vehicle', $vehicule_id);
        $req->bindParam(':client', $client_id);
        $req->bindParam(':debut', $date_debut);
        $req->bindParam(':fin', $date_fin);
        $req->bindParam(':jours', $jours);
        $req->bindParam(':montant', $montant);

        return $req->execute();
    }

    public function getByClient($client_id) {
        $sql = "SELECT * FROM locations WHERE client_id = :client";
        $req = $this->db->prepare($sql);
        $req->bindParam(':client', $client_id);
        $req->execute();
        return $req->fetchAll();
    }
}
