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

    // visualizzazione form degli eventi
    $('#addVolunteerToEvent').show();
    $('#addAssistedToEvent').hide();
    $('#createNewEvent').hide();
    $('#addNewEventType').hide();
    $('#viewVoluEventAssi').hide();

    $('#mng_event__selected').change(function() {
        let selectedOption = $(this).val();

        if (selectedOption === '1') {
            $('#addVolunteerToEvent').show();
            $('#addAssistedToEvent').hide();
            $('#createNewEvent').hide();
            $('#addNewEventType').hide();
            $('#viewVoluEventAssi').hide();
        } else if (selectedOption === '2') {
            $('#addVolunteerToEvent').hide();
            $('#addAssistedToEvent').show();
            $('#createNewEvent').hide();
            $('#addNewEventType').hide();
            $('#viewVoluEventAssi').hide();
        } else if (selectedOption === '3') {
            $('#addVolunteerToEvent').hide();
            $('#addAssistedToEvent').hide();
            $('#createNewEvent').show();
            $('#addNewEventType').hide();
            $('#viewVoluEventAssi').hide();
        } else if (selectedOption === '4') {
            $('#addVolunteerToEvent').hide();
            $('#addAssistedToEvent').hide();
            $('#createNewEvent').hide();
            $('#addNewEventType').show();
            $('#viewVoluEventAssi').hide();
        } else if (selectedOption === '5') {
            $('#addVolunteerToEvent').hide();
            $('#addAssistedToEvent').hide();
            $('#createNewEvent').hide();
            $('#addNewEventType').hide();
            $('#viewVoluEventAssi').show();
        }
    });

    // scorimento immagini nella pagina index
    var scrollPos = 0;
  var container = $('#container');

  setInterval(function() {
    scrollPos += 1; // Modifica la velocità di scorrimento modificando questo valore
    container.scrollLeft(scrollPos);
    if (scrollPos >= (container.get(0).scrollWidth - container.width())) {
      // Se arriva alla fine, riporta all'inizio
      scrollPos = 0;
    }
  }, 50);
});

// AJAX per il controllo live dell'email inserita
function checkInputUsername(username) {
    $.ajax({
        type: "POST",
        url: "../util/ajax/check_username.php",
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
        url: "../util/ajax/check_password.php",
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

//
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}