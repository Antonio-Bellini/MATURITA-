<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo WEBALL;
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
                        addToTable($table);
                        break;

                    case "del":
                        removeFromTable($table, $connection);
                        break;

                    case null:
                        header("Location: ../index.php");
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
                        addToTable($table);
                        break;

                    case "del":
                        removeFromTable($table, $connection);
                        break;

                    case null:
                        header("Location: ../index.php");
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
                        addToTable($table);
                        break;

                    case "del":
                        removeFromTable($table, $connection);
                        break;

                    case null:
                        header("Location: ../index.php");
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

    // funzione per aggiungere file in bacheca o in newsletter
    function addToTable($table) {
        echo "<br>
        <section id='form'>
            <h2>Aggiunta di un contenuto in " . $table . "</h2>
            <form action='../upload/upload.php' method='POST' enctype='multipart/form-data'>
                <input type='hidden' name='table' value=$table>
                <br><br>

                <div class='div__label'>
                    <label for='" . $table . "'>Seleziona il file che vuoi aggiungere in ". $table . "</label>
                    <label for='date'>Seleziona la data del file</label>
                </div>
                <div class='div__input'>
                    <input type='file' name='" . $table . "' accept='.pdf' required>
                    &nbsp;&nbsp;
                    <input type='date' name='date' required>
                </div>

                <input type='submit' value='AGGIUNGI'>
            </form>
        </section>";
    }

    // funzione per eliminare file dalla bacheca o dalla newsletter
    function removeFromTable($table, $connection) {
        $query = "SELECT id, $table, data FROM $table";
        $result = dbQuery($connection, $query);

        echo "<br>
            <section id='form'>
                <h2>Eliminazione di un contenuto dalla $table</h2>
                <form action='delete_content.php' method='POST'>
                    <br><br>";

        // se ci sono risultati nella tabella mostro cosa si puo eliminare
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "  <input type='hidden' name='file_id' value='" . $row["id"] . "'>
                        <input type='hidden' name='table_sel' value='$table'>";
            }
            mysqli_data_seek($result, 0);
        }

        echo "  <div id='name_surname__label'>
                    <label for='$table'>Seleziona il file che vuoi eliminare dalla $table</label>
                </div>
                    <select name='file_id'>";
        while ($row = $result->fetch_assoc()) {
            echo "      <option value='" . $row["id"] . "'>" . $row["$table"] . " del " . $row["data"] . "</option>";
        }

        echo "      </select>
                    <input type='submit' name='submit' value='RIMUOVI'>
                </form>
            </section>";
    }
?>