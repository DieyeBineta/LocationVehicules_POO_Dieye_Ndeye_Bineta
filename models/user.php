<?php

require_once __DIR__.'/../config/database.php';

class User {
    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnexion();
    }

    public function getAll() {
        $sql = "SELECT * FROM users";
        $req = $this->db->query($sql);
        return $req->fetchAll();
    }

    public function create($nom, $email, $password) {
        $sql = "INSERT INTO users(nom, email, mot_de_passe)
                VALUES(:nom, :email, :password)";
        $req = $this->db->prepare($sql);

        $req->bindParam(':nom', $nom);
        $req->bindParam(':email', $email);
        $req->bindParam(':password', $password);

        return $req->execute();
    }
    

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $req = $this->db->prepare($sql);
        $req->bindParam(':email', $email);
        $req->execute();
        return $req->fetch();
    }
    
    public function find($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $req = $this->db->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
        return $req->fetch();
    }

    public function update($id, $nom, $prenom, $email, $mdp) {
        $sql = "UPDATE users SET nom = :nom, prenom = :prenom, 
        email = :email, mot_de_passe= :mdp WHERE id = :id";
        $req = $this->db->prepare($sql);

        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $mdp);
        $req->bindParam(':id', $id);

        return $req->execute();
    }
}
