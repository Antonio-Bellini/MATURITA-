<?php 
    // funzione per connettersi al database
    function connectToDatabase($hN, $uN, $pw, $dN) {
        $hostName = $hN;
        $username = $uN;
        $password = $pw;
        $dbName = $dN;
        
        $connection = new mysqli($hostName, $username, $password, $dbName);
        
        if ($connection -> connect_error)
            die("Connessione fallita: " . ($connection -> connect_error));
        
        return $connection;
    }
?>