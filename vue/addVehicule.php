<?php
// Assurez-vous que ce fichier est inclus dans le contrôleur
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Véhicule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Ajouter un Véhicule</h2>

    <?php
    if(isset($_SESSION['errors'])){
        echo '<div class="alert alert-danger">';
        echo '<ul>';
        foreach($_SESSION['errors'] as $error){
            echo "<li>$error</li>";
        }
        echo '</ul>';
        echo '</div>';
        unset($_SESSION['errors']);
    }
    ?>

    <form action="index.php?action=addVehicule" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="marque">Marque :</label>
            <input type="text" id="marque" name="marque" class="form-control" maxlength="25" required>
        </div>

        <div class="form-group">
            <label for="modele">Modèle :</label>
            <input type="text" id="modele" name="modele" class="form-control" maxlength="25" required>
        </div>

        <div class="form-group">
            <label for="matricule">Matricule :</label>
            <input type="text" id="matricule" name="matricule" class="form-control" maxlength="25" required>
        </div>

        <div class="form-group">
            <label for="prix_journalier">Prix Journalier (€) :</label>
            <input type="number" id="prix_journalier" name="prix_journalier" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="type_vehicule">Type de Véhicule :</label>
            <input type="text" id="type_vehicule" name="type_vehicule" class="form-control" maxlength="25" required>
        </div>

        <div class="form-group">
            <label for="statut_dispo">Statut Disponibilité :</label>
            <select id="statut_dispo" name="statut_dispo" class="form-control" required>
                <option value="1">Disponible</option>
                <option value="0">Indisponible</option>
            </select>
        </div>

        <div class="form-group">
            <label for="photo">Photo :</label>
            <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Enregistrer Véhicule</button>
    </form>

    <p class="mt-3"><a href="index.php?action=gestionVehicule">Retour à la Gestion des Véhicules</a></p>
</body>
</html>
