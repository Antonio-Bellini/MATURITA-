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

        if ($result) {
            showMenu();
            echo "account creato con successo";
        }
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
        $result = dbQuery($connection, $query);

        if ($result) {
            showMenu_logged();
            echo "Account creato con successo";
        } else 
            echo "si é verificato un errore, riprova piú tardi";
    } else if (isset($_POST["form_assisted"])) {
        $uploadedFileName = null;
        $fileUploaded = false;
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $notes = $_POST["notes"];
        
        if(isset($_FILES['med'])) {
            $uploadDirectory = 'medical_module/'; 
        
            $fileName = $_FILES['med']['name'];
            $fileTmpName = $_FILES['med']['tmp_name'];
        
            // Aggiungi il nome del file al percorso della cartella di destinazione
            $newFilePath = $uploadDirectory . $fileName;
        
            if(move_uploaded_file($fileTmpName, $newFilePath)) {
                $fileUploaded = true;
                $uploadedFileName = "/".$fileName;
            } else
                echo "Si è verificato un errore durante il caricamento del file.";
        } else
            echo "Nessun file selezionato";
        
        // inserimento dell'assistito nel db
        $query = "INSERT INTO assistiti(nome, cognome, anamnesi, note, id_referente)
                  VALUES('$name', '$surname', '$uploadedFileName', '$notes', '{$_SESSION['user_id']}');";
        $result = dbQuery($connection, $query);
        
        if ($result && $fileUploaded) {
            showMenu();
            echo "Account creato con successo<br>";
            echo "File dell'anamnesi caricato correttamente";
        } else
            echo "Si è verificato un errore durante l'inserimento, riprova più tardi";
    } else 
        echo "Non é stato compilato nessun form";
?>