const LINK = window.location.origin + '/collect/public/';
const LINKS = window.location.origin + '/collect'; // En local il faut ajouter restaurant/ pour que çà passe!

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
                    window.location.href = LINKS;               } else {
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
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/categories/add',
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

// ========== KITS ==========
function addKit() {
    $('.formKit').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: LINK + 'admin/kits/add',
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
