 
  
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
     <!-- select tag -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

  <script>
  $(function () {

    $('.datatable-table').DataTable();
    $('#demandes-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        }
    });
    $('#stocks-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        order: [[6, 'desc']]
    });

  });

  </script>


</body>

</html>
