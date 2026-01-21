<?php
session_start();

require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/vehicule.php';
require_once __DIR__.'/../models/client.php';

$db = new Database();
$conn = $db->getConnexion();

$sql = "SELECT * FROM clients";
$req = $conn->query($sql);
$req->fetchAll();
$nbclient = $req->rowCount();

$sql1 = "SELECT * FROM vehicules";
$req1 = $conn->query($sql1);
$req1->fetchAll();
$nbvehicule = $req1->rowCount();

$sql2 = "SELECT * FROM locations";
$req2 = $conn->query($sql2);
$req2->fetchAll();
$nblocation = $req2->rowCount();

$date_du_jour = date('Y-m-d');

if(isset($_SESSION['user_id'])){
    $client_id = $_SESSION['user_id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['email'];
}
$sql = "SELECT rr.id,rr.date_debut,rr.date_fin,rr.statut,rr.created_at, c.nom AS client_nom,
        c.prenom AS client_prenom, v.marque, v.modele, v.immatriculation
        FROM rental_requests rr
        INNER JOIN clients c ON rr.client_id = c.id
        INNER JOIN vehicules v ON rr.vehicule_id = v.id
        WHERE rr.statut = 'en_attente'
        ORDER BY rr.created_at DESC";
$req = $conn->prepare($sql);
$req->execute();
$demandes = $req->fetchAll(PDO::FETCH_ASSOC);

$sql1 = "SELECT l.id, v.statut, marque, modele, nom, prenom, montant_total, date_debut, date_fin 
FROM  locations l
INNER JOIN vehicules v ON l.vehicule_id = v.id
INNER JOIN clients c ON l.client_id = c.id 
WHERE  date_fin >= '$date_du_jour'";

$locations = $conn->query($sql1)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
 
    <title>Dashboard</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/dashboard.css">
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
        <div class="cars">
            <div class="container">
                <div class="preview">
                    <div class="preview-item">
                        <img src="../images/typevoit.png" alt="">
    
                        <div class="prev">
                            <span>Total Vehicules</span>
                            <p><?php  echo $nbvehicule ?></p>
                        </div>
                    </div>
                    <div class="preview-item">
                        <img src="../images/carburant.png" alt="">
    
                        <div class="prev">
                            <span>Total Locations</span>
                            <p><?php echo $nblocation ?></p>
                        </div>
                    </div>
                    <div class="preview-item">
                        <img src="../images/people.png" alt="">
    
                        <div class="prev">
                            <span>Total Clients</span>
                            <p><?php echo $nbclient ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="demande">
            <div class="container">
                <div class="demande-content">
                    <h2>Demandes de location en attente</h2>

                    <table border="1" cellpadding="15" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Véhicule</th>
                                <th>Dates</th>
                                <th>Immatriculation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($demandes)) { ?>
                                <tr>
                                    <td colspan="5">Aucune demande en attente</td>
                                </tr>
                            <?php } else { ?>
                                <?php foreach ($demandes as $demande) { ?> 
                                    <tr>
                                        <td> <?= htmlspecialchars($demande['client_prenom'].' '.$demande['client_nom']) ?> </td>
                                        <td> <?= htmlspecialchars($demande['marque'].' - '.$demande['modele']) ?> </td>
                                        <td> <?= $demande['date_debut'] ?> → <?= $demande['date_fin'] ?> </td>
                                        <td> <?= htmlspecialchars($demande['immatriculation']) ?></td>
                                        <td>
                                            <a href="confirmer.php?id=<?= $demande['id'] ?>">Confirmer</a>
                                            
                                            <a href="refuser.php?id=<?= $demande['id'] ?>">Refuser</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="demande">
            <div class="container">
                <div class="demande-content">
                    <h2>Location en cours</h2>

                    <table border="1" cellpadding="15" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Véhicule</th>
                                <th>Dates</th>
                                <th>Montant</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($locations)) { ?>
                                <tr>
                                    <td colspan="5">Aucune location trouvée</td>
                                </tr>
                            <?php } else { ?>
                                <?php foreach ($locations as $location) { ?> 
                                    <tr>
                                        <td> <?php echo htmlspecialchars($location['prenom'].' '.$location['nom']) ?> </td>
                                        <td> <?php echo htmlspecialchars($location['marque'].' - '.$location['modele']) ?> </td>
                                        <td> <?php echo $location['date_debut'] ?> → <?= $location['date_fin'] ?> </td>
                                        <td> <?php echo $location['montant_total'] ?>FCFA</td>
                                        <td> <a href="rendre.php?id=<?= $location['id'] ?>"> Rendre </a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?> 
                        </tbody>
                    </table>
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