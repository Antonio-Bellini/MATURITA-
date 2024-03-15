$(document).ready(function () {
    // controllo sulla disponibilitá dell'username
    $('#username').on("input", function () {
        let username = $(this).val();
        checkInputUsername(username);
    });

    // controllo per la modifica della password
    
});

// AJAX per il controllo live dell'email inserita
function checkInputUsername(username) {
    $.ajax({
        type: "POST",
        url: "util/check_username.php",
        data: { username: username },
        success: function (response) {
            if (response === "exists")
                $("#usernameError").text("Username non disponibile");
            else
                $("#usernameError").text("");
        }
    });
}