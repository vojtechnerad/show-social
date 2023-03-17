<?php
//require 'includes/autoloader.inc.php';
require 'classes/dbh.class.php';
require 'classes/Users.class.php';

session_start();
$active_page = 'people';
$title = 'Lidé';
include 'includes/header.inc.php';

$users = new Users();
$allUsers = $users->getAllUsers();

foreach ($allUsers as $user) {
    echo '<a href="user.php?id='. $user['id'] .'">';
    echo $user['first_name'] . ' ' . $user['last_name'];
    echo '</a>';
}
?>

<?php
include 'includes/footer.inc.php';
