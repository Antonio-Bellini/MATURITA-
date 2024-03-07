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
        <form action="private/login.php" id="form_login" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" value="ACCEDI"><br><br>
        </form>
    </main>
</body>
</html>