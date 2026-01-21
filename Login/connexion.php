<?php
session_start();

require_once __DIR__.'/../config/database.php';

$db = new Database();
$conn = $db->getConnexion();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $sql = "SELECT * FROM users WHERE email = :email AND mot_de_passe = :mdp";
    $req = $conn->prepare($sql);
    $req->bindParam(':email', $email);
    $req->bindParam(':mdp', $mdp);
    $req->execute();
    $user = $req->fetch(PDO::FETCH_ASSOC);

    $sql1 = "SELECT * FROM clients WHERE email = :email AND mot_de_passe = :mdp";
    $req1 = $conn->prepare($sql1);
    $req1->bindParam(':email', $email);
    $req1->bindParam(':mdp', $mdp);
    $req1->execute();
    $client = $req1->fetch(PDO::FETCH_ASSOC);

    if($user) {
        if($user['email'] === $email && $user['mot_de_passe'] === $mdp) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['email'] = $user['email'];


        header("Location: ../Dashboard/admin.php");
        }
    }

    if($client) {
        if($client['email'] === $email && $client['mot_de_passe'] === $mdp) {
        $_SESSION['client_id'] = $client['id'];
        $_SESSION['nom'] = $client['nom'];
        $_SESSION['prenom'] = $client['prenom'];
        $_SESSION['email'] = $client['email'];


        header("Location: ../Site/index.php");
        }
    }

    $_SESSION['erreur'] = "Mot de passe ou email erroné";
    // header("Location: connexion.php");
    
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
</head>
<body>
    <div class="brand-side">
        <div class="logo-title">ONYX DRIVE</div>
        <div class="logo-subtitle">L'élégance à chaque tournant</div>
    </div>

    <div class="login-side">
        <h2>Connexion</h2>
        <?php
            if(isset($_SESSION['erreur'])){
                echo '<p style="color:red; font-size:13px;">'.$_SESSION['erreur'].'</p>';
                unset($_SESSION['erreur']);
            }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Adresse Email</label>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="mdp" required>
                <label for="password">Mot de passe</label>
                <a href="#" class="forgot-password">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-login">Se connecter</button>
        </form>

        <p class="footer-text">
            Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous</a>
        </p>
    </div>
</body>
</html>