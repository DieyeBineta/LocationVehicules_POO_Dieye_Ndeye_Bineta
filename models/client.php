<?php

require_once __DIR__.'/../config/database.php';

class Client {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnexion();
    }

    public function getAll() {
        $sql = "SELECT * FROM clients";
        $req = $this->db->query($sql);
        return $req->fetchAll();
    }

    public function create($nom, $prenom, $email, $password, $telephone, $adresse) {
        $sql = "INSERT INTO clients(nom, prenom, email, mot_de_passe, telephone, adresse)
                VALUES(:nom, :prenom, :email, :password, :telephone, :adresse)";
        $req = $this->db->prepare($sql);

        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':password', $password);
        $req->bindParam(':telephone', $telephone);
        $req->bindParam(':adresse', $adresse);

        return $req->execute();
    }

    public function findByEmail($email) {
        $sql = "SELECT COUNT(*) FROM clients WHERE email = :email";
        $req = $this->db->prepare($sql);
        $req->bindParam(':email', $email);
        $req->execute();
        return $req->fetch();
    }

    public function find($id) {
        $sql = "SELECT * FROM clients WHERE id = :id";
        $req = $this->db->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
        return $req->fetch();
    }

    public function delete($id) {
        $sql = "DELETE FROM clients WHERE id = :id";
        $req = $this->db->prepare($sql);
        $req->bindParam(':id', $id);

        return $req->execute();
    }

    public function update($id, $nom, $prenom, $email, $mdp, $tel, $adr) {
        $sql = "UPDATE clients SET nom = :nom, prenom = :prenom, 
        email = :email, mot_de_passe= :mdp, telephone = :tel, adresse = :adr WHERE id = :id";
        $req = $this->db->prepare($sql);

        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $mdp);
        $req->bindParam(':tel', $tel);
        $req->bindParam(':adr', $adr);
        $req->bindParam(':id', $id);

        return $req->execute();
    }
}
