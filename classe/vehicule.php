<?php

class Vehicule {
    private $idVehicule;
    private $marque;
    private $modele;
    private $matricule;
    private $prixJournalier;
    private $typeVehicule;
    private $statutDispo;
    private $photo;

    public function __construct($idVehicule, $marque, $modele, $matricule, $prixJournalier, $typeVehicule, $statutDispo, $photo) {
        $this->idVehicule = $idVehicule;
        $this->marque = $marque;
        $this->modele = $modele;
        $this->matricule = $matricule;
        $this->prixJournalier = $prixJournalier;
        $this->typeVehicule = $typeVehicule;
        $this->statutDispo = $statutDispo;
        $this->photo = $photo;
    }

    
    public function getIdVehicule() {
        return $this->idVehicule;
    }

    public function getMarque() {
        return $this->marque;
    }

    public function setMarque($marque) {
        $this->marque = $marque;
    }

    public function getModele() {
        return $this->modele;
    }

    public function setModele($modele) {
        $this->modele = $modele;
    }

    public function getMatricule() {
        return $this->matricule;
    }

    public function setMatricule($matricule) {
        $this->matricule = $matricule;
    }

    public function getPrixJournalier() {
        return $this->prixJournalier;
    }

    public function setPrixJournalier($prixJournalier) {
        $this->prixJournalier = $prixJournalier;
    }

    public function getTypeVehicule() {
        return $this->typeVehicule;
    }

    public function setTypeVehicule($typeVehicule) {
        $this->typeVehicule = $typeVehicule;
    }

    public function getStatutDispo() {
        return $this->statutDispo;
    }

    public function setStatutDispo($statutDispo) {
        $this->statutDispo = $statutDispo;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }
}
?>
