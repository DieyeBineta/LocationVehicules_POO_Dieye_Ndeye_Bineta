<?php
session_start();
require_once __DIR__.'/../../config/database.php';
require_once __DIR__.'/../../models/client.php';

if(isset($_SESSION['user_id'])){
    $client_id = $_SESSION['user_id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['email'];
}

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

    $checkemail = $clientModel->findByEmail($email);

    if($checkemail > 0){
        $_SESSION['erreur'] = "Cet email est invalide, il est déjà utilisé";
    }

    if($mdp !== $cmdp){
        $_SESSION['error'] = "Vérifier le mot de passe";
    } else {
        $clientModel->create($nom, $prenom, $email, $mdp, $tel, $adr);
        header("Location: ../client.php");
    }
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
 
    <title>Contact</title>

    <link rel="stylesheet" href="../../CSS/style.css">
    <link rel="stylesheet" href="../../CSS/dashboard.css">
    <link rel="stylesheet" href="../../CSS/profil.css">
    <link rel="stylesheet" href="../../CSS/contact.css">
    <link rel="stylesheet" href="../../CSS/footer.css">
    <link rel="stylesheet" href="../../CSS/footerfixed.css">

    <style>
        .jumbo-content{
            text-align: center;
        }

        input, textarea{
            background-color: var(--bg-light);
        }

        input[type="file"]::file-selector-button {
            padding: 5px 20px;
            border: none;
            border-radius: 8px;
            background-color: var(--text-main);
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            font-family: "Poppins", sans-serif;
            font-size: 14px;
            margin-right: 10px;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: black;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="../../Site/index.php"><img src="../../images/logo.png" alt=""></a>
                </div>

                <ul class="menu">
                    <li><a href="../admin.php">Dashboard</a></li>
                    <li><a href="../vehicule.php">Véhicules</a></li>
                    <li><a href="../location.php">Locations</a></li>
                    <li><a href="../client.php">Client</a></li>
                </ul>

                <?php if (isset($_SESSION['user_id'])){ ?>
                    <div class="user-menu-container">
                        <div class="user-card">
                            <div class="avatar-container">
                                <div class="prof-img">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 12C10.9 12 9.95833 11.6083 9.175 10.825C8.39167 10.0417 8 9.1 8 8C8 6.9 8.39167 5.95833 9.175 5.175C9.95833 4.39167 10.9 4 12 4C13.1 4 14.0417 4.39167 14.825 5.175C15.6083 5.95833 16 6.9 16 8C16 9.1 15.6083 10.0417 14.825 10.825C14.0417 11.6083 13.1 12 12 12ZM4 20V17.2C4 16.6333 4.14583 16.1125 4.4375 15.6375C4.72917 15.1625 5.11667 14.8 5.6 14.55C6.63333 14.0333 7.68333 13.6458 8.75 13.3875C9.81667 13.1292 10.9 13 12 13C13.1 13 14.1833 13.1292 15.25 13.3875C16.3167 13.6458 17.3667 14.0333 18.4 14.55C18.8833 14.8 19.2708 15.1625 19.5625 15.6375C19.8542 16.1125 20 16.6333 20 17.2V20H4ZM6 18H18V17.2C18 17.0167 17.9542 16.85 17.8625 16.7C17.7708 16.55 17.65 16.4333 17.5 16.35C16.6 15.9 15.6917 15.5625 14.775 15.3375C13.8583 15.1125 12.9333 15 12 15C11.0667 15 10.1417 15.1125 9.225 15.3375C8.30833 15.5625 7.4 15.9 6.5 16.35C6.35 16.4333 6.22917 16.55 6.1375 16.7C6.04583 16.85 6 17.0167 6 17.2V18ZM12 10C12.55 10 13.0208 9.80417 13.4125 9.4125C13.8042 9.02083 14 8.55 14 8C14 7.45 13.8042 6.97917 13.4125 6.5875C13.0208 6.19583 12.55 6 12 6C11.45 6 10.9792 6.19583 10.5875 6.5875C10.1958 6.97917 10 7.45 10 8C10 8.55 10.1958 9.02083 10.5875 9.4125C10.9792 9.80417 11.45 10 12 10Z" fill="white"/>
                                    </svg>
                                </div>
                                
                            </div>
                            <div class="user-info">
                                <div class="prfname">
                                    <p style="color: black;"><?php echo $prenom." ".$nom?></p>
                                    <span style="color: var(--text-muted);">Admin</span>
                                </div>
                            </div>
                            <span class="arrow-down" id="userBtn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 9.00005C18 9.00005 13.5811 15 12 15C10.4188 15 6 9 6 9" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18 9.00005C18 9.00005 13.5811 15 12 15C10.4188 15 6 9 6 9" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18 9.00005C18 9.00005 13.5811 15 12 15C10.4188 15 6 9 6 9" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>

                        <ul class="dropdown-menu" id="dropdownMenu">
                            <li><a href="../profil.php">Mon Profil</a></li>
                            <hr>
                            <li>
                                <a href="../../deconnexion.php" class="logout" style="display: flex; align-items: center; gap: 8px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 3.09502C13.543 3.03241 13.0755 3 12.6 3C7.29807 3 3 7.02944 3 12C3 16.9706 7.29807 21 12.6 21C13.0755 21 13.543 20.9676 14 20.905" stroke="#e74c3c" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14 3.09502C13.543 3.03241 13.0755 3 12.6 3C7.29807 3 3 7.02944 3 12C3 16.9706 7.29807 21 12.6 21C13.0755 21 13.543 20.9676 14 20.905" stroke="#e74c3c" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14 3.09502C13.543 3.03241 13.0755 3 12.6 3C7.29807 3 3 7.02944 3 12C3 16.9706 7.29807 21 12.6 21C13.0755 21 13.543 20.9676 14 20.905" stroke="#e74c3c" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M21 12L11 12M21 12C21 11.2998 19.0057 9.99153 18.5 9.5M21 12C21 12.7002 19.0057 14.0085 18.5 14.5" stroke="#e74c3c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 12L11 12M21 12C21 11.2998 19.0057 9.99153 18.5 9.5M21 12C21 12.7002 19.0057 14.0085 18.5 14.5" stroke="#e74c3c" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 12L11 12M21 12C21 11.2998 19.0057 9.99153 18.5 9.5M21 12C21 12.7002 19.0057 14.0085 18.5 14.5" stroke="#e74c3c" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </header>

    <main class="main" style="margin-top: -40px;">
        <section class="contact">
            <div class="container">
                <div class="contact-content">
                    <h2 style="text-align: center;">Ajouter un client</h2>
                    <div class="form-con">
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
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer" style="margin-top: 50px;">
        <div class="container">
            <div class="droits">
                <p>&copy;2026 Tous droits réservés</p>

                <ul>
                    <li><a href="">Privacy</a></li>
                    <li><a href="">Terms</a></li>
                    <li><a href="">Legal notice</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="../../JS/dropdown.js"></script>
</body>
</html>