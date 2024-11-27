<?php

class ReservationCtl {
    public function reservationAction(){
        $reservationMdl = new ReservationMdl();
        $vehiculeMdl = new VehiculeMdl();
        $userMdl = new PersonneMdl(); 
        
        if(isset($_GET['action'])){
            switch($_GET['action']){

                case "addReservation":
                    if(!$this->isConnected()){
                        header('Location: ?action=login');
                        exit;
                    }

                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $dateDebut = $_POST['date_debut'] ?? '';
                        $dateFin = $_POST['date_fin'] ?? '';
                        $idVehicule = $_POST['id_vehicule'] ?? '';

                        $errors = [];
                        if(empty($dateDebut)) $errors[] = "La date de début est requise.";
                        if(empty($dateFin)) $errors[] = "La date de fin est requise.";
                        if(empty($idVehicule)) $errors[] = "Le véhicule est requis.";

                        if(!empty($dateDebut) && !empty($dateFin)){
                            if(strtotime($dateFin) < strtotime($dateDebut)){
                                $errors[] = "La date de fin doit être après la date de début.";
                            }
                        }

                        if($vehiculeMdl->isVehiculeDisponible($idVehicule, $dateDebut, $dateFin)){
                        } else {
                            $errors[] = "Le véhicule n'est pas disponible pour les dates sélectionnées.";
                        }

                        if(empty($errors)){
                            $currentUser = unserialize($_SESSION['user']);
                            $reservation = new Reservation(
                                null,
                                null,
                                $dateDebut,
                                $dateFin,
                                $idVehicule,
                                $currentUser->getIdPersonne()
                            );

                            $reservationMdl->addReservation($reservation);

                            header("Location: ?action=viewReservations&success=1");
                            exit;
                        } else {
                            $_SESSION['errors'] = $errors;
                        }
                    }

                    include "vue/addReservation.php";
                    break;
                case "viewReservations":
                    if(!$this->isConnected()){
                        header('Location: ?action=login');
                        exit;
                    }

                    $currentUser = unserialize($_SESSION['user']);
                    $reservations = $reservationMdl->getReservationsByUser($currentUser->getIdPersonne());

                    $totalPrices = [];
                    foreach($reservations as $reservation){
                        $totalPrices[$reservation->getIdReservation()] = $reservationMdl->calculateTotalPrice($reservation, $vehiculeMdl);
                    }

                    include "vue/viewReservations.php";
                    break;
                case "editReservation":
                    if(!$this->isConnected()){
                        header('Location: ?action=login');
                        exit;
                    }

                    $id = $_GET['id'] ?? null;
                    if(!$id){
                        header('Location: ?action=viewReservations');
                        exit;
                    }

                    $reservation = $reservationMdl->getReservationById((int)$id);
                    if(!$reservation){
                        header('Location: ?action=viewReservations');
                        exit;
                    }
                    $currentUser = unserialize($_SESSION['user']);
                    if($currentUser->getRole() !== "ADMIN" && $reservation->getIdPersonne() !== $currentUser->getIdPersonne()){
                        header('Location: ?action=viewReservations');
                        exit;
                    }

                    $today = new DateTime();
                    $dateDebut = new DateTime($reservation->getDateDebut());
                    if($today >= $dateDebut){
                        $_SESSION['errors'] = ["La réservation ne peut plus être modifiée."];
                        header('Location: ?action=viewReservations');
                        exit;
                    }

                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $dateDebutNew = $_POST['date_debut'] ?? '';
                        $dateFinNew = $_POST['date_fin'] ?? '';
                        $idVehiculeNew = $_POST['id_vehicule'] ?? '';

                        $errors = [];
                        if(empty($dateDebutNew)) $errors[] = "La nouvelle date de début est requise.";
                        if(empty($dateFinNew)) $errors[] = "La nouvelle date de fin est requise.";
                        if(empty($idVehiculeNew)) $errors[] = "Le véhicule est requis.";
                        if(!empty($dateDebutNew) && !empty($dateFinNew)){
                            if(strtotime($dateFinNew) < strtotime($dateDebutNew)){
                                $errors[] = "La date de fin doit être après la date de début.";
                            }
                        }

                        if($vehiculeMdl->isVehiculeDisponible($idVehiculeNew, $dateDebutNew, $dateFinNew, $id)){

                        } else {
                            $errors[] = "Le véhicule n'est pas disponible pour les nouvelles dates sélectionnées.";
                        }

                        if(empty($errors)){
                            $reservation->setDateDebut($dateDebutNew);
                            $reservation->setDateFin($dateFinNew);
                            $reservation->setIdVehicule($idVehiculeNew);

                            $reservationMdl->updateReservation($reservation);

                            header("Location: ?action=viewReservations&update=1");
                            exit;
                        } else {
                            $_SESSION['errors'] = $errors;
             
                        }
                    }

                    include "vue/editReservation.php";
                    break;

                case "cancelReservation":
                    if(!$this->isConnected()){
                        header('Location: ?action=login');
                        exit;
                    }

                    $id = $_GET['id'] ?? null;
                    if(!$id){
                        header('Location: ?action=viewReservations');
                        exit;
                    }

                    $reservation = $reservationMdl->getReservationById((int)$id);
                    if(!$reservation){
                        header('Location: ?action=viewReservations');
                        exit;
                    }

                    $currentUser = unserialize($_SESSION['user']);
                    if($currentUser->getRole() !== "ADMIN" && $reservation->getIdPersonne() !== $currentUser->getIdPersonne()){
                        header('Location: ?action=viewReservations');
                        exit;
                    }

                    $today = new DateTime();
                    $dateDebut = new DateTime($reservation->getDateDebut());
                    if($today >= $dateDebut){
                        $_SESSION['errors'] = ["La réservation ne peut plus être annulée."];
                        header('Location: ?action=viewReservations');
                        exit;
                    }

                    $reservationMdl->deleteReservation((int)$id);

                    header("Location: ?action=viewReservations&cancel=1");
                    exit;
                    break;

                default:
                    header('Location: index.php');
                    exit;
            }
        } else {

            header('Location: ?action=viewReservations');
            exit;
        }
    }

    private function isConnected(){
        return isset($_SESSION['user']) ? true : false;
    }

    private function isAdmin(){
        return $this->isConnected() && 
               unserialize($_SESSION['user'])->getRole() == "ADMIN" 
               ? true 
               : false;
    }
}
