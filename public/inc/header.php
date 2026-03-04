<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title><?= TITLE ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=LOGO?>">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

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
<link rel="stylesheet" href="https://unpkg.com/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

  <!-- nav -->
   <?php
   
//    if(USER_ROLE === "admin"){ 
      require_once '../public/inc/sub_header/super_admin.php'; 
//    }
   

  ?>

   <!-- fin nav -->