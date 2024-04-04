$(document).ready(function () {
    // timer per far scomparire l'esito dell'operazione
    $(".success, .error, .warning").fadeIn();
    $(".success, .error, .warning").delay(2500).fadeOut();

    // bottoni per eseguire modifica ed eliminazione di un record
    $('#table').on('click', '.table--btn, .btn_delete', function() {
        let operation = $(this).data('operation');
        let user = $(this).data('user');
        let profile = $(this).data('profile');
        modify_delete_Profile(operation, user, profile);
    });

    // doppia conferma prima di eliminare un utente dal db
    $(".btn_delete").click(function(e) {
        e.preventDefault();
        
        // conferma di eliminazione
        let confirmed = confirm("Sei sicuro di voler procedere con l'eliminazione?");
        
        if (confirmed)
            window.location.href = "../area_personale.php";
    });

    // controllo sulla disponibilitá dell'username
    if (window.location.href.includes("register") > -1) {
        $('#username').on("input", function() {
            let username = $(this).val();
            checkInputUsername(username);
        });
    }
    
    // vieto l'invio del form nel caso in cui l'username sia occupato
    if (window.location.href.indexOf("register_user.php") > -1) {
        $('#form_register__user').submit(function (event) {
            if ($("#usernameError").text().includes("Username non disponibile")) {
                event.preventDefault();
                alert("Non puoi inviare il modulo perché l'username non è disponibile.");
            }
        });
    }
    
    // vieto l'invio del form se la password non rispetta i requisiti
    if (window.location.href.indexOf("crud.php") > -1) {
        // controllo per la modifica della password
        $('#new_psw').on("input", function() {
            let old_psw = $('#old_psw').val();
            let new_psw = $(this).val();
            checkNewPassword(old_psw, new_psw);
        });

        // vieto l'invio del form se la password non soddisfa i requisiti 
        $('#form_update__user').submit(function (event) {
            if ($("#passwordError").text().includes("Le due password non possono essere uguali") || 
                $("#passwordError").text().includes("La vecchia password non corrisponde")) {
                event.preventDefault();
                alert("La password non rispetta i requisiti");
            }
        });  
    }

    // alterno i due form in base all'opzione selezionata
    if (window.location.href.indexOf("page_upload.php") > -1) {
        // mostro uno dei due form di default
        $('#form_assisted').show();
        $('#form_volunteer').hide();

        // mostro il nuovo form in base alla nuova opzione selezionata
        $('#upload_choice').change(function() {
            let selectedOption = $(this).val();
            $('#form_assisted').toggle(selectedOption === '1');
            $('#form_volunteer').toggle(selectedOption === '2');
        });
    }    

    // scorimento immagini nella pagina index
    if (window.location.href.indexOf("index.php") > -1) {
        const gallery = document.querySelector('.gallery');
        const images = document.querySelectorAll('.photo');
        let currentIndex = 0;

        // tempo dopo cui viene eseguita la funzione (5 secondi)
        setInterval(slideImages, 5000);
    
        // funzione per il movimento
        function slideImages() {
            currentIndex = (currentIndex + 1) % images.length;
            gallery.style.transform = `translateX(-${currentIndex * 100}vw)`;
        }
    }

    // visualizzazione di diversi tipi di utenti 
    if (window.location.href.indexOf("admin_operation.php") > -1) {
        // bottone per mostrare un determinato tipo di utente
        user = $('#user_selected').val();
        getUserSelected(user);
        $('#user_selected').change(function(){
            let selected = $(this).val();
            getUserSelected(selected);
        });

        // bottone per scegliere cosa fare con le liberatorie
        choice = $('#rls_choice').val();
        doRlsEvent(choice);
        $('#rls_choice').change(function () {
            let choice = $(this).val();
            doRlsEvent(choice);
        });

        // visualizzazione form degli eventi
        let selectedOption = $('#mng_event__selected').val();
        executeEventOperation(selectedOption);
        $('#addVolunteerToEvent').show();
        $('#addAssistedToEvent').hide();
        $('#createNewEvent').hide();
        $('#addNewEventType').hide();
        $('#viewVoluEventAssi').hide();
        $('#mng_event__selected').change(function() {
            let selectedOption = $(this).val();
            executeEventOperation(selectedOption);

            // nascondo o mostro il menu in base all'opzione selezionata
            const mng_event__option = {
                '1': { addVolunteerToEvent: true, addAssistedToEvent: false, createNewEvent: false, addNewEventType: false, viewVoluEventAssi: false },
                '2': { addVolunteerToEvent: false, addAssistedToEvent: true, createNewEvent: false, addNewEventType: false, viewVoluEventAssi: false },
                '3': { addVolunteerToEvent: false, addAssistedToEvent: false, createNewEvent: true, addNewEventType: false, viewVoluEventAssi: false },
                '4': { addVolunteerToEvent: false, addAssistedToEvent: false, createNewEvent: false, addNewEventType: true, viewVoluEventAssi: false },
                '5': { addVolunteerToEvent: false, addAssistedToEvent: false, createNewEvent: false, addNewEventType: false, viewVoluEventAssi: true }
            };
            const mng_event__option_MAP = mng_event__option[selectedOption];
            $('#addVolunteerToEvent').toggle(mng_event__option_MAP.addVolunteerToEvent);
            $('#addAssistedToEvent').toggle(mng_event__option_MAP.addAssistedToEvent);
            $('#createNewEvent').toggle(mng_event__option_MAP.createNewEvent);
            $('#addNewEventType').toggle(mng_event__option_MAP.addNewEventType);
            $('#viewVoluEventAssi').toggle(mng_event__option_MAP.viewVoluEventAssi);
        });

        // gestione visualizzazione CRUD volontari_evento
        $('#crud_volu__choice1').show();
        $('#crud_volu__choice2').hide();
        $('#crud_volu__choice').change(function() {
            let selectedOption = $(this).val();

            // nascondo o mostro il menu in base all'opzione selezionata
            const crud_volu__option = {
                '1': { crud_volu__choice1: true, crud_volu__choice2: false, crud_volu__choice3: false, crud_volu__choice4: false },
                '2': { crud_volu__choice1: false, crud_volu__choice2: true, crud_volu__choice3: false, crud_volu__choice4: false },
                '3': { crud_volu__choice1: false, crud_volu__choice2: false, crud_volu__choice3: true, crud_volu__choice4: false },
                '4': { crud_volu__choice1: false, crud_volu__choice2: false, crud_volu__choice3: false, crud_volu__choice4: true }
            }
            const crud_volu__option_MAP = crud_volu__option[selectedOption];
            $('#crud_volu__choice1').toggle(crud_volu__option_MAP.crud_volu__choice1);
            $('#crud_volu__choice2').toggle(crud_volu__option_MAP.crud_volu__choice2);
            $('#crud_volu__choice3').toggle(crud_volu__option_MAP.crud_volu__choice3);
            $('#crud_volu__choice4').toggle(crud_volu__option_MAP.crud_volu__choice4);            
        });
    }

    // bottoni dell'area personale dell'admin
    if (window.location.href.indexOf("area_personale.php") > -1) {
        $('#admin_btn').on('click', '.btn', handlePersonalAreaBtnClick);
        function handlePersonalAreaBtnClick() {
            let operation = $(this).data('operation');
            personalAreaAction(operation);
        }
    }

    // bottoni per aggiungere o eliminare contenuti da bacheca o newsletter
    if ((window.location.href.indexOf("bacheca.php") > -1) || (window.location.href.indexOf("newsletter.php") > -1)) {
        $('#addBachecaBtn').click(handleBachecaNewsletterBtnClick);
        $('#delBachecaBtn').click(handleBachecaNewsletterBtnClick);
        $('#addNewsletterBtn').click(handleBachecaNewsletterBtnClick);
        $('#delNewsletterBtn').click(handleBachecaNewsletterBtnClick);   
        function handleBachecaNewsletterBtnClick() {
            let operation = $(this).data('operation');
            let table = $(this).data('table');
            crudBachecaNewsletter(operation, table);
        }
    }
});

