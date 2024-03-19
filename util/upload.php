<?php
    require_once("constants.php");
    include("connection.php");
    include("command.php");
    include("cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    $fileUploaded = false;
    $assistedId = null;
    $volunteerId = null;
    $notes = null;

    if (isset($_POST["assisted"]))
        $assistedId = $_POST["assisted"];

    if (isset($_POST["volunteer"]))
        $volunteerId = $_POST["volunteer"];

    if (isset($_POST["notes"]))
        $notes = $_POST["notes"];

    if(isset($_FILES['release'])) {
        $uploadDirectory = '../release_module/'; 
    
        $fileName = $_FILES['release']['name'];
        $fileTmpName = $_FILES['release']['tmp_name'];
    
        // aggiungo il nome del file al percorso della cartella di destinazione
        $newFilePath = $uploadDirectory . $fileName;
    
        if(move_uploaded_file($fileTmpName, $newFilePath)) {
            $fileUploaded = true;
            $uploadedFileName = "/".$fileName;
        } else
            echo "Si è verificato un errore durante il caricamento del file.";
    } else
        echo "Nessun file selezionato";

    if ($fileUploaded) {
        $query = "INSERT INTO liberatorie(liberatoria, note)
                    VALUES('$uploadedFileName', '$notes');";
        $result = dbQuery($connection, $query);

        if ($result) {
            $module_id = $connection->insert_id;

            if ($assistedId != null) {
                $query = "UPDATE assistiti
                SET id_liberatoria = '$module_id'
                WHERE id = '$assistedId';";
                $result = dbQuery($connection, $query);

                if ($result) {
                    echo "Liberatoria caricata correttamente, stai per essere reindirizzato";
                    header("Refresh: 3; URL=../loginPage.php");
                }
            } else if ($volunteerId != null) {
                $query = "UPDATE volontari
                SET id_liberatoria = '$module_id'
                WHERE id = '$volunteerId';";
                $result = dbQuery($connection, $query);

                if ($result) {
                    echo "Liberatoria caricata correttamente, stai per essere reindirizzato";
                    header("Refresh: 3; URL=../loginPage.php");
                }
            }

            
        }
    } else 
        echo "errore di caricamento del file";
?>