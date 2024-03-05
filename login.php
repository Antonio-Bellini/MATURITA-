<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    // inizalizzo la sessione per salvare il login dell'utente
    if (!isset($_SESSION["is_logged"]))
        $_SESSION["is_logged"] = false;

    $username = $_POST["username"];
    $password = $_POST["password"];

    // eseguo la query sul db per controllare se username e password sono corretti
    if (!$_SESSION['is_logged']) {
        try {
            $query = "SELECT password
                        FROM utenti
                        WHERE email = '$username';";
            $result = dbQuery($connection, $query);

            if ($result) {
                $password_enc = HASH("sha256", $password);
                
                while ($row = ($result->fetch_assoc())) {
                    if ($row["password"] === $password_enc) {
                        $_SESSION["is_logged"] = true;

                        welcome($username);

                        $query = "SELECT u.numero_accessi AS accessi_utente,
                                            tp.tipo AS tipo_profilo,
                                            tf.tipo AS tipo_funzione,
                                            p.tipo_operazione AS operazione_permessa
                                    FROM utenti u 
                                    INNER JOIN profili p ON u.id_profilo = p.id
                                    INNER JOIN tipi_profilo tp ON tp.id = p.tipo_profilo
                                    INNER JOIN tipi_funzione tf ON tf.id = p.tipo_funzione
                                    WHERE username = '$username';";
                                    $result = dbQuery($connection, $query);

                        if ($result) {
                            while ($row = ($result->fetch_assoc())) {
                                $numero_accessi = $row["accessi_utente"];
                                $tipo_profilo = $row["tipo_profilo"];
                                $tipo_funzione = $row["tipo_funzione"];
                                $operazione_permessa = $row["operazione_permessa"];

                                echo $numero_accessi . ", " . $tipo_profilo . ", " . $tipo_funzione . ", " . $operazione_permessa;
                            }
                        } {
                    
                        }
                    } else {
                        echo "La password é errata, stai per essere reindirizzato..."
                        header("Refresh: 3; url: loginPage.php");
                    }
                }
            } else
                echo "Il server ha restituito un errore, riprova piú tardi";
        } catch(Exception) {
            echo "Problema interno, riprova piú tardi";
        }
    } else {
        welcome($username);

        $query = "SELECT u.numero_accessi AS accessi_utente,
                            tp.tipo AS tipo_profilo,
                            tf.tipo AS tipo_funzione,
                            p.tipo_operazione AS operazione_permessa
                    FROM utenti u 
                    INNER JOIN profili p ON u.id_profilo = p.id
                    INNER JOIN tipi_profilo tp ON tp.id = p.tipo_profilo
                    INNER JOIN tipi_funzione tf ON tf.id = p.tipo_funzione
                    WHERE username = '$username';";
                    $result = dbQuery($connection, $query);

        if ($result) {
            while ($row = ($result->fetch_assoc())) {
                $numero_accessi = $row["accessi_utente"];
                $tipo_profilo = $row["tipo_profilo"];
                $tipo_funzione = $row["tipo_funzione"];
                $operazione_permessa = $row["operazione_permessa"];

                echo $numero_accessi . ", " . $tipo_profilo . ", " . $tipo_funzione . ", " . $operazione_permessa;
            }
        }
    }
?>