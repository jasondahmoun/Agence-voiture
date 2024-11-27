<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Utilisateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Modifier un Utilisateur</h2>

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

    <form action="index.php?action=updateUser&id=<?php echo htmlspecialchars($utilisateur->getIdPersonne()); ?>" method="POST">
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" class="form-control" maxlength="25" value="<?php echo htmlspecialchars($utilisateur->getPrenom()); ?>" required>
        </div>

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" class="form-control" maxlength="25" value="<?php echo htmlspecialchars($utilisateur->getNom()); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($utilisateur->getEmail()); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de Passe :</label>
            <input type="password" id="password" name="password" class="form-control">
            <small class="form-text text-muted">Laissez vide si vous ne souhaitez pas changer le mot de passe.</small>
        </div>

        <div class="form-group">
            <label for="role">Rôle :</label>
            <select id="role" name="role" class="form-control" required>
                <option value="CLIENT" <?php echo ($utilisateur->getRole() === 'CLIENT') ? 'selected' : ''; ?>>Client</option>
                <option value="ADMIN" <?php echo ($utilisateur->getRole() === 'ADMIN') ? 'selected' : ''; ?>>Administrateur</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Mettre à Jour Utilisateur</button>
    </form>

    <p class="mt-3"><a href="index.php?action=gestionUtilisateur">Retour à la Gestion des Utilisateurs</a></p>
</body>
</html>
