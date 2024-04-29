<?php
    // reindirizzo alla home se si cerca di accedere a questa pagina
    if (strpos($_SERVER['REQUEST_URI'], "/util/cookie.php") !== false) {
        header('Location: ../index.php');
        exit;
    }

    // funzione per creare un nuovo cookie
    function setNewCookie($name, $value) {
        $cookie_name = $name;
        $cookie_value = $value;
        $cookie_expire = time() + (86400 * 30);
        setcookie($cookie_name, $cookie_value, $cookie_expire, "/");
            
        importActualStyle();
    }

    // funzione per importare lo stile dal cookie
    function importActualStyle() {
        if(isset($_COOKIE['DarkMode']))
            echo "<body class='" . $_COOKIE['DarkMode'] . "' id='body'>"; 
        else 
            echo "<body class='body' id='body'>";
    }
?>