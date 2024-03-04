<?php
    include "command.php";
    include "connection.php";
    require_once("command.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oldPassword = $_POST['oldPsw'];
        $newPassword = $_POST['newPsw'];

        $connection = connectToDatabase(DB_NAME);

        // CONFRONTO tra PASSWORD VECCHIA e NUOVA
        if ($oldPassword === $newPassword)
            echo "same_password";
        else {
            $query = "SELECT password
                        FROM username_password
                        WHERE id_utente = '" . $_SESSION['id_utente'] . "'";
            $result = dbQuery($connection, $query);
            
            if (($result->num_rows) > 0) {
                while ($row = ($result->fetch_assoc())) {
                    if (check_password($row['password'], $oldPassword))
                        echo "correct";
                    else
                        echo "not_correct";
                }
            }
        }
    }
?>