<?php
class User
{
    private $id;
    private $nome;
    private $cognome;
    private $linkFoto;
    private $email;
    private $password;
    private $level;
    private $aut;


    public function __construct($id, $nome, $cognome, $linkFoto, $email, $password, $level, $aut) 
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->linkFoto = $linkFoto;
        $this->email = $email;
        $this->password = $password;
        $this->level = $level;
        $this->aut = $aut;
    }

    
    public function getId()
    {
        return $this->id;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function getCognome() 
    {
        return $this->cognome;
    }


    public function getLinkFoto()
    {
        return $this->linkFoto;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function getPassword() 
    {
        return $this->password;
    }

    public function getLevel() 
    {
        return $this->level;
    }

    public function getAut() 
    {
        return $this->aut;
    }

    public function setId($id): void 
    {
        $this->id = $id;
    }

    public function setNome($nome): void 
    {
        $this->nome = $nome;
    }

    public function setCognome($cognome): void 
    {
        $this->cognome = $cognome;
    }

    public function setEmail($email): void 
    {
        $this->email = $email;
    }

    public function setPassword($password): void 
    {
        $this->password = $password;
    }

    public function setLevel($level): void 
    {
        $this->level = $level;
    }

    public function setAut($aut): void 
    {
        $this->aut = $aut;
    }
    
    
    
    public function __toString() 
    {
        return $this->id . " " . $this->nome . " " . $this->cognome;
    }

    
    public function setLinkFoto($linkFoto)
    {
        $this->linkFoto = $linkFoto;

        return $this;
    }
}
?>