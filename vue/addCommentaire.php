<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Commentaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Ajouter un Commentaire</h2>

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
        <input type="hidden" name="id_vehicule" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
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

    <p class="mt-3"><a href="index.php?action=viewVehicule&id=<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">Retour aux Détails du Véhicule</a></p>
</body>
</html>
