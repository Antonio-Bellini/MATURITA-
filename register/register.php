<?php 
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");

    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["form_user"])) {
                    // ottengo i dati scritti nel form e li sanifico
                    $name = mysqli_real_escape_string($connection, $_POST['name']);
                    $surname = mysqli_real_escape_string($connection, $_POST["surname"]);
                    $username = mysqli_real_escape_string($connection, $_POST["username"]);
                    $password_clear = mysqli_real_escape_string($connection, $_POST["password"]);
                    $email = mysqli_real_escape_string($connection, $_POST["email"]);
                    $phone_f = $_POST["phone_f"];
                    $phone_m = $_POST["phone_m"];
                    $notes = isset($_POST["notes"]) ? mysqli_real_escape_string($connection, $_POST["notes"]) : null;

                    if (isset($_POST["form_terapist"])) 
                        $profile = $_POST["form_terapist"];
                    else if (isset($_POST["form_president"]))
                        $profile = $_POST["form_president"];
                    else 
                        $profile = 4;

                    // inserimento  dell'utente nel db
                    $password_enc = encryptPassword($password_clear);
                    $stmt = $connection->prepare("INSERT INTO utenti(nome, cognome, username, password, email, telefono_fisso, telefono_mobile, note, id_profilo)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssssssi", $name, $surname, $username, $password_enc, $email, $phone_f, $phone_m, $notes, $profile);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (!$stmt->error) {
                        $_SESSION["user_created"] = true;
                        header("Location: ../private/area_personale.php");
                    } else {
                        $_SESSION["user_not_created"] = true;
                        header("Location: ../private/area_personale.php");
                    }
                } else if (isset($_POST["form_volunteer"])) {
                    // ottengo i dati scritti nel form e li sanifico
                    $name = mysqli_real_escape_string($connection, $_POST["name"]);
                    $surname = mysqli_real_escape_string($connection, $_POST["surname"]);
                    $email = mysqli_real_escape_string($connection, $_POST["email"]);
                    $phone_f = $_POST["phone_f"];
                    $phone_m = $_POST["phone_m"];
                    $notes = isset($_POST["notes"]) ? mysqli_real_escape_string($connection, $_POST["notes"]) : null;

                    $uploadDirectory = '../upload/release_module/'; 
                
                    $fileName = $_FILES['release']['name'];
                    $fileTmpName = $_FILES['release']['tmp_name'];
                
                    // Aggiungi il nome del file al percorso della cartella di destinazione
                    $newFilePath = $uploadDirectory . $fileName;
                
                    if(move_uploaded_file($fileTmpName, $newFilePath)) {
                        $uploadedFileName = "release_module/" . $fileName;
                        $stmt = $connection->prepare("INSERT INTO liberatorie(liberatoria, note) VALUES(?, ?)");
                        $stmt->bind_param("ss", $uploadedFileName, $notes);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $query = "INSERT INTO liberatorie(liberatoria, note) VALUES('$uploadedFileName', '$notes')";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $lastId = $connection -> insert_id;

                            // inserimento dell'utente nel db
                            $stmt = $connection->prepare("INSERT INTO volontari(nome, cognome, email, telefono_fisso, telefono_mobile, id_liberatoria)
                                                            VALUES(?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("sssssi", $name, $surname, $email, $phone_f, $phone_m, $lastId);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if (!$stmt->error) {
                                $_SESSION["user_created"] = true;
                                header("Location: ../private/area_personale.php");
                            } else {
                                $_SESSION["user_not_created"] = true;
                                header("Location: ../private/area_personale.php");
                            }
                        }
                    } else {
                        $_SESSION["file_not_uploaded"] = true;
                        header("Location: ../private/area_personale.php");
                    }
                } else if (isset($_POST["form_assisted"])) {
                    // ottengo i dati dal form e li sanifico
                    $name = mysqli_real_escape_string($connection, $_POST["name"]);
                    $surname = mysqli_real_escape_string($connection, $_POST["surname"]);
                    $notes = isset($_POST["notes"]) ? mysqli_real_escape_string($connection, $_POST["notes"]) : null;
                    $parent = null;
                    
                    $uploadDirectory = '../upload/medical_module/'; 
                
                    $fileName = $_FILES['med']['name'];
                    $fileTmpName = $_FILES['med']['tmp_name'];
                
                    // Aggiungi il nome del file al percorso della cartella di destinazione
                    $newFilePath = $uploadDirectory . $fileName;
                
                    if(move_uploaded_file($fileTmpName, $newFilePath)) {
                        $uploadedFileName = "medical_module/" . $fileName;

                        if (isset($_POST["parent"]))
                            $parent = $_POST["parent"];
                        else 
                            $parent = $_SESSION["user_id"];

                        // caricamento della liberatoria in locale
                        $fileName = $_FILES['rel']['name'];
                        $fileTmpName = $_FILES['rel']['tmp_name'];
                        $uploadDirectory = '../upload/release_module/';

                        $newFilePath = $uploadDirectory . $fileName;

                        if (move_uploaded_file($fileTmpName, $newFilePath)) {
                            $uploadedFileName = "release_module/" . $fileName;
                            
                            // inserimento della liberatoria nel db
                            $stmt = $connection->prepare("INSERT INTO liberatorie(liberatoria) 
                                                            VALUES(?)");
                            $stmt->bind_param("s", $uploadedFileName);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // inserimento dell'assistito nel db se il caricamento dei file é andato a buon fine
                            if (!$stmt->error) {
                                $rel_id = $connection->insert_id;

                                $stmt = $connection->prepare("INSERT INTO assistiti(nome, cognome, anamnesi, note, id_referente, id_liberatoria)
                                                            VALUES(?, ?, ?, ?, ?, ?)");
                                $stmt->bind_param("ssssii", $name, $surname, $uploadedFileName, $notes, $parent, $rel_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if (!$stmt->error) {
                                    $_SESSION["user_created"] = true;
                                    header("Location: ../private/area_personale.php");
                                } else {
                                    $_SESSION["user_not_created"] = true;
                                    header("Location: ../private/area_personale.php");
                                }
                            } else 
                                echo ERROR_DB;
                        } else {
                            $_SESSION["file_not_uploaded"] = true;
                            header("Location: ../private/area_personale.php");
                        }
                    } else {
                        $_SESSION["file_not_uploaded"] = true;
                        header("Location: ../private/area_personale.php");
                    }
                } else {
                    nav_menu();
                    echo NO_FORM;
                }
            } else 
                header("Location: ../index.php");
        }
    } else 
        header("Location: ../index.php");
?>