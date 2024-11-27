<?php
// Assurez-vous que ce fichier est inclus dans le contrôleur
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des Véhicules</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Liste des Véhicules Disponibles</h2>

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

    <h4>Filtrer et Rechercher</h4>
    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="viewVehicules">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" name="marque" class="form-control" placeholder="Marque" value="<?php echo isset($_GET['marque']) ? htmlspecialchars($_GET['marque']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="modele" class="form-control" placeholder="Modèle" value="<?php echo isset($_GET['modele']) ? htmlspecialchars($_GET['modele']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="type_vehicule" class="form-control" placeholder="Type de Véhicule" value="<?php echo isset($_GET['type_vehicule']) ? htmlspecialchars($_GET['type_vehicule']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <select name="statut_dispo" class="form-control">
                    <option value="">Tous</option>
                    <option value="1" <?php echo (isset($_GET['statut_dispo']) && $_GET['statut_dispo'] === '1') ? 'selected' : ''; ?>>Disponible</option>
                    <option value="0" <?php echo (isset($_GET['statut_dispo']) && $_GET['statut_dispo'] === '0') ? 'selected' : ''; ?>>Indisponible</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-secondary">Filtrer</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Matricule</th>
                <th>Prix Journalier (€)</th>
                <th>Type</th>
                <th>Disponibilité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($vehicules)): ?>
                <tr>
                    <td colspan="8" class="text-center">Aucun véhicule trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach($vehicules as $vehicule): ?>
                    <tr>
                        <td>
                            <?php if($vehicule->getPhoto()): ?>
                                <img src="uploads/<?php echo htmlspecialchars($vehicule->getPhoto()); ?>" alt="Photo" width="100">
                            <?php else: ?>
                                Pas de photo
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($vehicule->getMarque()); ?></td>
                        <td><?php echo htmlspecialchars($vehicule->getModele()); ?></td>
                        <td><?php echo htmlspecialchars($vehicule->getMatricule()); ?></td>
                        <td><?php echo htmlspecialchars(number_format($vehicule->getPrixJournalier(), 2)); ?></td>
                        <td><?php echo htmlspecialchars($vehicule->getTypeVehicule()); ?></td>
                        <td><?php echo $vehicule->getStatutDispo() ? 'Disponible' : 'Indisponible'; ?></td>
                        <td>
                            <a href="index.php?action=viewVehicule&id=<?php echo $vehicule->getIdVehicule(); ?>" class="btn btn-info btn-sm">Voir Détails</a>
                            <?php if($vehicule->getStatutDispo()): ?>
                                <a href="index.php?action=addReservation&vehicule_id=<?php echo $vehicule->getIdVehicule(); ?>" class="btn btn-primary btn-sm">Réserver</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="index.php">Retour à l'accueil</a></p>
</body>
</html>
