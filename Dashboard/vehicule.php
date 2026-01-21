<?php
session_start();

require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/vehicule.php';

$db = new Database;
$conn = $db->getConnexion();
$vehicule = new Vehicule;

if(isset($_SESSION['user_id'])){
    $client_id = $_SESSION['user_id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['email'];
}
if(isset($_POST["refresh"]) && !empty($_POST["search"])){
    $search = $_POST["search"];
    $sql = "SELECT * FROM vehicules WHERE type LIKE '%$search%' OR marque LIKE '%$search%' OR modele LIKE '%$search%' ";
    $vehicules = $conn->query($sql)->fetchAll();
} else{
    $vehicules = $vehicule->getAll();
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

    <link rel="stylesheet" href="../CSS/dashboard.css">
    <link rel="stylesheet" href="../CSS/dashVeh.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/profil.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    <link rel="stylesheet" href="../CSS/footerfixed.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="../Site/index.php"><img src="../images/logo.png" alt=""></a>
                </div>

                <ul class="menu">
                    <li><a href="admin.php">Dashboard</a></li>
                    <li><a href="vehicule.php">Véhicules</a></li>
                    <li><a href="location.php">Locations</a></li>
                    <li><a href="client.php">Client</a></li>
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
                            <li><a href="profil.php">Mon Profil</a></li>
                            <!-- <li><a href="#">Mes locations</a></li> -->
                            <hr>
                            <li>
                                <a href="../deconnexion.php" class="logout" style="display: flex; align-items: center; gap: 8px;">
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

    <main class="main">
        <div class="recheche">
            <div class="container">
                <div class="recherche-content">
                    <form action="" method="post">
                        <input type="text" name="search" placeholder="Rechercher un article">
                        <button class="search" type="submit" name="refresh" >Rechercher</button>
                    </form>
                    <a href="FORM_VEH/ajoutvehicule.php">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4V20" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 12H20" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Ajouter un vehicule</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="cars">
            <div class="container">
                <div class="cars-content">
                    <?php 
                    foreach($vehicules as $veh){ 
                        $image_data = $veh['image_data'];
                        $image_base64 = base64_encode($image_data);
                    ?>
                    <div class="car-grid">
                        <div class="car-desc">
                            <div class="present">
                                <h4><?php echo $veh["modele"]." - ".$veh["type"] ?></h4>
    
                                <div class="description">
                                    <div>
                                        <img src="../images/meter.png" alt="">
                                        <span><?php echo $veh["marque"] ?></span>
                                    </div>
                                    <div>
                                        <img src="../images/people.png" alt="">
                                        <span><?php echo $veh["immatriculation"] ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="actions">
                                <a href="FORM_VEH/modifier.php?id=<?php echo $veh['id'] ?>">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.0737 3.88545C14.8189 3.07808 15.1915 2.6744 15.5874 2.43893C16.5427 1.87076 17.7191 1.85309 18.6904 2.39232C19.0929 2.6158 19.4769 3.00812 20.245 3.79276C21.0131 4.5774 21.3972 4.96972 21.6159 5.38093C22.1438 6.37312 22.1265 7.57479 21.5703 8.5507C21.3398 8.95516 20.9446 9.33578 20.1543 10.097L10.7506 19.1543C9.25288 20.5969 8.504 21.3182 7.56806 21.6837C6.63212 22.0493 5.6032 22.0224 3.54536 21.9686L3.26538 21.9613C2.63891 21.9449 2.32567 21.9367 2.14359 21.73C1.9615 21.5234 1.98636 21.2043 2.03608 20.5662L2.06308 20.2197C2.20301 18.4235 2.27297 17.5255 2.62371 16.7182C2.97444 15.9109 3.57944 15.2555 4.78943 13.9445L14.0737 3.88545Z" stroke="#141B34" stroke-width="1.5" stroke-linejoin="round"/>
                                        <path d="M14.0737 3.88545C14.8189 3.07808 15.1915 2.6744 15.5874 2.43893C16.5427 1.87076 17.7191 1.85309 18.6904 2.39232C19.0929 2.6158 19.4769 3.00812 20.245 3.79276C21.0131 4.5774 21.3972 4.96972 21.6159 5.38093C22.1438 6.37312 22.1265 7.57479 21.5703 8.5507C21.3398 8.95516 20.9446 9.33578 20.1543 10.097L10.7506 19.1543C9.25288 20.5969 8.504 21.3182 7.56806 21.6837C6.63212 22.0493 5.6032 22.0224 3.54536 21.9686L3.26538 21.9613C2.63891 21.9449 2.32567 21.9367 2.14359 21.73C1.9615 21.5234 1.98636 21.2043 2.03608 20.5662L2.06308 20.2197C2.20301 18.4235 2.27297 17.5255 2.62371 16.7182C2.97444 15.9109 3.57944 15.2555 4.78943 13.9445L14.0737 3.88545Z" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                                        <path d="M14.0737 3.88545C14.8189 3.07808 15.1915 2.6744 15.5874 2.43893C16.5427 1.87076 17.7191 1.85309 18.6904 2.39232C19.0929 2.6158 19.4769 3.00812 20.245 3.79276C21.0131 4.5774 21.3972 4.96972 21.6159 5.38093C22.1438 6.37312 22.1265 7.57479 21.5703 8.5507C21.3398 8.95516 20.9446 9.33578 20.1543 10.097L10.7506 19.1543C9.25288 20.5969 8.504 21.3182 7.56806 21.6837C6.63212 22.0493 5.6032 22.0224 3.54536 21.9686L3.26538 21.9613C2.63891 21.9449 2.32567 21.9367 2.14359 21.73C1.9615 21.5234 1.98636 21.2043 2.03608 20.5662L2.06308 20.2197C2.20301 18.4235 2.27297 17.5255 2.62371 16.7182C2.97444 15.9109 3.57944 15.2555 4.78943 13.9445L14.0737 3.88545Z" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                                        <path d="M13 4L20 11" stroke="#141B34" stroke-width="1.5" stroke-linejoin="round"/>
                                        <path d="M13 4L20 11" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                                        <path d="M13 4L20 11" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                                        <path d="M14 22L22 22" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 22L22 22" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 22L22 22" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                                <a href="FORM_VEH/supprimer.php?id=<?php echo $veh['id'] ?>" onclick="return(confirm('Voulez-vous vraiment supprimer ce vehicule ?'))">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9.5 16.5L9.5 10.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9.5 16.5L9.5 10.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9.5 16.5L9.5 10.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14.5 16.5L14.5 10.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14.5 16.5L14.5 10.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14.5 16.5L14.5 10.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <img src="data:image/jpeg;base64,<?php echo $image_base64 ?>" alt="">

                        <div class="price">
                            <p>FCFA <?php echo $veh["prix_jour"] ?></p>
                            <span>Par jour</span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
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

    <script src="../JS/dropdown.js"></script>
</body>
</html>