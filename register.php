<?php 
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    // ottengo i dati scritti nel form
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $username = $_POST["username"];
    $password_clear = $_POST["password"];
    $email = $_POST["email"];
    $phone_f = $_POST["phone_f"];
    $phone_m = $_POST["phone_m"];
    $notes = $_POST["notes"];

    // inserisco l'utente nel db
    $password_enc = encryptPassword($password_clear);
    $query = "INSERT INTO utenti(nome, cognome, username, password, email, telefono_fisso, telefono_mobile, note, numero_accessi, id_profilo)
                VALUES ('$name', '$surname', '$username', '$password_enc', '$email', '$phone_f', '$phone_m', '$notes', 0, 5);";#
    $result = dbQuery($connection, $query);

    if ($result) {
        echo "account creato con successo";
    }
?>