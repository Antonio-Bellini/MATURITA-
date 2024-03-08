<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    showMenu();

    $profile_type = null;
    $profile_func = null;
    $auth = null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        $result = getUserAuth($connection, $_SESSION["username"]);

        // salvo i permessi che l'utente che ha effettuato il login ha
        if ($result) {
            while($row = ($result->fetch_assoc())) {
                $profile_type = $row["tipo_profilo"];
                $profyle_func = $row["tipo_funzione"];
                $auth = $row["operazione_permessa"];
            }
        } else
            echo "Si é verificato un problema recuperando i dati dal database, riprova piú tardi";

        // permetto determinate funzioni in base al tipo di profilo
        switch($profile_type) {
            case "presidente":
            break;

            case "admin":
            break;

            case "terapista":
            break;

            case "genitore":
                welcome($_SESSION["username"]);

                // ottengo i dati dell'utente e li stampo in forma tabellare
                $result = getUserData($connection, $_SESSION["user_id"]);
                echo "I tuoi dati:<br>";
                if ($result) {
                    createTable($result);

                    // ottengo i dati degli assistiti collegati a questo utente
                    $result = getUserAssisted($connection, $_SESSION["user_id"]);
                    echo "<br><br>I tuoi assistiti:<br>";
                    if ($result)
                        createTable($result);
                    else 
                        echo "Si é verificato un problema recuperando i dati dal database, riprova piú tardi";

                    // bottone per inserire un nuovo assistito
                    echo "<br><br><label>Inserisci un nuovo assistito</label><br>";
                    echo "<button><a href='register_assisted.php'>Vai alla pagina</a></button>";
                } else 
                    echo "Si é verificato un problema recuperando i dati dal database, riprova piú tardi";
            break;
        }
    } else {
        echo "prima devi effettuare il login";
    }
?>