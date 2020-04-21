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
    }
}
?>