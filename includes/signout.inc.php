<?php
/**
 * Include script used to sign out currently signed user.
 */

include 'user.inc.php';

// Check if user is currently signed in
if (isset($_SESSION['user_name'])) {
    // Unset user session values
    unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['first_name'], $_SESSION['last_name']);
}

// Forward user to authentication page
header('Location: ../authentication.php');
exit();