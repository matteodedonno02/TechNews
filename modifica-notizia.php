<?php
include "phpClass/ManagerDB.php";
session_start();
if(!isset($_SESSION["loggedUser"]) || $_SESSION["loggedUser"]->getLevel() == 1)
{
    header("location: index.php");
    return;
}


if(!isset($_POST["id"]))
{
    header("location: index.php");
    return;
}

$db = new ManagerDB();
$listaCategorie = $db->getCategorie();
$temp = $db->getNewsDaId($_POST["id"]);
$news = $temp[0];
$categorieScelte = $news->getCategorie();
for ($i=0; $i < count($categorieScelte); $i++) 
{ 
    if($key = array_search($categorieScelte[$i], $listaCategorie))
    {
        unset($listaCategorie[$key]);
    }
}
$listaCategorie = array_values($listaCategorie);
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
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
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
            if($utente->getLevel() == 2)
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


    <script>
      var editor = tinymce.init(
        {
            selector: "#txtNews",
            setup: function (editor) 
            {
                editor.on('change', function () 
                {
                    tinymce.triggerSave();
                });
            }
        });
    </script>

    

    <div class="container" style="margin-top: 40px;">


    <h2 class="bold titolo">Modifica notizia</h2>
        <form autocomplete="off" method="POST" action="gestioneUtenti.php" enctype="multipart/form-data" onsubmit="return checkFormNews()">
            <input type="hidden" name="cmd" value="modificaNews">
            <input type="hidden" name="id" value="<?php echo $news->getIdNews() ?>">
            <div class="form-group">
                <label for="txtTitolo">Titolo</label>
                <input type="text" class="form-control" id="txtTitolo" name="txtTitolo" value="<?php echo $news->getTitolo() ?>">
            </div>
            <div class="form-group">
                <label for="txtLevel">Categorie rimanenti</label>
                <div class="categorie-rimanenti">
                    <?php
                    $j = 1;
                    for($i = 0; $i < count($listaCategorie); $i ++)
                    {
                    ?>
                        <button id="categoria<?php echo $i ?>" type="button" class="btn btn-outline-primary categoria" onclick="aggiungiCategoria('categoria<?php echo $i ?>', '+ <?php echo $listaCategorie[$i]->getNome() ?>')">+ <?php echo $listaCategorie[$i]->getNome() ?></button>
                    <?php
                        $j ++;
                    }
                    ?>
                </div>
            </div>
            <div class="form-group">
                Categorie scelte
                <div class="categorie-scelte form-control" style="height: 60px; line-height: 44px;">
                <?php
                $valueCategorie = "";
                for ($i=0; $i < count($categorieScelte); $i++) 
                {
                ?>
                    <button id="<?php echo $j ?>" type="button" class="btn btn-outline-primary categoria-scelta" onclick="rimuoviCategoria('<?php echo $j ?>', '- <?php echo $categorieScelte[$i]->getNome() ?>')">- <?php echo $categorieScelte[$i]->getNome() ?></button>
                <?php
                    $valueCategorie .= $categorieScelte[$i]->getNome() . "::";
                    $j ++;
                }
                ?>
                </div>
                <input type="hidden" id="txtCategorie" name="txtCategorie" value="<?php echo $valueCategorie?>">
            </div>
            <div class="form-group">
                <label for="txtLinkFoto" class="btn btn-outline-primary">SCEGLI FOTO NOTIZIA</label>
                <label for="txtLinkFoto" id="nomeFile"><?php echo explode("/", $news->getLinkImmagine())[count(explode("/", $news->getLinkImmagine())) - 1] ?></label>
                <input type="file" accept="image/*" class="form-control-file" id="txtLinkFoto" name="txtLinkFoto" aria-describedby="fileHelp">
            </div>
            <textarea id="txtNews" name="txtNews">
                <?php echo $news->getTesto() ?>
            </textarea>
            <div class="buttons-field">
                <button type="submit" class="btn btn-outline-primary" style="margin-top: 20px;">MODIFICA</button>
            </div>
        </form>
    </div>


    <script id="scriptCategorie" src="assets/js/selezioneCategorie.js"></script>
    <script src="assets/js/main.js"></script>


    <?php
        $db->chiudiConnessione(); 
    ?>
</body>
</html>