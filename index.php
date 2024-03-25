<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <script src="script/script.js"></script>
    <link rel="icon" href="style/loghi/logo.png" type="x-icon">
    <title>ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "util/cookie.php";
    include "util/command.php";
    importActualStyle();
?>
    <!-- SEZIONE PRINCIPALE della PAGINA INDEX -->
    <main>
        <section class="header">
            <nav>
                <a href='index.php'>
                    <img 
                        src="style/loghi/logo.png"
                        class="logo"
                        id="logoImg"
                        alt="logo associazione"
                    />
                </a>
                <div class="nav_links" id="navLinks">
                    <ul>
                        <li><a href="newsletter.php"             class="btn">Newsletter   </a></li>
                        <li><a href="bacheca.php"                class="btn">Bacheca       </a></li>
                        <li><a href="https://stripe.com/it"      class="btn">Donazioni     </a></li>
                        <li><a href="private/area_personale.php" class="btn">Area Personale</a></li>
                    </ul>
                </div>
            </nav>

            <!--Central section-->
            <div class="text">
                <h1>ZeroTre</h1>
            </div>
        </section>
    </main>
</body>
</html>