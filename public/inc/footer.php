
 
 <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-dark navbar-border">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2025 <a class="text-bold-800 grey darken-2" href="#" target="_blank"><?=APP_NAME?> </a></span><span class="float-md-right d-none d-lg-block">Fait avec <i class="feather icon-heart pink"></i></span></p>
    </footer>
    <!-- END: Footer-->


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?=RACINE; ?>json/func.js"></script>
    <script src="<?=RACINE; ?>json/ajax.js"></script>
    <!-- BEGIN: Vendor JS-->
    <script src="<?=RACINE; ?>app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- <script src="<?=RACINE; ?>app-assets/vendors/js/ui/jquery.sticky.js"></script> -->
    <script src="<?=RACINE; ?>app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="<?=RACINE; ?>app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
    <script src="<?=RACINE; ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?=RACINE; ?>app-assets/js/core/app-menu.js"></script>
    <script src="<?=RACINE; ?>app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?=RACINE; ?>app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
    <script src="<?=RACINE; ?>app-assets/js/scripts/forms/form-login-register.js"></script>
    <!-- END: Page JS-->
    <!-- BEGIN: Page Vendor JS-->
    <script src="<?=RACINE?>app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="<?=RACINE?>app-assets/vendors/js/charts/morris.min.js"></script>
    <script src="<?=RACINE?>app-assets/vendors/js/extensions/unslider-min.js"></script>
    <script src="<?=RACINE?>app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?=RACINE?>app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://unpkg.com/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- BEGIN: Page JS-->
    <script src="<?=RACINE?>app-assets/js/scripts/pages/page-users.js"></script>
    <!-- END: Page JS-->

                        <!-- BEGIN: Vendor JS-->
    <!-- <script src="<?=RACINE?>app-assets/vendors/js/vendors.min.js"></script> -->
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?=RACINE?>app-assets/vendors/js/extensions/jquery.steps.min.js"></script>

    <script src="<?=RACINE?>app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?=RACINE?>app-assets/js/scripts/forms/wizard-steps.js"></script>   

    <script src="<?=RACINE?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="<?RACINE?>app-assets/vendors/js/extensions/dropzone.min.js"></script>
    <script src="<?RACINE?>app-assets/vendors/js/ui/prism.min.js"></script>
    <!-- END: Page Vendor JS-->

       <!-- BEGIN: Page JS-->
    <script src="<?= RACINE ?>app-assets/js/scripts/pages/app-contacts.js"></script>
    <!-- END: Page JS-->
      
    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= RACINE ?>app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?= RACINE ?>app-assets/js/scripts/forms/select/form-select2.js"></script>
    <!-- END: Page JS-->

    <!-- END: Page JS-->
     <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>

<script>
  $(function () {

    $('.datatable-table').DataTable();

  });

    const socket = io("http://localhost:8080");

    socket.on("connect", () => {
        console.log("🟢 Connecté au serveur Node");
    });

    socket.on("nouvelle_commande", (data) => {
        console.log("🚨 Nouvelle commande :", data);

        // Afficher une notification toast qui reste visible
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: true,
            confirmButtonText: 'Voir la commande',
            confirmButtonColor: '#28a745',
            showCancelButton: true,
            cancelButtonText: 'Fermer',
            cancelButtonColor: '#6c757d',
            timer: null, // Pas de timer automatique
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            title: `🆕 en commande: ${$('.badge.badge-pill.badge-primary.badge-up').text() || 1}`,
            html: `Nouvelle Commande Reçue !`,
            icon: 'success',
            width: '300px',
            customClass: {
                popup: 'animated slideInRight'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Décrémenter le count et rediriger vers les commandes
                decrementNotificationCount();
                window.location.href = '<?=RACINE?>admin/commandes';
            }
            // Si annulé avec "Fermer", décrémenter aussi le count
            if (result.dismiss === Swal.DismissReason.cancel) {
                decrementNotificationCount();
            }
        });
    });
    
    // Fonction pour décrémenter le count des notifications
    function decrementNotificationCount() {
        // Sélectionner le badge count (element avec la classe badge-up)
        var badgeCount = $('.badge.badge-pill.badge-primary.badge-up');
        var currentCount = parseInt(badgeCount.text()) || 0;
        var newCount = Math.max(0, currentCount - 1); // Éviter les nombres négatifs
        
        // Mettre à jour le badge count
        badgeCount.text(newCount);
        
        // Mettre à jour le span "X Nouveau"
        var newTag = $('.notification-tag');
        if (newCount === 0) {
            newTag.text('0 Nouveau');
        } else {
            newTag.text(newCount + ' Nouveau');
        }
    }
    
    // Ajouter un peu de CSS pour l'animation pulse via jQuery
    $('<style>').prop('type', 'text/css').html(`
        .pulse {
            animation: pulse-animation 1s ease-in-out;
        }
        @keyframes pulse-animation {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    `).appendTo('head');

</script>


</body>

</html>
