<?php
    include "../command.php";
    include "../connection.php";
    require_once("../constants.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $volunteer = $_POST['volunteer'];
        $event = $_POST["event"];

        $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

        $query = "SELECT v.id, 
                        v.nome, 
                        v.cognome 
                    FROM volontari v
                    INNER JOIN volontari_evento ve ON v.id = ve.id_volontario
                    INNER JOIN eventi e ON e.id = ve.id_evento
                    WHERE v.id = '$volunteer' AND e.id = '$event'";
        $result = dbQuery($connection, $query);

        if (mysqli_num_rows($result) > 0) 
            echo "exists";
        else
            echo "not_exists"; 
    }
?>