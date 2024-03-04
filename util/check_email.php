<?php
    include "command.php";
    include "connection.php";
    require_once("constants.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];

        $connection = connectToDatabase(DB_NAME);

        $query = "SELECT username FROM username_password WHERE username = '$email'";
        $result = dbQuery($connection, $query);

        if (mysqli_num_rows($result) > 0)
            echo "exists";
        else
            echo "not_exists"; 
    }
?>