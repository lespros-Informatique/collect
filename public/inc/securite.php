<?php

if (!(isset($_SESSION['user'] ) && USER_ROLE === null)) {
    header('location: '.RACINE);
}
