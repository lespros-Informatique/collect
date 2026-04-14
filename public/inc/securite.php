<?php

if (!(isset($_SESSION['user'] ) && USER_ROLE === null)) {
    header('location: '.RACINE);
}

if (!(isset($_SESSION['entreprise'] ))) {
    header('location: '.RACINE);
}
