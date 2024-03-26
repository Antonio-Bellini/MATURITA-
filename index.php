<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
    <link rel="stylesheet" href="style/style.css">
    <script src="script/script.js"></script>
    <link rel="icon" href="image/logos/logo.png" type="x-icon">
    <title>Un aiuto per crescere insieme</title>
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
                        src="image/logos/logo.png"
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
        </section>

        <header>
            <h1>ZEROTRE</h1>
        </header>

        <div class="image-slider">
            <img class="image" src="image/content/image1.jpg" alt="Immagine 1">
            <img class="image" src="image/content/image2.jpg" alt="Immagine 2">
            <img class="image" src="image/content/image3.jpg" alt="Immagine 3">
        </div>
    </main>
</body>
</html>