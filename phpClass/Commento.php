<?php
class Commento
{
    private $id;
    private $testo;
    private $user;


    public function __construct($id, $testo, $user)
    {
        $this->id = $id;
        $this->testo = $testo;
        $this->user = $user;
    }


    public function getId()
    {
        return $this->id;
    }

    
    public function getTesto()
    {
        return $this->testo;
    }

    
    public function getUser()
    {
        return $this->user;
    }
}
?>