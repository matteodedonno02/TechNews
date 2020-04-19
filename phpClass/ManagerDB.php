<?php
include "User.php";
include "Categoria.php";
include "News.php";
include "Commento.php";
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
        $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%Y/%m/%d') as dataFormattata FROM news ORDER BY idNews DESC LIMIT 3";
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


            array_push($listaUltimeNews, new News($row["idNews"], $row["titolo"], $row["testo"], $row["dataFormattata"], $row["linkImmagine"], $row["idUser"], $categorie));
        }


        return $listaUltimeNews;
    }


    public function getNews($ricerca)
    {
        $listaNews = array();
        if($ricerca != "")
        {
            $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%Y/%m/%d') as dataFormattata FROM news WHERE LOWER(titolo) LIKE '%" . $ricerca . "%' OR LOWER(testo) LIKE '%" . $ricerca . "%' ORDER BY idNews DESC";
        }
        else
        {
            $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%Y/%m/%d') as dataFormattata FROM news ORDER BY idNews DESC";
        }
        
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


            array_push($listaNews, new News($row["idNews"], $row["titolo"], $row["testo"], $row["dataFormattata"], $row["linkImmagine"], $row["idUser"], $categorie));
        }


        return $listaNews;
    }


    public function getNewsDaId($id)
    {
        if(is_numeric($id))
        {
            $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%Y/%m/%d') as dataFormattata FROM news n INNER JOIN users u ON n.idUser = u.idUser WHERE n.idNews = " . $id;
            $result = $this->conn->query($query);
            if(mysqli_num_rows($result) == 0)
            {
                return array("", "");
            }


            while($row = $result->fetch_assoc())
            {
                $categorie = array();
                $query = "SELECT * FROM (news n INNER JOIN appartengono a ON n.idNews = a.idNews) INNER JOIN categorie c ON c.idCategoria = a.idCategoria WHERE n.idNews = " . $row["idNews"];
                $result2 = $this->conn->query($query);
                while($row2 = $result2->fetch_assoc())
                {
                    array_push($categorie, new Categoria($row2["idCategoria"], $row2["nomeCategoria"]));
                }

                return array(
                    new News($row["idNews"], $row["titolo"], $row["testo"], $row["dataFormattata"], $row["linkImmagine"], $row["idUser"], $categorie),
                    new User($row["idUser"], $row["nome"], $row["cognome"], $row["linkFoto"], $row["email"], $row["password"], $row["level"], $row["aut"])
                );
            }
        }


        return array("", "");
    }


    public function getNewsDaCategoria($id)
    {
        $categoria = "";
        $listaNewsDaCategoria = array();
        
        if(is_numeric($id))
        {
            $query = "SELECT nomeCategoria FROM categorie WHERE idCategoria = " . $id;
            $result = $this->conn->query($query);
            while($row = $result->fetch_assoc())
            {
                $categoria = $row["nomeCategoria"];
            }

            $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%Y/%m/%d') as dataFormattata FROM (news n INNER JOIN appartengono a ON n.idNews = a.idNews) INNER JOIN categorie c ON c.idCategoria = a.idCategoria WHERE c.idCategoria = " . $id;
            $result = $this->conn->query($query);
            while($row = $result->fetch_assoc())
            {
                array_push($listaNewsDaCategoria, new News($row["idNews"], $row["titolo"], $row["testo"], $row["dataFormattata"], $row["linkImmagine"], $row["idUser"], null));
            }
        }


        return array($categoria, $listaNewsDaCategoria);
    }


    public function getNewsDaAutore($id)
    {
        $autore = "";
        $listaNewsdaAutore = array();


        if(is_numeric($id))
        {
            $query = "SELECT * FROM users WHERE idUser = " . $id;
            $result = $this->conn->query($query);
            while($row = $result->fetch_assoc())
            {
                $autore = new User($row["idUser"], $row["nome"], $row["cognome"], $row["linkFoto"], $row["email"], $row["password"], $row["level"], $row["aut"]);
            }


            
            $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%Y/%m/%d') as dataFormattata FROM users u INNER JOIN news n ON u.idUser = n.idUser WHERE u.idUser = " . $id;
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
            
                array_push($listaNewsdaAutore, new News($row["idNews"], $row["titolo"], $row["testo"], $row["dataFormattata"], $row["linkImmagine"], $row["idUser"], $categorie));
            }
        }


        return array($autore, $listaNewsdaAutore);
    }


    public function getAutori()
    {
        $listaAutori = array();
        $query = "SELECT * FROM users WHERE level = 2";
        $result = $this->conn->query($query);
        while($row = $result->fetch_assoc())
        {
            array_push($listaAutori, new User($row["idUser"], $row["nome"], $row["cognome"], $row["linkFoto"], $row["email"], $row["password"], $row["level"], $row["aut"]));
        }


        return $listaAutori;
    }


    public function getCommenti($idNews)
    {
        $listaCommenti = array();
        $query = "SELECT * FROM commenti c INNER JOIN users u ON c.idUser = u.idUser WHERE c.idNews = " . $idNews;
        $result = $this->conn->query($query);
        while($row = $result->fetch_assoc())
        {
            array_push($listaCommenti, new Commento($row["idCommento"], $row["testo"], new User($row["idUser"], $row["nome"], $row["cognome"], $row["linkFoto"], $row["email"], $row["password"], $row["level"], $row["aut"])));
        }


        return $listaCommenti;
    }


    public function aggiungiCommento($testo, $idUser, $idNews)
    {
        $query = "INSERT INTO commenti VALUES(0, '" . $testo ."', " . $idUser . ", " . $idNews .")";
        $this->conn->query($query);
    }
}
?>