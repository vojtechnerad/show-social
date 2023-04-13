<?php
@session_start();
    if (@$_SESSION['user_id']) {
        $title = 'Dashboard';
        $active_page = 'dashboard';
    } else {
        $title = 'Úvod';
        $active_page = 'introduction';
    }


    // Generování stránky
    include 'includes/header.inc.php';

    if (@$_SESSION['user_id']) {
        require_once 'includes/pages/dashboard.inc.php';
    } else {
        require_once 'includes/pages/introduction.inc.php';
    }

    include 'includes/footer.inc.php';
?>
