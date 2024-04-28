<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    session_start();

    // Elaborazione del modulo di eliminazione
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
        $table = $_POST["table_sel"];
        $file_id = $_POST["file_id"];
        $file_name = null;

        $query = "SELECT $table FROM $table WHERE id = '$file_id'";
        $result = dbQuery($connection, $query);

        if ($result) {
            while ($row = ($result->fetch_assoc()))
                $file_name = $row[$table];

            $query = "DELETE FROM $table WHERE id = '$file_id'";
            $result = dbQuery($connection, $query);

            if ($result) {
                if (unlink("../$table/$file_name")) {
                    $_SESSION["file_deleted"] = true;
                    header("Location: ../{$table}/{$table}.php");
                } else 
                    echo ERROR_DB; 
            } else 
                echo ERROR_DB;
        } else 
            echo ERROR_DB;
    } else 
        header("Location: ../index.php");
?>