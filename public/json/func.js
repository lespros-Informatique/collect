const LINK = window.location.origin + '/collect/public/';
const LINKS = window.location.origin + '/collect'; // En local il faut ajouter restaurant/ pour que çà passe!
const LINKS_ADMIN = window.location.origin + '/entreprise'; // En local il faut ajouter restaurant/ pour que çà passe!

function trRemove(selecter) {
    $(selecter).remove();

}
function go_b(){
    history.back();
}
function showAlert(title, message, icon = 'success') {
    Swal.fire({
        title: `<span style="font-size: 24px;">${title}</span>`,
        html: `<span style="font-size: 18px;">${message}</span>`,
        icon: icon,
        confirmButtonText: '<span style="font-size: 16px;">OK</span>'
    });
}

function togglePassword() {
    var passwordField = document.getElementById("password");
    var toggleIcon = document.getElementById("togglePasswordIcon");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}

function profilTogglePassword(idPassword) {
    var passwordField = document.getElementById(idPassword);
    if (!passwordField) return;
    
    var toggleIcon = document.getElementById(idPassword === 'anPassword' ? 'togglePasswordIcon' : 'newTogglePasswordIcon');
    if (!toggleIcon) return;
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
// Fonction pour détecter le réseau et afficher le logo

function verifForm(fields)  // verification des champs du  formulaire
{
    fields.forEach(field => {
        const input = document.getElementById(field.id);
        input.addEventListener('input', function () {
            validateField(input, field.regex, field.errorMessage);
        });
    });

    function validateForm() // verifie un champ 
    {
        let isValid = true;
        fields.forEach(field => {
            const input = document.getElementById(field.id);
            if (!validateField(input, field.regex, field.errorMessage)) {
                isValid = false;
            }
        });

        return isValid;
    }
    function validateField(input, regex, errorMessage) {
        const errorElement = document.getElementById(input.id + 'Error');
        const nextSibling = input.nextElementSibling;
        const iconElement = nextSibling ? nextSibling.querySelector('i') : null;
      
        if (!regex.test(input.value)) {
          input.classList.add('invalid');
          input.classList.remove('valid');
          if (errorElement) {
            errorElement.innerHTML = `<i class="fa fa-exclamation-circle mr-2"></i> ${errorMessage}`;
            errorElement.classList.add('text-red-500');
          }
          if (iconElement) {
            iconElement.classList.add('text-red-500');
          }
          return false;
        } else {
          input.classList.add('valid');
          input.classList.remove('invalid');
          if (errorElement) {
            errorElement.innerHTML = '';
            errorElement.classList.remove('text-red-500');
          }
          if (iconElement) {
            iconElement.classList.remove('text-red-500');
            iconElement.classList.add('text-green-500');
          }
          return true;
        }
      }
      


    return validateForm;
}

function tableField(includeFields) {
    const allFields = {
        nom: { id: 'nom', regex: /.+/, errorMessage: 'Le nom est requis.' },
        prenom: { id: 'prenom', regex: /.+/, errorMessage: 'Le nom est requis.' },
        fonction: { id: 'fonction', regex: /.+/, errorMessage: 'La profession est requise.' },
        tel: { id: 'tel', regex: /^(07|05|01)\d{8}$/, errorMessage: 'Veuillez entrer un numéro de téléphone valide qui commence par 07, 05, ou 01, suivi de 8 chiffres.'},
        // Mot de passe (vérifie que le mot de passe est égal à "PRO-01" ou qu'il est présent)
        password: { id: 'password', regex: /^(MEMBRE-01)$/, errorMessage: 'Le mot de passe est incorrect.' },
        anPassword: { id: 'anPassword', regex: /.+/, errorMessage: 'L\'ancien mot de passe est requis.' },
        newPassword: { id: 'newPassword', regex: /.+/, errorMessage: 'Le nouveau mot de passe est requis.' },
        poste: { id: 'poste', regex: /^(?!default$).+$/, errorMessage: 'Veuillez sélectionner un poste valide.' },
        sexe: { id: 'sexe', regex: /^(?!default$).+$/, errorMessage: 'Veuillez sélectionner un sexe valide.' },
        annee: { id: 'annee', regex: /^(?!default$).+$/, errorMessage: 'Veuillez sélectionner une année valide.' },
        responsable: { id: 'responsable', regex: /^(?!default$).+$/, errorMessage: 'Vous devez donner une reponse valide.' },
        role: { id: 'role', regex: /^(?!default$).+$/, errorMessage: 'Veuillez sélectionner un role valide.' },
        libelle: { id: 'libelle', regex: /.+/, errorMessage: 'Le libelle est requis.' },
        date: { id: 'date', regex: /^\d{4}-\d{2}-\d{2}$/, errorMessage: 'Veuillez saisir une date valide (YYYY-MM-DD).'},
        photo: { id: 'photo', regex: /.+/, errorMessage: 'Veuillez télécharger la photo (formats acceptés : .jpg, .png).' },
        
    };

    return includeFields.map(field => allFields[field]);  // Retourne uniquement les champs spécifiés dans includeFields
}

function formIsValided(table)  // recreate Datatable
{
    const fields = tableField(table); // Exemple d'utilisation de la fonction tableField
    const formIsValidTable = verifForm(fields); // Fonction de validation des champs
    return formIsValidTable();
}

function loading(selector, status, message) {
    $(selector).html(message);
    $(selector).attr('disabled', status);
}

function changeById(id) {
    event.preventDefault(); // Empêche le rechargement si le bouton est dans un <form>

    Swal.fire({
        title: `<span style="font-size: 24px;">Attention!</span>`,
        html: `<span style="font-size: 18px;">Voulez-vous vraiment effectuer cette opération ?</span>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: '<span style="font-size: 16px;">Accepter</span>',
        cancelButtonText: '<span style="font-size: 16px;">Annuler</span>',
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                method: "POST",
                url: LINK + "adminController/changer",
                data: { id_admin: id, btn_changer: 1 },  // Envoi de l'ID au serveur
                success: function (rep) {
                    let data = rep.split('#');
                    if (data[0] == 1) {
                        showAlert('Félicitations !', 'Enregistrement effectué avec succès.', 'success');
                        setInterval(() => {
                            location.reload(); // Actualise la page si nécessaire

                        }, 2000)
                    }
                },
                error: function (xhr, status, error) {
                    showAlert('Désolé !', response.msg, 'error');
                }
            });
        }
    });
}
function changeDeleteById(url,id) {
    event.preventDefault(); // Empêche le rechargement si le bouton est dans un <form>

    Swal.fire({
        title: `<span style="font-size: 24px;">Attention!</span>`,
        html: `<span style="font-size: 18px;">Voulez-vous vraiment effectuer cette opération ?</span>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: '<span style="font-size: 16px;">Accepter</span>',
        cancelButtonText: '<span style="font-size: 16px;">Annuler</span>',
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                method: "POST",
                url: LINK+url,
                data: { id: id, btn_changer: 1 },  // Envoi de l'ID au serveur
                success: function (rep) {
                    // console.log(rep);return;
                    
                    let response = JSON.parse(rep);                    
                    if (response.status== 1) {
                        showAlert('Félicitations !', response.msg, 'success');
                        if( response.remove==true) {
                            trRemove('#trRemove-'+id);
                        }
                        if(response.reload == 1) {
                            setInterval(() => {
                                location.reload(); // Actualise la page si nécessaire

                            }, 2000)
                        }
                   
                    }
                },
                error: function (xhr, status, error) {
                    showAlert('Désolé !', response.msg, 'error');
                }
            });
        }
    });
}

