<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo WEBALL;
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
    importActualStyle();
    session_start();
    $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {        
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $tf = isset($_POST["tf"]) ? $_POST["tf"] : null;
        $tm = $_POST["tm"];
        $info = isset($_POST["info"]) ? mysqli_real_escape_string($connection, $_POST["info"]) : null;

        echo "WORK IN PROGRESS...";
    }
?>