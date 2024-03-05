<?php
    require_once("constants.php");

    // FUNZIONE per ESEGUIRE una QUERY sul DATABASE
    function dbQuery($connection, $query) {
        return $connection -> query($query);
    }

    // FUNZIONE per CREARE UNA TABELLA HTML in BASE ai DATI RICEVUTI dal DATABASE
    function createTable($result) {
        if (!$result)
            echo "Errore nella query: " . $result;
        else {
            if ($header = ($result->fetch_assoc())) {
                echo "<table border='1'>";
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            echo "<th>" . $key . "</th>";
                    echo "</tr>";

                    // riga appena inserita
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            printField($key, $value);
                    echo "</tr>";

                // inserimento delle altre righe della tabella
                while($header = $result->fetch_assoc()) {
                    echo "<tr>";
                        foreach ($header as $key => $value) 
                            printField($key, $value);
                    echo "</tr>";
                }

                echo "</table>";
            } else
                echo "Nessun risultato trovato.";
        }
    }

    // FUNZIONE che FORMATTA in MODO da STAMPARE in una MANIERA piú LEGGIBILE il DATO
    function printField($key, $value) {
        $connection = connectToDatabase(DB_NAME);

        switch($key) {
            case "data_di_nascita":
                echo "<td>" . date('d/m/Y', strtotime($value)) . "</td>";
                break;

            case "regione_di_residenza":
                $qRegion = "SELECT nome FROM regioni WHERE codice = '$value'";
                $queryR = dbQuery($connection, $qRegion);
                $result = $queryR -> fetch_assoc();

                foreach($result as $key => $value)
                    echo "<td>" . $value . "</td>";
                break;

            case "sesso":
                if ($value === "M")
                    echo "<td>Maschio</td>";
                else 
                    echo "<td>Femmina</td>";
                break;

            default:
                echo "<td>" . $value . "</td>";
                break;
        }
    }

    // FUNZIONE per CONTROLLARE che la PASSWORD INSERITA sia CORRETTA
    function check_password($dbPassword, $password) {
        return hash('sha256', $password) === $dbPassword;
    }

    // FUNZIONE per DARE il BENVENUTO SCRIVENDO il NOME
    function welcome($username) {
        $connection = connectToDatabase(DB_NAME);

        $query = "SELECT nome, cognome
                    FROM utenti u
                    WHERE u.username = '$username';";
        $result = dbQuery($connection, $query);

        if ($result) {
            while ($row = ($result->fetch_assoc()))
                echo "<h2>Benvenuto " . $row["nome"] . "</h2>";
        }
    }
?>