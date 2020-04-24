<?php
include "../phpClass/ManagerDB.php";
session_start();
$db = new ManagerDB();


if(!isset($_SESSION["loggedUser"]) || $_SESSION["loggedUser"]->getLevel() != 3 || !isset($_GET["id"]))
{
    header("location ../index.php");
    return;
}


$utente = $db->getUtente($_GET["id"]);
if($utente == null)
{
    header("location: index.php");
    return;
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
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
</head>
<body>
    <div class="container form register">
      <form autocomplete="off" action="gestioneAdmin.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="cmd" value="modificaUtente">
        <input type="hidden" name="id" value="<?php echo $utente->getId() ?>">
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
                <select class="form-control custom-select" id="txtLevel" name="txtLevel">
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


      <script src="../assets/js/main.js"></script>
      <?php
        $db->chiudiConnessione();
      ?>
</body>
</html>