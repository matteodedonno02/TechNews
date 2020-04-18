<?php
include "User.php";
include "Categoria.php";
include "News.php";
class ManagerDB
{
    private $conn;


    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "news");
    }


    public function login($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = '" . $email . "' AND password = md5('" . $password . "')";
        $result = $this->conn->query($query);
        while($row = $result->fetch_assoc())
        {
            return new User($row["idUser"], $row["nome"], $row["cognome"], $row["linkFoto"], $row["email"], $row["password"], $row["level"], $row["aut"]);
        }


        return null;
    }


    public function registrazione($utente)
    {
        $query = "SELECT * FROM users WHERE email = '" . $utente->getEmail() . "'";
        $result = $this->conn->query($query);
        if(mysqli_num_rows($result) == 1)
        {
            return false;
        }

        
        $query = "INSERT INTO users VALUES(0, '" . $utente->getNome() . "', '" . $utente->getCognome() . "', '" . $utente->getLinkFoto() . "', '" . $utente->getEmail() . "', md5('" . $utente->getPassword() . "'), " . $utente->getLevel() . ", '" . $utente->getAut() . "')";
        $this->conn->query($query);
        if($utente->getLinkFoto() == "")
        {
            $query = "UPDATE users SET linkFoto = NULL";
            $this->conn->query($query);
        }
        return true;
    }


    public function getCategorie()
    {
        $listaCategorie = array();
        $query = "SELECT * FROM categorie";
        $result = $this->conn->query($query);
        while($row = $result->fetch_assoc())
        {
            array_push($listaCategorie, new Categoria($row["idCategoria"], $row["nomeCategoria"]));
        }


        return $listaCategorie;
    }


    public function getUltimeNews()
    {
        $listaUltimeNews = array();
        $query = "SELECT * FROM news ORDER BY idNews DESC LIMIT 3";
        $result = $this->conn->query($query);
        while($row = $result->fetch_assoc())
        {
            $categorie = array();
            $query = "SELECT * FROM (news n INNER JOIN appartengono a ON n.idNews = a.idNews) INNER JOIN categorie c ON c.idCategoria = a.idCategoria WHERE n.idNews = " . $row["idNews"];
            $result2 = $this->conn->query($query);
            while($row2 = $result2->fetch_assoc())
            {
                array_push($categorie, new Categoria($row2["idCategoria"], $row2["nomeCategoria"]));
            }


            array_push($listaUltimeNews, new News($row["idNews"], $row["titolo"], $row["testo"], $row["linkImmagine"], $row["idUser"], $categorie));
        }


        return $listaUltimeNews;
    }
}
?>