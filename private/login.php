<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    // inizalizzo la sessione per salvare il login dell'utente
    if (!isset($_SESSION["is_logged"]))
        $_SESSION["is_logged"] = false;

    // dati forniti dall'utente
    $username = $_POST["username"];
    $password = $_POST["password"];

    // eseguo la query sul db per controllare se username e password sono corretti
    if (!$_SESSION['is_logged']) {
        try {
            $query = "SELECT password
                        FROM utenti
                        WHERE username = '$username';";
            $result = dbQuery($connection, $query);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    if (checkPassword($password, $row["password"])) {
                        $_SESSION["is_logged"] = true;

                        welcome($username);
                        showMenu();
                        $result = getUserAuth($connection, $username);

                        if ($result) {
                            createTable($result);
                            while ($row = ($result->fetch_assoc())) {
                                $numero_accessi = $row["accessi_utente"];
                                $tipo_profilo = $row["tipo_profilo"];
                                $tipo_funzione = $row["tipo_funzione"];
                                $operazione_permessa = $row["operazione_permessa"];
                            }
                        } else 
                            echo "Si é veriricato un errore recuperando i dati dal database, riprova piú tardi.";
                    } else
                        echo "La password é errata, riprova";
                }
            } else
                echo "Si é veriricato un errore recuperando i dati dal database, riprova piú tardi.";
        } catch(Exception) {
            echo "Qualcosa é andato storto, riprova piú tardi";
        }
    } else {
        welcome($username);
        showMenu();
        $result = getUserAuth($connection, $username);

        if ($result) {
            createTable($result);
            while ($row = ($result->fetch_assoc())) {
                $numero_accessi = $row["accessi_utente"];
                $tipo_profilo = $row["tipo_profilo"];
                $tipo_funzione = $row["tipo_funzione"];
                $operazione_permessa = $row["operazione_permessa"];
            }
        } else 
            echo "Si é veriricato un errore recuperando i dati dal database, riprova piú tardi.";
    }
?>