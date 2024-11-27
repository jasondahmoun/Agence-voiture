<?php
session_start();

// Inclure les classes nécessaires
require_once 'ModelGenerique.php'; // Votre classe de modèle générique
require_once 'Personne.php';
require_once 'PersonneMdl.php';
require_once 'PersonneCtl.php';
require_once 'Vehicule.php';
require_once 'VehiculeMdl.php';
require_once 'VehiculeCtl.php';
require_once 'Reservation.php';
require_once 'ReservationMdl.php';
require_once 'ReservationCtl.php';
require_once 'Commentaire.php';
require_once 'CommentaireMdl.php';
require_once 'CommentaireCtl.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=Agence;charset=utf8', 'root', ''); // Par défaut, XAMPP utilise 'root' sans mot de passe
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ModelGenerique::setPDO($pdo); // Suppose que vous avez une méthode statique pour définir PDO
} catch(PDOException $e){
    die("Erreur de connexion : " . $e->getMessage());
}

// Route vers le contrôleur approprié
if(isset($_GET['action'])){
    switch($_GET['action']){
        case "register":
        case "login":
        case "logout":
        case "gestionUtilisateur":
        case "addUser":
        case "editUser":
        case "deleteUser":
            $personneCtl = new PersonneCtl();
            $personneCtl->personneAction();
            break;

        case "addReservation":
        case "viewReservations":
        case "editReservation":
        case "cancelReservation":
            $reservationCtl = new ReservationCtl();
            $reservationCtl->reservationAction();
            break;

        case "addVehicule":
        case "gestionVehicule":
        case "viewVehicules":
        case "viewVehicule":
        case "editVehicule":
        case "deleteVehicule":
            $vehiculeCtl = new VehiculeCtl();
            $vehiculeCtl->vehiculeAction();
            break;

        case "addCommentaire":
            $commentaireCtl = new CommentaireCtl();
            $commentaireCtl->commentaireAction();
            break;

        // Ajoutez d'autres cases pour les actions de commentaires, etc.

        default:
            // Action par défaut ou afficher une page d'erreur
            echo "Page non trouvée.";
            break;
    }
} else {
    // Action par défaut, par exemple afficher la liste des véhicules ou une page d'accueil
    header('Location: index.php?action=viewVehicules');
    exit;
}
?>
