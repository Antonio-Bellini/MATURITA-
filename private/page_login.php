<!DOCTYPE html>
<html lang="en">
<?php
    include "../util/constants.php";
    include "../util/command.php";
    include "../util/connection.php";

    echo "
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <script src='https://kit.fontawesome.com/a730223cdf.js' crossorigin='anonymous'></script>
            <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo    WEBALL;
    echo "  <script src='../script/script.js'></script>
            <link rel='stylesheet' href='../style/style.css'>
            <link rel='icon' href='../image/logos/logo.png' type='x-icon'>
            <title>Associazione Zero Tre</title>
        </head>";

    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
    session_start();

    if (!isset($_SESSION["is_logged"]))
        $_SESSION["is_logged"] = false;

    check_operation();

    // controllo cosa mostrare in base a se é gia loggato oppure ancora no
    if (!$_SESSION["is_logged"]) {
        nav_menu();
        echo "<section id='login_form'>
                <h1 id='login_form__title'>Accedi al tuo account</h1>
                <form action='login.php' id='form_login' method='POST'>
                    <label for='username' id='login_form__label'>Username</label>
                    <input type='text' name='username' id='login_form__input' required>

                    <label for='password' id='login_form__label'>Password</label>
                    <input type='password' name='password' id='login_form__input' required>

                    <input id='login_form__submit' type='submit' value='ACCEDI'>
                </form>
            </section>";
    } else 
        header("Location: ../index.php");

    show_footer2();
?>
</body>
</html>