<?php
include $_SERVER['DOCUMENT_ROOT'] . "/simulation/include/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Récupérer les offres depuis la base de données
$sql = "SELECT id, titre, description, entreprise, localisation, image, disponible, date_publication FROM offres_emploi ORDER BY date_publication DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Offres d'Emploi</title>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="/simulation/assets/css/style.css">
    <link rel="stylesheet" href="/simulation/assets/css/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,900,900i" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Lien vers le JS de AOS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialiser AOS
    AOS.init();
</script>

<!-- NAVBAR SECTION A AJOUTER -->

<div class="container">
    <h2 style="text-align:center; color: #1A76D1;">Liste des Offres d'Emploi</h2><br>

    <hr style="border: 1px solid #1A76D1; width: 15%; margin: 0 auto;">
<br><br>


    <div class="offres-grid" >

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
        <div class="offre w3-card-4" data-aos="zoom-out" data-aos-duration="500" data-aos-delay="100">
            <?php if (!empty($row["image"])) { ?>
                <img src="/simulation/<?php echo $row["image"]; ?>" alt="Image de l'offre">
            <?php } else { ?>
                <img src="/simulation/uploads/default.png" alt="Image par défaut">
            <?php } ?>
            
            <div class="details">
                <h3><?php echo htmlspecialchars($row["titre"]); ?></h3>
                <p> <?php echo htmlspecialchars($row["description"]); ?></p>
                <p><i class="fas fa-building"></i> <strong>Entreprise :</strong> <?php echo htmlspecialchars($row["entreprise"]); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>Localisation :</strong> <?php echo htmlspecialchars($row["localisation"]); ?></p>
                <p><i class="fas fa-calendar-day"></i> <strong>Publié le :</strong> <?php echo $row["date_publication"]; ?></p>
                <p class="<?php echo $row["disponible"] ? 'disponible' : 'indisponible'; ?>">
                    <i class="fas fa-check-circle"></i> <?php echo $row["disponible"] ? 'Disponible' : 'Indisponible'; ?>
                </p>
                <!-- Bouton Voir sur la carte -->
                <a href="map.php?location=<?php echo urlencode($row['localisation']); ?>" class="btn btn-primary">
                    <i class="fas fa-map-marker-alt" style="color:white"></i>sur carte
                </a>
            </div>
        </div>

                <?php
            }
        } else {
            echo "<p>Aucune offre d'emploi disponible pour le moment.</p>";
        }

        $conn->close();
        ?>

    </div>
</div>



<footer>
    <!-- FOOTER SECTION A AJOUTER -->
</footer>
</body>
</html>
