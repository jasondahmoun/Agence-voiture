<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mes Réservations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Mes Réservations</h2>

    <?php
    if(isset($_GET['success']) && $_GET['success'] == 1){
        echo '<div class="alert alert-success">Réservation créée avec succès.</div>';
    }

    if(isset($_GET['update']) && $_GET['update'] == 1){
        echo '<div class="alert alert-success">Réservation mise à jour avec succès.</div>';
    }

    if(isset($_GET['cancel']) && $_GET['cancel'] == 1){
        echo '<div class="alert alert-success">Réservation annulée avec succès.</div>';
    }

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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Réservation</th>
                <th>Véhicule</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Prix Total (€)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($reservations as $reservation): ?>
                <?php
                    $vehicule = $vehiculeMdl->getVehiculeById($reservation->getIdVehicule());
                    $totalPrice = $totalPrices[$reservation->getIdReservation()];
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation->getIdReservation()); ?></td>
                    <td><?php echo htmlspecialchars($vehicule->getMarque().' '.$vehicule->getModele()); ?></td>
                    <td><?php echo htmlspecialchars($reservation->getDateDebut()); ?></td>
                    <td><?php echo htmlspecialchars($reservation->getDateFin()); ?></td>
                    <td><?php echo htmlspecialchars(number_format($totalPrice, 2)); ?></td>
                    <td>
                        <?php
                            $today = new DateTime();
                            $dateDebut = new DateTime($reservation->getDateDebut());
                            if($today < $dateDebut){
                                echo '<a href="index.php?action=editReservation&id='.$reservation->getIdReservation().'" class="btn btn-warning btn-sm">Modifier</a> ';
                                echo '<a href="index.php?action=cancelReservation&id='.$reservation->getIdReservation().'" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir annuler cette réservation ?\');">Annuler</a>';
                            } else {
                                echo 'Non modifiable';
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="index.php?action=addReservation" class="btn btn-primary">Ajouter une Réservation</a></p>
</body>
</html>
