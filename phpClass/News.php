<?php
class News
{
    private $idNews;
    private $titolo;
    private $testo;
    private $linkImmagine;
    private $idUser;
    private $categorie;

    public function __construct($idNews, $titolo, $testo, $linkImmagine, $idUser, $categorie)
    {
        $this->idNews = $idNews;
        $this->titolo = $titolo;
        $this->testo = $testo;
        $this->linkImmagine = $linkImmagine;
        $this->idUser = $idUser;
        $this->categorie = $categorie;
    }

 
    public function getIdNews()
    {
        return $this->idNews;
    }

    
    public function getTitolo()
    {
        return $this->titolo;
    }

    
    public function getTesto()
    {
        return $this->testo;
    }

    
    public function getLinkImmagine()
    {
        return $this->linkImmagine;
    }

    
    public function getIdUser()
    {
        return $this->idUser;
    }


    public function getCategorie()
    {
        return $this->categorie;
    }
}
?>