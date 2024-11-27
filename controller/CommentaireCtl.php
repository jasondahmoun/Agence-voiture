<?php

class CommentaireCtl {
    public function commentaireAction(){
        $commentaireMdl = new CommentaireMdl();
        $reservationMdl = new ReservationMdl();

        if(isset($_GET['action'])){
            switch($_GET['action']){

                case "addCommentaire":
                    if(!$this->isConnected()){
                        header('Location: index.php?action=login');
                        exit;
                    }

                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $idVehicule = $_POST['id_vehicule'] ?? '';
                        $commentaireText = $_POST['commentaire'] ?? '';
                        $note = $_POST['note'] ?? '';

                        $errors = [];
                        if(empty($idVehicule)) $errors[] = "Le véhicule est requis.";
                        if(empty($commentaireText)) $errors[] = "Le commentaire est requis.";
                        if(empty($note) || !is_numeric($note) || $note < 1 || $note > 5){
                            $errors[] = "La note doit être un nombre entre 1 et 5.";
                        }

                        $currentUser = unserialize($_SESSION['user']);

                        if(!$reservationMdl->hasUserRentedVehicule($currentUser->getIdPersonne(), (int)$idVehicule)){
                            $errors[] = "Vous ne pouvez commenter que les véhicules que vous avez loués.";
                        }

               
                        if($commentaireMdl->hasUserCommented($currentUser->getIdPersonne(), (int)$idVehicule)){
                            $errors[] = "Vous avez déjà commenté ce véhicule.";
                        }

                        if(empty($errors)){
                            $commentaire = new Commentaire(
                                null,
                                $commentaireText,
                                null, 
                                $note,
                                (int)$idVehicule,
                                $currentUser->getIdPersonne()
                            );

                            $commentaireMdl->addCommentaire($commentaire);

                            header("Location: index.php?action=viewVehicule&id=".$idVehicule."&comment=success");
                            exit;
                        } else {
                            $_SESSION['errors'] = $errors;
                            header("Location: index.php?action=viewVehicule&id=".$idVehicule);
                            exit;
                        }
                    }

                    header('Location: index.php?action=viewVehicules');
                    exit;
                    break;

                default:
                    header('Location: index.php?action=viewVehicules');
                    exit;
            }
        } else {
            header('Location: index.php?action=viewVehicules');
            exit;
        }
    }

    private function isConnected(){
        return isset($_SESSION['user']) ? true : false;
    }
}
?>
