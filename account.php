<?php
include "phpClass/ManagerDB.php";
session_start();


if(!isset($_SESSION["loggedUser"]))
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
                        <li class="nav-item active">
                            <div class="icon-and-menu">
                                <img class="icon active-icon" src="assets/img/user.svg">
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
                        <li class="nav-item active">
                            <div class="icon-and-menu">
                                <img class="icon active-icon" src="assets/img/user.svg">
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
                        <li class="nav-item active">
                            <div class="icon-and-menu">
                                <img class="icon active-icon" src="assets/img/user.svg">
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


    <div class="container" style="margin-top: 40px;">
        <?php
        $temp = $db->getNewsDaAutore($utente->getId());
        $listaNewsDaUtente = $temp[1];

        
        ?>
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label class="bold font-medium titolo">Immagine profilo</label><br>
                    <?php
                    if($utente->getLinkFoto() == "")
                    {
                    ?>
                        <div class="image-profile photo-border" style="background-image: url('assets/img/user.png');"></div>
                        <!-- <img src="assets/img/user.png"> -->
                    <?php
                    }
                    else
                    {
                    ?>
                        <div class="image-profile photo-border" style="background-image: url('<?php echo $utente->getLinkFoto() ?>');"></div>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label class="bold font-medium titolo">Nome </label>
                    <label class="font-medium"><?php echo $utente->getNome() ?></label>
                </div>
                <div class="form-group">
                    <label class="bold font-medium titolo">Cognome </label>
                    <label class="font-medium"><?php echo $utente->getCognome() ?></label>
                </div>
                <div class="form-group">
                    <label class="bold font-medium titolo">Email </label>
                    <label class="font-medium"><?php echo $utente->getEmail() ?></label>
                </div>
                <a href="modifica-utente.php"><button type="button" class="btn btn-outline-primary">MODIFICA ACCOUNT</button></a>
            </div>
            <div class="col-md-8 col-sm-12 blue-border">
            <?php
                if($utente->getLevel() == 1)
                {
                ?>
                    <label class="font-medium bold titolo">Sei un lettore quindi non puoi nè scrivere nè modificare le news</label>
                <?php
                }
                else
                {
                    if(count($listaNewsDaUtente) == 0)
                {
                ?>
                    <label class="font-medium bold titolo">Non hai ancora scritto nessuna news</label>
                <?php
                }


                for($i = 0; $i < count($listaNewsDaUtente); $i ++)
                {
                ?>
                    <div class="news">
                        <div style="display: flex;">
                            <form id="modifica-news-form<?php echo $i?>" action="modifica-notizia.php" method="POST" style="width: 20px">
                                <input type="hidden" name="id" value="<?php echo $listaNewsDaUtente[$i]->getIdNews() ?>">
                                <img id="<?php echo $i?>" class="modify-icon icon accept-icon" src="assets/img/edit.png">
                            </form>
                            <form id="cancella-news-form<?php echo $i?>" action="gestioneUtenti.php" method="POST">
                                <input type="hidden" name="cmd" value="cancellaNews">
                                <input type="hidden" name="id" value="<?php echo $listaNewsDaUtente[$i]->getIdNews() ?>">
                                <img id="<?php echo $i?>" class="delete-icon icon remove-icon" src="assets/img/close.png">
                            </form>
                        </div>
                        

                        
                        <a href="dettaglio.php?tipo=news&id=<?php echo $listaNewsDaUtente[$i]->getIdNews() ?>"><h3 class="bold titolo"><?php echo $listaNewsDaUtente[$i]->getTitolo() ?> <label class="date"> <?php echo $listaNewsDaUtente[$i]->getDataPubblicazione() ?></label></h3></a>
    
    
                        <?php
                        for($j = 0; $j < count($listaNewsDaUtente[$i]->getCategorie()); $j ++)
                        {
                        ?>
                            <small class="text-muted"><a href="dettaglio.php?tipo=cat&id=<?php echo $listaNewsDaUtente[$i]->getCategorie()[$j]->getId()  ?>"><?php echo $listaNewsDaUtente[$i]->getCategorie()[$j]->getNome() ?></a></small><br>
                        <?php
                        }
                        ?>
    
    
                        <p class="testo-news"><?php echo strip_tags(substr($listaNewsDaUtente[$i]->getTesto(), 0, 200)) ?>... <a href="dettaglio.php?tipo=news&id=<?php echo $listaNewsDaUtente[$i]->getIdNews() ?>">Continua a leggere</a></p>
                    </div>
                <?php
                }
                }
            ?>
            </div>
        </div>
    </div>


    <script src="assets/js/main.js"></script>
</body>
</html>