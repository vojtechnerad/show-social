<?php
/**
 * Include script used to sign out currently signed user.
 */
session_start();
include 'user.inc.php';

// Check if user is currently signed in
if (isset($_SESSION['user_name'])) {
    // Unset user session values
    unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['first_name'], $_SESSION['last_name']);

    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.

}
// Forward user to authentication page
session_unset();
session_destroy();
header('Location: ../signin.php');
exit();