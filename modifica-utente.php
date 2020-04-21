<?php
include "phpClass/ManagerDB.php";
session_start();
$db = new ManagerDB();


if(!isset($_SESSION["loggedUser"]))
{
    header("location index.php");
    return;
}


$utente = $_SESSION["loggedUser"];
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
            $utente = $_SESSION["loggedUser"];
            if($utente->getLevel() == 1)
            {
            ?>
                <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <div class="icon-and-menu">
                                <img class="icon active-icon" src="assets/img/home.png">
                                <a class="nav-link" href="index.php">Home</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/news.png">
                                <a class="nav-link" href="notizie.php">Notizie</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/user.svg">
                                <a class="nav-link" href="account.php"><?php echo $utente->getEmail() ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/logout.png">
                                <a class="nav-link" href="gestioneUtenti.php?cmd=logout">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            }
            else if($utente->getLevel() == 2)
            {
            ?>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <div class="icon-and-menu">
                                <img class="icon active-icon" src="assets/img/home.png">
                                <a class="nav-link" href="index.php">Home</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/news.png">
                                <a class="nav-link" href="notizie.php">Notizie</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/write.png">
                                <a class="nav-link" href="scrivi-notizia.php">Scrivi Notizia</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/user.svg">
                                <a class="nav-link" href="account.php"><?php echo $utente->getEmail() ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/logout.png">
                                <a class="nav-link" href="gestioneUtenti.php?cmd=logout">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            }
            else if($utente->getLevel() == 3)
            {
            ?>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <div class="icon-and-menu">
                                <img class="icon active-icon" src="assets/img/home.png">
                                <a class="nav-link" href="index.php">Home</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/news.png">
                                <a class="nav-link" href="notizie.php">Notizie</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/write.png">
                                <a class="nav-link" href="scrivi-notizia.php">Scrivi Notizia</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/admin.png">
                                <a class="nav-link" href="admin/">Sezione amministrazione</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/user.svg">
                                <a class="nav-link" href="account.php"><?php echo $utente->getEmail() ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/logout.png">
                                <a class="nav-link" href="gestioneUtenti.php?cmd=logout">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            }
        ?>
    </nav>

    
    <div class="container form register">
      <form autocomplete="off" action="gestioneUtenti.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="cmd" value="modificaUtente">
        <fieldset>
            <div class="form-group">
                <label for="txtNome">Nome</label>
                <input type="text" required="true" class="form-control" id="txtNome" name="txtNome" value="<?php echo $utente->getNome() ?>">
            </div>
            <div class="form-group">
                <label for="txtCognome">Cognome</label>
                <input type="text" required="true" class="form-control" id="txtCognome" name="txtCognome" value="<?php echo $utente->getCognome() ?>">
            </div>
            <div class="form-group">
                <label for="txtLinkFoto" class="btn btn-outline-primary">SCEGLI FOTO</label>
                <label for="txtLinkFoto" id="nomeFile"><?php echo explode("/", $utente->getLinkFoto())[count(explode("/", $utente->getLinkFoto())) - 1] ?></label>
                <input type="file" accept="image/*" class="form-control-file" id="txtLinkFoto" name="txtLinkFoto" aria-describedby="fileHelp">
            </div>
            <div class="form-group">
                <label for="txtEmail">Email address</label>
                <input type="email" required="true" class="form-control" id="txtEmail" name="txtEmail" value="<?php echo $utente->getEmail() ?>">
            </div>
            <div class="form-group">
                <label for="txtPassword">Nuova Password</label>
                <input type="password" class="form-control" name="txtPassword" id="txtPassword">
            </div>
            <div class="form-group">
            <label for="txtLevel">Tipo</label>
                <select disabled="true" class="form-control custom-select" id="txtLevel" name="txtLevel">
                    <?php
                    if($utente->getLevel() == 1)
                    {
                    ?>
                        <option selected>Lettore</option>
                        <option>Scrittore</option>
                    <?php
                    }
                    else 
                    {
                    ?>
                        <option>Lettore</option>
                        <option selected>Scrittore</option>
                    <?php
                    }
                    ?>
                    
                </select>
            </div>
        </fieldset>
        <div class="button-field">
            <button type="submit" class="btn btn-outline-primary">MODIFICA</button>
        </div>
        </form>
      </div>


      <script src="assets/js/main.js"></script>
</body>
</html>