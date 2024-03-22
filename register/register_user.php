<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../script/script.js"></script>
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "../util/cookie.php";
    importActualStyle();

    echo "  <button><a href='../index.php'>HOME</a></button>
            <button><a href='../newsletter.php'>NEWSLETTER</a></button>
            <button><a href='../bacheca.php'>BACHECA</a></button>
            <button><a href='../private/area_personale.php'>AREA PERSONALE</a></button>
            <button><a href='../private/crud.php?operation=LOGOUT'>LOGOUT</a></button><br><br>";
?>
    <!-- SEZIONE PRINCIPALE della PAGINA DI REGISTRAZIONE -->
    <main>
        <h1>CREA ACCOUNT GENITORE</h1>
        <form action="register.php" id="form_register__user" method="POST">
            <input type="hidden" name="form_user">
            
            <label for="nome">Inserisci il nome</label>
            <input type="text" name="name" id="name" required> <br>

            <label for="cognome">Inserisci il cognome</label>
            <input type="text" name="surname" id="surname" required> <br>

            <label for="username">Inserisci lo username</label>
            <input type="text" name="username" id="username" required>
            <span id="usernameError"></span> <br>

            <label for="password">Crea una password</label>
            <input type="password" name="password" id="password" required> <br>

            <label for="email">Inserisci l'email</label>
            <input type="email" name="email" id="email" required> <br>

            <label for="phone_f">Inserisci il numero di telefono fisso</label>
            <input type="text" name="phone_f" id="phone_f"> <br>

            <label for="phone_m">Inserisci il numero di telefono</label>
            <input type="text" name="phone_m" id="phone_m" required> <br>

            <label for="notes">Inserisci qualche nota aggiuntiva</label> <br>
            <textarea name="notes" id="notes" cols="30" rows="10" placeholder="Altre info utili"></textarea> <br><br><br>

            <input type="submit" value="Registra">
        </form>
    </main>  
</body>
</html>