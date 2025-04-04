<?php

$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'simulation_db';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Connexion à la base de données
    $conn = new mysqli($host, $username, $password, $db_name);

    // Optionnel : tu peux supprimer cette ligne pour ne pas afficher ce message en production
} catch (mysqli_sql_exception $e) {
    // Message d'erreur détaillé
    die("Database connection failed: " . $e->getMessage());
}

?>
