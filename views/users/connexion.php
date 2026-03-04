

<!-- <?php var_dump(Validator::hashPassword("ADMIN-01")) ?> -->
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= TITLE ?></title>
  <link rel="icon" href="<?= LOGO ?>" type="image/jpeg">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/vendors/css/vendors.min.css">
        <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/vendors/css/forms/selects/select2.min.css">

    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/vendors/css/tables/datatable/datatables.min.css">

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/pages/timeline.css">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/pages/page-users.css">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>assets/css/style.css">
    <!-- END: Custom CSS -->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css/plugins/forms/wizard.css">
        <link rel="stylesheet" type="text/css" href="<?=RACINE?>app-assets/css-rtl/plugins/file-uploaders/dropzone.css">

            <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= RACINE ?>app-assets/css/pages/app-contacts.css">
    <!-- END: Page CSS-->


    
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?=RACINE; ?>app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE; ?>app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE; ?>app-assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE; ?>app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE; ?>app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="<?=RACINE; ?>app-assets/vendors/css/forms/icheck/custom.css">
    <!-- END: Vendor CSS-->


</head>

<body class="con-body " >
  <div class="login-container">
    <div class="login-logo img-border">
    <img src="<?= LOGO ?>">
      
    </div>
    <?php 
    // var_dump(Validator::hashPassword(12345));
    ?>
    <!-- <div class="login-title">Connexion à Race bénie</div> -->
    <div class="login-title">Collect Bref</div>

    <form class="formConnexion" method="POST">
      <div class="form-group">
        <label for="email">Email ou Numéro de téléphone</label>
        <div class="input-group">
          <span><i class="fa fa-envelope"></i></span>
          <input type="text" name="email" id="email" value="admin@collect.ci" placeholder="Entrer l'email ou le numéro de téléphone">
          <span id="networkLogo"></span>
        </div>
        <div class="error-message" id="emailError"></div>
      </div>

      <div class="form-group">
        <label for="password">Mot de passe</label>
        <div class="input-group">
          <span><i class="fa fa-lock"></i></span>
          <input type="password" name="password" value="ADMIN-01" id="password" placeholder="Entrer le mot de passe">
          <!-- <input type="password" name="password" id="password" value="AGENT-01" placeholder="Entrer le mot de passe"> -->
          <span onclick="togglePassword()"><i class="fa fa-eye" id="togglePasswordIcon"></i></span>
        </div>
        <div class="error-message" id="passwordError"></div>

      </div>

      <button type="submit" class="btn btn_actions bg-primary">Se connecter <i class="fa fa-sign-in"></i></button>
    </form>
  </div>


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
<!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> -->
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

</body>

</html>
