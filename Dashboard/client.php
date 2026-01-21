<?php
session_start();

require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/client.php';

$db = new Database;
$conn = $db->getConnexion();
$client = new Client();

if(isset($_SESSION['user_id'])){
    $client_id = $_SESSION['user_id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['email'];
}
if(isset($_POST["refresh"]) && !empty($_POST["search"])){
    $search = $_POST["search"];
    $sql = "SELECT * FROM clients
    WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%' ";
    $clients = $conn->query($sql)->fetchAll();
} else{
    $clients = $client->getAll();
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

    <style>
        .med-grid{
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            width: 100%;
            box-sizing: border-box;
            margin-top: 30px;
            gap: 10px;
        }

        .item{
            background-color: white;
            border-radius: 10px;
            padding: 20px 30px;
            position: relative;
        }

        .item:hover{
            box-shadow: 0px 2px 5px #0000002a;
        }

        .icon{
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--text-main);
            width: 50px;
            height: 50px;
            border-radius: 50px;
        }

        .equipe-contact-item{
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .equipe-contact{
            display: flex;
            flex-direction: column;
            margin-bottom: 30px; 
            gap: 10px;
        }

        .supp{
            border: 1px solid var(--text-muted);
            border-radius: 20px;
            padding: 10px ;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .presentation > span{
            position: absolute;
            bottom: 20px;
            right: 20px;
            color: var(--text-muted);
        }

        .presentation h4{
            color: var(--accent);
        } 
    </style>
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
                        <input type="text" name="search" placeholder="Rechercher un client">
                        <button class="search" type="submit" name="refresh" >Rechercher</button>
                    </form>
                    <a href="FORM_CL/ajout.php">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4V20" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 12H20" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Ajouter un client</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="demande">
            <div class="container">
                <div class="demande-content">
                    <div class="med-grid">
                        <?php if (empty($clients)) { ?>
                                <p>Aucun client trouvé</p>
                        <?php } else { ?>
                        <?php foreach ($clients as $client) { ?> 
                        <div class="item">
                            <div class="icon">
                                <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.8663 17.25H18.3565C19.5064 17.25 20.421 16.7261 21.2421 15.9936C23.3283 14.1326 18.4244 12.25 16.7502 12.25M14.7502 2.31877C14.9773 2.27373 15.2131 2.25 15.455 2.25C17.2749 2.25 18.7502 3.59315 18.7502 5.25C18.7502 6.90685 17.2749 8.25 15.455 8.25C15.2131 8.25 14.9773 8.22627 14.7502 8.18123" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M3.73156 13.3612C2.55258 13.993 -0.538619 15.2831 1.34413 16.8974C2.26384 17.686 3.28815 18.25 4.57597 18.25H11.9245C13.2123 18.25 14.2367 17.686 15.1564 16.8974C17.0391 15.2831 13.9479 13.993 12.7689 13.3612C10.0043 11.8796 6.49623 11.8796 3.73156 13.3612Z" stroke="white" stroke-width="1.5"/>
                                    <path d="M12.2502 4.75C12.2502 6.95914 10.4594 8.75 8.25024 8.75C6.04111 8.75 4.25024 6.95914 4.25024 4.75C4.25024 2.54086 6.04111 0.75 8.25024 0.75C10.4594 0.75 12.2502 2.54086 12.2502 4.75Z" stroke="white" stroke-width="1.5"/>
                                </svg>
                            </div>
            
                            <div class="presentation">
                                <h4><?php echo $client['nom']." ".$client['prenom'] ?></h4>
                                <div class="equipe-contact">
                                    <div class="equipe-contact-item">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.77762 11.9424C2.8296 10.2893 2.37185 8.93948 2.09584 7.57121C1.68762 5.54758 2.62181 3.57081 4.16938 2.30947C4.82345 1.77638 5.57323 1.95852 5.96 2.6524L6.83318 4.21891C7.52529 5.46057 7.87134 6.08139 7.8027 6.73959C7.73407 7.39779 7.26737 7.93386 6.33397 9.00601L3.77762 11.9424ZM3.77762 11.9424C5.69651 15.2883 8.70784 18.3013 12.0576 20.2224M12.0576 20.2224C13.7107 21.1704 15.0605 21.6282 16.4288 21.9042C18.4524 22.3124 20.4292 21.3782 21.6905 19.8306C22.2236 19.1766 22.0415 18.4268 21.3476 18.04L19.7811 17.1668C18.5394 16.4747 17.9186 16.1287 17.2604 16.1973C16.6022 16.2659 16.0661 16.7326 14.994 17.666L12.0576 20.2224Z" stroke="#6F6F6F" stroke-width="1.5" stroke-linejoin="round"/>
                                        </svg>
                                        <span><?php echo $client['telephone'] ?></span>
                                    </div>
            
                                    <div class="equipe-contact-item">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2 6L8.91302 9.91697C11.4616 11.361 12.5384 11.361 15.087 9.91697L22 6" stroke="#6F6F6F" stroke-width="1.5" stroke-linejoin="round"/>
                                            <path d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z" stroke="#6F6F6F" stroke-width="1.5" stroke-linejoin="round"/>
                                        </svg>
                                        <span><?php echo $client['email'] ?></span>
                                    </div>
            
                                    <div class="equipe-contact-item">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 18C5.17107 18.4117 4 19.0443 4 19.7537C4 20.9943 7.58172 22 12 22C16.4183 22 20 20.9943 20 19.7537C20 19.0443 18.8289 18.4117 17 18" stroke="#6F6F6F" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M14.5 9C14.5 10.3807 13.3807 11.5 12 11.5C10.6193 11.5 9.5 10.3807 9.5 9C9.5 7.61929 10.6193 6.5 12 6.5C13.3807 6.5 14.5 7.61929 14.5 9Z" stroke="#6F6F6F" stroke-width="1.5"/>
                                            <path d="M13.2574 17.4936C12.9201 17.8184 12.4693 18 12.0002 18C11.531 18 11.0802 17.8184 10.7429 17.4936C7.6543 14.5008 3.51519 11.1575 5.53371 6.30373C6.6251 3.67932 9.24494 2 12.0002 2C14.7554 2 17.3752 3.67933 18.4666 6.30373C20.4826 11.1514 16.3536 14.5111 13.2574 17.4936Z" stroke="#6F6F6F" stroke-width="1.5"/>
                                        </svg>
                                        <span><?php echo $client['adresse'] ?></span>
                                    </div>
                                </div>
            
                                <a href="FORM_CL/supprimer.php?id=<?php echo $client['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet element ?')" class="supp">
                                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5" stroke="#6F6F6F" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M19.5 5.5L18.8803 15.5251C18.7219 18.0864 18.6428 19.3671 18.0008 20.2879C17.6833 20.7431 17.2747 21.1273 16.8007 21.416C15.8421 22 14.559 22 11.9927 22C9.42312 22 8.1383 22 7.17905 21.4149C6.7048 21.1257 6.296 20.7408 5.97868 20.2848C5.33688 19.3626 5.25945 18.0801 5.10461 15.5152L4.5 5.5" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5" stroke="#6F6F6F" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 5.5H21M16.0557 5.5L15.3731 4.09173C14.9196 3.15626 14.6928 2.68852 14.3017 2.39681C14.215 2.3321 14.1231 2.27454 14.027 2.2247C13.5939 2 13.0741 2 12.0345 2C10.9688 2 10.436 2 9.99568 2.23412C9.8981 2.28601 9.80498 2.3459 9.71729 2.41317C9.32164 2.7167 9.10063 3.20155 8.65861 4.17126L8.05292 5.5" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9.5 16.5L9.5 10.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9.5 16.5L9.5 10.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9.5 16.5L9.5 10.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14.5 16.5L14.5 10.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14.5 16.5L14.5 10.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M14.5 16.5L14.5 10.5" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </a>
    
                                <span><?php echo $client['created_at'] ?></span>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } ?> 
                    </div>
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