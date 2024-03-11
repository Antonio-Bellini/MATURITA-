<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "util/cookie.php";
    importActualStyle();
?>
    <!-- SEZIONE PRINCIPALE della PAGINA DI LOGIN -->
    <?php
        include "util/connection.php";
        include "util/command.php";
        session_start();

        if (!isset($_SESSION["is_logged"]))
            $_SESSION["is_logged"] = false;

        // controllo cosa mostrare in base a se é gia loggato oppure ancora no
        if ($_SESSION["is_logged"]) {
            showMenu();
            welcome($_SESSION["username"]);
        } else {
            echo "<main>
                    <h1>Accedi al tuo account</h1>
                    <form action='private/login.php' id='form_login' method='POST'>
                        <label for='username'>Username</label>
                        <input type='text' name='username' id='username' required><br>

                        <label for='password'>Password</label>
                        <input type='password' name='password' id='password' required><br>

                        <input type='submit' value='ACCEDI'><br><br><br>
                    </form>
                </main>";

            echo "<section>
                    <label>Non sei ancora registrato? Registrati ora</label><br>
                    <button><a href='register_user.php'>REGISTRATI</a></button>
                </section>";
        }
    ?>
</body>
</html>