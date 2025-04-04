<?php
$location = isset($_GET['location']) ? $_GET['location'] : 'Paris'; // Valeur par défaut : Paris
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte - <?php echo htmlspecialchars($location); ?></title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map {
            height: 400px; /* Réduit la taille de la carte */
            width: 100%;
        }
        .container {
            margin: 20px;
        }
        .input-container {
            margin-bottom: 10px;
        }
        .result {
            margin-top: 20px;
            color: #333;
        }

        .input-container {
    position: relative;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255, 255, 255, 0.9);
    padding: 10px 15px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 1000;
}

.input-container label {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

.input-container input {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    flex-grow: 1;
    outline: none;
}

.input-container button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.input-container button:hover {
    background-color: #0056b3;
}

/* Responsive : Ajustement pour petits écrans */
@media (max-width: 600px) {
    .input-container {
        width: 90%;
        flex-direction: column;
        align-items: stretch;
    }

    .input-container input {
        width: 100%;
    }

    .input-container button {
        width: 100%;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center; color: #1A76D1;">Carte de la Localisation : <?php echo htmlspecialchars($location); ?></h2>
    
    <!-- Champ de saisie pour entrer une nouvelle localisation -->
    <div class="input-container">
        <label for="userLocation">Entrez votre localisation :</label>
        <input type="text" id="userLocation" placeholder="Ex : Analakely" />
        <button onclick="geocodeUserLocation()">Voir sur la carte</button>
    </div>
    
    <!-- Zone pour afficher la distance calculée -->
    <div class="result" id="distanceResult"></div>
    
    <div id="map"></div>
</div>

<script>
    // Initialiser la carte
    var map = L.map('map').setView([48.8566, 2.3522], 13); // Coordonnées par défaut (Paris)

    // Ajouter une couche de tuiles (cartes)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Fonction pour géocoder la localisation et obtenir les coordonnées
    function geocodeLocation(location, callback) {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${location}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    var lat = data[0].lat;
                    var lon = data[0].lon;
                    callback(lat, lon);
                } else {
                    alert("Localisation introuvable !");
                }
            });
    }

    // Fonction pour ajouter un marqueur et ajuster la vue
    function addMarker(lat, lon, location) {
        map.setView([lat, lon], 13); // Ajuster la vue de la carte sur la localisation
        L.marker([lat, lon]).addTo(map).bindPopup(location).openPopup();
    }

    // Appeler la fonction de géocodage pour la localisation initiale
    geocodeLocation('<?php echo $location; ?>', (lat, lon) => {
        addMarker(lat, lon, '<?php echo $location; ?>');
    });

    // Fonction pour géocoder la localisation de l'utilisateur
    function geocodeUserLocation() {
        var userLocation = document.getElementById("userLocation").value;
        if (userLocation) {
            geocodeLocation(userLocation, (userLat, userLon) => {
                addMarker(userLat, userLon, userLocation);
                calculateDistance(userLat, userLon); // Calculer la distance
            });
        } else {
            alert("Veuillez entrer une localisation !");
        }
    }

    // Calcul de la distance entre la localisation initiale et la localisation de l'utilisateur
    function calculateDistance(userLat, userLon) {
        // Coordonnées de la localisation initiale (Paris par défaut)
        var initialLat = 48.8566;
        var initialLon = 2.3522;
        
        // Calculer la distance
        var initialLocation = L.latLng(initialLat, initialLon);
        var userLocation = L.latLng(userLat, userLon);
        var distance = initialLocation.distanceTo(userLocation); // Distance en mètres

        // Afficher la distance
        var result = document.getElementById("distanceResult");
        result.textContent = `La distance entre la localisation initiale et votre localisation est de ${Math.round(distance)} mètres.`;
    }
</script>

</body>
</html>
