<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    $operation = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    switch ($operation) {
        case "read_med":
            showMenu();
        break;

        case "mng_adm":
            showMenu();
        break;

        case "LOGOUT":
            if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
                $_SESSION["is_logged"] = false;
                $_SESSION["username"] = null;
                $_SESSION["user_id"] = null;
                if (session_destroy()) {
                    showMenu();
                    echo "Disconnessione avvenuta con successo"; 
                }
            } else
                header("Location: loginPage.php");
        break;

        case null:
            header("Location: index.php");
        break;
    }
?>