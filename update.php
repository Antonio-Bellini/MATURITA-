<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    showMenu();

    $type = $_POST["type"];

    switch ($type) {
        case "user":
            if (isset($_POST["new_name"]))
                $new_name = $_POST["new_name"];

            if (isset($_POST["new_surname"]))
                $new_surname = $_POST["new_surname"];

            if (isset($_POST["new_email"]))
                $new_email = $_POST["new_email"];

            if (isset($_POST["new_tf"]))
                $new_tf = $_POST["new_tf"];

            if (isset($_POST["new_tm"]))
                $new_tm = $_POST["new_tm"];

            if (isset($_POST["old_psw"]) && isset($_POST["new_psw"]))
        break;
    }
?>