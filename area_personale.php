<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();
    showMenu();

    $profile_type = null;
    $profile_func = null;
    $auth = null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        $result = getUserAuth($connection, $_SESSION["username"]);

        // salvo i permessi che ha l'utente che ha effettuato il login
        if ($result) {
            while($row = ($result->fetch_assoc())) {
                $profile_type = $row["tipo_profilo"];
                $profile_func = $row["tipo_funzione"];
                $auth = $row["operazione_permessa"];
            }
        } else
            echo "Si é verificato un problema recuperando i dati dal database, riprova piú tardi";

        // permetto determinate funzioni in base al tipo di profilo
        switch($profile_type) {
            case "presidente":
                welcome($_SESSION["username"]);
                $_SESSION["is_president"] = true;

                echo "<label>Effettua una delle seguenti operazioni</label><br><br>";
                echo "<button><a href='crud.php?operation=read_med'>READ su anamnesi</a></button><br><br>";
                echo "<button><a href='crud.php?operation=mng_adm'>Gestione Admin</a></button><br><br>";
            break;

            case "admin":
                welcome($_SESSION["username"]);
                $_SESSION["is_admin"] = true;

                echo "se leggi sei un admin";
            break;

            case "terapista":
                welcome($_SESSION["username"]);
                $_SESSION["is_terapist"] = true;

                echo "se leggi sei un terapista";
            break;

            case "genitore":
                welcome($_SESSION["username"]);
                $_SESSION["is_parent"] = true;

                // ottengo i dati dell'utente e li stampo
                echo "I tuoi dati:<br>";
                $result = getUserData($connection, $_SESSION["user_id"]);
                if ($result) {
                    createTable($result, "is_user");

                    // ottengo i dati degli assistiti collegati a questo utente e li stampo
                    echo "<br><br>I tuoi assistiti:<br>";
                    $result = getUserAssisted($connection, $_SESSION["user_id"]);
                    if ($result) {
                        createTable($result, "is_assisted");
                    }
                    else 
                        echo "Si é verificato un problema recuperando i dati dal database, riprova piú tardi";

                    // bottone per inserire un nuovo assistito
                    echo "<br><br><label>Inserisci un nuovo assistito</label><br>";
                    echo "<button><a href='register_assisted.php'>Vai alla pagina</a></button>";

                    // bottone per caricare la liberatoria
                    echo "<br><br><label>Inserisci la liberatoria firmata</label><br>";
                    echo "<button><a href='uploadPage.php'>Vai alla pagina</a></button>";
                } else 
                    echo "Si é verificato un problema recuperando i dati dal database, riprova piú tardi";
            break;
        }
    } else
        header("Location: loginPage.php");
?>