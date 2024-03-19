<?php
    include "../command.php";
    include "../connection.php";
    require_once("../constants.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oldPassword = $_POST['old_psw'];
        $newPassword = $_POST['new_psw'];

        $connection = connectToDatabase(DB_NAME);

        // CONFRONTO tra PASSWORD VECCHIA e NUOVA
        if ($oldPassword === $newPassword)
            echo "same_password";
        else {
            $query = "SELECT password
                        FROM utenti
                        WHERE id = '" . $_SESSION['user_id'] . "'";
            $result = dbQuery($connection, $query);
            
            if (($result->num_rows) > 0) {
                while ($row = ($result->fetch_assoc())) {
                    if (checkPassword($oldPassword, $row['password']))
                        echo "correct";
                    else
                        echo "not_correct";
                }
            }
        }
    }
?>