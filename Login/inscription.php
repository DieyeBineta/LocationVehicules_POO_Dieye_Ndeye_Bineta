<?php
session_start();
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/client.php';

$db = new Database();
$conn = $db->getConnexion();
$clientModel = new Client();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $cmdp = $_POST['cmdp'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $adr = $_POST['adr'];

    // $sql1 = "SELECT * from users WHERE email = :email";
    // $req1 = $conn->prepare($sql1);
    // $req1->bindparam(':email', $email);
    // $req1->execute();
    $checkemail = $clientModel->findByEmail($email);

    if($checkemail > 0){
        $_SESSION['erreur'] = "Cet email est invalide, il est déjà utilisé";
    }

    if($mdp !== $cmdp){
        $_SESSION['error'] = "Vérifier le mot de passe";
    } else {
        $clientModel->create($nom, $prenom, $email, $mdp, $tel, $adr);
        header("Location: connexion.php");
    }

    // if($req1->rowCount() > 0){
    // }else{
    //     $sql = "INSERT INTO users(nom, prenom, email, mot_de_passe, role) VALUES(:nom, :prenom, :email, :mdp, 'client')";
    //     $req = $conn->prepare($sql);
    //     $req->bindparam(':nom', $nom);
    //     $req->bindparam(':prenom', $prenom);    
    //     $req->bindparam(':email', $email);
    //     $req->bindparam(':mdp', $mdp);
    //     $req->execute();
    //     header("Location: connexion.php");
    // }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
 
    <title>Document</title>

    <link rel="stylesheet" href="../CSS/connexion.css">
    <style>
        .nom{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="brand-side">
        <div class="logo-title">ONYX DRIVE</div>
        <div class="logo-subtitle">L'élégance à chaque tournant</div>
    </div>

    <div class="login-side">
        <h2>Inscription</h2>
        <?php
            if(isset($_SESSION['erreur'])){
                echo '<p style="color:red; font-size:13px;">'.$_SESSION['erreur'].'</p>';
                unset($_SESSION['erreur']);
            }
        ?>
        <form action="" method="post">
            <div class="nom">
                <div class="form-group">
                    <input type="text" id="nom" name="nom" required>
                    <label for="nom">Nom</label>
                </div>
                <div class="form-group">
                    <input type="text" id="prenom" name="prenom" required>
                    <label for="prenom">Prenom</label>
                </div>
            </div>
            <div class="nom">
                <div class="form-group">
                    <input type="text" id="adr" name="adr" required>
                    <label for="adr">Adresse</label>
                </div>
                <div class="form-group">
                    <input type="text" id="tel" name="tel" required>
                    <label for="tel">Telephone</label>
                </div>
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Adresse Email</label>
            </div>

            <div class="nom">
                <div class="form-group">
                    <input type="password" id="password" name="mdp" required>
                    <label for="password">Mot de passe</label>
                </div>

                <div class="form-group">
                    <input type="password" id="cmdp" name="cmdp" required>
                    <label for="cmdp" style="display:flex; justify-content:space-between; align-items:center;">
                        Confirmer le mot de passe
                        <?php
                            if(isset($_SESSION['error'])){
                                echo '<p style="color:red; font-size:8px;">'.$_SESSION['error'].'</p>';
                                unset($_SESSION['error']);
                            }
                        ?>
                    </label>
                </div>

            </div>

            <button type="submit" class="btn-login">S'inscrire</button>
        </form>

        <p class="footer-text">
            Vous avez déjà un compte ? <a href="connexion.html">Connectez-vous</a>
        </p>
    </div>
</body>
</html>