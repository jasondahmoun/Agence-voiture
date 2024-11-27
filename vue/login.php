<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        /* Styles personnalisés */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Agence</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Ajouter des liens de navigation si nécessaire -->
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['user'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=logout">Déconnexion</a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=login">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=register">Inscription</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <div class="login-container">
        <div class="login-form">
            <h2 class="text-center mb-4">Connexion</h2>

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

            if(isset($_GET['register']) && $_GET['register'] == 'success'){
                echo '<div class="alert alert-success">Inscription réussie. Vous pouvez maintenant vous connecter.</div>';
            }
            ?>

            <form action="index.php?action=login" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="Entrez votre email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de Passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Entrez votre mot de passe">
                </div>

                <button type="submit" class="btn btn-primary w-100">Se Connecter</button>
            </form>

            <p class="mt-3 text-center">Vous n'avez pas de compte ? <a href="index.php?action=register">Inscrivez-vous</a>.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
