<?php
include "phpClass/ManagerDB.php";
session_start();
$db = new ManagerDB();
$listaCategorie = $db->getCategorie();
$listaUltimeNews = $db->getUltimeNews();
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
                        <a class="nav-link" href="login.php">Notizie</a>
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
        <div class="container" style="text-align: center;">
            <img src="assets/img/coding2.png" width="200px">
        </div>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ops!</strong> <a href="login.php" class="alert-link">Effettua il login</a> o <a href="registrazione.php" class="alert-link">registrati</a> per poter accedere al sito.
        </div>
    <?php
    }
    else
    {
    ?>
        <div class="container" style="margin-top: 80px">
            <div class="row">
                <div class="col-md-8 col-sm-12 blue-border">
                <?php
                for($i = 0; $i < count($listaUltimeNews); $i ++)
                {
                ?>
                    <div class="news">
                        <a href="dettaglio.php?tipo=news&id=<?php echo $listaUltimeNews[$i]->getIdNews() ?>"><h3 class="bold titolo"><?php echo $listaUltimeNews[$i]->getTitolo() ?></h3></a>


                        <?php
                        for($j = 0; $j < count($listaUltimeNews[$i]->getCategorie()); $j ++)
                        {
                        ?>
                            <small class="text-muted"><?php echo $listaUltimeNews[$i]->getCategorie()[$j]->getNome() ?></small><br>
                        <?php
                        }
                        ?>


                        <p><?php echo substr($listaUltimeNews[$i]->getTesto(), 0, 200) ?>... <a href="dettaglio.php?tipo=news&id=<?php echo $listaUltimeNews[$i]->getIdNews() ?>">Continua a leggere</a></p>
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
                </div>
            </div>
        </div>
    <?php
    }
    ?>

      
</body>
</html>