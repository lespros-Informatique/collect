<?php 
session_start();
session_destroy();
// header("Location:https://tontine.dndcorporations.com");
header('Location:'.RACINE);
?>