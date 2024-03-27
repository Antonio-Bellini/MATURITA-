<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_HOST, USER_ADMIN, ADMIN_PW, DB_NAME);
    echo "<link rel='stylesheet' href='../style/style.css'>";
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
                        showMenu_logged();
                        echo FILE_OK;
                    } else {
                        showMenu_logged();
                        echo ERROR_FILE;
                    }
                } else if ($volunteerId != null) {
                    $query = "UPDATE volontari
                                SET id_liberatoria = '$module_id'
                                WHERE id = '$volunteerId';";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        showMenu_logged();
                        echo FILE_OK;
                    } else {
                        showMenu_logged();
                        echo ERROR_FILE;
                    }
                }
            }
        } else {
            showMenu_logged();
            echo ERROR_GEN;
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
                showMenu_logged();
                echo FILE_OK;
            }
        }
    } else {
        showMenu_logged();
        echo NO_FILE;
    }

    function showMenu_logged() {
        // menu di navigazione
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
                                <li><a href='../newsletter.php'             class='btn'>Newsletter   </a></li>
                                <li><a href='../bacheca.php'                class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'     class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='../private/area_personale.php' class='btn'>Area Personale</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>