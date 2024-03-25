<?php 
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

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
                                    <li><a href='https://stripe.com/it'         class='btn'>Donazioni     </a></li>
                                    <li><a href='private/area_personale.php'    class='btn'>Area Personale</a></li>
                                </ul>
                            </div>
                        </nav>            
                    </section>
                </main>";
            echo ACC_OK;
        } else 
            echo ERROR_GEN;
    } else if (isset($_POST["form_volunteer"])) {
        // ottengo i dati scritti nel form
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $phone_f = $_POST["phone_f"];
        $phone_m = $_POST["phone_m"];
        $notes = "";
        
        if (isset($_POST["notes"]))
            $notes = $_POST["notes"];

        if(isset($_FILES['release'])) {
            $uploadDirectory = '../upload/release_module/'; 
        
            $fileName = $_FILES['release']['name'];
            $fileTmpName = $_FILES['release']['tmp_name'];
        
            // Aggiungi il nome del file al percorso della cartella di destinazione
            $newFilePath = $uploadDirectory . $fileName;
        
            if(move_uploaded_file($fileTmpName, $newFilePath)) {
                $uploadedFileName = "/" . $fileName;
                $query = "INSERT INTO liberatorie(liberatoria, note) VALUES('$uploadedFileName', '$notes')";
                $result = dbQuery($connection, $query);

                if ($result) {
                    $lastId = $connection -> insert_id;
                    // inserimento dell'utente nel db
                    $query = "INSERT INTO volontari(nome, cognome, email, telefono_fisso, telefono_mobile, id_liberatoria)
                                VALUES('$name', '$surname', '$email', '$phone_f', '$phone_m', '$lastId');";
                    $result = dbQuery($connection, $query);

                    if ($result) {
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
                                                <li><a href='https://stripe.com/it'         class='btn'>Donazioni     </a></li>
                                                <li><a href='private/area_personale.php'    class='btn'>Area Personale</a></li>
                                            </ul>
                                        </div>
                                    </nav>            
                                </section>
                            </main>";
                        echo ACC_OK;
                    }
                }
            } else
                echo ERROR_FILE;
        } else
            echo NO_FILE;
    } else if (isset($_POST["form_assisted"])) {
        // ottengo i dati dal form
        $uploadedFileName = null;
        $fileUploaded = false;
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $notes = $_POST["notes"];
        $parent = null;
        
        if(isset($_FILES['med'])) {
            $uploadDirectory = '../upload/medical_module/'; 
        
            $fileName = $_FILES['med']['name'];
            $fileTmpName = $_FILES['med']['tmp_name'];
        
            // Aggiungi il nome del file al percorso della cartella di destinazione
            $newFilePath = $uploadDirectory . $fileName;
        
            if(move_uploaded_file($fileTmpName, $newFilePath)) {
                $uploadedFileName = "/" . $fileName;

                if (isset($_POST["parent"]))
                    $parent = $_POST["parent"];
                else 
                    $parent = $_SESSION["user_id"];

                // inserimento dell'assistito nel db
                $query = "INSERT INTO assistiti(nome, cognome, anamnesi, note, id_referente)
                                VALUES('$name', '$surname', '$uploadedFileName', '$notes', '$parent');";
                $result = dbQuery($connection, $query);

                if ($result) {
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
                                            <li><a href='https://stripe.com/it'         class='btn'>Donazioni     </a></li>
                                            <li><a href='private/area_personale.php'    class='btn'>Area Personale</a></li>
                                        </ul>
                                    </div>
                                </nav>            
                            </section>
                        </main>";
                    echo ACC_OK;
                    echo FILE_OK;
                } else
                    echo GEN_ERROR;
            } else
                echo ERROR_FILE;
        } else
            echo NO_FILE;
    } else 
        echo NO_FORM;
?>