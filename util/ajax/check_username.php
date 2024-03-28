<?php
    include "../command.php";
    include "../connection.php";
    require_once("../constants.php");

    // controllo della disponibilitá di uno username
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];

        $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

        $query = "SELECT username FROM utenti WHERE username = '$username'";
        $result = dbQuery($connection, $query);

        if (mysqli_num_rows($result) > 0)
            echo "exists";
        else
            echo "not_exists"; 
    }
?>