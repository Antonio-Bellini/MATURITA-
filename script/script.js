$(document).ready(function () {
    // controllo se l'username é gia in uso vieto l'invio del form
    $('#form_register__user').submit(function (event) {
        if ($("#usernameError").text().includes("Username non disponibile")) {
            event.preventDefault();
            alert("Non puoi inviare il modulo perché l'username non è disponibile.");
        }
    });

    // controllo se si é verificato un errore nella modifica della password e vieto l'invio del form nel caso
    $('#form_update__user').submit(function (event) {
        if ($("#passwordError").text().includes("Le due password non possono essere uguali") || 
            $("#passwordError").text().includes("La vecchia password non corrisponde")) {
            event.preventDefault();
            alert("La password non rispetta i requisiti");
        }
    });

    // controllo sulla disponibilitá dell'username
    $('#username').on("input", function() {
        let username = $(this).val();
        checkInputUsername(username);
    });

    // controllo per la modifica della password
    $('#new_psw').on("input", function() {
        console.log("dciao");
        let old_psw = $('#old_psw').val();
        let new_psw = $(this).val();
        checkNewPassword(old_psw, new_psw);
    });

    // meccanismo per la scelta del tipo di utente su cui caricare la liberatoria
    $('#form_assisted').show();
    $('#form_volunteer').hide();

    $('#choice').change(function() {
        let selectedOption = $(this).val();

        if (selectedOption === '1') {
            $('#form_assisted').show();
            $('#form_volunteer').hide();
        } else if (selectedOption === '2') {
            $('#form_volunteer').show();
            $('#form_assisted').hide();
        } else {
            $('#form_assisted').hide();
            $('#form_volunteer').hide();
        }
    });
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

// FUNZIONE per CONTROLLARE se é POSSIBILE MODIFICARE la PASSWORD
function checkNewPassword(old_psw, new_psw) {
    $.ajax({
        type: "POST",
        url: "util/check_password.php",
        data: { old_psw: old_psw, new_psw: new_psw },
        success: function (response) {
            if (response === "same_password")
                $("#passwordError").text("Le due password non possono essere uguali");
            else if (response === "not_correct")
                $("#passwordError").text("La vecchia password non corrisponde");
            else 
                $("#passwordError").text("");
        }
    })
}