function animateCounters() {
    const counters = document.querySelectorAll(".stat-box");

    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute("data-target").replace(/\s/g, ''), 10); // Supprime les espaces pour les nombres formatés
        let current = 0;
        const increment = target / 100; // Ajuste la vitesse

        function updateCounter() {
            current += increment;
            if (current < target) {
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString('fr-FR'); // Format français (ex: 1 000)
            }
        }

        updateCounter();
    });
}


// $(document).ajaxStart(function() { Pace.restart(); });
function connexion() {
    $('.formConnexion').on('submit', function (e) {
        e.preventDefault(); // Empêche la soumission normale du formulaire
        // Vérifie si le formulaire est valide
        
        // console.log(LINK + 'userController/connexion');
        
        $.ajax({
            url: LINK + 'userController/connexion',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function () {
                loading('.btnConnexion', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>'); // activer loader
            },
            success: function (rep) {
                console.log(rep)
                // ;return
                // console.log(rep);return;
                let response = JSON.parse(rep);
                loading('.btnConnexion', false, '<button type="submit" class="btn btnConnexion py-0">Se connecter <i class="fa fa-sign-in"></i></button>'); // desactiver loader
                // Simule une connexion réussie (remplace cela par ta logique backend)

                if (response.status == 1) {
                    showAlert('Connexion réussie !', response.msg, 'success');
                    window.location.href = LINKS;               
                } else if(response.status == 2){
                    showAlert('Connexion réussie !', response.msg, 'success');
                    window.location.href = LINKS_ADMIN; 
                }else{
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function (xhr, status, error) {
                alert('Erreur : ' + error);
            }
        });

    });
}


function addUser() // form
{
    $('.formUser').on('submit', function (e) {
        e.preventDefault();

        // const table = ['nom', 'tel','password', "role"];

        // Vérifie si le formulaire est valide
        // if (formIsValided(table)) {
            // Créer un objet FormData pour gérer l'upload de fichiers
            let formData = $(this).serialize();
            $.ajax({
                url: LINK + 'userController/add',
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>'); // activer loader
                },
                success: function (rep) {
                    // console.log(rep);return
                    let response = JSON.parse(rep);

                    loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_action">Sauvegarder</button>'); // desactiver loader
                    if (response.status == 1) {
                        showAlert('Félicitations !', response.msg , 'success');
                        setInterval(() => {
                            location.reload(); // Actualise la page si nécessaire
                        }, 2000)
                    } else {
                        showAlert('Désolé !', response.msg, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    alert('Erreur :' + error);
                }
            });
        // }
    });
}
function editUser() // form agent edit
{
    
    $('.formEditUser').on('submit', function (e) {
        e.preventDefault();
        // const table = ['nom','prenom', 'tel','fonction', "role"];
        
        // Vérifie si le formulaire est valide
        // if (formIsValided(table)) {
            // Créer un objet FormData pour gérer l'upload de fichiers
            let formData = $(this).serialize();
            // alert('click me='+formData);return;
            $.ajax({
                url: LINK + 'userController/edit',
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>'); // activer loader
                },
                success: function (rep) {
                    // console.log(rep);return;
                    let response = JSON.parse(rep);

                    loading('.btn_actions', false, '<button type="submit" class="btn btn-primary btn_action">Sauvegarder</button>'); // desactiver loader
                    if (response.status == 1) {
                        showAlert('Félicitations !', 'Modification effectué avec succès.', 'success');
                        // redirect(LINK + 'agent/list');
                        setInterval(() => {
                            go_b(); // Retourne à la page précédente
                        }, 2000)
                    } else {
                        showAlert('Désolé !', response.msg, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    alert('Erreur :' + error);
                }
            });
        // }
    });
}

function editPassword() // form agent edit
{
    $('.formEditPassword').on('submit', function (e) {
        e.preventDefault();
        // const table = ['anPassword', 'newPassword'];

        // Vérifie si le formulaire est valide
        // if (formIsValided(table)) {
            // Créer un objet FormData pour gérer l'upload de fichiers
            let formData = $(this).serialize();
            $.ajax({
                url: LINK + 'userController/editPassword',
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>'); // activer loader
                },
                success: function (rep) {
                    // console.log(rep);return;
                    let response = JSON.parse(rep);

                    loading('.btn_actions', false, '<button type="submit" class="btn btn-primary btn_action">Sauvegarder</button>'); // desactiver loader
                    if (response.status == 1) {
                        showAlert('Félicitations !', 'Modification effectué avec succès.', 'success');
                        // redirect(LINK + 'agent/list');
                        setInterval(() => {
                            window.reload();
                        }, 2000)
                    } else {
                        showAlert('Désolé !', response.msg, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    alert('Erreur :' + error);
                }
            });
        // }
    });
}


function toggleUserStatus() {
    $('.toggleUserStatus').on('click', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        $.ajax({
            url: LINK + 'admin/users/toggleStatus',
            type: 'POST',
            data: { id: id },
            success: function (rep) {
                let response = JSON.parse(rep);
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            }
       });
    });
}

// ========== CATEGORIES ==========
function addCategorie() {
    $('.formCategorie').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: LINK + 'admin/categories/add',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => { location.reload(); }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== KITS ==========
function addKit() {
    $('.formKit').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: LINK + 'admin/kits/add',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    // Fermer le modal et rediriger vers la page d'ajout d'articles au kit
                    setTimeout(() => {
                        $('#addKitModal').modal('hide');
                        window.location.href = LINK + 'admin/kits/articles/' + response.code_choix_encrypted;
                    }, 1500);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

function editKit() {
    $('.formKitEdit').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: LINK + 'admin/kits/edit',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary btn_actions"><i class="feather icon-save"></i> Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setTimeout(() => {
                        window.location.href = LINK + 'admin/kits';
                    }, 1500);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== INSCRIPTIONS ==========
function addInscription() {
    $('.formInscription').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/inscriptions/create',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => { location.reload(); }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== PAIEMENTS ==========
function addPaiement() {
    $('.formPaiement').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/paiements/create',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => { location.reload(); }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// Gestion du bouton Payer dans la liste des inscriptions
function initPaiementButtons() {
    $(document).on('click', '.btn-payer-inscription', function() {
        var inscriptionCode = $(this).data('inscription');
        var userCode = $(this).data('user');
        
        console.log('>>> Opening paiement modal for inscription:', inscriptionCode, 'user:', userCode);
        
        // Ouvrir le modal
        $('#addPaiementModal').modal('show');
        
        // Sélectionner l'utilisateur
        $('#user_select').val(userCode);
        
        // Charger les inscriptions de cet utilisateur
        if (userCode) {
            $.ajax({
                url: LINK + 'admin/paiements/getInscriptionsByUser',
                type: 'POST',
                data: { user_code: userCode },
                success: function(rep) {
                    let inscriptions = JSON.parse(rep);
                    
                    $('#inscription_select').empty();
                    $('#inscription_select').append('<option value="">... Sélectionnez une inscription ...</option>');
                    
                    if (inscriptions && inscriptions.length > 0) {
                        inscriptions.forEach(function(ins) {
                            var selected = ins.code_inscription === inscriptionCode ? 'selected' : '';
                            $('#inscription_select').append(
                                $('<option ' + selected + '></option>')
                                    .val(ins.code_inscription)
                                    .text(ins.code_inscription + ' - ' + (ins.client_code || 'N/A'))
                            );
                        });
                    }
                    
                    $('#inscription_select').prop('disabled', false);
                    
                    // Sélectionner l'inscription spécifique
                    $('#inscription_select').val(inscriptionCode);
                    $('#inscription_select').trigger('change');
                },
                error: function(xhr, status, error) {
                    console.log('>>> Error:', error);
                }
            });
        }
    });
}

// ========== VERSEMENTS ==========
function addVersement() {
    $('.formVersement').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/versements/create',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => { location.reload(); }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== RETRAITS ==========
function addRetrait() {
    $('.formRetrait').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/retraits/create',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => { location.reload(); }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== SETTINGS ==========
function updateSettings() {
    $('.formSettings').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/settings/update',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary btn_actions"><i class="feather icon-save"></i> Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

function updatePreferences() {
    $('.formPreferences').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/settings/updatePreferences',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary btn_actions"><i class="feather icon-save"></i> Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== FAMILLES ==========
function addFamille() {
    $('.formFamille').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/familles/create',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => { location.reload(); }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== ARTICLES ==========
function addArticle() {
    $('.formArticle').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: LINK + 'admin/articles/create',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => { location.reload(); }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== DEMANDES ==========
function addDemande() {
    $('.formDemande').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'demandeController/create',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setInterval(() => { window.location.href = LINK + 'admin/demandes'; }, 2000);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

function updateStockByCategorie() {
    $(document).on('change', '#categorie_code', function() {
        var categorie_code = $(this).val();
        if(categorie_code) {
            $.ajax({
                url: LINK + 'demandeController/getStockByCategorie',
                type: 'POST',
                data: { categorie_code: categorie_code },
                dataType: 'json',
                success: function(response) {
                    var stock = response.stock || 0;
                    var html = '<strong>Stock actuel: ' + stock + ' carnets</strong>';
                    $('#stock-info').html(html);
                },
                error: function() {
                    $('#stock-info').html('<span class="text-danger">Erreur lors de la récupération du stock</span>');
                }
            });
        } else {
            $('#stock-info').html('Veuillez sélectionner une catégorie pour voir le stock disponible');
        }
    });
}

function validerDemande() {
    $(document).on('click', '.btn-valider-demande', function(e) {
        e.preventDefault();
        var code_demande = $(this).data('code');
        
        Swal.fire({
            title: '<span style="font-size: 24px;">Confirmation</span>',
            html: '<span style="font-size: 18px;">Voulez-vous valider cette demande?</span>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<span style="font-size: 16px;">Oui, valider</span>',
            cancelButtonText: '<span style="font-size: 16px;">Annuler</span>',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: LINK + 'demandeController/valider',
                    type: 'POST',
                    data: { code_demande: code_demande },
                    dataType: 'json',
                    success: function(response) {
                        showAlert('Résultat', response.msg, response.status == 1 ? 'success' : 'error');
                        if(response.status == 1) {
                            setInterval(() => { location.reload(); }, 2000);
                        }
                    },
                    error: function() {
                        showAlert('Erreur', 'Une erreur est survenue', 'error');
                    }
                });
            }
        });
    });
}

function rejeterDemande() {
    $(document).on('click', '.btn-rejeter-demande', function(e) {
        e.preventDefault();
        var code_demande = $(this).data('code');
        
        Swal.fire({
            title: '<span style="font-size: 24px;">Confirmation</span>',
            html: '<span style="font-size: 18px;">Voulez-vous rejeter cette demande?</span>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<span style="font-size: 16px;">Oui, rejeter</span>',
            cancelButtonText: '<span style="font-size: 16px;">Annuler</span>',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: LINK + 'demandeController/rejeter',
                    type: 'POST',
                    data: { code_demande: code_demande },
                    dataType: 'json',
                    success: function(response) {
                        showAlert('Résultat', response.msg, response.status == 1 ? 'success' : 'error');
                        if(response.status == 1) {
                            setInterval(() => { location.reload(); }, 2000);
                        }
                    },
                    error: function() {
                        showAlert('Erreur', 'Une erreur est survenue', 'error');
                    }
                });
            }
        });
    });
}

function addStock() {
    $('.formStock').on('submit', function(e) {
        e.preventDefault();
        
        var type_mouvement = $('#type_mouvement').val();
        var url = type_mouvement === 'ENTREE' 
            ? LINK + 'demandeController/entreeStock'
            : LINK + 'demandeController/retourStock';
        
        let formData = $(this).serialize();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(response) {
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                showAlert('Résultat', response.msg, response.status == 1 ? 'success' : 'error');
                if(response.status == 1) {
                    setInterval(() => { location.reload(); }, 2000);
                }
            },
            error: function() {
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary py-0 btn_actions">Sauvegarder</button>');
                showAlert('Erreur', 'Une erreur est survenue', 'error');
            }
        });
    });
}

// ========== KITS ARTICLES ==========
function addKitArticles() {
    // Initialize Choices.js for articles select
    document.addEventListener('DOMContentLoaded', function () {
        const element = document.getElementById('articles');
        if (element) {
            new Choices(element, {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Sélectionner des articles',
                searchEnabled: true,
                maxItemCount: -1
            });
        }
    });

    $('.formKitArticles').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: LINK + 'admin/kits/saveArticles',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin"></i> Enregistrement...');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<i class="feather icon-save"></i> Sauvegarder');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    setTimeout(() => {
                        window.location.href = LINK + 'admin/kits';
                    }, 1500);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                loading('.btn_actions', false, '<i class="feather icon-save"></i> Sauvegarder');
                alert('Erreur : ' + error);
            }
        });
    });
}

