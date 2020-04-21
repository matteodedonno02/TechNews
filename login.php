<?php
include "phpClass/ManagerDB.php";
session_start();
if(isset($_SESSION["loggedUser"]))
{
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech News</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://bootswatch.com/4/lumen/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/img/coding.png" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand bold" href="index.php">Tech News</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        if(!isset($_SESSION["loggedUser"]))
        {
        ?>
            <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <div class="icon-and-menu">
                            <img class="icon unactive" src="assets/img/home.png">
                            <a class="nav-link" href="index.php">Home</a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <div class="icon-and-menu">
                            <img class="icon active-icon" src="assets/img/enter.png">
                            <a class="nav-link" href="login.php">Login</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="icon-and-menu">
                            <img class="icon unactive" src="assets/img/register.svg">
                            <a class="nav-link" href="registrazione.php">Registrazione</a>
                        </div>
                    </li>
                </ul>
            </div>
        <?php
        }
        ?>
      </nav>

    <div class="container">
        <?php
        if(isset($_GET["errore"]) && $_GET["errore"] == "erroreLogin")
        {
        ?>
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Ahia!</strong> Dati errati o account inesistente.
            </div>
        <?php
        }
        else if(isset($_GET["errore"]) && $_GET["errore"] == "notAut")
        {
        ?>
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Devi aspettare!</strong> L'amministratore non ti ha ancora aprovato.
            </div>
        <?php
        }
        else if(isset($_GET["registrazione"]))
        {
        ?>
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Ti sei registrato!</strong> Attendi che l'amministratore ti accetti per poter effettuare il login.
            </div>
        <?php
        }
        
        ?>
    </div>


    


    <div class="container form">
      <form autocomplete="off" action="gestioneUtenti.php" method="POST">
        <input type="hidden" name="cmd" value="login">
        <fieldset>
            <div class="form-group">
                <label for="txtEmail">Email address</label>
                <input type="email" required="true" class="form-control" id="txtEmail" name="txtEmail" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="txtPassword">Password</label>
                <input type="password" required="true" class="form-control" name="txtPassword" id="txtPassword">
            </div>
        </fieldset>
        <div class="button-field">
            <button type="submit" class="btn btn-outline-primary">LOGIN</button>
        </div>
        </form>
      </div>
</body>
</html>