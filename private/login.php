<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_HOST, "root", "", DB_NAME);
    echo "<link rel='stylesheet' href='../style/style.css'>";
    session_start();

    // inizalizzo la sessione per salvare il login dell'utente
    if (!isset($_SESSION["is_logged"]))
        $_SESSION["is_logged"] = false;

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    }

    // eseguo la query sul db per controllare se username e password sono corretti
    if (!$_SESSION['is_logged']) {
        try {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                $query = "SELECT id, password
                            FROM utenti
                            WHERE username = '$username';";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        if (checkPassword($password, $row["password"])) {
                            $_SESSION["is_logged"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["user_id"] = $row["id"];
                            
                            showMenu_logged();
                            welcome($connection, $username);
                        } else {
                            echo ERROR_PW;
                            header("Refresh: 3; URL=loginPage.php");
                        }
                    }
                } else
                    echo ERROR_DB;
            } else
                header("Location: loginPage.php");
        } catch(Exception $e) {
            echo ERROR_GEN;
        }
    } else {
        showMenu_logged();
        welcome($connection, $_SESSION["username"]);
    }

    // funzione per mostrare il menu
    function showMenu_logged() {
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
                                <li><a href='../newsletter.php'     class='btn'>Newsletter   </a></li>
                                <li><a href='../bacheca.php'        class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it' class='btn'>Donazioni     </a></li>
                                <li><a href='area_personale.php'    class='btn'>Area Personale</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>