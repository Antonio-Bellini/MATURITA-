<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../script/script.js"></script>
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "../util/cookie.php";
    importActualStyle();
?>
    <?php
        session_start();
        $_SESSION["is_parent"] = true;
        if (!isset($_SESSION["is_parente"]))
            $_SESSION["is_parente"] = false;

        if ($_SESSION["is_parent"] || $_SESSION["is_admin"]) {
            echo "<h1>Pagina di registrazione di un assistito</h1>";
            echo "<main>
                    <form action='register.php' name='form_assisted' id='form_register__assisted' method='POST'>
                        <input type='hidden' name='form_assisted'>

                        <label for='name'>Inserisci il nome</label>
                        <input type='text' name='name' id='name' required> <br>

                        <label for='surname'>Inserisci il cognome</label>
                        <input type='text' name='surname' id='surname' required> <br>

                        <label for='med'>Inserisci il nome del file dell'anamnesi</label>
                        <input type='text' name='med' id='med' required> <br>

                        <label for='notes'>Inserisci qualche nota aggiuntiva</label> <br>
                        <textarea name='notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea>
                    </form>
                </main>";
        } else 
            echo "<h2>NON SEI AUTORIZZATO AD ENTRARE IN QUESTA PAGINA</h2>";  
    ?>
    
</body>
</html>