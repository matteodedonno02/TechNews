<?php
include "../phpClass/ManagerDB.php";
session_start();
$db = new ManagerDB();


if(!isset($_SESSION["loggedUser"]) || $_SESSION["loggedUser"]->getLevel() != 3)
{
    header("location: ../index.php");
    return;
}

$sezione;
if(!isset($_GET["sezione"]))
{
    $sezione = "";
}
else
{
    $sezione = $_GET["sezione"];
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/coding.png" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sidebar">
        <a class="navbar-brand" href="../index.php">Tech News</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php
        if($sezione == "")
        {
        ?>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=lua">Lista utenti da accettare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=lu">Lista utenti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=ln">Lista news</a>
                    </li>
                </ul>
            </div>
        <?php
        }
        else if($sezione == "lua")
        {
        ?>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?sezione=lua">Lista utenti da accettare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=lu">Lista utenti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=ln">Lista news</a>
                    </li>
                </ul>
            </div>
        <?php
        }
        else if($sezione == "lu")
        {
        ?>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=lua">Lista utenti da accettare</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?sezione=lu">Lista utenti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=ln">Lista news</a>
                    </li>
                </ul>
            </div>
        <?php   
        }
        else if($sezione == "ln")
        {
        ?>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=lua">Lista utenti da accettare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?sezione=lu">Lista utenti</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?sezione=ln">Lista news</a>
                    </li>
                </ul>
            </div>
        <?php
        }
        ?>
    </nav>

    <div class="container sidebar-container" style="padding-top: 20px">
        <?php
        if($sezione == "")
        {
        ?>
            <h2 class="bold titolo" style="margin-bottom: 20px;">Sezione amministrazione di TechNews</h2>
            <img class="accept-icon home-icon" src="../assets/img/wrench.png">
        <?php
        }
        else if($sezione == "lua")
        {
            ?>
                <h2 class="bold titolo" style="margin-bottom: 20px;">Sezione amministrazione di TechNews <img class="accept-icon title-icon" src="../assets/img/wrench.png"></h2>
            <?php


            $listaUtentiDaAccettare = $db->getUtentiDaAccettare();
            if(count($listaUtentiDaAccettare) == 0)
            {
            ?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Tutto perfetto!</strong> Al momento non ci sono utenti da accettare.
                </div>
            <?php
            }
            else
            {
            ?>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td class="titolo bold">Nome</td>
                            <td class="titolo bold">Cognome</td>
                            <td class="titolo bold">Email</td>
                            <td class="titolo bold">Tipo</td>
                            <td class="titolo bold">&nbsp;</td>
                        </tr>
                        <?php
                        for($i = 0; $i < count($listaUtentiDaAccettare); $i ++)
                        {
                        ?>
                            <tr>
                                <td><?php echo $listaUtentiDaAccettare[$i]->getNome() ?></td>
                                <td><?php echo $listaUtentiDaAccettare[$i]->getCognome() ?></td>
                                <td><?php echo $listaUtentiDaAccettare[$i]->getEmail() ?></td>
                                <td><?php echo $listaUtentiDaAccettare[$i]->getLevel() == 1 ? "Lettore" : "Scrittore" ?></td>
                                <td><a href="gestioneAdmin.php?cmd=accettaUtente&id=<?php echo $listaUtentiDaAccettare[$i]->getId() ?>"><img class="icon accept-icon" src="../assets/img/tick.png"></a></td>
                            </tr> 
                        <?php
                        }
                        ?>
                    </table>
                </div>
            <?php
            }
        }
        else if($sezione == "lu")
        {
            ?>
                <h2 class="bold titolo" style="margin-bottom: 20px;">Sezione amministrazione di TechNews <img class="accept-icon title-icon" src="../assets/img/wrench.png"></h2>
            <?php
            if(isset($_POST["ricerca"]))
            {
                $listaUtenti = $db->getUtenti($_POST["ricerca"]);
            }
            else
            {
                $listaUtenti = $db->getUtenti("");
            }


            if(count($listaUtenti) == 0)
            {
            ?>
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Cosa sta succedendo?</strong> Al momento non ci sono utenti.
                </div>
            <?php
            }
            else
            {
            ?>
                <form autocomplete="off" class="form-inline my-2 my-lg-0" action="index.php?sezione=lu" method="POST">
                    <input class="form-control mr-sm-2" name="ricerca" type="text" placeholder="Cerca utente">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">CERCA UTENTE</button>
                </form>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td class="titolo bold">Nome</td>
                            <td class="titolo bold">Cognome</td>
                            <td class="titolo bold">Email</td>
                            <td class="titolo bold">Tipo</td>
                            <td class="titolo bold">&nbsp;</td>
                            <td class="titolo bold">&nbsp;</td>
                        </tr>
                        <?php
                        for($i = 0; $i < count($listaUtenti); $i ++)
                        {
                        ?>
                            <tr>
                                <td><?php echo $listaUtenti[$i]->getNome() ?></td>
                                <td><?php echo $listaUtenti[$i]->getCognome() ?></td>
                                <td><?php echo $listaUtenti[$i]->getEmail() ?></td>
                                <td><?php echo $listaUtenti[$i]->getLevel() == 1 ? "Lettore" : "Scrittore" ?></td>
                                <td><a href="modifica-utente.php?id=<?php echo $listaUtenti[$i]->getId() ?>"><img class="icon accept-icon" src="../assets/img/edit.png"></a></td>
                                <td><a href="gestioneAdmin.php?cmd=bloccaUtente&id=<?php echo $listaUtenti[$i]->getId() ?>"><img class="icon remove-icon" src="../assets/img/close.png"></a></td>
                            </tr> 
                        <?php
                        }
                        ?>
                    </table>
                </div>
            <?php
            }
        }
        ?>
    </div>
</body>
</html>