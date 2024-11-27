<?php

class VehiculeCtl {
    public function vehiculeAction(){
        $vehiculeMdl = new VehiculeMdl();
        $userMdl = new PersonneMdl(); 

        if(isset($_GET['action'])){
            switch($_GET['action']){

                case "addVehicule":
                    if(!$this->isAdmin()){
                        header('Location: index.php');
                        exit;
                    }

                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $marque = $_POST['marque'] ?? '';
                        $modele = $_POST['modele'] ?? '';
                        $matricule = $_POST['matricule'] ?? '';
                        $prixJournalier = $_POST['prix_journalier'] ?? '';
                        $typeVehicule = $_POST['type_vehicule'] ?? '';
                        $statutDispo = $_POST['statut_dispo'] ?? 1;
                        $photo = '';

                        if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                            $fileExt = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                            if(in_array(strtolower($fileExt), $allowed)){
                                $photo = uniqid() . '.' . $fileExt;
                                move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo);
                            } else {
                                $_SESSION['errors'] = ["Type de fichier non autorisé pour la photo."];
                                include "vue/addVehicule.php";
                                exit;
                            }
                        } else {
                            $_SESSION['errors'] = ["Une photo est requise."];
                            include "vue/addVehicule.php";
                            exit;
                        }

                        $errors = [];
                        if(empty($marque)) $errors[] = "La marque est requise.";
                        if(empty($modele)) $errors[] = "Le modèle est requis.";
                        if(empty($matricule)) $errors[] = "Le matricule est requis.";
                        if(empty($prixJournalier) || !is_numeric($prixJournalier)) $errors[] = "Le prix journalier est invalide.";
                        if(empty($typeVehicule)) $errors[] = "Le type de véhicule est requis.";

                        $existingVehicule = $vehiculeMdl->executeReq("SELECT * FROM vehicule WHERE matricule = :matricule", ["matricule" => $matricule])->fetch();
                        if($existingVehicule){
                            $errors[] = "Le matricule est déjà utilisé.";
                        }

                        if(empty($errors)){
                            $vehicule = new Vehicule(
                                null,
                                $marque,
                                $modele,
                                $matricule,
                                $prixJournalier,
                                $typeVehicule,
                                $statutDispo,
                                $photo
                            );

                            $vehiculeMdl->addVehicule($vehicule);

                            header("Location: index.php?action=gestionVehicule&success=1");
                            exit;
                        } else {
                            $_SESSION['errors'] = $errors;
                        }
                    }

                    include "vue/addVehicule.php";
                    break;

                case "gestionVehicule":
                    if(!$this->isAdmin()){
                        header('Location: index.php');
                        exit;
                    }

                    $filters = [];
                    if(isset($_GET['marque'])) $filters['marque'] = $_GET['marque'];
                    if(isset($_GET['modele'])) $filters['modele'] = $_GET['modele'];
                    if(isset($_GET['type_vehicule'])) $filters['type_vehicule'] = $_GET['type_vehicule'];
                    if(isset($_GET['statut_dispo']) && $_GET['statut_dispo'] !== ''){
                        $filters['statut_dispo'] = $_GET['statut_dispo'];
                    }

                    $vehicules = $vehiculeMdl->getAllVehicules($filters);
                    include "vue/gestionVehicule.php";
                    break;

                case "editVehicule":
                    if(!$this->isAdmin()){
                        header('Location: index.php');
                        exit;
                    }

                    $id = $_GET['id'] ?? null;
                    if(!$id){
                        header('Location: index.php?action=gestionVehicule');
                        exit;
                    }

                    $vehicule = $vehiculeMdl->getVehiculeById((int)$id);
                    if(!$vehicule){
                        header('Location: index.php?action=gestionVehicule');
                        exit;
                    }

                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $marque = $_POST['marque'] ?? '';
                        $modele = $_POST['modele'] ?? '';
                        $matricule = $_POST['matricule'] ?? '';
                        $prixJournalier = $_POST['prix_journalier'] ?? '';
                        $typeVehicule = $_POST['type_vehicule'] ?? '';
                        $statutDispo = $_POST['statut_dispo'] ?? 1;
                        $photo = $vehicule->getPhoto();

                        if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                            $fileExt = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                            if(in_array(strtolower($fileExt), $allowed)){
                                $photo = uniqid() . '.' . $fileExt;
                                move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo);
                                if(file_exists('uploads/' . $vehicule->getPhoto())){
                                    unlink('uploads/' . $vehicule->getPhoto());
                                }
                            } else {
                                $_SESSION['errors'] = ["Type de fichier non autorisé pour la photo."];
                                include "vue/editVehicule.php";
                                exit;
                            }
                        }

                        $errors = [];
                        if(empty($marque)) $errors[] = "La marque est requise.";
                        if(empty($modele)) $errors[] = "Le modèle est requis.";
                        if(empty($matricule)) $errors[] = "Le matricule est requis.";
                        if(empty($prixJournalier) || !is_numeric($prixJournalier)) $errors[] = "Le prix journalier est invalide.";
                        if(empty($typeVehicule)) $errors[] = "Le type de véhicule est requis.";

                        if($matricule !== $vehicule->getMatricule()){
                            $existingVehicule = $vehiculeMdl->executeReq("SELECT * FROM vehicule WHERE matricule = :matricule", ["matricule" => $matricule])->fetch();
                            if($existingVehicule){
                                $errors[] = "Le matricule est déjà utilisé.";
                            }
                        }

                        if(empty($errors)){
                            $vehicule->setMarque($marque);
                            $vehicule->setModele($modele);
                            $vehicule->setMatricule($matricule);
                            $vehicule->setPrixJournalier($prixJournalier);
                            $vehicule->setTypeVehicule($typeVehicule);
                            $vehicule->setStatutDispo($statutDispo);
                            $vehicule->setPhoto($photo);

                            $vehiculeMdl->updateVehicule($vehicule);

                            header("Location: index.php?action=gestionVehicule&update=1");
                            exit;
                        } else {
                            $_SESSION['errors'] = $errors;
                        }
                    }

                    include "vue/editVehicule.php";
                    break;

                case "deleteVehicule":
                    if(!$this->isAdmin()){
                        header('Location: index.php');
                        exit;
                    }

                    $id = $_GET['id'] ?? null;
                    if(!$id){
                        header('Location: index.php?action=gestionVehicule');
                        exit;
                    }

                    $vehicule = $vehiculeMdl->getVehiculeById((int)$id);
                    if($vehicule){
                        // Supprimer la photo si nécessaire
                        if(file_exists('uploads/' . $vehicule->getPhoto())){
                            unlink('uploads/' . $vehicule->getPhoto());
                        }
                        $vehiculeMdl->deleteVehicule((int)$id);
                    }

                    header("Location: index.php?action=gestionVehicule&delete=1");
                    exit;
                    break;

                case "viewVehicules":
                    $filters = [];
                    if(isset($_GET['marque'])) $filters['marque'] = $_GET['marque'];
                    if(isset($_GET['modele'])) $filters['modele'] = $_GET['modele'];
                    if(isset($_GET['type_vehicule'])) $filters['type_vehicule'] = $_GET['type_vehicule'];
                    if(isset($_GET['statut_dispo']) && $_GET['statut_dispo'] !== ''){
                        $filters['statut_dispo'] = $_GET['statut_dispo'];
                    }

                    $vehicules = $vehiculeMdl->getAllVehicules($filters);
                    include "vue/viewVehicules.php";
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

    private function isAdmin(){
        return $this->isConnected() && 
               unserialize($_SESSION['user'])->getRole() == "ADMIN" 
               ? true 
               : false;
    }
}
?>
