<?php
class articles
{
    private $id;
    private $titre;
    private $contenu;
    private $date_publication;  // Respecte le nom tel qu'il est écrit dans la base de données
    private $categorie;
    private $rate;
    private $count_rates;
    private $image;
    
    // Constructeur pour initialiser les propriétés
    public function __construct($titre, $contenu, $date_publication, $categorie,$rate,$count_rates,$image)
    {
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->date_publication = $date_publication;  // Propriété avec le nom exact du champ
        $this->categorie = $categorie;
        $this->rate = $rate;
        $this->count_rates = $count_rates;
        $this->image = $image;
    }
    // Getters pour accéder aux propriétés
    function getId()
    {
        return $this->id;
    }
    function getTitre()
    {
        return $this->titre;
    }
    function getContenu()
    {
        return $this->contenu;
    }
    function getdate_publication()
    {
        return $this->date_publication;  // Retourne la date de publication
    }
    function getCategorie()
    {
        return $this->categorie;
    }
    function getRate()
    {
        return $this->rate;
    }
    function getCountRates()
    {
        return $this->count_rates;
    }
    function getImage()
    {
        return $this->image;
    }
    // Setters pour modifier les propriétés
    function setTitre(string $titre)
    {
        $this->titre = $titre;
    }
    function setContenu(string $contenu)
    {
        $this->contenu = $contenu;
    }
    function setdate_publication(DateTime $date_publication)
    {
        $this->date_publication = $date_publication;
    }
    function setCategorie(string $categorie)
    {
        $this->categorie = $categorie;
    }
    function setRate(string $rate)
    {
        $this->rate = $rate;
    }
    function setCountRates(string $count_rates)
    {
        $this->count_rates = $count_rates;
    }
    function setImage(string $image)
    {
        $this->image = $image;
    }
}
?>