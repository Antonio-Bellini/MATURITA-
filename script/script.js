$(document).ready(function () {
    // timer per far scomparire l'esito dell'operazione
    $(".success, .error, .warning").fadeIn();
    $(".success, .error, .warning").delay(2500).fadeOut();

    // funzione per mostrare o nascondere la password
    $('#togglePassword').click(function(){
        let passwordField = $('#password, #new_psw');
        let passwordField2 = $('#password, #old_psw');
        let passwordFieldType = passwordField.attr('type');
        
        if (passwordFieldType === 'password') {
          passwordField.attr('type', 'text');
          passwordField2.attr('type', 'text');
          $('#togglePassword').html('&#x1f441;').addClass('active');
        } else {
          passwordField.attr('type', 'password');
          passwordField2.attr('type', 'password');
          $('#togglePassword').html('&#x1f441;').removeClass('active');
        }
      });

    // bottoni per eseguire modifica ed eliminazione di un record
    $('#table').on('click', '.table--btn, .btn_delete', function(e) {
        // chiedo la doppia conferma di eliminazione
        if ($(this).hasClass('btn_delete')) {        
            let confirmed = confirm("Sei sicuro di voler procedere con l'eliminazione?");
            
            if (confirmed) {
                let operation = $(this).data('operation');
                let user = $(this).data('user');
                let profile = $(this).data('profile');
                modify_delete_Profile(operation, user, profile);
                window.location.href = "../area_personale.php";
            }
        } else {
            let operation = $(this).data('operation');
            let user = $(this).data('user');
            let profile = $(this).data('profile');
            modify_delete_Profile(operation, user, profile);
        }
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

        let isTransitioning = false;

        // tempo dopo cui viene eseguita la funzione (5 secondi)
        setInterval(slideImages, 5000);

        // funzione per il movimento
        function slideImages() {
            if (!isTransitioning) {
                isTransitioning = true;
                currentIndex++;
                gallery.style.transition = 'transform 0.5s ease-in-out'; 
                gallery.style.transform = `translateX(-${currentIndex * 100}vw)`;

                // quando arriva all'ultima foto avanza invece di scorrere indietro
                if (currentIndex === images.length) {
                    setTimeout(() => {
                        gallery.style.transition = 'none';
                        currentIndex = 0;
                        gallery.style.transform = `translateX(0)`;
                    }, 500);
                }
                setTimeout(() => {
                    isTransitioning = false;
                }, 500);
            }
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
        $('#crud__volu_event').show();
        $('#crud__assi_event, #crud__event, #crud__eventType, #view__all').hide();
        $('#mng_event__selected').change(function() {
            let selectedOption = $(this).val();
            executeEventOperation(selectedOption);

            // nascondo o mostro il menu in base all'opzione selezionata
            const mng_event__option = {
                '1': { crud__volu_event: true, crud__assi_event: false, crud__event: false, crud__eventType: false, view__all: false },
                '2': { crud__volu_event: false, crud__assi_event: true, crud__event: false, crud__eventType: false, view__all: false },
                '3': { crud__volu_event: false, crud__assi_event: false, crud__event: true, crud__eventType: false, view__all: false },
                '4': { crud__volu_event: false, crud__assi_event: false, crud__event: false, crud__eventType: true, view__all: false },
                '5': { crud__volu_event: false, crud__assi_event: false, crud__event: false, crud__eventType: false, view__all: true }
            };
            const mng_event__option_MAP = mng_event__option[selectedOption];
            
            $('#crud__volu_event').toggle(mng_event__option_MAP.crud__volu_event);
            $('#crud__assi_event').toggle(mng_event__option_MAP.crud__assi_event);
            $('#crud__event').toggle(mng_event__option_MAP.crud__event);
            $('#crud__eventType').toggle(mng_event__option_MAP.crud__eventType);
            $('#view__all').toggle(mng_event__option_MAP.view__all);
        });

        // funzione per mostrare o nascondere i sotto menu della pagina gestione eventi
        function togglechoices(prefix, maxChoices) {
            // mostro la prima opzione e nascondo tutte le altre opzioni del sotto menu
            $("#crud_" + prefix + "__choice1").show();
            for (let i = 1; i <= maxChoices; i++) {
                $("#crud_" + prefix + "__choice" + i).hide();
            }

            // applico la funzione change al menu desiderato per mostrare i sotto menu
            $("#crud_" + prefix + "__choice").change(function() {
                let selectedOption = $(this).val();
                
                const crud__option = {
                    '1': { crud__choice1: true, crud__choice2: false, crud__choice3: false, crud__choice4: false },
                    '2': { crud__choice1: false, crud__choice2: true, crud__choice3: false, crud__choice4: false },
                    '3': { crud__choice1: false, crud__choice2: false, crud__choice3: true, crud__choice4: false },
                    '4': { crud__choice1: false, crud__choice2: false, crud__choice3: false, crud__choice4: true }
                }
                const crud__option_MAP = crud__option[selectedOption];
                
                $("#crud_" + prefix + "__choice1").toggle(crud__option_MAP.crud__choice1);
                $("#crud_" + prefix + "__choice2").toggle(crud__option_MAP.crud__choice2);
                $("#crud_" + prefix + "__choice3").toggle(crud__option_MAP.crud__choice3);
                $("#crud_" + prefix + "__choice4").toggle(crud__option_MAP.crud__choice4);
            });
        }

        togglechoices("volu", 4);
        togglechoices("assi", 4);
        togglechoices("eventType", 2);
        $("#crud_volu__choice1, #crud_assi__choice1, #crud_eventType__choice1").show();
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
        // gestione dei click sui 2 bottoni presenti in bacheca o newsletter
        $('#addBachecaBtn').click(handleBachecaNewsletterBtnClick);
        $('#delBachecaBtn').click(handleBachecaNewsletterBtnClick);
        $('#addNewsletterBtn').click(handleBachecaNewsletterBtnClick);
        $('#delNewsletterBtn').click(handleBachecaNewsletterBtnClick);   
        function handleBachecaNewsletterBtnClick() {
            let operation = $(this).data('operation');
            let table = $(this).data('table');
            crudBachecaNewsletter(operation, table);
        }

        // disabilito i bottoni di eliminazione se non é presente nessun elemento in bacheca o newsletter
        if ($(".bacheca_newsletter__list h3:contains('Nessuno risultato trovato')").length === 0) {
            $('#delBachecaBtn').prop('disabled', false);
            $('#delNewsletterBtn').prop('disabled', false);
            $('#delBachecaBtn').removeClass('btn__dis');
            $('#delNewsletterBtn').removeClass('btn__dis');
        } else {
            $('#delBachecaBtn').prop('disabled', true);
            $('#delNewsletterBtn').prop('disabled', true);
            $('#delBachecaBtn').addClass('btn__dis');
            $('#delNewsletterBtn').addClass('btn__dis');
        }
    }

    // controllo per limitare a max 9 caratteri l'input del numero di telefono
    $('#new_tf, #new_tm, #phone_f, #phone_m').on("input", function() {
        let input = $(this).val();
        if (input > 15)
            $(this).val(input.slice(0, 15));
    });
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