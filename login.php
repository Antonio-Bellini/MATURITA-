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

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    }

    // eseguo la query sul db per controllare se username e password sono corretti
    if (!$_SESSION['is_logged']) {
        try {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                $query = "SELECT id, password
                            FROM utenti
                            WHERE username = '$username';";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        if (checkPassword($password, $row["password"])) {
                            $_SESSION["is_logged"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["user_id"] = $row["id"];
                            
                            showMenu();
                            welcome($username);
                        } else
                            echo "La password é errata, riprova...";
                            header("Location: loginPage.php; Refresh: 3");
                    }
                } else
                    echo "Si é veriricato un errore recuperando i dati dal database, riprova piú tardi.";
            } else
                header("Location: loginPage.php");
        } catch(Exception $e) {
            echo "Qualcosa é andato storto, riprova piú tardi";
        }
    } else {
        showMenu();
        welcome($_SESSION["username"]);
    }
?>