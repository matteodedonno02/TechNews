<?php
include "../phpClass/ManagerDB.php";
session_start();
$db = new ManagerDB();


if(!isset($_POST["cmd"]))
{
    header("location ../index.php");
}
else
{
    $cmd = $_POST["cmd"];
    switch($cmd)
    {
        case "modificaUtente":
            $id = $_POST["id"];
            $nome = $_POST["txtNome"];
            $cognome = $_POST["txtCognome"];
            $email = $_POST["txtEmail"];
            $password = $_POST["txtPassword"];
            $level = $_POST["txtLevel"] == "Lettore" ? 1 : 2;
            $linkFoto = "";


            if (isset($_FILES["txtLinkFoto"]) || !is_uploaded_file($_FILES["txtLinkFoto"]["tmp_name"])) 
            {
                define ("SITE_ROOT", str_replace("admin", "", realpath(dirname(__FILE__))));
                $uploaddir = SITE_ROOT . "/assets/img/userImg/" . $email . "/";


                $photo_tmp = $_FILES["txtLinkFoto"]["tmp_name"];
                $photo_name = $_FILES["txtLinkFoto"]["name"];
                if($photo_name == "")
                {
                    $linkFoto = "";
                }
                else
                {
                    if(!file_exists($uploaddir))
                    {
                        mkdir($uploaddir);
                    }
                    move_uploaded_file($photo_tmp, $uploaddir . $photo_name);
                    $linkFoto = "assets/img/userImg/" . $email . "/" . $photo_name;
                }
            }

            
            $db->modificaUtente(new User($id, $nome, $cognome, $linkFoto, $email, $password, $level, null));
            header("location: index.php?sezione=lu");
        break;
        case "modificaNews":
            $linkFoto = "";
    
    
            if (isset($_FILES["txtLinkFoto"]) || !is_uploaded_file($_FILES["txtLinkFoto"]["tmp_name"])) 
            {
                define ("SITE_ROOT", realpath(dirname(__FILE__)));
                $uploaddir = SITE_ROOT . "/assets/img/newsImg/";
    
    
                $photo_tmp = $_FILES["txtLinkFoto"]["tmp_name"];
                $photo_name = $_FILES["txtLinkFoto"]["name"];
                if($photo_name == "")
                {
                    $linkFoto = "";
                }
                else
                {
                    if(!file_exists($uploaddir))
                    {
                        mkdir($uploaddir);
                    }
                    move_uploaded_file($photo_tmp, $uploaddir . $photo_name);
                    $linkFoto = "assets/img/newsImg/" . $photo_name;
                }
            }
    
    
            $db->modificaNews(new News($_POST["id"], $_POST["txtTitolo"], $_POST["txtNews"], null, $linkFoto, $_SESSION["loggedUser"]->getId(), $_POST["txtCategorie"]));
            header("location: index.php?sezione=ln");
        break;
        case "aggiungiCategoria":
            $result = $db->aggiungiCategoria($_POST["txtNuovaCategoria"]);
            $result = $result ? "true" : "false";
            echo $result;
            header("location: index.php?sezione=lc&aresult=" . $result);
        break;
    }
}


if(!isset($_GET["cmd"]))
{
    header("location ../index.php");
    return;
}
else
{
    $cmd = $_GET["cmd"];
    switch($cmd)
    {
        case "accettaUtente":
            $db->accettaUtente($_GET["id"]);
            header("location: " . $_SERVER['HTTP_REFERER']);
        break;
        case "bloccaUtente":
            $db->bloccaUtente($_GET["id"]);
            header("location: " . $_SERVER['HTTP_REFERER']);
        break;
        case "cancellaNews":
            $db->cancellaNews($_GET["id"]);
            header("location: " . $_SERVER['HTTP_REFERER']);
        break;
        case "cancellaCategoria":
            $result = $db->cancellaCategoria($_GET["id"]);
            $result = $result ? "true" : "false";
            header("location: index.php?sezione=lc&cresult=" . $result);
        break;
    }
}
?>