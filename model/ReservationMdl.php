<?php

class ReservationMdl extends ModelGenerique {

    public function addReservation(Reservation $reservation){
        $query = "INSERT INTO reservation (date_debut, date_fin, id_vehicule, id_personne) 
                  VALUES (:date_debut, :date_fin, :id_vehicule, :id_personne)";
        
        $params = [
            "date_debut" => $reservation->getDateDebut(),
            "date_fin" => $reservation->getDateFin(),
            "id_vehicule" => $reservation->getIdVehicule(),
            "id_personne" => $reservation->getIdPersonne()
        ];

        $this->executeReq($query, $params);
        $reservation->$this->idReservation = $this->getLastInsertId();
        return $reservation;
    }

    public function updateReservation(Reservation $reservation){
        $query = "UPDATE reservation SET date_debut = :date_debut, date_fin = :date_fin, 
                  id_vehicule = :id_vehicule WHERE id_reservation = :id_reservation";

        $params = [
            "date_debut" => $reservation->getDateDebut(),
            "date_fin" => $reservation->getDateFin(),
            "id_vehicule" => $reservation->getIdVehicule(),
            "id_reservation" => $reservation->getIdReservation()
        ];

        $this->executeReq($query, $params);
    }

    public function deleteReservation(int $id){
        $query = "DELETE FROM reservation WHERE id_reservation = :id";
        $this->executeReq($query, ["id" => $id]);
    }

    public function getReservationById(int $id){
        $res = $this->executeReq("SELECT * FROM reservation WHERE id_reservation = :id", ["id" => $id]);
        $data = $res->fetch();
        if($data){
            return new Reservation(
                $data['id_reservation'],
                $data['date_reservation'],
                $data['date_debut'],
                $data['date_fin'],
                $data['id_vehicule'],
                $data['id_personne']
            );
        }
        return null;
    }

    public function getReservationsByUser(int $idPersonne){
        $res = $this->executeReq("SELECT * FROM reservation WHERE id_personne = :id_personne", ["id_personne" => $idPersonne]);
        $reservations = [];
        while($data = $res->fetch()){
            $reservations[] = new Reservation(
                $data['id_reservation'],
                $data['date_reservation'],
                $data['date_debut'],
                $data['date_fin'],
                $data['id_vehicule'],
                $data['id_personne']
            );
        }
        return $reservations;
    }

    public function getAllReservations(){
        $res = $this->executeReq("SELECT * FROM reservation");
        $reservations = [];
        while($data = $res->fetch()){
            $reservations[] = new Reservation(
                $data['id_reservation'],
                $data['date_reservation'],
                $data['date_debut'],
                $data['date_fin'],
                $data['id_vehicule'],
                $data['id_personne']
            );
        }
        return $reservations;
    }

    public function hasUserRentedVehicule(int $idPersonne, int $idVehicule){
        $query = "SELECT COUNT(*) FROM reservation WHERE id_personne = :id_personne AND id_vehicule = :id_vehicule";
        $params = [
            "id_personne" => $idPersonne,
            "id_vehicule" => $idVehicule
        ];
        $res = $this->executeReq($query, $params);
        $count = $res->fetchColumn();
        return $count > 0;
    }

    public function calculateTotalPrice(Reservation $reservation, VehiculeMdl $vehiculeMdl){
        $vehicule = $vehiculeMdl->getVehiculeById($reservation->getIdVehicule());
        if(!$vehicule){
            return 0;
        }
        $prixJournalier = $vehicule->getPrixJournalier();
        $dateDebut = new DateTime($reservation->getDateDebut());
        $dateFin = new DateTime($reservation->getDateFin());
        $interval = $dateDebut->diff($dateFin);
        $jours = $interval->days + 1; 
        return $prixJournalier * $jours;
    }
}