// ========== PAIEMENTS ==========
function initPaiementForm() {
    console.log('>>> initPaiementForm called');
    
    // Variables globales pour stocker les données
    var montantTotal = 0;
    var montantTotalPeriode = 0;
    var resteAPayer = 0;
    var nombreJourPeriode = 0;
    var selectedKits = [];
    
    $(document).ready(function() {
        // Charger les données depuis localStorage au démarrage
        loadPaiementFromStorage();
        
        // Gestion du changement d'utilisateur
        $('#user_select').on('change', function() {
            var userCode = $(this).val();
            console.log('>>> User selected:', userCode);
            
            if (userCode) {
                // Charger les inscriptions de cet utilisateur
                $.ajax({
                    url: LINK + 'admin/paiements/getInscriptionsByUser',
                    type: 'POST',
                    data: { user_code: userCode },
                    success: function(rep) {
                        console.log('>>> Inscriptions:', rep);
                        let inscriptions = JSON.parse(rep);
                        
                        // Vider le select et ajouter l'option par défaut
                        $('#inscription_select').empty();
                        $('#inscription_select').append('<option value="">... Sélectionnez une inscription ...</option>');
                        
                        if (inscriptions && inscriptions.length > 0) {
                            inscriptions.forEach(function(ins) {
                                $('#inscription_select').append(
                                    $('<option></option>')
                                        .val(ins.code_inscription)
                                        .text(ins.code_inscription + ' - ' + (ins.client_code || 'N/A'))
                                );
                            });
                        }
                        
                        $('#inscription_select').prop('disabled', false);
                        
                        // Activer Choices si disponible
                        if (typeof Choices !== 'undefined') {
                            var element = document.getElementById('inscription_select');
                            if (element) {
                                if (element.choicesInstance) {
                                    element.choicesInstance.destroy();
                                }
                                element.choicesInstance = new Choices(element, {
                                    removeItemButton: true,
                                    placeholder: true,
                                    placeholderValue: 'Sélectionner une inscription'
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('>>> Error:', error);
                    }
                });
            } else {
                $('#inscription_select').html('<option value="">Sélectionnez d\'abord un utilisateur</option>').prop('disabled', true);
            }
            
            // Effacer les détails et sauvegarder
            $('#inscription_details').html('');
            $('#montant_display').hide();
            $('#montant').val('');
            $('#nombre_jour').val('');
            savePaiementToStorage();
        });
        
        // Gestion du changement d'inscription
        $('#inscription_select').on('change', function() {
            var inscriptionCode = $(this).val();
            console.log('>>> Inscription selected:', inscriptionCode);
            
            if (inscriptionCode) {
                // Charger les détails de l'inscription
                $.ajax({
                    url: LINK + 'admin/paiements/getInscriptionDetails',
                    type: 'POST',
                    data: { inscription_code: inscriptionCode },
                    success: function(rep) {
                        console.log('>>> Details:', rep);
                        let data = JSON.parse(rep);
                        if (data) {
                            // Stocker les montants dans les variables globales
                            montantTotal = parseFloat(data.montant_total) || 0;
                            montantTotalPeriode = parseFloat(data.montant_total_periode) || 0;
                            resteAPayer = parseFloat(data.reste_a_payer) || 0;
                            nombreJourPeriode = parseInt(data.nombre_jour) || 0;
                            
                            displayInscriptionDetails(data);
                            savePaiementToStorage();
                            
                            // Si un nombre de jours est déjà saisi, recalculer le montant
                            var nbJour = $('#nombre_jour').val();
                            if (nbJour && nbJour > 0) {
                                calculateMontant();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('>>> Error:', error);
                    }
                });
            } else {
                $('#inscription_details').html('');
                $('#montant_display').hide();
                $('#montant').val('');
                montantTotal = 0;
                resteAPayer = 0;
                savePaiementToStorage();
            }
        });
        
        // Gestion du changement de nombre de jours
        $('#nombre_jour').on('input', function() {
            calculateMontant();
            savePaiementToStorage();
        });
        
        // Soumission du formulaire
        // $('.formPaiement').on('submit', function(e) {
        //     e.preventDefault();
            
        //     // Empêcher la double soumission
        //     if ($(this).data('submitting')) {
        //         return;
        //     }
        //     $(this).data('submitting', true);
            
        //     var formData = $(this).serialize();
        //     console.log('>>> Form data:', formData);
            
        //     $.ajax({
        //         url: LINK + 'admin/paiements/create',
        //         type: 'POST',
        //         data: formData,
        //         beforeSend: function() {
        //             loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
        //         },
        //         success: function(rep) {
        //             let response = JSON.parse(rep);
        //             loading('.btn_actions', false, '<i class="feather icon-save"></i> Sauvegarder');
        //             if (response.status == 1) {
        //                 showAlert('Félicitations !', response.msg, 'success');
        //                 // Vider le localStorage après succès
        //                 localStorage.removeItem('collect_paiementData');
        //                 setInterval(() => { location.reload(); }, 2000);
        //             } else {
        //                 showAlert('Désolé !', response.msg, 'error');
        //             }
        //             $('.formPaiement').data('submitting', false);
        //         },
        //         error: function(xhr, status, error) {
        //             loading('.btn_actions', false, '<i class="feather icon-save"></i> Sauvegarder');
        //             $('.formPaiement').data('submitting', false);
        //             alert('Erreur :' + error);
        //         }
        //     });
        // });
        
        // Nettoyer le localStorage quand le modal est fermé
        $('#addPaiementModal').on('hidden.bs.modal', function() {
            // Optionnel: garder les données pour la prochaine ouverture
            // localStorage.removeItem('collect_paiementData');
        });
    });
    
    // Fonction pour afficher les détails de l'inscription
    function displayInscriptionDetails(data) {
        selectedKits = data.kits || [];
        montantTotal = parseFloat(data.montant_total) || 0;
        montantTotalPeriode = parseFloat(data.montant_total_periode) || 0;
        resteAPayer = parseFloat(data.reste_a_payer) || 0;
        nombreJourPeriode = parseInt(data.nombre_jour) || 0;
        
        var html = '<div class="alert alert-info">';
        html += '<h5>Détails de l\'inscription</h5>';
        html += '<p><strong>Client:</strong> ' + (data.inscription.client_code || 'N/A') + '</p>';
        html += '<p><strong>Date début:</strong> ' + formatDate(data.inscription.date_debut) + '</p>';
        html += '<p><strong>Date fin:</strong> ' + formatDate(data.inscription.date_fin) + '</p>';
        html += '<p><strong>Type:</strong> ' + (data.inscription.type_inscription || 'N/A') + '</p>';
        html += '</div>';
        
        // Informations sur la période
        html += '<div class="alert alert-secondary mt-2">';
        html += '<p class="mb-1"><strong>Période de la catégorie:</strong> ' + nombreJourPeriode + ' jours</p>';
        html += '<p class="mb-0"><strong>Montant pour la période complète:</strong> ' + montantTotalPeriode.toLocaleString() + ' F</p>';
        html += '</div>';
        
        // Tableau des kits
        if (selectedKits && selectedKits.length > 0) {
            html += '<div class="table-responsive mt-3">';
            html += '<table class="table table-sm table-bordered">';
            html += '<thead><tr><th>Kits</th><th>Cotisation</th></tr></thead>';
            html += '<tbody>';
            
            selectedKits.forEach(function(kit) {
                var cot = parseFloat(kit.cotisation_choix) || 0;
                html += '<tr><td>' + (kit.libelle_choix || 'N/A') + '</td><td>' + cot.toLocaleString() + ' F</td></tr>';
            });
            
            html += '<tr class="table-primary"><td><strong>Total Kits</strong></td><td><strong>' + montantTotal.toLocaleString() + ' F</strong></td></tr>';
            html += '<tr><td>Déjà payé (validé)</td><td>' + (parseFloat(data.montant_paye) || 0).toLocaleString() + ' F</td></tr>';
            html += '<tr class="table-success"><td><strong>Reste à payer</strong></td><td><strong>' + resteAPayer.toLocaleString() + ' F</strong></td></tr>';
            html += '</tbody></table></div>';
        }
        
        $('#inscription_details').html(html);
    }
    
    // Fonction pour formater les dates
    function formatDate(dateStr) {
        if (!dateStr) return 'N/A';
        try {
            var date = new Date(dateStr);
            return date.toLocaleDateString('fr-FR');
        } catch (e) {
            return dateStr;
        }
    }
    
    // Fonction pour calculer le montant
    function calculateMontant() {
        var nombreJour = parseInt($('#nombre_jour').val()) || 0;
        
        // Calcul: nb jours × total des kits (pas de la période)
        if (nombreJour > 0 && montantTotal > 0) {
            var montant = Math.round(montantTotal * nombreJour);
            
            $('#montant').val(montant);
            $('#montant_value').text(montant.toLocaleString());
            $('#montant_display').show();
        } else {
            $('#montant').val('');
            $('#montant_display').hide();
        }
    }
    
    // Fonction pour sauvegarder dans localStorage
    function savePaiementToStorage() {
        try {
            var data = {
                user_code: $('#user_select').val(),
                inscription_code: $('#inscription_select').val(),
                nombre_jour: $('#nombre_jour').val(),
                montant: $('#montant').val(),
                montant_total: montantTotal,
                montant_total_periode: montantTotalPeriode,
                reste_a_payer: resteAPayer,
                nombre_jour_periode: nombreJourPeriode
            };
            localStorage.setItem('collect_paiementData', JSON.stringify(data));
            console.log('>>> Saved to localStorage:', data);
        } catch (e) {
            console.error('>>> Error saving to localStorage:', e);
        }
    }
    
    // Fonction pour charger depuis localStorage
    function loadPaiementFromStorage() {
        try {
            var stored = localStorage.getItem('collect_paiementData');
            console.log('>>> Loading from localStorage:', stored);
            if (stored) {
                var data = JSON.parse(stored);
                
                if (data.user_code) {
                    $('#user_select').val(data.user_code);
                    
                    // Déclencher le chargement des inscriptions
                    $('#user_select').trigger('change');
                    
                    // Attendre que les inscriptions soient chargées
                    setTimeout(function() {
                        if (data.inscription_code) {
                            $('#inscription_select').val(data.inscription_code);
                            
                            // Charger les détails de l'inscription depuis le serveur
                            $.ajax({
                                url: LINK + 'admin/paiements/getInscriptionDetails',
                                type: 'POST',
                                data: { inscription_code: data.inscription_code },
                                success: function(rep) {
                                    console.log('>>> Reloading Details from storage:', rep);
                                    let inscriptionData = JSON.parse(rep);
                                    if (inscriptionData) {
                                        displayInscriptionDetails(inscriptionData);
                                        // Appliquer le nombre de jours et calculer le montant
                                        if (data.nombre_jour) {
                                            $('#nombre_jour').val(data.nombre_jour);
                                            calculateMontant();
                                        }
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log('>>> Error reloading details:', error);
                                }
                            });
                        }
                    }, 1000);
                }
            }
        } catch (e) {
            console.error('>>> Error loading from localStorage:', e);
        }
    }
}

// ========== CLIENTS ==========
function addClient() {
    $('.formClient').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: LINK + 'admin/clients/create',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary btn_actions">Sauvegarder</button>');
                if (response.status == 1) {
                    showAlert('Félicitations !', response.msg, 'success');
                    // Fermer le modal et rediriger vers la page de choix
                    setTimeout(() => {
                        $('#addClientModal').modal('hide');
                        window.location.href = LINK + 'admin/inscriptions/choix/' + response.code_client;
                    }, 1500);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                alert('Erreur :' + error);
            }
        });
    });
}

// ========== INSCRIPTION CHOIX KIT ==========
function addChoixKit() {
    
    $('.formChoixKit').on('submit', function(e) {
        e.preventDefault();

        // Récupérer les données du formulaire
        var formData = new FormData(this);
        var clientCode = formData.get('client_code');
        var typeInscription = formData.get('type_inscription');
        var userCode = formData.get('user_code');
        
        // Récupérer les kits sélectionnés depuis le localStorage
        var kits = window.selectedKits || [];
        
        console.log('>>> Submitting form with kits:', kits);
        console.log('>>> Client code:', clientCode);
        console.log('>>> Type:', typeInscription);
        console.log('>>> User:', userCode);
        
        if (kits.length === 0) {
            showAlert('Erreur', 'Veuillez sélectionner au moins un kit!', 'error');
            return;
        }
        
        // Préparer les données pour saveMultiple
        var postData = {
            client_code: clientCode,
            type_inscription: typeInscription,
            user_code: userCode,
            kits: kits.map(function(kit) { return kit.code; })
        };
        
        console.log('>>> Post data:', postData);

        $.ajax({
            url: LINK + 'admin/inscriptions/saveMultiple',
            type: 'POST',
            data: postData,
            beforeSend: function() {
                loading('.btn_actions', 'disabled', '<i class="fa fa-spinner fa-spin fa-2x text-light"></i>');
            },
            success: function(rep) {
                console.log('>>> Response:', rep);
                let response = JSON.parse(rep);
                loading('.btn_actions', false, '<button type="submit" class="btn btn-primary btn_actions"><i class="feather icon-check-circle"></i> Finaliser l\'inscription</button>');
                if (response.status == 1) {
                    // Vider le panier après soumission réussie
                    window.clearKitSelection();
                    showAlert('Félicitations !', response.msg, 'success');
                    setTimeout(() => {
                        window.location.href = LINK + 'admin/inscriptions';
                    }, 1500);
                } else {
                    showAlert('Désolé !', response.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.log('>>> Error:', error);
                alert('Erreur :' + error);
            }
        });
    });
}
// ========== GESTION KITS PAR CATÉGORIE ==========
function loadKitsByCategorie() {
    $(document).on('change', '#categorie', function() {
        const categorieCode = $(this).val();
        const kitSelect = $('#kit');
        const choixParCategorie = window.choixParCategorie || {};
        
        if (categorieCode && choixParCategorie[categorieCode]) {
            kitSelect.empty();
            kitSelect.append('<option value="">Sélectionner un kit</option>');
            
            choixParCategorie[categorieCode].forEach(function(kit) {
                kitSelect.append(
                    $('<option></option>')
                        .val(kit.code_choix)
                        .text(kit.libelle_choix + ' - ' + Number(kit.cotisation_choix).toLocaleString() + ' CFA')
                );
            });
            
            kitSelect.prop('disabled', false);
        } else {
            kitSelect.empty();
            kitSelect.append('<option value="">Sélectionner d\'abord une catégorie</option>');
            kitSelect.prop('disabled', true);
        }
    });
}

// ========== SÉLECTION KITS POUR INSCRIPTION (AVEC LOCALSTORAGE) ==========
function initKitSelection() {
    console.log('>>> initKitSelection called');
    
    // Wrapper dans document ready pour s'assurer que jQuery est chargé
    $(document).ready(function() {
        console.log('>>> document is ready');
        
        // Charger les kits depuis localStorage au démarrage
        loadKitsFromStorage();
        
        // Gestion du clic sur le bouton de choix de kit
        $(document).on('click', '.btn-choose-kit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var code = $(this).data('code');
            var libelle = $(this).data('libelle');
            var cotisations = $(this).data('cotisation');
            
            console.log('>>> Kit selected:', code, libelle, cotisations);
            console.log('>>> Data attributes:', $(this).data());
            
            // Vérifier si déjà sélectionné
            if (!window.selectedKits) {
                window.selectedKits = [];
            }
            
            if (window.selectedKits.some(function(kit) { return kit.code === code; })) {
                showAlert('Info', 'Ce kit est déjà sélectionné!', 'info');
                return;
            }
            
            // Ajouter le kit
            var newKit = {
                code: code,
                libelle: libelle,
                cotisations: parseFloat(cotisations)
            };
            window.selectedKits.push(newKit);
            
            console.log('>>> Kits after add:', window.selectedKits);
            
            // Sauvegarder dans localStorage
            saveKitsToStorage();
            
            // Mettre à jour l'interface
            updateSelectionUI();
            showAlert('Succès', libelle + ' ajouté à votre sélection!', 'success');
        });
        
        // Gestion de la suppression de kit
        $(document).on('click', '.remove-kit', function(e) {
            e.preventDefault();
            var code = $(this).data('code');
            window.removeKitFromSelection(code);
        });
        
        // Filtrer les kits par catégorie
        $(document).on('change', '#filter_categorie', function() {
            var categorieCode = $(this).val();
            
            $('.kit-card').each(function() {
                if (categorieCode === '' || $(this).data('categorie') === categorieCode) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Soumettre le formulaire quand on clique sur Finaliser
        $(document).on('click', '.formChoixKitSubmit', function(e) {
            e.preventDefault();
            $('.formChoixKit').trigger('submit');
        });
    });
    
    // Fonction pour sauvegarder dans localStorage
    function saveKitsToStorage() {
        try {
            localStorage.setItem('collect_selectedKits', JSON.stringify(window.selectedKits));
            console.log('>>> Saved to localStorage:', window.selectedKits);
        } catch (e) {
            console.error('>>> Error saving to localStorage:', e);
        }
    }
    
    // Fonction pour charger depuis localStorage
    function loadKitsFromStorage() {
        try {
            var stored = localStorage.getItem('collect_selectedKits');
            console.log('>>> Loading from localStorage, found:', stored);
            if (stored) {
                window.selectedKits = JSON.parse(stored);
                console.log('>>> Kits loaded:', window.selectedKits);
                updateSelectionUI();
            } else {
                window.selectedKits = [];
                console.log('>>> No kits in storage, initializing empty array');
            }
        } catch (e) {
            console.error('>>> Error loading from localStorage:', e);
            window.selectedKits = [];
        }
    }
    
    // Fonction globale pour vider le panier (à appeler après soumission réussie)
    window.clearKitSelection = function() {
        window.selectedKits = [];
        localStorage.removeItem('collect_selectedKits');
        updateSelectionUI();
    };
    
    // Mettre à jour l'interface de sélection
    window.updateSelectionUI = function() {
        var container = $('#selectionContainer');
        var kits = window.selectedKits || [];
        
        if (kits.length === 0) {
            container.html('<div class="text-center text-muted py-4"><i class="feather icon-shopping-cart" style="font-size: 48px;"></i><p class="mt-2">Aucun kit sélectionné</p></div>');
            return;
        }
        
        var total = 0;
        var html = '<ul class="list-group">';
        
        kits.forEach(function(kit) {
            // Support both 'cotisation' and 'cotisations' for backward compatibility
            var cot = kit.cotisation || kit.cotisations || 0;
            total += cot;
            html += '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                '<div><strong>' + kit.libelle + '</strong></div>' +
                '<div class="d-flex align-items-center">' +
                '<span class="badge badge-success badge-pill mr-3">' + Number(cot).toLocaleString() + ' CFA</span>' +
                '<button type="button" class="btn btn-sm btn-danger remove-kit" data-code="' + kit.code + '">' +
                '<i class="feather icon-trash-2"></i></button></div></li>';
        });
        
        html += '</ul>';
        html += '<div class="mt-3 p-3 bg-primary text-white rounded">' +
            '<div class="d-flex justify-content-between align-items-center">' +
            '<strong>Total:</strong>' +
            '<strong style="font-size: 18px;">' + Number(total).toLocaleString() + ' CFA</strong></div></div>';
        
        container.html(html);
    };
    
    // Fonction globale pour supprimer un kit
    window.removeKitFromSelection = function(code) {
        if (!window.selectedKits) return;
        window.selectedKits = window.selectedKits.filter(function(kit) { return kit.code !== code; });
        saveKitsToStorage();
        updateSelectionUI();
    };
}
// active select tag
document.addEventListener('DOMContentLoaded', function () {
    const element = document.getElementById('articles');
    new Choices(element, {
        removeItemButton: true, // Active la petite croix ❌
        placeholder: true,
        placeholderValue: 'Sélectionner un article',
        searchEnabled: true
    });
});