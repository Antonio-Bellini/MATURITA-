<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        echo "  <button><a href='index.php'>HOME</a></button>
                <button><a href='newsletter.php'>NEWSLETTER</a></button>
                <button><a href='bacheca.php'>BACHECA</a></button>
                <button><a href='private/area_personale.php'>AREA PERSONALE</a></button>";

        echo "<br><br>QUESTA PAGINA CONTERRÁ LA BACHECA DELL'ASSOCIAZIONE";
    } else 
        header("Location: private/loginPage.php");
?>