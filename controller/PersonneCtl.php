<?php

class PersonneCtl {
    public function personneAction(){
        $personneMdl = new PersonneMdl();

        if(isset($_GET['action'])){
            switch($_GET['action']){
                
                // Inscription
                case "register":
                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        // Valider les données du formulaire
                        $civilite = $_POST['civilite'] ?? '';
                        $prenom = $_POST['prenom'] ?? '';
                        $nom = $_POST['nom'] ?? '';
                        $login = $_POST['login'] ?? '';
                        $email = $_POST['email'] ?? '';
                        $tel = $_POST['tel'] ?? '';
                        $mdp = $_POST['mdp'] ?? '';
                        $confirm_mdp = $_POST['confirm_mdp'] ?? '';

                        // Simple validation
                        $errors = [];
                        if(empty($civilite)) $errors[] = "La civilité est requise.";
                        if(empty($prenom)) $errors[] = "Le prénom est requis.";
                        if(empty($nom)) $errors[] = "Le nom est requis.";
                        if(empty($login)) $errors[] = "Le login est requis.";
                        if(empty($email)) $errors[] = "L'email est requis.";
                        if(empty($tel)) $errors[] = "Le téléphone est requis.";
                        if(empty($mdp)) $errors[] = "Le mot de passe est requis.";
                        if($mdp !== $confirm_mdp) $errors[] = "Les mots de passe ne correspondent pas.";

                        // Vérifier l'unicité du login et du téléphone
                        if($personneMdl->getPersonneByLogin($login)){
                            $errors[] = "Le login est déjà utilisé.";
                        }

                        // Vous pouvez ajouter d'autres vérifications, comme la validité de l'email

                        if(empty($errors)){
                            $personne = new Personne(
                                null,
                                $civilite,
                                $prenom,
                                $nom,
                                $login,
                                $email,
                                $tel,
                                $mdp // Le constructeur hash le mot de passe
                            );

                            $personneMdl->addPersonne($personne);

                            // Rediriger vers la page de connexion ou afficher un message de succès
                            header("Location: ?action=login&register=success");
                            exit;
                        } else {
                            // Passer les erreurs à la vue
                            $_SESSION['errors'] = $errors;
                        }
                    }

                    include "vue/register.php";
                    break;

                // Connexion
                case "login":
                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        $login = $_POST['login'] ?? '';
                        $mdp = $_POST['mdp'] ?? '';

                        $personne = $personneMdl->getPersonneByLogin($login);
                        if($personne && password_verify($mdp, $personne->getMdp())){
                            // Authentification réussie
                            $_SESSION['user'] = serialize($personne);
                            header("Location: index.php"); // Rediriger vers la page d'accueil
                            exit;
                        } else {
                            $_SESSION['errors'] = ["Login ou mot de passe incorrect."];
                        }
                    }

                    include "vue/login.php";
                    break;

                // Déconnexion
                case "logout":
                    session_destroy();
                    header("Location: index.php");
                    exit;
                    break;

                // Gestion des utilisateurs (Administrateur)
                case "gestionUtilisateur":
                    if(!$this->isAdmin()){
                        header('Location: index.php');
                        exit;
                    }

                    $personnes = $personneMdl->getAllPersonnes();
                    include "vue/gestionUtilisateur.php";
                    break;

                // Supprimer un utilisateur (Administrateur)
                case "deleteUser":
                    if(!$this->isAdmin()){
                        header('Location: index.php');
                        exit;
                    }

                    $id = $_GET['id'] ?? null;
                    if($id){
                        $personneMdl->deletePersonne((int)$id);
                    }

                    header('Location: ?action=gestionUtilisateur');
                    exit;
                    break;

                // Modifier un utilisateur (Administrateur)
                case "updateUser":
                    if(!$this->isAdmin()){
                        header('Location: index.php');
                        exit;
                    }

                    $id = $_GET['id'] ?? null;
                    if(!$id){
                        header('Location: ?action=gestionUtilisateur');
                        exit;
                    }

                    $personneToUpdate = $personneMdl->getPersonneById((int)$id);

                    if($_SERVER['REQUEST_METHOD'] === 'POST'){
                        // Valider les données du formulaire
                        $civilite = $_POST['civilite'] ?? '';
                        $prenom = $_POST['prenom'] ?? '';
                        $nom = $_POST['nom'] ?? '';
                        $login = $_POST['login'] ?? '';
                        $email = $_POST['email'] ?? '';
                        $tel = $_POST['tel'] ?? '';
                        $role = $_POST['role'] ?? 'CLIENT';
                        $mdp = $_POST['mdp'] ?? '';
                        $confirm_mdp = $_POST['confirm_mdp'] ?? '';

                        $errors = [];
                        if(empty($civilite)) $errors[] = "La civilité est requise.";
                        if(empty($prenom)) $errors[] = "Le prénom est requis.";
                        if(empty($nom)) $errors[] = "Le nom est requis.";
                        if(empty($login)) $errors[] = "Le login est requis.";
                        if(empty($email)) $errors[] = "L'email est requis.";
                        if(empty($tel)) $errors[] = "Le téléphone est requis.";

                        // Vérifier l'unicité du login et du téléphone si modifiés
                        $existingPersonne = $personneMdl->getPersonneByLogin($login);
                        if($existingPersonne && $existingPersonne->getIdPersonne() != $id){
                            $errors[] = "Le login est déjà utilisé par un autre utilisateur.";
                        }

                        if(!empty($mdp) && ($mdp !== $confirm_mdp)){
                            $errors[] = "Les mots de passe ne correspondent pas.";
                        }

                        if(empty($errors)){
                            $personneToUpdate->setCivilite($civilite);
                            $personneToUpdate->setPrenom($prenom);
                            $personneToUpdate->setNom($nom);
                            $personneToUpdate->setLogin($login);
                            $personneToUpdate->setEmail($email);
                            $personneToUpdate->setTel($tel);
                            $personneToUpdate->setRole($role);

                            if(!empty($mdp)){
                                $personneToUpdate->setMdp($mdp);
                            }

                            $personneMdl->updatePersonne($personneToUpdate);

                            header('Location: ?action=gestionUtilisateur');
                            exit;
                        } else {
                            $_SESSION['errors'] = $errors;
                        }
                    }

                    include "vue/formUpdateUser.php";
                    break;

                default:
                    // Action par défaut ou afficher une page d'erreur
                    header('Location: index.php');
                    exit;
            }
        } else {
            // Action par défaut, par exemple afficher la page d'accueil ou un tableau de bord
            header('Location: index.php');
            exit;
        }
    }

    // Vérifier si l'utilisateur est connecté
    private function isConnected(){
        return isset($_SESSION['user']) ? true : false;
    }

    // Vérifier si l'utilisateur est administrateur
    private function isAdmin(){
        return $this->isConnected() && 
               unserialize($_SESSION['user'])->getRole() == "ADMIN" 
               ? true 
               : false;
    }
}
