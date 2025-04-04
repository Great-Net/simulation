<?php
include $_SERVER['DOCUMENT_ROOT'] . "/simulation/include/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST["titre"]);
    $description = htmlspecialchars($_POST["description"]);
    $entreprise = htmlspecialchars($_POST["entreprise"]);
    $localisation = htmlspecialchars($_POST["localisation"]);
    $disponible = isset($_POST["disponible"]) ? 1 : 0;

    // Gérer l’upload de l’image
    $image_path = null;
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/simulation/uploads/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = "uploads/" . $image_name;
        }
    }

    // Insertion dans la base de données
    $sql = "INSERT INTO offres_emploi (titre, description, entreprise, localisation, image, disponible) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $titre, $description, $entreprise, $localisation, $image_path, $disponible);

    if ($stmt->execute()) {
        echo "Offre ajoutée avec succès !";
    } else {
        echo "Erreur lors de l'ajout de l'offre.";
    }

    $stmt->close();
    $conn->close();
}
?>
