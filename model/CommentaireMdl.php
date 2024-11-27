<?php

class CommentaireMdl extends ModelGenerique {

    public function addCommentaire(Commentaire $commentaire){
        $query = "INSERT INTO commentaire (commentaire, note, id_vehicule, id_personne) 
                  VALUES (:commentaire, :note, :id_vehicule, :id_personne)";
        
        $params = [
            "commentaire" => $commentaire->getCommentaire(),
            "note" => $commentaire->getNote(),
            "id_vehicule" => $commentaire->getIdVehicule(),
            "id_personne" => $commentaire->getIdPersonne()
        ];

        $this->executeReq($query, $params);
        $commentaire->$this->idComment = $this->getLastInsertId();
        return $commentaire;
    }

    public function getCommentairesByVehicule(int $idVehicule){
        $res = $this->executeReq("SELECT commentaire.*, personne.prenom, personne.nom FROM commentaire 
                                   JOIN personne ON commentaire.id_personne = personne.id_personne 
                                   WHERE commentaire.id_vehicule = :id_vehicule ORDER BY dateCommantaire DESC", 
                                   ["id_vehicule" => $idVehicule]);
        $commentaires = [];
        while($data = $res->fetch()){
            $commentaires[] = [
                "commentaire" => $data['commentaire'],
                "dateCommantaire" => $data['dateCommantaire'],
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

    public function hasUserCommented(int $idPersonne, int $idVehicule){
        $res = $this->executeReq("SELECT COUNT(*) FROM commentaire WHERE id_personne = :id_personne AND id_vehicule = :id_vehicule", 
                                 ["id_personne" => $idPersonne, "id_vehicule" => $idVehicule]);
        $count = $res->fetchColumn();
        return $count > 0;
    }
}
?>
