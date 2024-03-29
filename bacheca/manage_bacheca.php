<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    importActualStyle();
    session_start();

    $operation = null;

    // menu di navigazione
    nav_menu();

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    switch ($_SESSION["profile_type"]) {
        case "presidente":
            $connection = connectToDatabase(DB_HOST, DB_PRESIDENT, PRESIDENT_PW, DB_NAME);
            break;

        case "admin":
            $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
            
            switch ($operation) {
                case "add":
                    echo "<br>
                    <section id='form'>
                        <h2>Aggiunta di un contenuto in bacheca</h2>
                            <form action='../upload/upload.php' method='POST' enctype='multipart/form-data'>
                                <br><br>

                                <div id='name_surname__label'>
                                    <label for='bacheca'>Seleziona il file che vuoi aggiungere in bacheca</label>
                                    <label for='date'>Seleziona la data del file</label>
                                </div>
                                <div id='name_surname__input'>
                                    <input type='file' name='bacheca' accept='.pdf' enctype='multipart/form-data' required>
                                    &nbsp;&nbsp;
                                    <input type='date' name='date' required>
                                </div>

                                <input type='submit' value='AGGIUNGI'>
                            </form>
                    </section>";
                    break;

                case "del":
                    $query = "SELECT id, bacheca, data FROM bacheca";
                    $result = dbQuery($connection, $query);
                    echo "<br>
                    <section id='form'>
                        <h2>Eliminazione di un contenuto dalla bacheca</h2>
                            <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST' enctype='multipart/form-data'>
                                <br><br>";
                                if ($result) {
                                    while ($row = ($result->fetch_assoc())) 
                                        echo "<input type='hidden' name='file_name' value='" . $row["bacheca"] . "'>";
                                    mysqli_data_seek($result, 0);
                                }

                    echo "      <div id='name_surname__label'>
                                    <label for='bacheca'>Seleziona il file che vuoi eliminare dalla bacheca</label>
                                </div>
                                <select name='bacheca'>";
                                if ($result) {
                                    while ($row = ($result->fetch_assoc())) {
                                        echo "<option value='" . $row["id"] . "'>" . $row["bacheca"] . " del " . $row["data"] . "</option>";
                                    }
                                }
                            
                    echo "      </select>
                                <input type='submit' name='submit' value='RIMUOVI'>
                            </form>
                    </section>";
                    break;
            }
            break;

        case "terapista":
            $connection = connectToDatabase(DB_HOST, DB_TERAPIST, TERAPIST_PW, DB_NAME);
            break;

        case "genitore":
            $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
            break;
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
                                <li><a href='../newsletter/newsletter.php'          class='btn'>Newsletter   </a></li>
                                <li><a href='bacheca.php'                           class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'                 class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='../private/area_personale.php'         class='btn'>Area Personale</a></li>
                                <li><a href='../private/crud.php?operation=LOGOUT'  class='btn'>Logout</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }

    // eliminazione del file bacheca selezionato
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $file_name = $_POST["file_name"];
        $bacheca = $_POST["bacheca"];
        $query = "DELETE FROM bacheca WHERE id = '$bacheca'";
        $result = dbQuery($connection, $query);
        echo $file_name;

        if ($result) {
            if (file_exists($file_name)) {
                if (unlink($file_name)) {
                    $_SESSION["file_deleted"] = true;
                    header("Location: ../private/area_personale.php");
                } else 
                    echo "no";
            } else 
                echo "no ciao";
        }
    }
?>