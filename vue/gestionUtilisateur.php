<?php
// Assurez-vous que ce fichier est inclus dans le contrôleur
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Gestion des Utilisateurs</h2>

    <?php
    if(isset($_GET['success']) && $_GET['success'] == 1){
        echo '<div class="alert alert-success">Utilisateur ajouté avec succès.</div>';
    }

    if(isset($_GET['update']) && $_GET['update'] == 1){
        echo '<div class="alert alert-success">Utilisateur mis à jour avec succès.</div>';
    }

    if(isset($_GET['delete']) && $_GET['delete'] == 1){
        echo '<div class="alert alert-success">Utilisateur supprimé avec succès.</div>';
    }
    ?>

    <a href="index.php?action=addUser" class="btn btn-primary mb-3">Ajouter un Nouvel Utilisateur</a>

    <h4>Filtrer et Rechercher</h4>
    <form method="GET" action="index.php">
        <input type="hidden" name="action" value="gestionUtilisateur">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" name="prenom" class="form-control" placeholder="Prénom" value="<?php echo isset($_GET['prenom']) ? htmlspecialchars($_GET['prenom']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="nom" class="form-control" placeholder="Nom" value="<?php echo isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <select name="role" class="form-control">
                    <option value="">Tous</option>
                    <option value="CLIENT" <?php echo (isset($_GET['role']) && $_GET['role'] === 'CLIENT') ? 'selected' : ''; ?>>Client</option>
                    <option value="ADMIN" <?php echo (isset($_GET['role']) && $_GET['role'] === 'ADMIN') ? 'selected' : ''; ?>>Administrateur</option>
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
                <th>ID Utilisateur</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($utilisateurs)): ?>
                <tr>
                    <td colspan="6" class="text-center">Aucun utilisateur trouvé.</td>
                </tr>
            <?php else: ?>
                <?php foreach($utilisateurs as $utilisateur): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($utilisateur->getIdPersonne()); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur->getPrenom()); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur->getNom()); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur->getEmail()); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur->getRole()); ?></td>
                        <td>
                            <a href="index.php?action=editUser&id=<?php echo $utilisateur->getIdPersonne(); ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="index.php?action=deleteUser&id=<?php echo $utilisateur->getIdPersonne(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="index.php">Retour à l'accueil</a></p>
</body>
</html>
