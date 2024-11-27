<?php

class Commentaire {
    private $idComment;
    private $commentaire;
    private $dateCommantaire;
    private $note;
    private $idVehicule;
    private $idPersonne;

    public function __construct($idComment, $commentaire, $dateCommantaire, $note, $idVehicule, $idPersonne) {
        $this->idComment = $idComment;
        $this->commentaire = $commentaire;
        $this->dateCommantaire = $dateCommantaire;
        $this->note = $note;
        $this->idVehicule = $idVehicule;
        $this->idPersonne = $idPersonne;
    }


    public function getIdComment() {
        return $this->idComment;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    public function getDateCommantaire() {
        return $this->dateCommantaire;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }

    public function getIdVehicule() {
        return $this->idVehicule;
    }

    public function setIdVehicule($idVehicule) {
        $this->idVehicule = $idVehicule;
    }

    public function getIdPersonne() {
        return $this->idPersonne;
    }

    public function setIdPersonne($idPersonne) {
        $this->idPersonne = $idPersonne;
    }
}
?>
