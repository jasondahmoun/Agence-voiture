<?php
// Assurez-vous que ce fichier est inclus dans le contrôleur
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Véhicules</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Gestion des Véhicules</h2>

    <?php
    if(isset($_GET['success']) && $_GET['success'] == 1){
        echo '<div class="alert alert-success">Véhicule ajouté avec succès.</div>';
    }

    if(isset($_GET['update']) && $_GET['update'] == 1){
        echo '<div class="alert alert-success">Véhicule mis à jour avec succès.</div>';
    }

    if(isset($_GET['delete']) && $_GET['delete'] == 1){
        echo '<div class="alert alert-success">Véhicule supprimé avec succès.</div>';
    }
    ?>

    <a href="index.php?action=addVehicule" class="btn btn-primary mb-3">Ajouter un Nouveau Véhicule</a>

    <h4>Filtrer et Rechercher</h4>
    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="gestionVehicule">
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
                <th>ID Véhicule</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Matricule</th>
                <th>Prix Journalier (€)</th>
                <th>Type de Véhicule</th>
                <th>Statut Disponibilité</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($vehicules)): ?>
                <tr>
                    <td colspan="9" class="text-center">Aucun véhicule trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach($vehicules as $vehicule): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vehicule->getIdVehicule()); ?></td>
                        <td><?php echo htmlspecialchars($vehicule->getMarque()); ?></td>
                        <td><?php echo htmlspecialchars($vehicule->getModele()); ?></td>
                        <td><?php echo htmlspecialchars($vehicule->getMatricule()); ?></td>
                        <td><?php echo htmlspecialchars(number_format($vehicule->getPrixJournalier(), 2)); ?></td>
                        <td><?php echo htmlspecialchars($vehicule->getTypeVehicule()); ?></td>
                        <td><?php echo $vehicule->getStatutDispo() ? 'Disponible' : 'Indisponible'; ?></td>
                        <td>
                            <?php if($vehicule->getPhoto()): ?>
                                <img src="uploads/<?php echo htmlspecialchars($vehicule->getPhoto()); ?>" alt="Photo" width="100">
                            <?php else: ?>
                                Pas de photo
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?action=editVehicule&id=<?php echo $vehicule->getIdVehicule(); ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="index.php?action=deleteVehicule&id=<?php echo $vehicule->getIdVehicule(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">Supprimer</a>
                            <a href="index.php?action=viewVehicule&id=<?php echo $vehicule->getIdVehicule(); ?>" class="btn btn-info btn-sm">Voir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="index.php">Retour à l'accueil</a></p>
</body>
</html>
