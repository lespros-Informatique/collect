  <?php
  // session_destroy();
  // var_dump("USER_ROLE= ".USER_ROLE);return;
  // session_destroy();
  if (USER_ROLE === null) {
    require_once '../views/users/connexion.php';
  }
  if (USER_ROLE === ROLE_ADMIN) {
    require_once '../views/dashboard/dashboard.php';
  } elseif (USER_ROLE === "staff" || USER_ROLE === "livreur") {
    require_once '../views/dashboard/dashboard.php'; // or create a different view
  } 
  ?>
  
  
  