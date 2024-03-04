<?php
    include "command.php";
    include "connection.php";
    require_once("command.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];

        $connection = connectToDatabase(DB_NAME);

        // Eseguo la query per verificare se l'email è già presente nel db
        $query = "SELECT username FROM username_password WHERE username = '$email'";
        $result = dbQuery($connection, $query);

        if (mysqli_num_rows($result) > 0)
            echo "exists";
        else
            echo "not_exists"; 
    }
?>