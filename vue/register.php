<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Inscription</h2>

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

    <form action="index.php?action=register" method="POST">
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" class="form-control" maxlength="25" required>
        </div>

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" class="form-control" maxlength="25" required>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de Passe :</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="role">Rôle :</label>
            <select id="role" name="role" class="form-control" required>
                <option value="CLIENT">Client</option>
                <option value="ADMIN">Administrateur</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">S'inscrire</button>
    </form>

    <p class="mt-3">Vous avez déjà un compte ? <a href="index.php?action=login">Connectez-vous</a>.</p>
</body>
</html>
