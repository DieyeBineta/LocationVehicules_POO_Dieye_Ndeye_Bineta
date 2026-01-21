<?php

require_once __DIR__.'/../config/database.php';

class Vehicule {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnexion();
    }

    public function getAll() {
        $sql = "SELECT * FROM vehicules";
        return $this->db->query($sql)->fetchAll();
    }

    public function countAll() {
        $sql = "SELECT COUNT(*) FROM vehicules";
        $req = $this->db->query($sql);
        return $req->fetchAll();
    }

    public function getDisponibles() {
        $sql = "SELECT * FROM vehicules WHERE statut = 'disponible'";
        return $this->db->query($sql)->fetchAll();
    }

    public function create($marque, $modele, $type, $immatriculation, $prix_jour, $desc, $name_img, $imagedata) {
        $sql = "INSERT INTO vehicules(marque, modele, type, immatriculation, prix_jour, description, name_img, image_data)
                VALUES(:marque, :modele, :type, :immat, :prix, :desc, :name, :data)";
        $req = $this->db->prepare($sql);

        $req->bindParam(':marque', $marque);
        $req->bindParam(':modele', $modele);
        $req->bindParam(':type', $type);
        $req->bindParam(':immat', $immatriculation);
        $req->bindParam(':prix', $prix_jour);
        $req->bindParam(':desc', $desc);
        $req->bindParam(':name', $name_img);
        $req->bindParam(':data', $imagedata);

        return $req->execute();
    }

    public function update($id, $marque, $modele, $type, $immatriculation, $prix_jour, $desc, $name_img, $imagedata) {
        $sql = "UPDATE vehicules SET marque = :marque, modele = :modele, type = :type, 
        immatriculation = :immat, prix_jour = :prix, description = :desc, name_img = :name, 
        image_data = :data WHERE id = :id";
        $req = $this->db->prepare($sql);

        $req->bindParam(':marque', $marque);
        $req->bindParam(':modele', $modele);
        $req->bindParam(':type', $type);
        $req->bindParam(':immat', $immatriculation);
        $req->bindParam(':prix', $prix_jour);
        $req->bindParam(':desc', $desc);
        $req->bindParam(':name', $name_img);
        $req->bindParam(':data', $imagedata);
        $req->bindParam(':id', $id);

        return $req->execute();
    }

    public function updateStatut($id, $statut) {
        $sql = "UPDATE vehicules SET statut = :statut WHERE id = :id";
        $req = $this->db->prepare($sql);
        $req->bindParam(':statut', $statut);
        $req->bindParam(':id', $id);
        return $req->execute();
    }

    public function find($id) {
        $sql = "SELECT * FROM vehicules WHERE id = :id";
        $req = $this->db->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
        return $req->fetch();
    }

    public function delete($id) {
        $sql = "DELETE FROM vehicules WHERE id = :id";
        $req = $this->db->prepare($sql);
        $req->bindParam(':id', $id);

        return $req->execute();
    }
}
