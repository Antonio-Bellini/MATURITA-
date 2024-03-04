<?php
    include "command.php";
    include "connection.php";
    require_once("command.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oldPassword = $_POST['oldPsw'];
        $newPassword = $_POST['newPsw'];

        $connection = connectToDatabase(DB_NAME);

        // Eseguo la query per verificare se la vecchia password é corretta
        if ($oldPassword === $newPassword) {
            echo "same_password";
            $_SESSION['newPswConfirmed'] = false;
        } else {
            $query = "SELECT password
                            FROM username_password
                            WHERE id_utente = '" . $_SESSION['id_utente'] . "'";
            $result = dbQuery($connection, $query);
            
            if (($result->num_rows) > 0) {
                while ($row = ($result->fetch_assoc())) {
                    if (check_password($row['password'], $oldPassword)) {
                        echo "correct";
                        $_SESSION['newPswConfirmed'] = true;
                    } else {
                        echo "not_correct";
                        $_SESSION['newPswConfirmed'] = false;
                    }
                }
            }
        }
    }
?>