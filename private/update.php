<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");

    session_start();

    $type = $_POST["type"];
    $userId = $_POST["user_id"];
    $update_query = null;
    $new_data = array();

    if (!empty($new_data)) 
        $new_data = array();

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            switch ($type) {
                case "user":
                    $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
                    $update_query = "UPDATE utenti SET ";

                    if (!empty($_POST["new_name"])) {
                        $new_name = mysqli_real_escape_string($connection, $_POST['new_name']);
                        $new_data[] = "nome = '{$new_name}'";
                    }
                        
                    if (!empty($_POST["new_surname"])) {
                        $new_surname = mysqli_real_escape_string($connection, $_POST['new_surname']);
                        $new_data[] = "cognome = '{$new_surname}'";
                    }

                    if (!empty($_POST["new_email"]))
                        $new_data[] = "email = '{$_POST["new_email"]}'";

                    if (!empty($_POST["new_tf"])) 
                        $new_data[] = "telefono_fisso = '{$_POST["new_tf"]}'";

                    if (!empty($_POST["new_tm"])) 
                        $new_data[] = "telefono_mobile = '{$_POST["new_tm"]}'";

                    if (!empty($_POST["old_psw"]) && !empty($_POST["new_psw"])) {
                        $new_psw_enc = encryptPassword($_POST["new_psw"]);
                        $new_data[] = "password = '{$new_psw_enc}'";
                    }

                    // Controlla se ci sono colonne da aggiornare
                    if (!empty($new_data)) {
                        $update_query .= implode(", ", $new_data);
                        $update_query .= " WHERE id = $userId";
                        $result = dbQuery($connection, $update_query);

                        if ($result) {
                            $_SESSION["user_modified"] = true;
                            header("Location: area_personale.php");
                        } else
                            echo ERROR_DB;
                    } else {
                        $_SESSION["user_not_modified"] = true;
                        header("Location: area_personale.php");
                    }
                    break;

                case "assisted":
                    $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
                    $update_query = "UPDATE assistiti SET ";

                    if (!empty($_POST["new_name"])) {
                        $new_name = mysqli_real_escape_string($connection, $_POST['new_name']);
                        $new_data[] = "nome = '{$new_name}'";
                    }
                        

                    if (!empty($_POST["new_surname"])) {
                        $new_surname = mysqli_real_escape_string($connection, $_POST['new_surname']);
                        $new_data[] = "cognome = '{$new_surname}'";
                    }

                    if (!empty($new_data)) {
                        $update_query .= implode(", ", $new_data);
                        $update_query .= " WHERE id = $userId";
                        $result = dbQuery($connection, $update_query);

                        if ($result) {
                            $_SESSION["user_modified"] = true;
                            header("Location: area_personale.php");
                        } else
                            echo ERROR_DB;
                    } else {
                        $_SESSION["user_not_modified"] = true;
                        header("Location: area_personale.php");
                    }
                    break;

                case "volunteer":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $update_query = "UPDATE volontari SET ";

                    if (!empty($_POST["new_name"])) {
                        $new_name = mysqli_real_escape_string($connection, $_POST['new_name']);
                        $new_data[] = "nome = '{$new_name}'";
                    }

                    if (!empty($_POST["new_surname"])) {
                        $new_surname = mysqli_real_escape_string($connection, $_POST['new_surname']);
                        $new_data[] = "cognome = '{$new_surname}'";
                    }

                    if (!empty($_POST["new_email"]))
                        $new_data[] = "email = '{$_POST["new_email"]}'";

                    if (!empty($_POST["new_tf"])) 
                        $new_data[] = "telefono_fisso = '{$_POST["new_tf"]}'";

                    if (!empty($_POST["new_tm"])) 
                        $new_data[] = "telefono_mobile = '{$_POST["new_tm"]}'";

                    if (!empty($new_data)) {
                        $update_query .= implode(", ", $new_data);
                        $update_query .= " WHERE id = $userId";
                        $result = dbQuery($connection, $update_query);

                        if ($result) {
                            $_SESSION["user_modified"] = true;
                            header("Location: area_personale.php");
                        } else
                            echo ERROR_DB;
                    } else {
                        $_SESSION["user_not_modified"] = true;
                        header("Location: area_personale.php");
                    }
                    break;

                case "update_event":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $update_query = "UPDATE eventi SET ";

                    if (!empty($_POST["new_eventType"]))
                        $new_data[] = "tipo_evento = '{$_POST["new_eventType"]}'";

                    if (!empty($_POST["new_date"]))
                        $new_data[] = "data = '{$_POST["new_date"]}'";

                    if (!empty($new_data)) {
                        $update_query .= implode(", ", $new_data);
                        $update_query .= " WHERE id = $userId";
                        $result = dbQuery($connection, $update_query);

                        if ($result) {
                            $_SESSION["event_modified"] = true;
                            header("Location: area_personale.php");
                        } else
                            echo ERROR_DB;
                    } else {
                        $_SESSION["event_not_modified"] = true;
                        header("Location: area_personale.php");
                    }
                    break;

                case "update_eventType":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $update_query = "UPDATE tipi_evento SET ";

                    if (!empty($_POST["new_name"])) {
                        $new_name = mysqli_real_escape_string($connection, $_POST['new_name']);
                        $update_query .= "tipo = '{$new_name}' WHERE id = $userId";
                        $result = dbQuery($connection, $update_query);

                        if ($result) {
                            $_SESSION["event_modified"] = true;
                            header("Location: area_personale.php");
                        } else
                            echo ERROR_DB;
                    } else {
                        $_SESSION["event_not_modified"] = true;
                        header("Location: area_personale.php");
                    }
                    break;

                case "index_info":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $query = null;
                    $new_data = array();
                    $update = false;
            
                    $query_check = "SELECT anni_associazione, volontari_attivi, famiglie_aiutate FROM registro_associazione";
                    $result_check = dbQuery($connection, $query_check);
            
                    if ($result_check) {
                        if ($result_check->num_rows > 0)
                            $update = true;
                    } else
                        echo ERROR_DB;
            
                    if ($update) {
                        $query = "UPDATE registro_associazione SET ";
            
                        if (!empty($new_data)) 
                            $new_data = array();
            
                        if (!empty($_POST["newYears"])) {
                            $new_years = intval($_POST["newYears"]);
                            $new_data[] = "anni_associazione = '{$new_years}'";
                        }
            
                        if (!empty($_POST["newVolunteers"])) {
                            $new_volunteers = intval($_POST["newVolunteers"]);
                            $new_data[] = "volontari_attivi = '{$new_volunteers}'";
                        }
            
                        if (!empty($_POST["newFamilies"])) {
                            $new_family = intval($_POST["newFamilies"]);
                            $new_data[] = "famiglie_aiutate = '{$new_family}'";
                        }
            
                        if (!empty($new_data)) {
                            $query .= implode(", ", $new_data);
                        } else {
                            $_SESSION["user_not_modified"] = true;
                            header("Location: ../index.php");
                        }
                    } else {
                        $years = isset($_POST["newYears"]) ? intval($_POST["newYears"]) : null;
                        $activeVolunteers = isset($_POST["newVolunteers"]) ? intval($_POST["newVolunteers"]) : null;
                        $helpedFamiles = isset($_POST["newFamilies"]) ? intval($_POST["newFamilies"]) : null;
            
                        $query = "INSERT INTO registro_associazione(anni_associazione, volontari_attivi, famiglie_aiutate) 
                                            VALUES($years, $activeVolunteers, $helpedFamiles)";
                    }
            
                    $result = dbQuery($connection, $query);
            
                    if ($result) {
                        $_SESSION["user_modified"] = true;
                        $update = false;
                        header("Location: ../index.php");
                    } else
                        echo ERROR_DB;
                    break;

                case "index_news":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $uploadDirectory = '../image/news/'; 
                    $fileName = $_FILES['news__image']['name'];
                    $fileTmpName = $_FILES['news__image']['tmp_name'];
                    $newFilePath = $uploadDirectory . $fileName;

                    if (move_uploaded_file($fileTmpName, $newFilePath)) {
                        $uploadedFileName = "news/" . $fileName;
                        $title = $_POST["news__title"];
                        $date = $_POST["news__date"];
                        $text = mysqli_real_escape_string($connection, $_POST["news__text"]);

                        $stmt = $connection->prepare("INSERT INTO immagini(path, id_titolo) VALUES(?, null)");
                        $stmt->bind_param("s", $uploadedFileName);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if (!$stmt->error) {
                            $id_image = $connection->insert_id;

                            $stmt = $connection->prepare("INSERT INTO news(id_image, titolo, data, testo) 
                                                            VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("isss", $id_image, $title, $date, $text);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if (!$stmt->error) {
                                $_SESSION["user_modified"] = true;
                                header("Location: ../index.php");
                            } else 
                                echo ERROR_DB;
                        } else
                            echo ERROR_DB;

                        $stmt->close();
                    } else {
                        echo ERROR_GEN;
                    }
                    break;

                case "gallery_img":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $uploadDirectory = '../image/ragazzi/'; 
                    $fileName = $_FILES['ragazzi__image']['name'];
                    $fileTmpName = $_FILES['ragazzi__image']['tmp_name'];
                    $newFilePath = $uploadDirectory . $fileName;
                    $section = $_POST["title"];

                    if (move_uploaded_file($fileTmpName, $newFilePath)) {
                        $uploadedFileName = "ragazzi/" . $fileName;

                        $stmt = $connection->prepare("INSERT INTO immagini(path, id_titolo) VALUES(?, ?)");
                        $stmt->bind_param("ss", $uploadedFileName, $section);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if (!$stmt->error) {
                            $_SESSION["user_modified"] = true;
                            header("Location: ../image/gallery.php");
                        } else {
                            echo ERROR_DB;
                        }

                        $stmt->close();
                    } else {
                        echo ERROR_GEN;
                    }
                    break;

                case "gallery_section":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $sectionTitle = mysqli_real_escape_string($connection, $_POST["section_title"]);
                
                    $stmt = $connection->prepare("INSERT INTO sezioni_foto(titolo) VALUES(?)");
                    $stmt->bind_param("s", $sectionTitle);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    if (!$stmt->$error) {
                        $_SESSION["user_modified"] = true;
                        header("Location: ../image/gallery.php");
                    } else 
                        echo ERROR_DB;
                    break;
                    break;

                case "offer_img":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $uploadDirectory = '../image/offer/'; 
                    $fileName = $_FILES['offer__image']['name'];
                    $fileTmpName = $_FILES['offer__image']['tmp_name'];
                    $newFilePath = $uploadDirectory . $fileName;

                    if (move_uploaded_file($fileTmpName, $newFilePath)) {
                        $uploadedFileName = "offer/" . $fileName;

                        $stmt = $connection->prepare("INSERT INTO immagini(path, id_titolo) VALUES(?, null)");
                        $stmt->bind_param("s", $uploadedFileName);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if (!$stmt->error) {
                            $_SESSION["user_modified"] = true;
                            header("Location: ../offer.php");
                        } else {
                            echo ERROR_DB;
                        }

                        $stmt->close();
                    } else
                        echo ERROR_GEN;
                    break;
            }
        } else 
            header("Location: ../index.php");
    } else 
        header("Location: ../index.php");
?>