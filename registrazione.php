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
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
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
                    <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item active">
                    <a class="nav-link" href="registrazione.php">Registrazione</a>
                    </li>
                </ul>
            </div>
        <?php
        }
        ?>
      </nav>

    <div class="container">
        <?php
        if(isset($_GET["errore"]))
        {
        ?>
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Ahia!</strong> Account già esistente. <a href="login.php" class="alert-link">Vai alla pagina di login.</a>
            </div>
        <?php
        }
        ?>
    </div>


    


    <div class="container form register">
      <form autocomplete="off" action="gestioneUtenti.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="cmd" value="registrazione">
        <fieldset>
            <div class="form-group">
                <label for="txtNome">Nome</label>
                <input type="text" required="true" class="form-control" id="txtNome" name="txtNome">
            </div>
            <div class="form-group">
                <label for="txtCognome">Cognome</label>
                <input type="text" required="true" class="form-control" id="txtCognome" name="txtCognome">
            </div>
            <div class="form-group">
                <label for="txtLinkFoto" class="btn btn-outline-primary">SCEGLI FOTO</label>
                <label for="txtLinkFoto" id="nomeFile">Nessun file</label>
                <input type="file" accept="image/*" class="form-control-file" id="txtLinkFoto" name="txtLinkFoto" aria-describedby="fileHelp">
            </div>
            <div class="form-group">
                <label for="txtEmail">Email address</label>
                <input type="email" required="true" class="form-control" id="txtEmail" name="txtEmail">
            </div>
            <div class="form-group">
                <label for="txtPassword">Password</label>
                <input type="password" required="true" class="form-control" name="txtPassword" id="txtPassword">
            </div>
            <div class="form-group">
            <label for="txtLevel">Tipo</label>
                <select class="form-control custom-select" id="txtLevel" name="txtLevel">
                    <option>Lettore</option>
                    <option>Scrittore</option>
                </select>
            </div>
        </fieldset>
        <div class="button-field">
            <button type="submit" class="btn btn-outline-primary">REGISTRATI</button>
        </div>
        </form>
      </div>


      <script src="assets/js/main.js"></script>
</body>
</html>