<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="style/style.css">
    <script src="script/script.js"></script>
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "util/cookie.php";
    importActualStyle();
?>
    <!-- SEZIONE PRINCIPALE della PAGINA DI REGISTRAZIONE -->
    <main>
        <h1>Crea il tuo account</h1>
        <form action="private/register.php" id="form_register__user" method="POST">
            <input type="hidden" name="form_user">
            
            <label for="nome">Inserisci il tuo nome</label>
            <input type="text" name="name" id="name" required> <br>

            <label for="cognome">Inserisci il tuo cognome</label>
            <input type="text" name="surname" id="surname" required> <br>

            <label for="username">Inserisci il tuo username</label>
            <input type="text" name="username" id="username" required>
            <span id="usernameError"></span> <br>

            <label for="password">Crea una password</label>
            <input type="password" name="password" id="password" required> <br>

            <label for="email">Inserisci la tua email</label>
            <input type="email" name="email" id="email" required> <br>

            <label for="phone_f">Inserisci il tuo numero di telefono fisso</label>
            <input type="text" name="phone_f" id="phone_f"> <br>

            <label for="phone_m">Inserisci il tuo numero di telefono</label>
            <input type="text" name="phone_m" id="phone_m" required> <br>

            <label for="notes">Inserisci qualche nota aggiuntiva</label> <br>
            <textarea name="notes" id="notes" cols="30" rows="10" placeholder="Altre info utili"></textarea> <br><br><br>

            <input type="submit" value="Registrati">
        </form>
    </main>  
</body>
</html>