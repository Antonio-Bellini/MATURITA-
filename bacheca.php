<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        showMenu_logged();

        echo "QUESTA PAGINA CONTERRÁ LA BACHECA DELL'ASSOCIAZIONE";
    } else 
        header("Location: loginPage.php");
?>