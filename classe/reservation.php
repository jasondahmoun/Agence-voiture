<?php

class Reservation {
    private $idReservation;
    private $dateReservation;
    private $dateDebut;
    private $dateFin;
    private $idVehicule;
    private $idPersonne;

    public function __construct($idReservation, $dateDebut, $dateFin, $idVehicule, $idPersonne, $dateReservation = null) {
        $this->idReservation = $idReservation;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->idVehicule = $idVehicule;
        $this->idPersonne = $idPersonne;
        $this->dateReservation = $dateReservation ?? date("Y-m-d H:i:s");
    }


    public function getIdReservation() {
        return $this->idReservation;
    }

    public function getDateReservation() {
        return $this->dateReservation;
    }

    public function getDateDebut() {
        return $this->dateDebut;
    }

    public function setDateDebut($dateDebut) {
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin() {
        return $this->dateFin;
    }

    public function setDateFin($dateFin) {
        $this->dateFin = $dateFin;
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
