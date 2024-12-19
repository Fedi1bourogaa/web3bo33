<?php
class commentaires {
    // Attributs
    private $id;
    private $nom;
    private $contenu_comm;
    private $date_pub;
    private $id_article;
    // Constructeur
    public function __construct($nom, $contenu_comm, $date_pub,$id_article) {
        $this->nom = $nom;
        $this->contenu_comm = $contenu_comm;
        $this->date_pub = $date_pub;
        $this->id_article = $id_article;
    }
    // Getters
     
    function getNom() {
        return $this->nom;
    }
    function getContenu_Comm(){
        return $this->contenu_comm;
    }
    function getDate_pub() {
        return $this->date_pub;
    }
    function getIdArticle() {
        return $this->id_article;
    }
    // Setters
    public function setNom(string $nom) {
        $this->nom = $nom;
    }
    public function setContenu_Comm(string $contenu_comm) {
        $this->contenu_comm = $contenu_comm;
    }
    public function setDate_pub(DateTime $date_pub) {
        $this->date_pub = $date_pub;
    }
    public function setIdArticle(DateTime $id_article) {
        $this->id_article = $id_article;
    }
}
?>