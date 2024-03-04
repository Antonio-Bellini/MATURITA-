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
    <main>
        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="email" name="email" id="email" required>

            <br>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <br>

            <input type="submit" value="ACCEDI">

            <br><br>
        </form>
    </main>

    <!-- SEZIONE per REGISTRARSI se NON ANCORA REGISTRATI -->
    <section>
        <label for="registrati">Non sei ancora registrato?</label>
        <button><a href="registerPage.php">Registrati ora</a></button>
    </section>
</body>
</html>