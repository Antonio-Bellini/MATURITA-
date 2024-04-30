<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST['password'];
        $other_password = $_POST['other_password'];

        // controllo che le due password siano uguali
        if ($password === $other_password)
            echo "correct";
        else {
            echo "not_correct";
        }
    }
?>