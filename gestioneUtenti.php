<?php
include "phpClass/ManagerDB.php";
session_start();


if(isset($_GET["cmd"]) && $_GET["cmd"] == "logout")
{
    session_destroy();
    header("location: index.php");
    return;
}


if(!isset($_POST["cmd"]))
{
    header("location: index.php");
    return;
}


$cmd = $_POST["cmd"];
$db = new ManagerDB();


switch ($cmd)
{
    case "login":
        $utente = $db->login($_POST["txtEmail"], $_POST["txtPassword"]);
        if($utente == null)
        {
            header("location: login.php?errore=erroreLogin");
            return;
        }


        if($utente->getAut() == "N")
        {
            header("location: login.php?errore=notAut");
            return;
        }
        

        $_SESSION["loggedUser"] = $utente;
        header("location: index.php");
    break;
    case "registrazione":
        $nome = $_POST["txtNome"];
        $cognome = $_POST["txtCognome"];
        $email = $_POST["txtEmail"];
        $password = $_POST["txtPassword"];
        $level = $_POST["txtLevel"] == "Lettore" ? 1 : 2;
        $linkFoto = "";


        if (isset($_FILES["txtLinkFoto"]) || !is_uploaded_file($_FILES["txtLinkFoto"]["tmp_name"])) 
        {
            define ("SITE_ROOT", realpath(dirname(__FILE__)));
            $uploaddir = SITE_ROOT . "/assets/img/userImg/" . $email . "/";
            if(!file_exists($uploaddir))
            {
                mkdir($uploaddir);
            }


            $photo_tmp = $_FILES["txtLinkFoto"]["tmp_name"];
            $photo_name = $_FILES["txtLinkFoto"]["name"];
            if($photo_name == "")
            {
                $linkFoto = "";
            }
            else
            {
                move_uploaded_file($photo_tmp, $uploaddir . $photo_name);
                $linkFoto = "assets/img/userImg/" . $email . "/" . $photo_name;
            }
        }
        
        

        $result = $db->registrazione(new User(0, $nome, $cognome, $linkFoto, $email, $password, $level, "N"));
        if(!$result)
        {
            header("location: registrazione.php?errore=erroreRegistrazione");
            return;
        }


        header("location: login.php?registrazione=registrazioneEffettuata");
    break;
    case "aggiungiCommento":
        $db->aggiungiCommento($_POST["txtCommento"], $_POST["idUser"], $_POST["idNews"]);
        header("location: dettaglio.php?tipo=news&id=" . $_POST["idNews"]);
    break;
    case "aggiungiNews":

        $linkFoto = "";


        if (isset($_FILES["txtLinkFoto"]) || !is_uploaded_file($_FILES["txtLinkFoto"]["tmp_name"])) 
        {
            define ("SITE_ROOT", realpath(dirname(__FILE__)));
            $uploaddir = SITE_ROOT . "/assets/img/newsImg/";
            if(!file_exists($uploaddir))
            {
                mkdir($uploaddir);
            }


            $photo_tmp = $_FILES["txtLinkFoto"]["tmp_name"];
            $photo_name = $_FILES["txtLinkFoto"]["name"];
            if($photo_name == "")
            {
                $linkFoto = "";
            }
            else 
            {
                move_uploaded_file($photo_tmp, $uploaddir . $photo_name);
                $linkFoto = "assets/img/newsImg/" . $photo_name;
            }
        }


        $db->aggiungiNews(new News(0, $_POST["txtTitolo"], $_POST["txtNews"], null, $linkFoto, $_POST["idUser"], $_POST["txtCategorie"]));
        header("location: index.php");
    break;
}
?>