<?php
include "User.php";
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


    public function register($utente)
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
}
?>