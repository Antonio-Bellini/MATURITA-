<?php
    include "../command.php";
    include "../connection.php";
    require_once("../constants.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

        $query1 = "SELECT a.id,
                            l.id,
                            l.LIBERATORIA,
                            l.NOTE,
                            a.nome AS 'NOME ASSISTITO',
                            a.cognome AS 'COGNOME ASSISTITO',
                            u.nome AS 'NOME REFERENTE',
                            u.cognome AS 'COGNOME REFERENTE'
                    FROM liberatorie l
                    INNER JOIN assistiti a ON l.id = a.id_liberatoria
                    INNER JOIN utenti u ON a.id_referente = u.id";
        $result1 = dbQuery($connection, $query1);

        $query2 = "SELECT l.id,
                            l.LIBERATORIA,
                            l.NOTE,
                            v.nome AS 'NOME VOLONTARIO',
                            v.cognome AS 'COGNOME VOLONTARIO'
                    FROM liberatorie l
                    INNER JOIN volontari v ON l.id = v.id_liberatoria";
        $result2 = dbQuery($connection, $query2);
                
        if ($result1 && $result2) {
            $response = array(
                'result1' => createTable($result1, "rls"),
                'result2' => createTable($result2, "rls")
            );
            return $response;
        } else 
            echo ERROR_DB;
    }
?>