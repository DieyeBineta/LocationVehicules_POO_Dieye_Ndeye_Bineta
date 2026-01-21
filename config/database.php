<?php 

class Database{
    private $host = "localhost";
    private $database = "location_vehicule";
    private $username = "root";
    private $password = "";
    private $con = null;

    public function getConnexion(){
        if($this->con === null){
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            $this->con = new PDO($dsn, $this->username, $this->password, $options);
        }
        return $this->con;
    }

}