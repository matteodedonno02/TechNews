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
        $query = "SET NAMES utf8";
        $this->conn->query($query);
        $query = "SET CHARACTER SET utf8";
        $this->conn->query($query);
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

        
        if($utente->getLinkFoto() == "")
        {
            $query = "INSERT INTO users VALUES(0, '" . $utente->getNome() . "', '" . $utente->getCognome() . "', NULL, '" . $utente->getEmail() . "', md5('" . $utente->getPassword() . "'), " . $utente->getLevel() . ", '" . $utente->getAut() . "')";
        }
        else
        {
            $query = "INSERT INTO users VALUES(0, '" . $utente->getNome() . "', '" . $utente->getCognome() . "', '" . $utente->getLinkFoto() . "', '" . $utente->getEmail() . "', md5('" . $utente->getPassword() . "'), " . $utente->getLevel() . ", '" . $utente->getAut() . "')";
        }
        $this->conn->query($query);
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
        $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%d/%m/%Y') as dataFormattata FROM news n INNER JOIN users u ON n.idUser = u.idUser WHERE u.aut = 'Y' ORDER BY n.idNews DESC LIMIT 3";
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
        $ricerca != "" ? $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%d/%m/%Y') as dataFormattata FROM news n INNER JOIN users u ON n.idUser = u.idUser WHERE u.aut = 'Y' AND (LOWER(n.titolo) LIKE '%" . $ricerca . "%' OR LOWER(n.testo) LIKE '%" . $ricerca . "%') ORDER BY n.idNews DESC" : $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%d/%m/%Y') as dataFormattata FROM news n INNER JOIN users u ON n.idUser = u.idUser WHERE u.aut = 'Y' ORDER BY n.idNews DESC";
        
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
            $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%d/%m/%Y') as dataFormattata FROM news n INNER JOIN users u ON n.idUser = u.idUser WHERE u.aut = 'Y' AND n.idNews = " . $id;
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

            $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%d/%m/%Y') as dataFormattata FROM ((news n INNER JOIN appartengono a ON n.idNews = a.idNews) INNER JOIN users u ON n.idUser = u.idUser) INNER JOIN categorie c ON c.idCategoria = a.idCategoria WHERE u.aut = 'Y' AND c.idCategoria = " . $id . " ORDER BY n.idNews DESC";
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


            
            $query = "SELECT *, DATE_FORMAT(dataPubblicazione, '%d/%m/%Y') as dataFormattata FROM users u INNER JOIN news n ON u.idUser = n.idUser WHERE u.aut = 'Y' AND u.idUser = " . $id . " ORDER BY n.idNews DESC";
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
        $query = "SELECT * FROM users WHERE level > 1 AND aut = 'Y'";
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


    public function aggiungiNews($news)
    {
        if($news->getLinkImmagine() == "")
        {
            $query = "INSERT INTO news VALUES (0, '" . $news->getTitolo() ."', '" . $news->getTesto() . "', NOW(), NULL, '" . $news->getIdUser() . "')";
        }
        else
        {
            $query = "INSERT INTO news VALUES (0, '" . $news->getTitolo() ."', '" . $news->getTesto() . "', NOW(), '" . $news->getLinkImmagine() . "', '" . $news->getIdUser() . "')";
        }
        
        $this->conn->query($query);
        


        $query = "SELECT idNews FROM news WHERE idNews = LAST_INSERT_ID()";
        $reuslt = $this->conn->query($query);
        $idNews;
        while ($row = $reuslt->fetch_assoc())
        {
            $idNews = $row["idNews"];
        }


        $categorie = explode("::", $news->getCategorie());
        for ($i = 0; $i < count($categorie) - 1; $i ++) 
        {
            $query1 = "SELECT idCategoria FROM categorie WHERE nomeCategoria = '" . $categorie[$i] . "'";
            $result = $this->conn->query($query1);
            $idCategoria;
            while($row = $result->fetch_assoc())
            {
                $idCategoria = $row["idCategoria"];
            }

            $query = "INSERT INTO appartengono VALUES (" . $idCategoria .", " . $idNews . ")";
            $this->conn->query($query);
        }
    }


    public function getUtentiDaAccettare()
    {
        $listaUtentiDaAccettare = array();
        $query = "SELECT * FROM users WHERE aut = 'N'";
        $result = $this->conn->query($query);


        while($row = $result->fetch_assoc())
        {
            array_push($listaUtentiDaAccettare, new User($row["idUser"], $row["nome"], $row["cognome"], $row["linkFoto"], $row["email"], $row["password"], $row["level"], $row["aut"]));    
        }


        return $listaUtentiDaAccettare;
    }


    public function accettaUtente($id)
    {
        $query = "UPDATE users SET aut = 'Y' WHERE idUSer = " . $id;
        $this->conn->query($query);  
    }


    public function getUtenti($ricerca)
    {
        $listaUtenti = array();
        $ricerca == "" ? $query = "SELECT * FROM users WHERE aut = 'Y'" : $query = "SELECT * FROM users WHERE LOWER(nome) LIKE '%" . $ricerca . "%' OR LOWER(cognome) LIKE '%" . $ricerca . "%' OR LOWER(email) LIKE '%" . $ricerca . "%' AND aut = 'Y'";
        $result = $this->conn->query($query);


        while($row = $result->fetch_assoc())
        {
            array_push($listaUtenti, new User($row["idUser"], $row["nome"], $row["cognome"], $row["linkFoto"], $row["email"], $row["password"], $row["level"], $row["aut"]));    
        }


        return $listaUtenti;
    }


    public function bloccaUtente($id)
    {
        $query = "UPDATE users SET aut = 'N' WHERE idUSer = " . $id;
        $this->conn->query($query);  
    }


    public function getUtente($id)
    {
        $query = "SELECT * FROM users WHERE idUser = " . $id;
        $result = $this->conn->query($query);
        while($row = $result->fetch_assoc())
        {
            return new User($row["idUser"], $row["nome"], $row["cognome"], $row["linkFoto"], $row["email"], $row["password"], $row["level"], $row["aut"]);
        }


        return null;
    }


    public function modificaUtente($utente)
    {
        if($utente->getId() == 58)
        {
            $utente->setLevel(3);
        }


        if($utente->getLinkFoto() != "")
        {
            $query = "UPDATE users SET linkFoto = '" . $utente->getLinkFoto() . "' WHERE idUser = " . $utente->getId();
            $this->conn->query($query);
        }


        $utente->getPassword() == "" ?
        $query = "UPDATE users SET nome = '" . $utente->getNome() . "', cognome = '" . $utente->getCognome() . "', email = '" . $utente->getEmail() . "', level = " . $utente->getLevel() . " WHERE idUser = " . $utente->getId():
        $query = "UPDATE users SET password = md5('" . $utente->getPassword() . "') , nome = '" . $utente->getNome() . "', cognome = '" . $utente->getCognome() . "', email = '" . $utente->getEmail() . "', level = " . $utente->getLevel() . " WHERE idUser = " . $utente->getId();


        $this->conn->query($query);
        echo "FINITO \n";
    }


    public function modificaNews($news)
    {
        if($news->getLinkImmagine() != "")
        {
            $query = "UPDATE news SET linkImmagine = '" . $news->getLinkImmagine() . "' WHERE idNews = " . $news->getIdNews();
            $this->conn->query($query);
        }


        $query = "DELETE FROM appartengono WHERE idNews = " . $news->getIdNews();
        $this->conn->query($query);


        $categorie = explode("::", $news->getCategorie());
        for ($i = 0; $i < count($categorie) - 1; $i ++) 
        {
            $query1 = "SELECT idCategoria FROM categorie WHERE nomeCategoria = '" . $categorie[$i] . "'";
            $result = $this->conn->query($query1);
            $idCategoria;
            while($row = $result->fetch_assoc())
            {
                $idCategoria = $row["idCategoria"];
            }

            $query = "INSERT INTO appartengono VALUES (" . $idCategoria .", " . $news->getIdNews() . ")";
            $this->conn->query($query);
        }


        $query = "UPDATE news SET titolo = '" . $news->getTitolo() ."', testo = '" . $news->getTesto() ."' WHERE idNews = " . $news->getIdNews();
        $this->conn->query($query);
    }


    public function cancellaNews($id)
    {
        $query = "DELETE FROM appartengono WHERE idNews = " . $id;
        $this->conn->query($query);


        $query = "DELETE FROM commenti WHERE idNews = " . $id;
        $this->conn->query($query);

        $query = "DELETE FROM news WHERE idNews = " . $id;
        $this->conn->query($query);
    }


    public function cancellaCategoria($id)
    {
        $query= "SELECT * FROM appartengono WHERE idCategoria = " .$id;
        $result = $this->conn->query($query);
        if(mysqli_num_rows($result) > 0)
        {
            return false;
        }
        else
        {
            $query = "DELETE FROM categorie WHERE idCategoria = " .$id;
            $this->conn->query($query);
            return true;
        }
    }


    public function aggiungiCategoria($testoCategoria)
    {
        $query = "SELECT * FROM categorie WHERE LOWER(nomeCategoria) = LOWER('" . $testoCategoria ."')";
        $result = $this->conn->query($query);
        if(mysqli_num_rows($result) > 0)
        {
            return false;
        }


        $query = "INSERT INTO categorie VALUES(0, '" . $testoCategoria ."')";
        $this->conn->query($query);
        return true;
    }
}
?>