// -------------------------- FUNZIONI AJAX ----------------------------- \\

// ajax per il controllo live dell'username inserito
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

// ajax per il controllo live della password inserita
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
    });
}

// ajax per ottenere i dati del tipo di utente selezionato
function getUserSelected(user) {
    $.ajax({
        type: "POST",
        url: "../util/ajax/get_user.php",
        data: { user_selected: user },
        success: function (response) {
            switch (parseInt(user)) {
                case 1:
                    $('#table').html(response);
                    $('#user_title').text("PRESIDENTI REGISTRATI");
                    $('#create_title').show().text("Crea un nuovo account presidente");
                    $('#button_parent').show();
                    $('#button_title').show().attr('href', '../register/register_president.php');
                    break;

                case 2:
                    $('#table').html(response);
                    $('#user_title').text("ADMIN REGISTRATI");
                    $('#create_title').hide();
                    $('#button_parent').hide();
                    $('#button_title').hide();
                    break;

                case 3:
                    $('#table').html(response);
                    $('#user_title').text("TERAPISTI REGISTRATI");
                    $('#create_title').show().text("Crea un nuovo account terapista");
                    $('#button_parent').show();
                    $('#button_title').show().attr('href', '../register/register_terapist.php');
                    break;

                case 4:
                    $('#table').html(response);
                    $('#user_title').text("GENITORI/REFERENTI REGISTRATI");
                    $('#create_title').show().text("Crea un nuovo account genitore/referente");
                    $('#button_parent').show();
                    $('#button_title').show().attr('href', '../register/register_user.php');
                    break;
            }
        }
    });
}

