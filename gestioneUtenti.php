<?php
include "phpClass/ManagerDB";
session_start();


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
        
    break;
}
?>