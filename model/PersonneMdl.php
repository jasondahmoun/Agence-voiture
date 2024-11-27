<?php

class PersonneMdl extends ModelGenerique {

    public function addPersonne(Personne $personne){
        $query = "INSERT INTO personne (civilite, prenom, nom, login, email, tel, mdp, role) 
                  VALUES (:civilite, :prenom, :nom, :login, :email, :tel, :mdp, :role)";
        
        $params = [
            "civilite" => $personne->getCivilite(),
            "prenom" => $personne->getPrenom(),
            "nom" => $personne->getNom(),
            "login" => $personne->getLogin(),
            "email" => $personne->getEmail(),
            "tel" => $personne->getTel(),
            "mdp" => $personne->getMdp(),
            "role" => $personne->getRole()
        ];

        $this->executeReq($query, $params);
        $personne->$this->idPersonne = $this->getLastInsertId();
        return $personne;
    }

    public function updatePersonne(Personne $personne){
        $query = "UPDATE personne SET civilite = :civilite, prenom = :prenom, nom = :nom, 
                  login = :login, email = :email, tel = :tel, role = :role";

        if(!empty($personne->getMdp())){
            $query .= ", mdp = :mdp";
        }

        $query .= " WHERE id_personne = :id_personne";

        $params = [
            "civilite" => $personne->getCivilite(),
            "prenom" => $personne->getPrenom(),
            "nom" => $personne->getNom(),
            "login" => $personne->getLogin(),
            "email" => $personne->getEmail(),
            "tel" => $personne->getTel(),
            "role" => $personne->getRole(),
            "id_personne" => $personne->getIdPersonne()
        ];

        if(!empty($personne->getMdp())){
            $params["mdp"] = $personne->getMdp();
        }

        $this->executeReq($query, $params);
    }

    // Supprimer un utilisateur
    public function deletePersonne(int $id){
        $query = "DELETE FROM personne WHERE id_personne = :id";
        $this->executeReq($query, ["id" => $id]);
    }

    // Récupérer un utilisateur par ID
    public function getPersonneById(int $id){
        $res = $this->executeReq("SELECT * FROM personne WHERE id_personne = :id", ["id" => $id]);
        $data = $res->fetch();
        if($data){
            return new Personne(
                $data['id_personne'],
                $data['civilite'],
                $data['prenom'],
                $data['nom'],
                $data['login'],
                $data['email'],
                $data['tel'],
                $data['mdp'],
                $data['role'],
                $data['date_inscription']
            );
        }
        return null;
    }

    public function getPersonneByLogin($login){
        $res = $this->executeReq("SELECT * FROM personne WHERE login = :login", ["login" => $login]);
        $data = $res->fetch();
        if($data){
            return new Personne(
                $data['id_personne'],
                $data['civilite'],
                $data['prenom'],
                $data['nom'],
                $data['login'],
                $data['email'],
                $data['tel'],
                $data['mdp'],
                $data['role'],
                $data['date_inscription']
            );
        }
        return null;
    }

    public function getAllPersonnes(){
        $res = $this->executeReq("SELECT * FROM personne");
        $personnes = [];
        while($data = $res->fetch()){
            $personnes[] = new Personne(
                $data['id_personne'],
                $data['civilite'],
                $data['prenom'],
                $data['nom'],
                $data['login'],
                $data['email'],
                $data['tel'],
                $data['mdp'],
                $data['role'],
                $data['date_inscription']
            );
        }
        return $personnes;
    }
}
