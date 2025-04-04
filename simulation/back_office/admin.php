<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout d'une Offre d'Emploi</title>
</head>
<body>
    <h2>Ajouter une Offre d'Emploi</h2>
    <form action="/simulation/action/add_work.php" method="POST" enctype="multipart/form-data">
    <label for="titre">Titre :</label>
    <input type="text" name="titre" required><br>

    <label for="description">Description :</label>
    <textarea name="description" required></textarea><br>

    <label for="entreprise">Entreprise :</label>
    <input type="text" name="entreprise" required><br>

    <label for="localisation">Localisation :</label>
    <input type="text" name="localisation" required><br>

    <label for="image">Image :</label>
    <input type="file" name="image" accept="image/*"><br>

    <label for="disponible">Disponible :</label>
    <input type="checkbox" name="disponible" value="1" checked><br>

    <input type="submit" value="Ajouter">
</form>

</body>
</html>
