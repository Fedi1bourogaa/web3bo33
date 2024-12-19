<?php
class Produits
{
    private ?int $produit_id = null;
    private ?string $nom = null;
    private ?string $description = null;
    private ?float $prix = null;
    private ?int $stock = null;
    private ?DateTime $date_ajout = null;
    private ?string $image = null;
    private ?int $categorie_id = null ;

    public function __construct(String $nom, String $description, float $prix, int $stock, DateTime $date_ajout, ?string $image ,?int $categorie_id)
    {
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->stock = $stock;
        $this->date_ajout = $date_ajout;
        $this->image = $image;
        $this->categorie_id = $categorie_id;
    }

    public function getProduitId(): ?int
    {
        return $this->produit_id;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getPrix(): ?float
    {
        return $this->prix;
    }
    public function getStock(): ?int
    {
        return $this->stock;
    }
    public function getDateAjout(): ?DateTime
    {
        return $this->date_ajout;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }
    public function getCategorieId(): ?int
    {
        return $this->categorie_id;
    }
    public function setProduitId(int $produit_id): void
    {
        $this->produit_id = $produit_id;
    }
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }
    public function setDateAjout(DateTime $date_ajout): void
    {
        $this->date_ajout = $date_ajout;
    }
    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    public function setCategorieId(int $categorie_id): void
    {
        $this->categorie_id = $categorie_id;
    }
}
