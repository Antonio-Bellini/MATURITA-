<?php
    // FUNZIONE per CREARE un NUOVO COOKIE
    function setNewCookie($name, $value) {
        $cookie_name = $name;
        $cookie_value = $value;
        $cookie_expire = time() + (86400 * 30);
        setcookie($cookie_name, $cookie_value, $cookie_expire, "/");
            
        importActualStyle();
    }

    // FUNZIONE per IMPORTARE lo STILE in BASE al COOKIE
    function importActualStyle() {
        if(isset($_COOKIE['DarkMode']))
            echo "<body class='" . $_COOKIE['DarkMode'] . "' id='body'>"; 
        else 
            echo "<body class='body' id='body'>";
    }
?>