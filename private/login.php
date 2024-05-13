<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    session_start();
    
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    // inizalizzo la sessione per salvare il login dell'utente
    if (!isset($_SESSION["is_logged"]))
        $_SESSION["is_logged"] = false;

    // eseguo la query sul db per controllare se username e password sono corretti
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!$_SESSION['is_logged']) {
            try {
                if (isset($_POST["username"]) && isset($_POST["password"])) {
                    // sanifico i dati in input del form
                    $username = mysqli_real_escape_string($connection, $_POST["username"]);
                    $password = mysqli_real_escape_string($connection, $_POST["password"]);

                    $stmt = $connection->prepare("SELECT id, password FROM utenti WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();

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

                            $stmt->close();
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
        } else 
            header("Location: ../index.php");
    } else 
        header("Location: ../index.php");
?>