// gestione della pagina "gestione liberatorie"
function doRlsEvent(choice) {
    switch (parseInt(choice)) {
        case 1:
            $('#up_rls').show();
            $('#table').hide();
            $('#up_rls').click(function() {
                window.location.href = "../upload/page_upload.php";
            });
            break;

        case 2:
            $('#up_rls').hide();
            $('#table').show();
            $.ajax({
                type: "POST",
                url: "../util/ajax/get_release.php",
                success: function (response) {
                    $('#table').html(response);
                }
            });
            break;
    }
}

// ajax per fare il CRUD su bacheca e newsletter
function crudBachecaNewsletter(operation, table) {
    $.ajax({
        type: "POST",
        url: "../util/ajax/send_data.php",
        data: { operation: operation, table: table },
        success: function (response) {
            window.location.href = "../private/crud_bacheca_newsletter.php";
            window.history.pushState({}, '', '../' + table + '/' + table + '.php');
        }
    });
}

// ajax per click dei bottoni nell'area personale dell'admin
function personalAreaAction(operation) {
    $.ajax({
        type: "POST",
        url: "../util/ajax/send_data.php",
        data: { operation: operation },
        success: function (response) {
            window.location.href = "../private/admin_operation.php";
            window.history.pushState({}, '', '../private/area_personale.php');
        }
    });
}

// ajax per mandare alla pagina di modifica o cancellazione i dati con $_POST
function modify_delete_Profile(operation, user, profile) {
    $.ajax({
        type: "POST",
        url: "../util/ajax/send_data.php",
        data: { operation: operation, user: user, profile: profile },
        success: function (response) {
            window.location.href = "../private/crud.php";
            window.history.pushState({}, '', '../private/area_personale.php');
        }
    });
}

// funzione per eseguire una delle opzioni possibili nella pagina degli eventi
function executeEventOperation(selected) {
    switch (parseInt(selected)) {
        case 1:
            $.ajax({
                type: "POST",
                url: "../util/ajax/send_data.php",
                data: { function: "crud_volunteer_event" },
                success: function (response) {
                    window.history.pushState({}, '', '../private/area_personale.php');
                }
            });
            break;

        case 2:
            $.ajax({
                type: "POST",
                url: "../util/ajax/send_data.php",
                data: { function: "crud_assisted_event" },
                success: function (response) {
                    window.history.pushState({}, '', '../private/area_personale.php');
                }
            });
            break;
        
        case 3:
            $.ajax({
                type: "POST",
                url: "../util/ajax/send_data.php",
                data: { function: "crud_event" },
                success: function (response) {
                    window.history.pushState({}, '', '../private/area_personale.php');
                }
            });
            break;

        case 4:
            $.ajax({
                type: "POST",
                url: "../util/ajax/send_data.php",
                data: { function: "crud_eventType" },
                success: function (response) {
                    window.history.pushState({}, '', '../private/area_personale.php');
                }
            });
            break;

        case 5:
            $.ajax({
                type: "POST",
                url: "../util/ajax/send_data.php",
                data: { function: "view_all_event" },
                success: function (response) {
                    window.history.pushState({}, '', '../private/area_personale.php');
                }
            });
            break;
    }
}