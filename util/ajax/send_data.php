<?php
    include "../command.php";
    include "../connection.php";
    require_once("../constants.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["function"]))
            $_SESSION["function"] = $_POST["function"];

        if (isset($_POST["user"]))
            $_SESSION["user"] = $_POST["user"];
        
        if (isset($_POST["profile"]))
            $_SESSION["profile"] = $_POST["profile"];

        if (isset($_POST["operation"]))
            $_SESSION["operation"] = $_POST["operation"];

        if (isset($_POST["table"]))
            $_SESSION["table"] = $_POST["table"];
    }
?>