<?php
$vehiculeMdl = new VehiculeMdl();
$vehicules = $vehiculeMdl->getAllVehicules(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Réservation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2>Modifier une Réservation</h2>

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

    <form action="index.php?action=editReservation&id=<?php echo htmlspecialchars($reservation->getIdReservation()); ?>" method="POST">
        <div class="form-group">
            <label for="date_debut">Nouvelle Date de Début :</label>
            <input type="date" id="date_debut" name="date_debut" class="form-control" value="<?php echo htmlspecialchars($reservation->getDateDebut()); ?>" required>
        </div>

        <div class="form-group">
            <label for="date_fin">Nouvelle Date de Fin :</label>
            <input type="date" id="date_fin" name="date_fin" class="form-control" value="<?php echo htmlspecialchars($reservation->getDateFin()); ?>" required>
        </div>

        <div class="form-group">
            <label for="id_vehicule">Véhicule :</label>
            <select id="id_vehicule" name="id_vehicule" class="form-control" required>
                <option value="">Sélectionner un véhicule</option>
                <?php
                    foreach($vehicules as $vehicule){
                        $selected = ($vehicule->getIdVehicule() == $reservation->getIdVehicule()) ? 'selected' : '';
                        echo '<option value="'.$vehicule->getIdVehicule().'" '.$selected.'>'.$vehicule->getMarque().' '.$vehicule->getModele().'</option>';
                    }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Mettre à Jour Réservation</button>
    </form>

    <p class="mt-3"><a href="index.php?action=viewReservations">Retour aux Réservations</a></p>
</body>
</html>
