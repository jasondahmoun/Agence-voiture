<?php

class Personne {
    private $idPersonne;
    private $civilite;
    private $prenom;
    private $nom;
    private $login;
    private $email;
    private $role;
    private $dateInscription;
    private $tel;
    private $mdp;

    public function __construct($idPersonne, $civilite, $prenom, $nom, $login, $email, $tel, $mdp, $role = "CLIENT", $dateInscription = null) {
        $this->idPersonne = $idPersonne;
        $this->civilite = $civilite;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->login = $login;
        $this->email = $email;
        $this->tel = $tel;
        $this->mdp = $mdp;
        $this->role = $role;
        $this->dateInscription = $dateInscription ?? date("Y-m-d H:i:s");
    }

    public function getIdPersonne() {
        return $this->idPersonne;
    }

    public function getCivilite() {
        return $this->civilite;
    }

    public function setCivilite($civilite) {
        $this->civilite = $civilite;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getDateInscription() {
        return $this->dateInscription;
    }

    public function getTel() {
        return $this->tel;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function setMdp($mdp) {
        $this->mdp = password_hash($mdp, PASSWORD_BCRYPT);
    }
}
