<?php
// Déclarer les attributs
class Sponsor
{
    private ?int $id_sponsor = null;
    private ?int $id_eventsponsor = null;
    private ?string $nom = null;
    private ?string $description = null;
    private ?int $phone = null;

    // Constructeur
    public function __construct($id_sponsor = null, $id_eventsponsor = null, $nom, $description, $phone)
    {
        $this->id_sponsor = $id_sponsor;
        $this->id_eventsponsor = $id_eventsponsor;
        $this->nom = $nom;
        $this->description = $description;
        $this->phone = $phone;
    }

    // Getter pour $id_sponsor
    public function getIdSponsor(): ?int
    {
        return $this->id_sponsor;
    }

    // Setter pour $id_sponsor
    public function setIdSponsor(?int $id_sponsor): void
    {
        $this->id_sponsor = $id_sponsor;
    }

    // Getter pour $id_eventsponsor
    public function getIdEventSponsor(): ?int
    {
        return $this->id_eventsponsor;
    }

    // Setter pour $id_eventsponsor
    public function setIdEventSponsor(?int $id_eventsponsor): void
    {
        $this->id_eventsponsor = $id_eventsponsor;
    }

    // Getter pour $nom
    public function getNom(): ?string
    {
        return $this->nom;
    }

    // Setter pour $nom
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    // Getter pour $description
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Setter pour $description
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    // Getter pour $phone
    public function getPhone(): ?int
    {
        return $this->phone;
    }

    // Setter pour $phone
    public function setPhone(?int $phone): void
    {
        $this->phone = $phone;
    }
}
?>
