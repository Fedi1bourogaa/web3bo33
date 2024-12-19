<?php

class Users {
    private ?int $id;
    private ?string $nom;
    private ?string $prenom;
    private ?string $email;
    private ?string $mot_de_passe;
    private ?string $role;
    private ?string $entreprise;
    private ?string $secteur;
    private ?string $site_web;
    private ?string $telephone;
    private ?string $adresse;
    private ?string $specialite;
    private ?string $langues;
    private ?string $photo;
    

    // Constructor
    public function __construct(
        ?int $id = null,
        ?string $nom = null,
        ?string $prenom = null,
        ?string $email = null,
        ?string $mot_de_passe = null,
        ?string $role = null,
        ?string $entreprise = null,
        ?string $secteur = null,
        ?string $site_web = null,
        ?string $telephone = null,
        ?string $adresse = null,
        ?string $specialite = null,
        ?string $langues = null,
        ?string $photo = null,
        ?DateTime $date_inscription = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->role = $role;
        $this->entreprise = $entreprise;
        $this->secteur = $secteur;
        $this->site_web = $site_web;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->specialite = $specialite;
        $this->langues = $langues;
        $this->photo = $photo;
        $this->date_inscription = $date_inscription;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(?string $nom): void {
        $this->nom = $nom;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void {
        $this->prenom = $prenom;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    public function getMotDePasse(): ?string {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(?string $mot_de_passe): void {
        $this->mot_de_passe = $mot_de_passe;
    }

    public function getRole(): ?string {
        return $this->role;
    }

    public function setRole(?string $role): void {
        $this->role = $role;
    }

    public function getEntreprise(): ?string {
        return $this->entreprise;
    }

    public function setEntreprise(?string $entreprise): void {
        $this->entreprise = $entreprise;
    }

    public function getSecteur(): ?string {
        return $this->secteur;
    }

    public function setSecteur(?string $secteur): void {
        $this->secteur = $secteur;
    }

    public function getSiteWeb(): ?string {
        return $this->site_web;
    }

    public function setSiteWeb(?string $site_web): void {
        $this->site_web = $site_web;
    }

    public function getTelephone(): ?string {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void {
        $this->telephone = $telephone;
    }

    public function getAdresse(): ?string {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): void {
        $this->adresse = $adresse;
    }

    public function getSpecialite(): ?string {
        return $this->specialite;
    }

    public function setSpecialite(?string $specialite): void {
        $this->specialite = $specialite;
    }

    public function getLangues(): ?string {
        return $this->langues;
    }

    public function setLangues(?string $langues): void {
        $this->langues = $langues;
    }

    public function getPhoto(): ?string {
        return $this->photo;
    }

    public function setPhoto(?string $photo): void {
        $this->photo = $photo;
    }

    
}

?>




































