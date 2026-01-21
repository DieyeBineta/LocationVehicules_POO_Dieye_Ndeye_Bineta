<?php 
session_start();

require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/vehicule.php';

$db = new Database();
$conn = $db->getConnexion();

$vehicule = new Vehicule;

$id = intval($_GET['id']);

if(isset($_SESSION['client_id'])){
    $client_id = $_SESSION['client_id'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['email'];
    
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $sql = "INSERT INTO rental_requests(vehicule_id, client_id, date_debut, date_fin)
        VALUES (:vehicule_id, :client_id, :date_deb, :date_fin)";
        $req = $conn->prepare($sql);
        $req->bindParam(':vehicule_id', $id);
        $req->bindParam(':client_id', $client_id);
        $req->bindParam(':date_deb', $date_debut);
        $req->bindParam(':date_fin', $date_fin);
        $req->execute();

        // header("Location: index.php");
        echo "
        <script>
            alert('Votre demande de location a été envoyée avec succés !');
            window.location.href('index.php');
        </script>
        ";
    }
} else {
    header("Location: ../Login/connexion.php");
}







$veh = $vehicule->find($id);
$image_data = $veh['image_data'];
$image_base64 = base64_encode($image_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
 

    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/profil.css">
    <link rel="stylesheet" href="../CSS/demande.css">
    <link rel="stylesheet" href="../CSS/footer.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                    <div class="logo">
                        <a href="index.php"><img src="../images/footerlogo-removebg-preview.png" alt=""></a>
                    </div>
    
                    <ul class="menu">
                        <li><a href="index.php">Acceuil</a></li>
                        <li><a href="vehicule.php">Véhicules</a></li>
                        <li><a href="">À propos</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>

                    <?php if (isset($_SESSION['client_id'])){ ?>
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
                                        <p><?php echo $prenom." ".$nom?></p>
                                        <span><?php echo $email ?></span>
                                    </div>
                                </div>
                                <span class="arrow-down" id="userBtn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 9.00005C18 9.00005 13.5811 15 12 15C10.4188 15 6 9 6 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M18 9.00005C18 9.00005 13.5811 15 12 15C10.4188 15 6 9 6 9" stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M18 9.00005C18 9.00005 13.5811 15 12 15C10.4188 15 6 9 6 9" stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>

                            <ul class="dropdown-menu" id="dropdownMenu">
                                <li><a href="../Client/profil.php">Mon Profil</a></li>
                                <li><a href="../Client/cl_loc.php">Mes locations</a></li>
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
                    <?php } else{ ?>
                        <a href="../Login/connexion.php" class="btn-primary">Se connecter </a>
                    <?php } ?>
                <!-- </div> -->
            </div>
        </div>
    </header>

    <main class="main" style="background-color: var(--bg-light); padding: 120px 0px 50px 0px">
        <div class="details_veh">
            <div class="container">
                <div class="details_content">
                    <div class="title">
                        <a href="index.php">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 6C15 6 9.00001 10.4189 9 12C8.99999 13.5812 15 18 15 18" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 6C15 6 9.00001 10.4189 9 12C8.99999 13.5812 15 18 15 18" stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 6C15 6 9.00001 10.4189 9 12C8.99999 13.5812 15 18 15 18" stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>

                        <h3><?php echo $veh["modele"]?> - <?php echo $veh["type"] ?></h3>
                    </div>

                    <div class="present-auto">
                        <div class="img-auto">
                            <img src="data:image/jpeg;base64,<?php echo $image_base64 ?>" alt="">

                            <div class="price">
                                <p><?php echo $veh["description"] ?></p>
                                <div class="desc">
                                    <p>FCFA <?php echo $veh["prix_jour"] ?></p>
                                    <span>Par jour</span>
                                </div>
                            </div>
                        </div>

                        <form action="" method="post">
                            <div class="datedeprise">
                                <h4>Votre trajet</h4>
                                <div class="nom">
                                    <div class="form-group">
                                        <label for="dp">Date de prise</label>
                                        <input type="date" id="dp" name="date_debut" placeholder=" " required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dr">Date de retour</label>
                                        <input type="date" id="dr" name="date_fin" required>
                                    </div>
                                </div>
                            </div>

                            <div class="total">
                                <h4>Details trafic</h4>

                                <div class="facture">
                                    <span>Location par jour</span>
                                    <span>FCFA <?php echo $veh["prix_jour"] ?></span>
                                    <input type="hidden" id="prix_jour" value="<?php echo $veh["prix_jour"] ?>">
                                </div>
                                <div class="facture">
                                    <span>Nombre de jour</span>
                                    <span id="jours">-</span>
                                </div>
                                <div class="facture">
                                    <span>Total</span>
                                    <span  style="font-weight: 600; color:var(--accent);">FCFA <span id="total" style="font-weight: 600; color:var(--accent);">-</span></span>
                                </div>

                                <button type="submit" class="button">Reserver maintenant</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <a href="index.php"><img src="../images/footerlogo-removebg-preview.png" alt=""></a>

                    <div class="newsletter">
                        <p>Inscrivez-vous à notre newsletter</p>
                        <form action="">
                            <input type="text" placeholder="Votre email">
                            <button type="submit">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 11.9998L4 11.9998" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20 11.9998L4 11.9998" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20 11.9998L4 11.9998" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15 17C15 17 20 13.3176 20 12C20 10.6824 15 7 15 7" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15 17C15 17 20 13.3176 20 12C20 10.6824 15 7 15 7" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15 17C15 17 20 13.3176 20 12C20 10.6824 15 7 15 7" stroke="black" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="foot-menu">
                    <h4>Liens rapides</h4>
                    <ul class="lienrap">
                        <li><a href="index.php">Acceuil</a></li>
                        <li><a href="vehicule.php">Vehicules</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="../Login/connexion.php">Se connecter</a></li>
                    </ul>
                </div>

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d38889.783923308445!2d-17.332227630546665!3d14.748992975571099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xec10b001f2d33db%3A0x8ea45b926146ab6e!2sZac%20Mbao%20Cit%C3%A9%20assurance!5e0!3m2!1sfr!2ssn!4v1767272532441!5m2!1sfr!2ssn" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div> 
        </div>

        <div class="container">
            <div class="droits">
                <p>&copy;2026 Tous droits réservés</p>

                <ul>
                    <li><a href="">Privacy</a></li>
                    <li><a href="">Terms</a></li>
                    <li><a href="">Legal notice</a></li>
                </ul>

                <ul>
                    <li>
                        <a href="">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.18182 10.3333C5.20406 10.3333 5 10.5252 5 11.4444V13.1111C5 14.0304 5.20406 14.2222 6.18182 14.2222H8.54545V20.8889C8.54545 21.8081 8.74951 22 9.72727 22H12.0909C13.0687 22 13.2727 21.8081 13.2727 20.8889V14.2222H15.9267C16.6683 14.2222 16.8594 14.0867 17.0631 13.4164L17.5696 11.7497C17.9185 10.6014 17.7035 10.3333 16.4332 10.3333H13.2727V7.55556C13.2727 6.94191 13.8018 6.44444 14.4545 6.44444H17.8182C18.7959 6.44444 19 6.25259 19 5.33333V3.11111C19 2.19185 18.7959 2 17.8182 2H14.4545C11.191 2 8.54545 4.48731 8.54545 7.55556V10.3333H6.18182Z" stroke="#6F6F6F" stroke-width="1.5" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.18182 10.3333C5.20406 10.3333 5 10.5252 5 11.4444V13.1111C5 14.0304 5.20406 14.2222 6.18182 14.2222H8.54545V20.8889C8.54545 21.8081 8.74951 22 9.72727 22H12.0909C13.0687 22 13.2727 21.8081 13.2727 20.8889V14.2222H15.9267C16.6683 14.2222 16.8594 14.0867 17.0631 13.4164L17.5696 11.7497C17.9185 10.6014 17.7035 10.3333 16.4332 10.3333H13.2727V7.55556C13.2727 6.94191 13.8018 6.44444 14.4545 6.44444H17.8182C18.7959 6.44444 19 6.25259 19 5.33333V3.11111C19 2.19185 18.7959 2 17.8182 2H14.4545C11.191 2 8.54545 4.48731 8.54545 7.55556V10.3333H6.18182Z" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.18182 10.3333C5.20406 10.3333 5 10.5252 5 11.4444V13.1111C5 14.0304 5.20406 14.2222 6.18182 14.2222H8.54545V20.8889C8.54545 21.8081 8.74951 22 9.72727 22H12.0909C13.0687 22 13.2727 21.8081 13.2727 20.8889V14.2222H15.9267C16.6683 14.2222 16.8594 14.0867 17.0631 13.4164L17.5696 11.7497C17.9185 10.6014 17.7035 10.3333 16.4332 10.3333H13.2727V7.55556C13.2727 6.94191 13.8018 6.44444 14.4545 6.44444H17.8182C18.7959 6.44444 19 6.25259 19 5.33333V3.11111C19 2.19185 18.7959 2 17.8182 2H14.4545C11.191 2 8.54545 4.48731 8.54545 7.55556V10.3333H6.18182Z" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 18.5C3.76504 19.521 5.81428 20 8 20C14.4808 20 19.7617 14.8625 19.9922 8.43797L22 4.5L18.6458 5C17.9407 4.37764 17.0144 4 16 4C13.4276 4 11.5007 6.51734 12.1209 8.98003C8.56784 9.20927 5.34867 7.0213 3.48693 4.10523C2.25147 8.30185 3.39629 13.3561 6.5 16.4705C6.5 17.647 3.5 18.3488 2 18.5Z" stroke="#6F6F6F" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M2 18.5C3.76504 19.521 5.81428 20 8 20C14.4808 20 19.7617 14.8625 19.9922 8.43797L22 4.5L18.6458 5C17.9407 4.37764 17.0144 4 16 4C13.4276 4 11.5007 6.51734 12.1209 8.98003C8.56784 9.20927 5.34867 7.0213 3.48693 4.10523C2.25147 8.30185 3.39629 13.3561 6.5 16.4705C6.5 17.647 3.5 18.3488 2 18.5Z" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M2 18.5C3.76504 19.521 5.81428 20 8 20C14.4808 20 19.7617 14.8625 19.9922 8.43797L22 4.5L18.6458 5C17.9407 4.37764 17.0144 4 16 4C13.4276 4 11.5007 6.51734 12.1209 8.98003C8.56784 9.20927 5.34867 7.0213 3.48693 4.10523C2.25147 8.30185 3.39629 13.3561 6.5 16.4705C6.5 17.647 3.5 18.3488 2 18.5Z" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#6F6F6F" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M16.5 12C16.5 14.4853 14.4853 16.5 12 16.5C9.51472 16.5 7.5 14.4853 7.5 12C7.5 9.51472 9.51472 7.5 12 7.5C14.4853 7.5 16.5 9.51472 16.5 12Z" stroke="#6F6F6F" stroke-width="1.5"/>
                                <path d="M16.5 12C16.5 14.4853 14.4853 16.5 12 16.5C9.51472 16.5 7.5 14.4853 7.5 12C7.5 9.51472 9.51472 7.5 12 7.5C14.4853 7.5 16.5 9.51472 16.5 12Z" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5"/>
                                <path d="M16.5 12C16.5 14.4853 14.4853 16.5 12 16.5C9.51472 16.5 7.5 14.4853 7.5 12C7.5 9.51472 9.51472 7.5 12 7.5C14.4853 7.5 16.5 9.51472 16.5 12Z" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="1.5"/>
                                <path d="M17.5078 6.5L17.4988 6.5" stroke="#6F6F6F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.5078 6.5L17.4988 6.5" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.5078 6.5L17.4988 6.5" stroke="#6F6F6F" stroke-opacity="0.2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>


    <script>
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.addEventListener('change', () => {
                const debut = document.querySelector('[name="date_debut"]').value;
                const fin   = document.querySelector('[name="date_fin"]').value;
                const prix = parseInt(document.getElementById('prix_jour').value);
                const total = document.getElementById('total'); 

                if (debut && fin) {
                    const d1 = new Date(debut);
                    const d2 = new Date(fin);

                    const diff = Math.floor((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;

                    if(diff > 0){
                        document.getElementById('jours').innerText = diff;
                        total.textContent = (prix * diff)
                    } else {
                        document.getElementById('jours').innerText = 'Date invalide';
                        total.textContent = '-'
                        
                    }

                    // const total = diff * prix;
                    // document.getElementById('prix_jour').innerText = total;
                }
            });
        });
</script>

<script src="../JS/dropdown.js"></script>


</body>
</html>