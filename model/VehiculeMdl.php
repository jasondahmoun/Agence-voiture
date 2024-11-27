<?php

class VehiculeMdl extends ModelGenerique {

    public function addVehicule(Vehicule $vehicule){
        $query = "INSERT INTO vehicule (marque, modele, matricule, prix_journalier, type_vehicule, statut_dispo, photo) 
                  VALUES (:marque, :modele, :matricule, :prix_journalier, :type_vehicule, :statut_dispo, :photo)";
        
        $params = [
            "marque" => $vehicule->getMarque(),
            "modele" => $vehicule->getModele(),
            "matricule" => $vehicule->getMatricule(),
            "prix_journalier" => $vehicule->getPrixJournalier(),
            "type_vehicule" => $vehicule->getTypeVehicule(),
            "statut_dispo" => $vehicule->getStatutDispo(),
            "photo" => $vehicule->getPhoto()
        ];

        $this->executeReq($query, $params);
        $vehicule->$this->idVehicule = $this->getLastInsertId();
        return $vehicule;
    }

    public function updateVehicule(Vehicule $vehicule){
        $query = "UPDATE vehicule SET marque = :marque, modele = :modele, matricule = :matricule, 
                  prix_journalier = :prix_journalier, type_vehicule = :type_vehicule, 
                  statut_dispo = :statut_dispo, photo = :photo 
                  WHERE id_vehicule = :id_vehicule";

        $params = [
            "marque" => $vehicule->getMarque(),
            "modele" => $vehicule->getModele(),
            "matricule" => $vehicule->getMatricule(),
            "prix_journalier" => $vehicule->getPrixJournalier(),
            "type_vehicule" => $vehicule->getTypeVehicule(),
            "statut_dispo" => $vehicule->getStatutDispo(),
            "photo" => $vehicule->getPhoto(),
            "id_vehicule" => $vehicule->getIdVehicule()
        ];

        $this->executeReq($query, $params);
    }

    public function deleteVehicule(int $id){
        $query = "DELETE FROM vehicule WHERE id_vehicule = :id";
        $this->executeReq($query, ["id" => $id]);
    }

    public function getVehiculeById(int $id){
        $res = $this->executeReq("SELECT * FROM vehicule WHERE id_vehicule = :id", ["id" => $id]);
        $data = $res->fetch();
        if($data){
            return new Vehicule(
                $data['id_vehicule'],
                $data['marque'],
                $data['modele'],
                $data['matricule'],
                $data['prix_journalier'],
                $data['type_vehicule'],
                $data['statut_dispo'],
                $data['photo']
            );
        }
        return null;
    }

    public function getAllVehicules($filters = []){
        $query = "SELECT * FROM vehicule WHERE 1=1";
        $params = [];

        if(!empty($filters['marque'])){
            $query .= " AND marque LIKE :marque";
            $params['marque'] = '%' . $filters['marque'] . '%';
        }

        if(!empty($filters['modele'])){
            $query .= " AND modele LIKE :modele";
            $params['modele'] = '%' . $filters['modele'] . '%';
        }

        if(!empty($filters['type_vehicule'])){
            $query .= " AND type_vehicule LIKE :type_vehicule";
            $params['type_vehicule'] = '%' . $filters['type_vehicule'] . '%';
        }

        if(isset($filters['statut_dispo']) && $filters['statut_dispo'] !== ''){
            $query .= " AND statut_dispo = :statut_dispo";
            $params['statut_dispo'] = $filters['statut_dispo'];
        }

        $res = $this->executeReq($query, $params);
        $vehicules = [];
        while($data = $res->fetch()){
            $vehicules[] = new Vehicule(
                $data['id_vehicule'],
                $data['marque'],
                $data['modele'],
                $data['matricule'],
                $data['prix_journalier'],
                $data['type_vehicule'],
                $data['statut_dispo'],
                $data['photo']
            );
        }
        return $vehicules;
    }

    public function getAvailableVehicules($dateDebut, $dateFin){
        $query = "SELECT * FROM vehicule WHERE statut_dispo = 1 
                  AND id_vehicule NOT IN (
                      SELECT id_vehicule FROM reservation 
                      WHERE (date_debut <= :date_fin AND date_fin >= :date_debut)
                  )";
        $params = [
            "date_debut" => $dateDebut,
            "date_fin" => $dateFin
        ];
        $res = $this->executeReq($query, $params);
        $vehicules = [];
        while($data = $res->fetch()){
            $vehicules[] = new Vehicule(
                $data['id_vehicule'],
                $data['marque'],
                $data['modele'],
                $data['matricule'],
                $data['prix_journalier'],
                $data['type_vehicule'],
                $data['statut_dispo'],
                $data['photo']
            );
        }
        return $vehicules;
    }

    public function getCommentairesByVehicule(int $idVehicule){
        $res = $this->executeReq("SELECT commentaire.*, personne.prenom, personne.nom FROM commentaire 
                                   JOIN personne ON commentaire.id_personne = personne.id_personne 
                                   WHERE commentaire.id_vehicule = :id_vehicule ORDER BY datecommenataire DESC", 
                                   ["id_vehicule" => $idVehicule]);
        $commentaires = [];
        while($data = $res->fetch()){
            $commentaires[] = [
                "commentaire" => $data['commentaire'],
                "datecommenataire" => $data['datecommenataire'],
                "note" => $data['note'],
                "prenom" => $data['prenom'],
                "nom" => $data['nom']
            ];
        }
        return $commentaires;
    }

    public function getNoteMoyenne(int $idVehicule){
        $res = $this->executeReq("SELECT AVG(note) as moyenne FROM commentaire WHERE id_vehicule = :id_vehicule", 
                                 ["id_vehicule" => $idVehicule]);
        $data = $res->fetch();
        return $data['moyenne'] ? round($data['moyenne'], 2) : 0;
    }

    public function isVehiculeDisponible(int $idVehicule, string $dateDebut, string $dateFin){
        $query = "SELECT COUNT(*) FROM reservation WHERE id_vehicule = :id_vehicule 
                  AND (
                      (date_debut <= :date_fin AND date_fin >= :date_debut)
                  )";
        $params = [
            "id_vehicule" => $idVehicule,
            "date_debut" => $dateDebut,
            "date_fin" => $dateFin
        ];

        $res = $this->executeReq($query, $params);
        $count = $res->fetchColumn();
        return $count == 0;
    }
}
?>
