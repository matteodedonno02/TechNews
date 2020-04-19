<?php
include "phpClass/ManagerDB.php";
session_start();


if(!isset($_SESSION["loggedUser"]))
{
    header("location: index.php");
    return;
}


if(!isset($_GET["tipo"]) || !isset($_GET["id"]))
{
    header("location: index.php");
    return;
}


$db = new ManagerDB();
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
                        <li class="nav-item">
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
                        <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="notizie.php">Notizie</a>
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
                        <li class="nav-item">
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


    <div class="container" style="margin-top: 40px;">
        <?php
        $tipo = $_GET["tipo"];
        $id = $_GET["id"];


        switch($tipo)
        {
            case "news":
                $temp = $db->getNewsDaId($id);
                $news = $temp[0];
                $autore = $temp[1];
                ?>
                    <h2 class="bold titolo"><?php echo $news->getTitolo() ?></h2>
                    <small class="text-muted bold">Categorie: </small>
                    <?php
                    for($i = 0; $i < count($news->getCategorie()); $i ++)
                    {
                        if($i == count($news->getCategorie()) - 1)
                        {
                        ?>
                            <small class="text-muted"><?php echo $news->getCategorie()[$i]->getNome() ?></small>
                        <?php
                            continue;
                        }
                    ?>
                        <small class="text-muted"><?php echo $news->getCategorie()[$i]->getNome() ?>, </small>
                    <?php
                    }
                    ?>
                    <h4 class="titolo" style="margin-bottom: 20px;">Scritto da <?php echo ($autore->getNome() . " " . $autore->getCognome()) ?></h4>
                    <?php
                    if($news->getLinkImmagine() != "")
                    {
                    ?>
                        <div class="floated">
                            <img class="blue-border floated" src="<?php echo $news->getLinkImmagine() ?>">
                        </div>
                    <?php
                    }
                    ?>
                    <p class="testo-news"><?php echo $news->getTesto(); ?></p>
                <?php
            break;


            case "cat":
                $temp = $db->getNewsDaCategoria($id);
                $categoria = $temp[0];
                $listaNewsDaCategoria = $temp[1];
                ?>
                    <h2 class="bold titolo" style="margin-bottom: 20px;">Tutte le news della cagetoria <?php echo $categoria ?></h2>
                    <div class="blue-border">
                <?php
                for($i = 0; $i < count($listaNewsDaCategoria); $i ++)
                {
                ?>
                    <div class="news">
                        <a href="dettaglio.php?tipo=news&id=<?php echo $listaNewsDaCategoria[$i]->getIdNews() ?>"><h3 class="bold titolo"><?php echo $listaNewsDaCategoria[$i]->getTitolo() ?></h3></a>

                        <p class="testo-news"><?php echo substr($listaNewsDaCategoria[$i]->getTesto(), 0, 300) ?>... <a href="dettaglio.php?tipo=news&id=<?php echo $listaNewsDaCategoria[$i]->getIdNews() ?>">Continua a leggere</a></p>
                    </div>
                <?php
                }
                ?>
                </div>
                <?php
            break;


            case "user":
            break;
        }
        ?>
    </div>
</body>
</html>