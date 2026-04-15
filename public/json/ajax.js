connexion();
// User management
addUser(); // add user
editUser(); // edit user
editPassword();
addClient();
// Categories management
addCategorie();

// Kits management
addKit();
editKit();
addKitArticles();

// Succursales management
addSuccursale();
editSuccursale();

// Campagnes management
addCampagne();
editCampagne();

// Inscriptions management
addInscription();
// addChoixKit();
$(document).ready(function() {
    addChoixKit();
});
loadKitsByCategorie();
initKitSelection();

addPaiement();

// Paiements - Formulaire dynamique
$(document).ready(function() {
    initPaiementForm();
    initPaiementButtons();
});

createPagination('#paginationControls', '.element-item', 6);

// Versements management
addVersement();

// Retraits management
addRetrait();

// Settings management
updateSettings();
updatePreferences();

// Familles management
addFamille();

// Articles management
addArticle();

// Demandes management
addDemande();
updateStockByCategorie();
validerDemande();
rejeterDemande();
addStock();