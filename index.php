<?php
include "phpClass/ManagerDB.php";
session_start();
$db = new ManagerDB();
$listaCategorie = $db->getCategorie();
$listaUltimeNews = $db->getUltimeNews();
$listaAutori = $db->getAutori();
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
                    <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="registrazione.php">Registrazione</a>
                    </li>
                </ul>
            </div>
        <?php
        }
        else
        {
            $utente = $_SESSION["loggedUser"];
            if($utente->getLevel() == 1)
            {
            ?>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="notizie.php">Notizie</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="gestioneUtenti.php?cmd=logout">Log out</a>
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
                        <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="notizie.php">Notizie</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="scrivi-notizia.php">Scrivi Notizia</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="gestioneUtenti.php?cmd=logout">Log out</a>
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
                        <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="notizie.php">Notizie</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="scrivi-notizia.php">Scrivi Notizia</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="admin/">Sezione amministrazione</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="gestioneUtenti.php?cmd=logout">Log out</a>
                        </li>
                    </ul>
                </div>
            <?php
            }
        }
        ?>
      </nav>

    <?php
    if(!isset($_SESSION["loggedUser"]))
    {
    ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops!</strong> <a href="login.php" class="alert-link">Effettua il login</a> o <a href="registrazione.php" class="alert-link">registrati</a> per poter accedere alle risorse del sito.
        </div>
    <?php
    }
    ?>
    <div class="container" style="margin-top: 80px; margin-bottom: 80px;">
        <div class="row">
            <div class="col-md-8 col-sm-12 blue-border">
            <?php
            for($i = 0; $i < count($listaUltimeNews); $i ++)
            {
            ?>
                <div class="news">
                    <a href="dettaglio.php?tipo=news&id=<?php echo $listaUltimeNews[$i]->getIdNews() ?>"><h3 class="bold titolo"><?php echo $listaUltimeNews[$i]->getTitolo() ?> <label class="date"> <?php echo $listaUltimeNews[$i]->getDataPubblicazione() ?></label></h3></a>



                    <?php
                    for($j = 0; $j < count($listaUltimeNews[$i]->getCategorie()); $j ++)
                    {
                    ?>
                        <small class="text-muted"><a href="dettaglio.php?tipo=cat&id=<?php echo $listaUltimeNews[$i]->getCategorie()[$j]->getId() ?>"><?php echo $listaUltimeNews[$i]->getCategorie()[$j]->getNome() ?></a></small><br>
                    <?php
                    }
                    ?>


                    <p class="testo-news"><?php echo substr($listaUltimeNews[$i]->getTesto(), 0, 200) ?>... <a href="dettaglio.php?tipo=news&id=<?php echo $listaUltimeNews[$i]->getIdNews() ?>">Continua a leggere</a></p>
                </div>
            <?php
            }
            ?>
            </div>
            <div class="col-md-4 col-sm-12">
                <h4 class="titolo">Categorie</h4>
                <?php
                for($i = 0; $i < count($listaCategorie); $i ++)
                {
                ?>
                    <p class="lead">> <a href="dettaglio.php?tipo=cat&id=<?php echo $listaCategorie[$i]->getId(); ?>"><?php echo $listaCategorie[$i]->getNome(); ?></a></p>
                <?php
                }
                ?>


                <h4 class="titolo">Autori</h4>
                <?php
                for($i = 0; $i < count($listaAutori); $i ++)
                {
                ?>
                    <p class="lead">> <a href="dettaglio.php?tipo=user&id=<?php echo $listaAutori[$i]->getId() ?>"><?php echo ($listaAutori[$i]->getNome() . " " . $listaAutori[$i]->getCognome()) ?></a></p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

      
</body>
</html>