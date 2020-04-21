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
            $utente = $_SESSION["loggedUser"];
            if($utente->getLevel() == 1)
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
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/news.png">
                                <a class="nav-link" href="notizie.php">Notizie</a>
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
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/home.png">
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
                        <li class="nav-item">
                            <div class="icon-and-menu">
                                <img class="icon unactive" src="assets/img/home.png">
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


                $listaCommenti = $db->getCommenti($id);


                if($news == "")
                {
                ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Ops!</strong> Risorsa non trovata.
                    </div>
                <?php
                    return;
                }


                ?>
                    <h2 class="bold titolo"><?php echo $news->getTitolo() ?> <label class="date"> <?php echo $news->getDataPubblicazione() ?></label></h2>
                    <small class="text-muted bold">Categorie: </small>
                    <?php
                    for($i = 0; $i < count($news->getCategorie()); $i ++)
                    {
                        if($i == count($news->getCategorie()) - 1)
                        {
                        ?>
                            <small class="text-muted"><a href="dettaglio.php?tipo=cat&id=<?php echo $news->getCategorie()[$i]->getId() ?>"><?php echo $news->getCategorie()[$i]->getNome() ?></a></small>
                        <?php
                            continue;
                        }
                    ?>
                        <small class="text-muted"><a href="dettaglio.php?tipo=cat&id=<?php echo $news->getCategorie()[$i]->getId() ?>"><?php echo $news->getCategorie()[$i]->getNome() ?></a>, </small>
                    <?php
                    }
                    ?>
                    <h4 class="titolo" style="margin-bottom: 20px;">Scritto da <a href="dettaglio.php?tipo=user&id=<?php echo $autore->getId() ?>"><?php echo ($autore->getNome() . " " . $autore->getCognome()) ?></a></h4>
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
                    <div class="testo-news">
                        <?php echo $news->getTesto(); ?>
                    </div>

                    <div style="float: left; width: 100%">
                    <h4 class="titolo bold">Sezione commenti</h4>
                    <form method="POST" action="gestioneUtenti.php">
                        <input type="hidden" name="cmd" value="aggiungiCommento">
                        <input type="hidden" name="idUser" value="<?php echo $utente->getId() ?>">
                        <input type="hidden" name="idNews" value="<?php echo $id?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <textarea style="margin-bottom: 10px;" required="true" class="form-control" id="txtCommento" name="txtCommento" rows="2"></textarea>
                                    <button type="submit" class="btn btn-outline-primary">SCRIVI COMMENTO</button>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                <?php
                                if(count($listaCommenti) == 0)
                                {
                                ?>
                                    <h5 class="titolo">Al momento questa news non contiene commenti</h5>
                                <?php
                                }

                                for($i = 0; $i < count($listaCommenti); $i ++)
                                {
                                ?>
                                    <h5 class="titolo"><?php echo $listaCommenti[$i]->getUser()->getEmail() ?></h5>
                                    <p class="testo-commento"><?php echo $listaCommenti[$i]->getTesto() ?></p>
                                <?php
                                    if ($i < count($listaCommenti) - 1) 
                                    {
                                    ?>
                                        <hr class="comment-separator">
                                    <?php
                                    }
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                <?php
            break;


            case "cat":
                $temp = $db->getNewsDaCategoria($id);
                $categoria = $temp[0];
                $listaNewsDaCategoria = $temp[1];


                if($categoria == "")
                {
                ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Ops!</strong> Risorsa non trovata.
                    </div> 
                <?php
                    return;
                }


                ?>
                    <h2 class="bold titolo" style="margin-bottom: 20px;">Tutte le news della cagetoria <?php echo $categoria ?></h2>
                    <div class="blue-border" style="padding: 10px;">
                <?php
                for($i = 0; $i < count($listaNewsDaCategoria); $i ++)
                {
                ?>
                    <div class="news">
                        <a href="dettaglio.php?tipo=news&id=<?php echo $listaNewsDaCategoria[$i]->getIdNews() ?>"><h3 class="bold titolo"><?php echo $listaNewsDaCategoria[$i]->getTitolo() ?> <label class="date"> <?php echo $listaNewsDaCategoria[$i]->getDataPubblicazione() ?></label></h3></a>

                        <p class="testo-news"><?php echo strip_tags(substr($listaNewsDaCategoria[$i]->getTesto(), 0, 300)) ?>... <a href="dettaglio.php?tipo=news&id=<?php echo $listaNewsDaCategoria[$i]->getIdNews() ?>">Continua a leggere</a></p>
                    </div>
                <?php
                }
                ?>
                </div>
                <?php
            break;


            case "user":
                $temp = $db->getNewsDaAutore($id);
                $autore = $temp[0];
                $listaNewsDaAutore = $temp[1];


                if($autore == "")
                {
                ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Ops!</strong> Risorsa non trovata.
                    </div>
                <?php
                    return;
                }

                ?>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="bold font-medium titolo">Immagine profilo</label><br>
                            <?php
                            if($autore->getLinkFoto() == "")
                            {
                            ?>
                                <div class="image-profile photo-border" style="background-image: url('assets/img/user.png');"></div>
                                <!-- <img src="assets/img/user.png"> -->
                            <?php
                            }
                            else
                            {
                            ?>
                                <div class="image-profile photo-border" style="background-image: url('<?php echo $autore->getLinkFoto() ?>');"></div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="bold font-medium titolo">Nome </label>
                            <label class="font-medium"><?php echo $autore->getNome() ?></label>
                        </div>
                        <div class="form-group">
                            <label class="bold font-medium titolo">Cognome </label>
                            <label class="font-medium"><?php echo $autore->getCognome() ?></label>
                        </div>
                        <div class="form-group">
                            <label class="bold font-medium titolo">Email </label>
                            <label class="font-medium"><?php echo $autore->getEmail() ?></label>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12 blue-border">
                    <?php
                        if(count($listaNewsDaAutore) == 0)
                        {
                        ?>
                            <label class="font-medium bold titolo">Questo autore non ha scritto nessuna news al momento</label>
                        <?php
                        }


                        for($i = 0; $i < count($listaNewsDaAutore); $i ++)
                        {
                        ?>
                            <div class="news">
                                <a href="dettaglio.php?tipo=news&id=<?php echo $listaNewsDaAutore[$i]->getIdNews() ?>"><h3 class="bold titolo"><?php echo $listaNewsDaAutore[$i]->getTitolo() ?> <label class="date"> <?php echo $listaNewsDaAutore[$i]->getDataPubblicazione() ?></label></h3></a>
            
            
                                <?php
                                for($j = 0; $j < count($listaNewsDaAutore[$i]->getCategorie()); $j ++)
                                {
                                ?>
                                    <small class="text-muted"><a href="dettaglio.php?tipo=cat&id=<?php echo $listaNewsDaAutore[$i]->getCategorie()[$j]->getId()  ?>"><?php echo $listaNewsDaAutore[$i]->getCategorie()[$j]->getNome() ?></a></small><br>
                                <?php
                                }
                                ?>
            
            
                                <p class="testo-news"><?php echo strip_tags(substr($listaNewsDaAutore[$i]->getTesto(), 0, 200)) ?>... <a href="dettaglio.php?tipo=news&id=<?php echo $listaNewsDaAutore[$i]->getIdNews() ?>">Continua a leggere</a></p>
                            </div>
                        <?php
                        }
                    ?>
                    </div>
                </div>
                <?php
            break;
        }
        ?>
    </div>
</body>
</html>