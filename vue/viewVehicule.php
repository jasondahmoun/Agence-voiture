<?php
// Assurez-vous que ce fichier est inclus dans le contrôleur
?>
<!DOCTYPE html>
<html>
<head>
    <title>Détails du Véhicule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Détails du Véhicule</h2>

    <div class="card mb-3">
        <div class="row g-0">
            <?php if($vehicule->getPhoto()): ?>
                <div class="col-md-4">
                    <img src="uploads/<?php echo htmlspecialchars($vehicule->getPhoto()); ?>" class="img-fluid rounded-start" alt="Photo">
                </div>
            <?php endif; ?>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($vehicule->getMarque().' '.$vehicule->getModele()); ?></h5>
                    <p class="card-text"><strong>Matricule:</strong> <?php echo htmlspecialchars($vehicule->getMatricule()); ?></p>
                    <p class="card-text"><strong>Prix Journalier:</strong> <?php echo htmlspecialchars(number_format($vehicule->getPrixJournalier(), 2)); ?> €</p>
                    <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($vehicule->getTypeVehicule()); ?></p>
                    <p class="card-text"><strong>Disponibilité:</strong> <?php echo $vehicule->getStatutDispo() ? 'Disponible' : 'Indisponible'; ?></p>
                    <p class="card-text"><strong>Note Moyenne:</strong> <?php echo htmlspecialchars($noteMoyenne); ?>/5</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Commentaires</h4>

    <?php
    if(isset($_GET['comment']) && $_GET['comment'] == 'success'){
        echo '<div class="alert alert-success">Commentaire ajouté avec succès.</div>';
    }

    if(empty($commentaires)){
        echo '<p>Aucun commentaire pour ce véhicule.</p>';
    } else {
        foreach($commentaires as $com){
            echo '<div class="card mb-3">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$com['prenom'].' '.$com['nom'].' - '.$com['note'].'/5</h5>';
            echo '<p class="card-text">'.nl2br(htmlspecialchars($com['commentaire'])).'</p>';
            echo '<p class="card-text"><small class="text-muted">Posté le '.date("d/m/Y H:i", strtotime($com['dateCommantaire'])).'</small></p>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>

    <?php if($this->isConnected()): ?>
        <?php
            // Vérifier si l'utilisateur a déjà commenté
            $currentUser = unserialize($_SESSION['user']);
            $hasCommented = false;
            foreach($commentaires as $com){
                if($com['nom'] === $currentUser->getNom() && $com['prenom'] === $currentUser->getPrenom()){
                    $hasCommented = true;
                    break;
                }
            }
        ?>
        <?php if(!$hasCommented && $reservationMdl->hasUserRentedVehicule($currentUser->getIdPersonne(), $vehicule->getIdVehicule())): ?>
            <h4>Laisser un Commentaire</h4>

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

            <form action="index.php?action=addCommentaire" method="POST">
                <input type="hidden" name="id_vehicule" value="<?php echo $vehicule->getIdVehicule(); ?>">
                <div class="form-group">
                    <label for="commentaire">Commentaire :</label>
                    <textarea id="commentaire" name="commentaire" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="note">Note (1 à 5) :</label>
                    <input type="number" id="note" name="note" class="form-control" min="1" max="5" required>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Poster Commentaire</button>
            </form>
        <?php else: ?>
            <p>Vous avez déjà commenté ce véhicule.</p>
        <?php endif; ?>
    <?php else: ?>
        <p><a href="index.php?action=login">Connectez-vous</a> pour laisser un commentaire.</p>
    <?php endif; ?>

    <p class="mt-3"><a href="index.php?action=viewVehicules">Retour à la Liste des Véhicules</a></p>
</body>
</html>
