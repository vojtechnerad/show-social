<?php
@session_start();

if (@$_SESSION['user_id']) {
    $title = 'Dashboard';
    $active_page = 'dashboard';
} else {
    $title = 'Úvod';
    $active_page = 'introduction';
}

// Generování obsahu stránky
include 'includes/header.inc.php';
if (@$_SESSION['user_id']) {
    header('Location: profile.php');
    exit();
} else {
    require_once 'includes/pages/introduction.inc.php';
}

include 'includes/footer.inc.php';
?>
