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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,900,900i" rel="stylesheet">  
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        .offres-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 colonnes fixes */
            gap: 15px;
        }
        .offre {
            border-radius: 8px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
        }
        .offre img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .details {
            margin-top: 10px;
        }
        .details h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .details p {
            font-size: 14px;
            margin: 5px 0;
        }
        .disponible {
            color: green;
            font-weight: bold;
        }
        .indisponible {
            color: red;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .offres-grid { grid-template-columns: repeat(3, 1fr); } /* 3 colonnes sur tablette */
        }
        @media (max-width: 768px) {
            .offres-grid { grid-template-columns: repeat(2, 1fr); } /* 2 colonnes sur mobile */
        }
        @media (max-width: 480px) {
            .offres-grid { grid-template-columns: repeat(1, 1fr); } /* 1 colonne sur petits écrans */
        }
    </style>
</head>
<body>

<!-- Lien vers le JS de AOS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialiser AOS
    AOS.init();
</script>

<div class="container">
    <h2 style="text-align:center">Liste des Offres d'Emploi</h2><br><br>
    <div class="offres-grid" >

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="offre" data-aos="zoom-out" data-aos-duration="500" data-aos-delay="100">
                    <?php if (!empty($row["image"])) { ?>
                        <img src="/simulation/<?php echo $row["image"]; ?>" alt="Image de l'offre">
                    <?php } else { ?>
                        <img src="/simulation/uploads/default.png" alt="Image par défaut">
                    <?php } ?>
                    
                    <div class="details">
                        <h3><?php echo htmlspecialchars($row["titre"]); ?></h3>
                        <p><strong>Entreprise :</strong> <?php echo htmlspecialchars($row["entreprise"]); ?></p>
                        <p><strong>Localisation :</strong> <?php echo htmlspecialchars($row["localisation"]); ?></p>
                        <p><strong>Publié le :</strong> <?php echo $row["date_publication"]; ?></p>
                        <p class="<?php echo $row["disponible"] ? 'disponible' : 'indisponible'; ?>">
                            <?php echo $row["disponible"] ? 'Disponible' : 'Indisponible'; ?>
                        </p>
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

</body>
</html>
