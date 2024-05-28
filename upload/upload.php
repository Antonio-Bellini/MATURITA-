<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");

    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    $assistedId = isset($_POST["assisted"]) ? $_POST["assisted"] : null;
    $volunteerId = isset($_POST["volunteer"]) ? $_POST["volunteer"] : null;
    $notes = isset($_POST["notes"]) ? $_POST["notes"] : null;
    $table = isset($_POST["table"]) ? $_POST["table"] : null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // caricamento della liberatoria
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                if (isset($_FILES['release'])) {
                    $uploadDirectory = 'release_module/'; 
                
                    $fileName = $_FILES['release']['name'];
                    $fileTmpName = $_FILES['release']['tmp_name'];
                
                    // aggiungo il nome del file al percorso della cartella di destinazione
                    $newFilePath = $uploadDirectory . $fileName;
                
                    if (move_uploaded_file($fileTmpName, $newFilePath)) {
                        $uploadedFileName = "release_module/" . $fileName;

                        $stmt = $connection->prepare("INSERT INTO liberatorie(liberatoria, note)
                                                        VALUES(?, ?)");
                        $stmt->bind_param("ss", $uploadedFileName, $notes);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if (!$stmt->error) {
                            $module_id = $connection->insert_id;

                            if ($assistedId != null) {
                                $stmt = $connection->prepare("UPDATE assistiti
                                                                SET id_liberatoria = ?
                                                                WHERE id = ?");
                                $stmt->bind_param("ii", $module_id, $assistedId);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if (!$stmt->error) {
                                    $_SESSION["file_uploaded"] = true;
                                    header("Location: ../private/area_personale.php");
                                } else {
                                    $_SESSION["file_not_uploaded"] = true;
                                    header("Location: ../private/area_personale.php");
                                }
                            } else if ($volunteerId != null) {
                                $stmt = $connection->prepare("UPDATE volontari
                                                                SET id_liberatoria = ?
                                                                WHERE id = ?");
                                $stmt->bind_param("ii", $module_id, $volunteerId);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if (!$stmt->error) {
                                    $_SESSION["file_uploaded"] = true;
                                    header("Location: ../private/area_personale.php");
                                } else {
                                    $_SESSION["file_not_uploaded"] = true;
                                    header("Location: ../private/area_personale.php");
                                }
                            } else 
                                echo ERROR_GEN;
                        }
                    } else {
                        nav_menu();
                        echo ERROR_GEN;
                    }
                }
            }

            // caricamento di file nella bacheca o nella newsletter
            if (isset($_FILES[$table])) {
                $uploadDirectory = "../" . $table . "/files/"; 
            
                $fileName = $_FILES[$table]['name'];
                $fileTmpName = $_FILES[$table]['tmp_name'];
                $date = $_POST["date"];

                // aggiungo il nome del file al percorso della cartella di destinazione
                $newFilePath = $uploadDirectory . $fileName;
            
                if(move_uploaded_file($fileTmpName, $newFilePath)) {
                    $uploadedFileName = "files/" . $fileName;

                    $stmt = $connection->prepare("INSERT INTO $table($table, data)
                                                    VALUES(?, ?)");
                    $stmt->bind_param("ss", $uploadedFileName, $date);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (!$stmt->error) {
                        $_SESSION["file_uploaded"] = true;
                        header("Location: ../" . $table . "/" . $table . ".php");
                    } else {
                        $_SESSION["file_not_uploaded"] = true;
                        header("Location: ../" . $table . "/" . $table . ".php");
                    }
                }
            }

            // caricamento di file anamnesi
            if (isset($_FILES["medical"])) {
                $uploadDirectory = "medical_module/"; 
            
                $fileName = $_FILES["medical"]['name'];
                $fileTmpName = $_FILES["medical"]['tmp_name'];

                // aggiungo il nome del file al percorso della cartella di destinazione
                $newFilePath = $uploadDirectory . $fileName;
            
                if(move_uploaded_file($fileTmpName, $newFilePath)) {
                    $uploadedFileName = "medical_module/" . $fileName;

                    $stmt = $connection->prepare("UPDATE assistiti SET anamnesi = ? WHERE id = ?");
                    $stmt->bind_param("si", $uploadedFileName, $assistedId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (!$stmt->error) {
                        $_SESSION["file_uploaded"] = true;
                        header("Location: ../private/area_personale.php");
                    } else {
                        $_SESSION["file_not_uploaded"] = true;
                        header("Location: ../private/area_personale.php");
                    }
                }
            } else {
                nav_menu();
                echo NO_FILE;
            }
        } else 
            header("Location: ../index.php");
    } else 
        header("Location: ../index.php");
?>