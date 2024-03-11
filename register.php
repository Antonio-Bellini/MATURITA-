<?php 
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    if (isset($_POST["form_user"])) {
        // ottengo i dati scritti nel form
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $username = $_POST["username"];
        $password_clear = $_POST["password"];
        $email = $_POST["email"];
        $phone_f = $_POST["phone_f"];
        $phone_m = $_POST["phone_m"];
        $notes = $_POST["notes"];

        // inserimento  dell'utente nel db
        $password_enc = encryptPassword($password_clear);
        $query = "INSERT INTO utenti(nome, cognome, username, password, email, telefono_fisso, telefono_mobile, note, numero_accessi, id_profilo)
                    VALUES ('$name', '$surname', '$username', '$password_enc', '$email', '$phone_f', '$phone_m', '$notes', 0, 4);";
        $result = dbQuery($connection, $query);

        if ($result)
            echo "account creato con successo";
    } else if (isset($_POST["form_volunteer"])) {
        // ottengo i dati scritti nel form
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $phone_f = $_POST["phone_f"];
        $phone_m = $_POST["phone_m"];

        // inserimento dell'utente nel db
        $query = "INSERT INTO volontari(nome, cognome, email, telefono_fisso, telefono_mobile)
                    VALUES('$name', '$surname', '$email', '$phone_f', '$phone_m');";
    } else if (isset($_POST["form_assisted"])) {
        // ottengo i dati scritti nel form
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $med = $_POST["med"];
        $notes = $_POST["notes"];

        // inserimento dell'assistito nel db
        $query = "INSERT INTO assistiti(nome, cognome, anamnesi, note, id_referente)
                VALUES('$name', '$surname', '$med', '$notes', '{$_SESSION['user_id']}');";
        $result = dbQuery($connection, $query);

        if ($result) {
            showMenu();
            echo "Account creato con successo";
        } else 
            echo "Si é verificato un errore in inserimento, riprova piú tardi";
    } else 
        echo "Non é stato compilato nessun form";
?>