<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_HOST, USER_ADMIN, ADMIN_PW, DB_NAME);
    session_start();

    $assistedId = null;
    $volunteerId = null;
    $notes = null;

    if (isset($_POST["assisted"]))
        $assistedId = $_POST["assisted"];

    if (isset($_POST["volunteer"]))
        $volunteerId = $_POST["volunteer"];

    if (isset($_POST["notes"]))
        $notes = $_POST["notes"];

    // caricamento della liberatoria
    if(isset($_FILES['release'])) {
        $uploadDirectory = 'release_module/'; 
    
        $fileName = $_FILES['release']['name'];
        $fileTmpName = $_FILES['release']['tmp_name'];
    
        // aggiungo il nome del file al percorso della cartella di destinazione
        $newFilePath = $uploadDirectory . $fileName;
    
        if(move_uploaded_file($fileTmpName, $newFilePath)) {
            $uploadedFileName = "/" . $fileName;

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
                        echo FILE_OK;
                        header("Refresh: 3; URL=../private/loginPage.php");
                    } else {
                        echo ERROR_FILE;
                        header("Refresh: 3; URL=../private/loginPage.php");
                    }
                } else if ($volunteerId != null) {
                    $query = "UPDATE volontari
                                SET id_liberatoria = '$module_id'
                                WHERE id = '$volunteerId';";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        echo FILE_OK;
                        header("Refresh: 3; URL=../private/loginPage.php");
                    } else {
                        echo ERROR_FILE;
                        header("Refresh: 3; URL=../private/loginPage.php");
                    }
                }
            }
        } else {
            echo GEN_ERROR;
            header("Refresh: 3; URL=../private/loginPage.php");
        }

    // caricamento di file nella bacheca
    } else if (isset($_FILES['bacheca'])) {
        $uploadDirectory = '../bacheca/files/'; 
    
        $fileName = $_FILES['bacheca']['name'];
        $fileTmpName = $_FILES['bacheca']['tmp_name'];
        $date = date("Y-m-d");

        // aggiungo il nome del file al percorso della cartella di destinazione
        $newFilePath = $uploadDirectory . $fileName;
    
        if(move_uploaded_file($fileTmpName, $newFilePath)) {
            $uploadedFileName = "/" . $fileName;

            $query = "INSERT INTO bacheca(bacheca, data)
                            VALUES('$uploadedFileName', '$date');";
            $result = dbQuery($connection, $query);

            if ($result) {
                echo FILE_OK;
                header("Refresh: 3; URL=../bacheca.php");
            }
        }
    } else {
        echo NO_FILE;
        header("Refresh: 3; URL=../private/loginPage.php");
    }
?>