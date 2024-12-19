<?php

class Commande {
    // Propriétés de la commande
    private $id_commande;
    private $nom_prenom;
    private $num_tlf;
    private $location;
    private $prixTot;
    private $id_produit;
    private $user_id;


    // Constructeur
    public function __construct(string $nom_prenom, string $num_tlf, string $location, int $id_produit, float $prixTot,) {
        $this->nom_prenom = $nom_prenom;
        $this->num_tlf = $num_tlf;
        $this->location = $location;
        $this->id_produit = $id_produit;
        $this->prixTot = $prixTot;
    }

    // Getters
    public function getIdCommande(): int {
        return $this->id_commande;
    }

    public function getNomPrenom(): string {
        return $this->nom_prenom;
    }

    public function getNumTlf(): string {
        return $this->num_tlf;
    }

    public function getLocation(): string {
        return $this->location;
    }

    public function getPrixTot(): float {
        return $this->prixTot;
    }

    public function getIdProduit(): int {
        return $this->id_produit;
    }
    
}
