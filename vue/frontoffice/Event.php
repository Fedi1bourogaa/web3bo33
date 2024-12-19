<?php
// declarer les atributs
class Event
{
    
    private ?int $id_event = null;
    private ?string $nom_event = null;
    private ?DateTime $date_event = null;
    private ?string $type = null;
    private ?string $image = null;

    public function __construct($id_event = null, $nom, $date, $type, $image)
    {
        $this->id_event = $id_event;
        $this->nom_event = $nom;

        // Vérifiez si $date est une instance de DateTime avant d'assigner
        if ($date instanceof DateTime) {
            $this->date_event = $date;
        } else {
            $this->date_event = new DateTime($date);
        }

        $this->type = $type;
        $this->image = $image;
    }

    // Getter pour $id_event
    public function getIdEvent(): ?int
    {
        return $this->id_event;
    }

    // Setter pour $id_event
    public function setIdEvent(?int $id_event): void
    {
        $this->id_event = $id_event;
    }

    // Getter pour $nom_event
    public function getNomEvent(): ?string
    {
        return $this->nom_event;
    }

    // Setter pour $nom_event
    public function setNomEvent(?string $nom_event): void
    {
        $this->nom_event = $nom_event;
    }

    // Getter pour $date_event
    public function getDateEvent(): ?DateTime
    {
        return $this->date_event;
    }

    // Setter pour $date_event
    public function setDateEvent(?DateTime $date_event): void
    {
        $this->date_event = $date_event;
    }

    // Getter pour $type
    public function getType(): ?string
    {
        return $this->type;
    }

    // Setter pour $type
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    // Getter pour $image
    public function getImage(): ?string
    {
        return $this->image;
    }

    // Setter pour $image
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}
